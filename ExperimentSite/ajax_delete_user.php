<?php
require_once "Includes/session.php";
require_role('admin');
require_once "Classes/class.user.php";

global $databaseConnection;

    User::deleteById($databaseConnection, $_POST['userId']);
