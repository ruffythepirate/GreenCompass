
    <h3><?php print msg('Created Workshops')?></h3>
        <?php
            
$messages = array (
    'se'=> array( //ok
        'Create Workshop' =>
            'Skapa Workshop'
    )
);

function msg($s) {
    global $LANG;
    global $messages;
    
    if (isset($messages[$LANG][$s])) {
        return $messages[$LANG][$s];
    } else {
        return $s;
    }
}


            global $databaseConnection;

     function getWorkshops($databaseConnection)
    {
        //We load the countries so that we can group on the later.        
        $query = 'SELECT workshopid, workshopname, createddate FROM workshops';
        $result = $databaseConnection->query($query);
        $workshops = array();
        while($row = $result->fetch_object())
        {
            array_push($workshops, $row);
        }
        $result->close();

        return $workshops;
    }


        $workshops = getWorkshops($databaseConnection);

        echo "<table>";
        echo "<tr><th>Name</th><th>Created</th><th>Delete</th></tr>";
        foreach($workshops as $workshop)
        {
            echo "<tr>";
            echo "<td><a href=\"admin_workshop_edit.php?id=$workshop->workshopid\">$workshop->workshopname</a></td>" ;
            echo "<td>$workshop->createddate</td>" ; 
            echo "<td><a class=\"delete-workshop\" data-workshopid=\"$workshop->workshopid\" href=\"#\">Delete</a></td>" ;
            echo "</tr>";
 
        }
        echo "</table>";
        ?>
        
    <script>

        function updateWorkshops() {
            $.ajax({
                type: "GET",
                url: "ajax_get_workshops.php",
                data: {}
            })
                .done(
                function (result) {
                    $("#available-workshops").html(result);
                });
        }

        $(document).ready(function () {
            $('.delete-workshop').click(function () {
                var workshopId = $(this).attr('data-workshopid');

                $.ajax({
                    type: "POST",
                    url: "ajax_delete_workshop.php",
                    data: { workshopid: workshopId }
                }).done(function () {
                    updateWorkshops()
                });
                return false;
            });
        });
    </script>
