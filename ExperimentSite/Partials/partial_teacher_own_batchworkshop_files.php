        <h2>Uploaded by You</h2>
        <table>
        <tr><th>Name</th><th>Size</th><th>Uploaded By</th><th>Created</th><th>Download</th></tr>
        <?php
            
            require_once "Classes/class.batchworkshopfile.php";

            global $databaseConnection;
            global $batchWorkshopId;
            $teacherBatchWorkshopFiles = BatchWorkshopFile::GetByBatchWorkshopIdAndUserId($databaseConnection, $batchWorkshopId, get_user_id());
            foreach($teacherBatchWorkshopFiles as $batchFile)
            {
                if(!isset($uploader) || $uploader->userid != $batchFile->userid)
                {
                    $uploader = User::fromId($databaseConnection, $batchFile->userid);
                }
                print "<tr>";
                print "<td>$batchFile->filename</td>";
                print "<td>". getFileSizeString($batchFile->Size) . "</td>";
                print "<td>$uploader->username</td>";
                print "<td>$batchFile->createddate</td>";
                print "<td><a href=\"batch/$batchFile->batchworkshopid/$batchFile->filename\">Here</a>";
                print "</tr>";
            }
        ?>
        </table>
