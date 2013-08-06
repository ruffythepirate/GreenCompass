<?php
    require_once("Includes/session.php");
    require_role('admin');

    require_once "Classes/class.batchworkshop.php";

    global $databaseConnection;

    $batchWorkshopId = $_POST['batchworkshopid'];
    $publishDate = $_POST['publishdate'];

    BatchWorkshop::UpdatePublishDate($databaseConnection, $batchWorkshopId, $publishDate);
