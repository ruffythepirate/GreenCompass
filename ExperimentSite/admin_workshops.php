<?php 
    require_once("Includes/session.php");
    require_role('admin');


        require_once ("Includes/header.php");         
        require_once("workshop_post_methods.php");         
     ?>

<?php
$messages = array (
    'se'=> array( //ok
        'Create Workshop' =>
            'Skapa Workshop'
    )
);

function work_msg($s) {
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

?>

    <div id="main">

    <div class="section">

    <h3><?php print work_msg('Create Workshop')?></h3>
        <form method="post" action="admin_workshops.php">
            Name: <input type="text" name="workshopname"><br>
            <input type="submit" value="Save" >    
        </form>
            </div>

    <div class="section" id="available-workshops">
        <?php include ("Partials/partial_admin_workshops.php"); ?>
    </div>
</div> <!-- End of outer-wrapper which opens in header.pho -->

<?php 
    include ("Includes/footer.php");
