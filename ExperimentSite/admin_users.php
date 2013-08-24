<?php
    require_once("Includes/session.php");
    require_role('admin');

    require_once('Includes/header.php');
    require_once('Classes/class.user.php');
    require_once('Classes/class.school.php');
    require_once('Classes/class.country.php');
    

?>

<div class="section">
    <h1>Admin Users</h1>
</div>

<div class="section">
    <h2>Users</h2>
    <h3>Admin</h3>

    <div id="user-list">
       <?php                
        include "Partials/partial_admin_user_list.php";
        ?>
    </div>
    <a href="admin_user_new.php">Add New</a>
</div>

<?php
    include ("Includes/footer.php");
