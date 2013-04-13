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
    <h3><?php print msg('Create School')?></h3>
    </div>
    <div class="section">
    <h3><?php print msg('Create School')?></h3>
        <form method="post">
            <input type="text" id="schoolName">
            <input type="" id="schoolName">
        </form>
    </div>

    </div>

</div> <!-- End of outer-wrapper which opens in header.pho -->

<?php 
    include ("/Includes/footer.php");
 ?>
