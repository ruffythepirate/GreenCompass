<?php
require_once ("Includes/session.php");
include('Classes/class.workshopfile.php');    

$fileName = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
$workshopId = $_POST['workshopId'];
$uploadFolder = "fileUploads/$workshopId/";

//Makes sure the upload folder exists.
if(!file_exists($uploadFolder))
{
    $createFolderResult = mkdir($uploadFolder);
    if(!$createFolderResult)
    {
        echo "Failed to create directory for upload!";
        exit();
    }
}

if($fileName)
{
    //Check if a folder already exists for the workshop, otherwise create one.

    file_put_contents($uploadFolder . $fileName, file_get_contents('php://input'));

    $fileMetadata = WorkshopFile::fromDictionary($_POST);
    $fileMetadata.saveToDatabase();

    echo "$fileName has been uploaded successfully! (alt 1)";
    exit();
} else{
        $file = $_FILES['file'];
            $fileName = $file['name'];
            move_uploaded_file(
                $file['tmp_name'],
                $uploadFolder . $fileName);
            $fileMetadata = WorkshopFile::fromDictionary($_POST);
            $fileMetadata->saveToDatabase($databaseConnection);

            echo "<p>$fileName has been uploaded successfully (alt 2)!</p>";
        
    }

require_once ("Includes/closeDB.php");
?>

