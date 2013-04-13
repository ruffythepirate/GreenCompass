    <?php 
        require_once ("Includes/simplecms-config.php"); 
        require_once  ("Includes/connectDB.php");
        include("Includes/header.php");         
     ?>

<?php
$messages = array (
    'se'=> array(
        'My favorite foods are' =>
            'My favourite foods are',
        'french fries' => 'chips',
        'biscuit' => 'scone',
        'candy' => 'sweets',
        'potato chips' => 'crisps',
        'cookie' => 'biscuit',
        'corn' => 'maize',
        'eggplant' => 'aubergine'
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
    <h3><?php print msg('Admin Users')?></h3>
    </div>
    <div class="section">
    <h3><?php print msg('Users')?></h3>
    </div>


    </div>

</div> <!-- End of outer-wrapper which opens in header.pho -->

<?php 
    include ("Includes/footer.php");
 ?>
