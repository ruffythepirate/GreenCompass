<?php
    require_once ("Includes/session.php");
    require_once('Classes/class.workshopfile.php');    
    require_once('Classes/class.operationresult.php');    
    
    $fileName = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
    $workshopId = $_POST['workshopid'];
    $uploadFolder = "FileUploads/$workshopId/";
    
    //Makes sure the upload folder exists.
    if(!file_exists($uploadFolder))
    {
        $createFolderResult = mkdir($uploadFolder);
        if(!$createFolderResult)
        {
            $result = new OperationResult(10, "Failed to create directory for upload!", NULL);
            $result->jsonEncode();
            exit();
        }
    }
    
    if($fileName)
    {
        //Check if a folder already exists for the workshop, otherwise create one.
    
        file_put_contents($uploadFolder . $fileName, file_get_contents('php://input'));
    
        $fileMetadata = WorkshopFile::fromDictionary($_POST);
        $fileMetadata->saveToDatabase($databaseConnection);
    
            $result = new OperationResult(10, "$fileName has been uploaded successfully! (alt 1)", NULL);
                     $result->jsonEncode();
                     exit();
        echo "";
        exit();
    } else{
            $file = $_FILES['file'];
            $fileName = $file['name'];
            $fileName = str_replace(" ","_",$fileName);
            
            $tmpFileName = $file['tmp_name'];
            echo "Temp path is: $tmpFileName.";
            $fileIsMoved = move_uploaded_file(
                $file['tmp_name'],
                $uploadFolder . $fileName);
            if($fileIsMoved)
            {
            $fileMetadata = WorkshopFile::fromDictionary($_POST);
            $response = $fileMetadata->saveToDatabase($databaseConnection);
            if(!$response)
            {
                 $result = new OperationResult(1, "<p>$fileName has been uploaded successfully, but metadata is not saved!</p>",
                 $fileMetadata);
                 $result->jsonEncode();
                 exit();
            }
            else
            {
                 $result = new OperationResult(0, 
                 "<p>$fileName has been uploaded successfully (alt 2)!</p>",
                 $fileMetadata);
                 $result->jsonEncode();
                 exit();
            }
            }
            else {
                 $result = new OperationResult(0, 
                 "<p>Failed to copy $fileName!</p>",
                 $fileMetadata);
                 $result->jsonEncode();
                 exit();                
            }
        }
    
    require_once ("Includes/closeDB.php");
?>

