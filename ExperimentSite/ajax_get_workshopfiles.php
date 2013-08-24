<?php
    require_once("Includes/session.php");
    require_role('admin');

     $workshopId = $_REQUEST['workshopid'];
     include "Partials/partial_admin_workshop_files.php";
     require_once ("Includes/closeDB.php");
