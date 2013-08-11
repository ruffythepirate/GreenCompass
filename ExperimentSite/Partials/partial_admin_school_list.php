<?php
    require_once "Includes/session.php";
    global $databaseConnection;
        function countrySort( $a, $b ) {
            return $a->name == $b->name ? 0 : ( $a->name > $b->name ) ? 1 : -1;
        }

        $countries = array();
        //We load the countries so that we can group on the later.        
        $query = 'SELECT countryid, name FROM countries';
        $result = $databaseConnection->query($query);
        while($row = $result->fetch_object())
        {
            $countries[$row->countryid] = $row;
        }
        $result->close();

        $query = 'SELECT schoolid, name, countryid, createddate FROM schools';
        
        $result = $databaseConnection->query($query);

        $rows = array();
        while($row =   $result->fetch_object())
        {
            $rows[] = $row;
        }

        foreach($rows as $row)
        {
            $countrySchools[$row->countryid][] = $row;
        }

        usort( $countries, 'countrySort' );


        echo "<div id=\"school-list\">";

        foreach($countries as $key => $value)
        {
            if(isset ($countrySchools[$value->countryid]))
            {
                 //We print out a table over the schools of this country
                 print "<h4>$value->name</h4>";
                 print "<table>";
                 print "<tr><th>Name</th><th>Teachers</th><th>Created</th><th>Edit</th><th>Delete</th></tr>";
                 foreach($countrySchools[$value->countryid] as $school)
                 {
                     print"<tr>\n";
                     print"<td>$school->name</td>\n";
                     print"<td>0</td>\n";
                     $dateAsDateTime = new DateTime($school->createddate, new DateTimeZone('Etc/GMT+1'));
                     $formattedDate = $dateAsDateTime->format('Y-m-d');
                     print"<td>$formattedDate</td>\n";
                     print"<td><a href=\"admin_school_edit.php?schoolId=$school->schoolid\">Edit</a></td>\n";
                     print"<td><a href=\"#\" class=\"delete-school\" data-schoolid=\"$school->schoolid\">Delete</a></td>\n";
                     print"</tr>\n";
                 }
                 print "</table>";
            }
        }
        echo "</div>";
        $result->close();
        ?>
<script>

    function updateSchoolList() {
        $.ajax({
            url: "ajax_get_school_list.php",
            type: "GET"
        }).done(function (result) {
            $('#school-list').html(result);
        });
    }

    $('.delete-school').click(function () {
        var schoolId = $(this).attr('data-schoolid');

        $.ajax({
            url: "ajax_delete_school.php",
            data: { schoolId: schoolId },
            type: "POST"
        }).done(function (result) {
            //We fetch the school list again.
            updateSchoolList();
        });
    });
</script>
