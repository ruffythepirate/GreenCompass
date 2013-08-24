<?php
    global $workshopId;
    require_once "Includes/session.php";
    require_once "Classes/class.workshopfile.php";
    require_once "Util/FileHelp.php";

            global $databaseConnection;
            function getUserName($databaseConnection, $userId)
            {
                    $uploader = User::fromId($databaseConnection, $userId);
                if(isset($uploader))
                {
                    return $uploader->username;
                }                
                return "N/A";
            }

            $workshopFiles = WorkshopFile::getWorkshopFiles($databaseConnection, $workshopId);
            if($workshopFiles != NULL && sizeof($workshopFiles) > 0)
            {
                echo "<table>";
                echo "<tr><th>Name</th><th>Size</th><th>Uploaded By</th><th>Created</th><th>Download</th><th>Delete</th></tr>";
                foreach($workshopFiles as $workshopFile)
                {
                    $username = getUserName($databaseConnection, $workshopFile->userid);
                    echo "<tr>"; 
                    echo "<td>$workshopFile->filename</td>";
                    echo "<td>". getFileSizeString($workshopFile->size) . "</td>";
                    echo "<td>$username</td>";
                    echo "<td>$workshopFile->createddate</td>";
                    echo "<td><a href=\"download_workshopfile.php?type=workshop&parentid=$workshopFile->workshopid&filename=$workshopFile->filename\">Here</a>";
                    echo "<td><a class=\"delete-workshop-file\" data-workshopfileid=\"$workshopFile->workshopfileid\" href=\"#\">Delete</a></td>";
                }
                echo "</table>";
             }
        ?>

<script type="text/javascript">

   function updateWorkshopFiles(workshopid) {
   $.ajax({
       type: "GET",
       url: "ajax_get_workshopfiles.php",
       data: { workshopid: workshopid }
   })
    .done(function (result) {
       $("#available-workshop-files").html(result);
    });
    }
    $(document).ready(function () {
        $('.delete-workshop-file').click(function () {
            var fileid = $(this).attr('data-workshopfileid');

            $.ajax({
                type: "POST",
                url: "ajax_delete_workshopfile.php",
                data: { workshopfileid: fileid }
            }).done(function () {
               updateWorkshopFiles(<?php echo"$workshopId";?>) 
            });
        });
    });
</script>