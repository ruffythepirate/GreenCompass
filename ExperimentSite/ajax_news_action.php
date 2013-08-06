<?php
    require_once("Includes/session.php");
    require_role('admin');
    require_once("Classes/class.news.php");

    $newsId = $_POST['newsid'];
    global $databaseConnection;

    if($_POST['operation'] == 'delete')
    {
        news::deleteNews($databaseConnection, $newsId);
    } else if($_POST['operation'] == 'toggle_publish')
    {
        news::toggleNewsPublish($databaseConnection, $newsId);        
    }

    require_once ("Includes/closeDB.php");
