<?php
    require_once "Includes/session.php";
    require_role('admin');
    require_once "Classes/class.workshop.php";

    global $databaseConnection;

    Workshop::deleteById($databaseConnection, $_POST['workshopid']);
