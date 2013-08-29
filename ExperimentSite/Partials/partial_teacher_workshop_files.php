<?php
    global $workshopTranslation;
    global $batchWorkshopId;
    global $workshopId;

    require_once "Classes/class.batchworkshopfile.php";
    require_once "Classes/class.workshopfile.php";
    require_once "Classes/class.user.php";
    require_once "Includes/session.php";
    require_once "Util/FileHelp.php";

    global $databaseConnection;
    
?>

<h2>Workshop Files</h2>
<table>
<tr><th>Name</th><th>Size</th><th>Uploaded By</th><th>Created</th><th>Download</th></tr>
<?php
    $workshopFiles = WorkshopFile::getWorkshopFiles($databaseConnection, $workshopId);
    foreach($workshopFiles as $workshopFile)
    {
        if(!isset($uploader) || $uploader->userid != $workshopFile->userid)
        {
            $uploader = User::fromId($databaseConnection, $workshopFile->userid);
        }
        print "<tr>";
        print "<td>$workshopFile->filename</td>";
        print "<td>". getFileSizeString($workshopFile->size) . "</td>";
        print "<td>$uploader->username</td>";
        print "<td>$workshopFile->createddate</td>";
        print "<td><a href=\"download_workshopfile.php?type=workshop&parentid=$workshopFile->workshopid&filename=$workshopFile->filename\">Here</a>";
        print "</tr>";
    }
?>
</table>

<h2>Uploaded by Others</h2>
<table>
<tr><th>Name</th><th>Size</th><th>Uploaded By</th><th>Created</th><th>Download</th></tr>
<?php
    $othersBatchWorkshopFiles = BatchWorkshopFile::GetByBatchWorkshopId($databaseConnection, $batchWorkshopId);
    foreach($othersBatchWorkshopFiles as $batchFile)
    {
        if($batchFile->userid != get_user_id())
        {
            if(!isset($uploader) || $uploader->userid != $batchFile->userid)
            {
                $uploader = User::fromId($databaseConnection, $batchFile->userid);
            }
            print "<tr>";
            print "<td>$batchFile->filename</td>";
            print "<td>". getFileSizeString($batchFile->size) . "</td>";
            print "<td>$uploader->username</td>";
            print "<td>$batchFile->createddate</td>";
            print "<td><a href=\"batch/$batchFile->batchworkshopid/$batchFile->filename\">Here</a>";
            print "</tr>";
        }
    }
?>
</table>