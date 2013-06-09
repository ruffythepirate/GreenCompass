    <?php 
        include("Includes/header.php");         
     ?>

<?php
$messages = array (
    'se'=> array(
        'Admin Schools' =>
            'Administrera skolor',
        'Schools' => 'Skolor',
        'No Schools Available' => 'Inga skolor är tillgängliga'
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
}?>

    <div id="main">
    <div class="section">
    <h3><?php print msg('Admin Schools')?></h3>
    </div>
    <div class="section">
    <h3><?php print msg('Schools')?></h3>
   <?php

        function countrySort( $a, $b ) {
            return $a->name == $b->name ? 0 : ( $a->name > $b->name ) ? 1 : -1;
        }

        //We load the countries so that we can group on the later.        
        $query = 'SELECT countryid, name FROM Countries';
        $result = $databaseConnection->query($query);
        while($row = $result->fetch_object())
        {
            $countries[$row->countryid] = $row;
        }
        $result->close();

        $query = 'SELECT schoolid, name, countryid, createddate FROM Schools';
        
        $result = $databaseConnection->query($query);

        while($row =   $result->fetch_object())
        {
            $rows[] = $row;
        }

        foreach($rows as $row)
        {
            $countrySchools[$row->countryid][] = $row;
            echo "$row->name <br>" ;
        }

        foreach($countrySchools as $key => $value)
        {
            $arraySize = count($value);
            echo "CountryId = $key, count = $arraySize<br>";
        }

        usort( $countries, 'countrySort' );
        //ksort($countries);
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
                     $dateAsDateTime = new DateTime($school->createddate);
                     $formattedDate = $dateAsDateTime->format('Y-m-d');
                     print"<td>$formattedDate</td>\n";
                     print"<td>Edit</td>\n";
                     print"<td>Delete</td>\n";
                     print"</tr>\n";
                 }
                 print "</table>";
            }
        }


        $result->close();
        /*$statement = $databaseConnection->prepare($query);
        $statement->execute();
        $statement->store_result();
        if ($statement->error)
        {
            print msg('Received Errors<br>');
            //die('Database query failed: ' . $statement->error);
        }

        if ($statement->num_rows > 0)
        {
            $number_of_rows = $statement->num_rows;
            print  'checking list<br>';
            print  "number of rows: $number_of_rows<br>";
            while($statement->next_result())
            {
               // $statement->next_result();
                print  'iterating list item...<br>';
//                print  $row['name'];
            }
        }
        else
        {
            print msg('No Schools Available');
        }*/
    ?>

        <a href="school_create.php"><?php print msg('Add New')?></a>
    </div>

    </div>

</div> <!-- End of outer-wrapper which opens in header.pho -->

<?php 
    include ("/Includes/footer.php");
 ?>