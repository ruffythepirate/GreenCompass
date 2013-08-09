<?php
require_once("Includes/session.php");
require_role('admin');
require_once("Classes/class.news.php");

if(isset($_POST['text']))
{
    $_POST['userid'] = $_SESSION['userid'];

    $newsItem = News::fromPost($_POST);

    global $databaseConnection;
    $newsItem->saveToDatabase($databaseConnection);
}


