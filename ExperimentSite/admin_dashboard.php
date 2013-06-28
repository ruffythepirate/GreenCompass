<?php
    require_once("Includes/session.php");
    require_role('admin');
require_once("Includes/header.php");
?>
    <div class="section">
        <?php include ("/Partials/partial_admin_workshops.php"); ?>
    </div>


</div>
<?php
require_once("Includes/footer.php");
