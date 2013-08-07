<?php
    require_once "Includes/session.php";

    global $databaseConnection;

    require_once "Classes/class.batchworkshopfile.php";

    $fileToRemove = BatchWorkshopFile::getById($databaseConnection, $_POST['batchworkshopfileid']);

    $hasCreatedFile = $fileToRemove->userid = get_user_id();

    if($hasCreatedFile || has_role('admin'))
    {
        //1. We move the file to old.
        if($fileToRemove != null)
        {
            //2. If object exists, remove file from hard drive.
            $filePath = "FileUploads/batch/$fileToRemove->batchworkshopid/";
            $backupFilePath = "FileUploads/old/batch/$fileToRemove->batchworkshopid/";
    
            if(file_exists($filePath . $fileToRemove->filename))
            {
                if(!file_exists($backupFilePath))
                {
                    if(!file_exists("FileUploads/old/"))
                    {
                        $createFolderResult = mkdir("FileUploads/old/");                    
                    }
                    if(!file_exists("FileUploads/old/batch"))
                    {
                        $createFolderResult = mkdir("FileUploads/old/batch/");                    
                    }
                $createFolderResult = mkdir($backupFilePath);
                if(!$createFolderResult)
                {
                    echo "Failed to create backup folder...";
                    exit();
                }
            }
                echo "Moving file...";
                $successRename = rename($filePath  . $fileToRemove->filename,
                 $backupFilePath . $fileToRemove->filename);
                 if(!$successRename)
                 {
                    echo "Failed to remove file from folder!";
                    exit();                
                 }
            }
        }
        //2. We remove the metadata.
        BatchWorkshopFile::deleteByNameAndBatchWorkshopId($databaseConnection,$fileToRemove->batchworkshopid,$fileToRemove->filename);
    }
    else
    {
        header("HTTP/1.0 500 Internal Server Error");
        exit();
    }
