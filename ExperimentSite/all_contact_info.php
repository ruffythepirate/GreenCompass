<?php
    require_once("Includes/session.php");
    require_one_of_roles(array('admin', 'teacher') );


    require_once('Includes/header.php');
    require_once('Classes/class.user.php');
    require_once('Classes/class.school.php');
    require_once('Classes/class.country.php');
    

?>
<div class="section">
    <h2>Users</h2>
    <div id="user-list">
       <?php                
        include "Partials/partial_all_user_list.php";
        ?>
    </div>
</div>

<?php
    include ("Includes/footer.php");
