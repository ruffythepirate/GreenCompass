<?php

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

    file_put_contents($uploadFolder . $fileName,
                        file_get_contents('php://input'));

    echo "$fileName has been uploaded successfully!";
    exit();
} else{
    $files = $_FILES['fileselect'];
    foreach($files['error'] as $id => $err)
    {
        if($err == UPLOAD_ERR_OK) {
            $fileName = $files['name'][$id];
            move_uploaded_file(
            $files['tmp_name'][$id],
            $uploadFolder . $fileName);
            echo "<p>$fileName has been uploaded successfully!</p>";
        }
    }
}
?>
