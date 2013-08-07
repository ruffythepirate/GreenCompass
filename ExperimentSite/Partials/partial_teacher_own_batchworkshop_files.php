        <h2>Uploaded by You</h2>
        <table>
        <tr>
            <th>Name</th>
            <th>Size</th>
            <th>Uploaded By</th>
            <th>Created</th>
            <th>Download</th>
            <th>Delete</th>
        </tr>
        <?php
            
            require_once "Classes/class.batchworkshopfile.php";
            require_once "Util/FileHelp.php";

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
                print "<td><a href=\"download_workshopfile.php?type=batch&parentid=$batchFile->batchworkshopid&filename=$batchFile->filename\">Here</a>";
                print "<td><a href=\"#\" class=\"delete-own-file\" data-batchworkshopfileid=\"$batchFile->batchworkshopfileid\">Delete</a>";
                print "</tr>";
            }
        ?>
        </table>
<script type="text/javascript">
    $(document).ready(function () {
        $('.delete-own-file').click(function () {
            var fileid = $(this).attr('data-batchworkshopfileid');

            $.ajax({
                type: "POST",
                url: "ajax_delete_batchworkshopfile.php",
                data: { batchworkshopfileid: fileid }
            }).done(function () {
               updateWorkshopFiles(<?php echo"$batchWorkshopId";?>) 
            });
        });
    });
</script>