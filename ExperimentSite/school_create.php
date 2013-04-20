    <?php 
        include("Includes/header.php");         
     ?>

<?php
$messages = array (
    'se'=> array( //ok
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
    <h3><?php print msg('Create School')?></h3>
    </div>
    <div class="section">
    <h3><?php print msg('Create School')?></h3>
        <form method="post">
            Name: <input type="text" id="schoolName"><br>
            Country: 
            <select id="schoolName">
                <?php 
                       function countrySort( $a, $b ) {
            return $a->name == $b->name ? 0 : ( $a->name > $b->name ) ? 1 : -1;
                }

        //We load the countries so that we can group on the later.        
        $query = 'SELECT countryid, name FROM Countries';
        $result = $databaseConnection->query($query);
        while($row = $result->fetch_object())
        {
            $countries[] = $row;
        }
        $result->close();
                    
        usort( $countries, 'countrySort' );    
        
        foreach($countries as $country)
        {
            print "<option value=\"$country->countryid\">";
            print "$country->name";
            print "</option>";
        }
        ?>
                </select><br>
            <input type="button" id="submit" value="Create">
        </form>
    </div>

    </div>

</div> <!-- End of outer-wrapper which opens in header.pho -->

<?php 
    include ("/Includes/footer.php");
 ?>
