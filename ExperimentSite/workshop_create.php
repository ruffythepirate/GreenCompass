    <?php 
        include("Includes/header.php");         
        include("workshop_post_methods.php");         
     ?>

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
}?>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $successful = addWorkshop($databaseConnection, $_POST);
        //echo "<div class=\"section\"> Here it comes: $_POST[workshopname]</div>";
        if($successful)
        {
            echo "<div class=\"section\"> Insert successful!</div>";
        } else {
            echo "<div class=\"section\"> Insert failed!</div>";            
        }
    }    

    $workshops = getWorkshops($databaseConnection);
?>

    <div id="main">

    <div class="section">

    <h3><?php print msg('Create Workshop')?></h3>
        <form method="post" action="workshop_create.php">
            Name: <input type="text" name="workshopname"><br>
            <input type="submit" value="Save" >    
        </form>
            </div>
    <div class="section">
    <h3><?php print msg('Already Created Workshops')?></h3>
        <ul>
        <?php
            
        foreach($workshops as $workshop)
        {
            echo "<li> <a href=\"workshop_edit.php?id=$workshop->workshopid\">$workshop->workshopname</a></li>" ;
        }
        ?>
        </ul>
    </div>
</div> <!-- End of outer-wrapper which opens in header.pho -->

<?php 
    include ("/Includes/footer.php");
 ?>
