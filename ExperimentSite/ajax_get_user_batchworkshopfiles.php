<?php
    
    require_once("Includes/session.php");
    require_one_of_roles(array('admin', 'teacher') );

    $batchWorkshopId = $_GET['batchworkshopid'];

    include "Partials/partial_teacher_own_batchworkshop_files.php";
     require_once "Includes/closeDB.php";
