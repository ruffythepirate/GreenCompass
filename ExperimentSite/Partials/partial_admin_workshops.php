
    <h3><?php print msg('Created Workshops')?></h3>
        <ul>
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
        $query = 'SELECT workshopid, workshopname, createddate FROM Workshops';
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


        foreach($workshops as $workshop)
        {
            echo "<li> <a href=\"admin_workshop_edit.php?id=$workshop->workshopid\">$workshop->workshopname</a></li>" ;
        }
        ?>
</ul>

