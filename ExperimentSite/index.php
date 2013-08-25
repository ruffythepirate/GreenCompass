<?php 
    require_once  ("Includes/session.php");
    if(!logged_on()) 
    {
        header("Location: logon.php");
        exit();
    }
    else if(is_admin())
    {
        header("Location: admin_dashboard.php");        
        exit();
    }
    else if(is_teacher())
    {
        header("Location: teacher_dashboard.php");
        exit();
    }

   require_once  ("Includes/header.php");

    ?>

</div> <!-- End of outer-wrapper which opens in header.pho -->

<?php 
    include ("Includes/footer.php");
 ?>