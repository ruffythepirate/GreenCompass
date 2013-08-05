<?php
    require_once("Includes/session.php");
    require_role('admin');
    
    include("Includes/Header.php");
?>

<div class="section">
<h1>Batches</h1>
    <?php include "Partials/partial_admin_batch_list.php"; ?>

    <a href="admin_batch_edit.php">Add New</a>
</div>
</div>
<?php
include("Includes/Footer.php");    
