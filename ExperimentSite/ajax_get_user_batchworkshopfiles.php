<?php
    
    require_once("Includes/session.php");
    require_role('teacher');

    $batchWorkshopId = $_GET['batchworkshopid'];

    include "Partials/partial_teacher_own_batchworkshop_files.php";
     require_once "Includes/closeDB.php";
