<?php
    require_once("Includes/session.php");
    require_role('admin');

    require_once ("Includes/session.php");
    require_once('Classes/class.workshopfile.php');    
    
    $workshopfileid = $_REQUEST['workshopfileid'];
    
        //1. Load the object from the database.
        $workshopFile = WorkshopFile::fromDatabase($databaseConnection, $workshopfileid);
    
        if($workshopFile != null)
        {
            //2. If object exists, remove file from hard drive.
            $filePath = "FileUploads/workshop/$workshopFile->workshopid/";
            $backupFilePath = "FileUploads/old/$workshopFile->workshopid/";
    
            if(file_exists($filePath  . $workshopFile->filename))
            {
            if(!file_exists($backupFilePath))
            {
                if(!file_exists("FileUploads/old/"))
                {
                echo "Creating backup folder /FileUploads/old...";
                $createFolderResult = mkdir("FileUploads/old/");                    
                }

                echo "Creating backup folder $backupFilePath...";
                $createFolderResult = mkdir($backupFilePath);
                if(!$createFolderResult)
                {
                    echo "Failed to create backup folder...";
                    exit();
                }
            }
                echo "Moving file...";
                $successRename = rename($filePath  . $workshopFile->filename,
                 $backupFilePath . $workshopFile->filename);
                 if(!$successRename)
                 {
                    echo "Failed to remove file from folder!";
                    exit();                
                 }
            }
        }
            //3. After removing file, remove all entries in database with matching name / workshopid.
            $deleteSuccess = WorkshopFile::deleteByNameAndWorkshopId($databaseConnection, $workshopFile->filename, $workshopFile->workshopid);
            echo "Deleting from DB... $deleteSuccess.";
    
        require_once ("Includes/closeDB.php");
?>

