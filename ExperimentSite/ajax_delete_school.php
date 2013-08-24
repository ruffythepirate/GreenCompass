<?php
require_once "Includes/session.php";
require_role('admin');
require_once "Classes/class.school.php";

global $databaseConnection;

    //1. We delete the school.
School::deleteById($databaseConnection, $_POST['schoolId']);
