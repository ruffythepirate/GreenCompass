<?php
require_once ("Includes/session.php");
require_once('Classes/class.workshopfile.php');    

$workshopfileid = $_REQUEST['workshopfileid'];

    echo "DELETE workshopfileid = '$workshopfileid'";
require_once ("Includes/closeDB.php");
?>

