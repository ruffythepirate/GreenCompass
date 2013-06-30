<?php
    require_once "/Includes/session.php";
    require_once("/Classes/class.news.php");

    global $databaseConnection;
    $allNewsItems = News::getNews($databaseConnection);

    echo json_encode($allNewsItems);
    exit();
