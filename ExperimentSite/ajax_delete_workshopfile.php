<?php
require_once ("Includes/session.php");
require_once('Classes/class.workshopfile.php');    

$workshopfileid = $_REQUEST['workshopfileid'];

    echo "DELETE workshopfileid = '$workshopfileid'";

    //1. Load the object from the database.
    $workshopFile = WorkshopFile::fromDatabase($databaseConnection, $workshopfileid);

    if($workshopFile != null)
    {
        //2. If object exists, remove file from hard drive.
        $filePath = "FileUploads/$workshopFile->workshopid/$workshopFile->filename";
        echo "Checking if filepath '$filePath' exists...";
        if(file_exists($filePath))
        {
            echo "Moving file...";
            rename($filePath,
            "FileUploads/old/$workshopFile->workshopid/$workshopFile->filename");
        }
        //3. After removing file, remove all entries in database with matching name / workshopid.
        $deleteSuccess = WorkshopFile::deleteByNameAndWorkshopId($databaseConnection, $workshopFile->filename, $workshopFile->workshopid);
        echo "Deleting from DB... $deleteSuccess.";
    }

    require_once ("Includes/closeDB.php");
?>

