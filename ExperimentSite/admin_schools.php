<?php 
    require_once("Includes/session.php");
    require_role('admin');

    require_once("Includes/header.php");         
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
        <?php include "Partials/partial_admin_school_list.php"; ?>
        <a href="admin_school_new.php"><?php print msg('Add New')?></a>
    </div>

    </div>

</div> <!-- End of outer-wrapper which opens in header.pho -->

<?php 
    include ("Includes/footer.php");
 ?>
