<?php
    require_once ("Includes/session.php");
    require_one_of_roles(array('admin', 'teacher') );

    global $databaseConnection;

    require_once('Classes/class.batchworkshopfile.php');    
    require_once('Classes/class.operationresult.php');    
    
    $fileName = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
    $batchWorkshopId = $_POST['batchworkshopid'];
    $userId = $_SESSION['userid'];

    if(!isset($userId) || !isset($batchWorkshopId))
    {
        echo "UserId ($userId) or batchWorkshopId ($batchWorkshopId) not set...";
        exit();
    }
    //We put this data in so that the meta data can be read.
    $_POST['userid'] = $userId;


    $uploadFolder = "FileUploads/batch/$batchWorkshopId/";
    
    //Makes sure the upload folder exists.
    if(!file_exists($uploadFolder))
    {
        $createFolderResult = mkdir($uploadFolder);
        if(!$createFolderResult)
        {
            $result = new OperationResult(10, "Failed to create directory for upload! ($uploadFolder)", NULL);
            $result->jsonEncode();
            exit();
        }
    }
    
    if($fileName)
    {
        //Check if a folder already exists for the workshop, otherwise create one.
    
        file_put_contents($uploadFolder . $fileName, file_get_contents('php://input'));
    
        $fileMetadata = BatchWorkshopFile::fromDictionary($_POST);
        $fileMetadata->saveToDatabase($databaseConnection);
    
                     exit();
    } else{
            $file = $_FILES['file'];
            $fileName = $file['name'];
            $fileName = str_replace(" ","_",$fileName);
            
            $tmpFileName = $file['tmp_name'];
            $fileIsMoved = move_uploaded_file(
                $file['tmp_name'],
                $uploadFolder . $fileName);
            if($fileIsMoved)
            {
            $fileMetadata = BatchWorkshopFile::fromDictionary($_POST);
            $response = $fileMetadata->saveToDatabase($databaseConnection);
            if(!$response)
            {

            }
            else
            {

            }
            }
            else {

            }
        }
    
    require_once ("Includes/closeDB.php");