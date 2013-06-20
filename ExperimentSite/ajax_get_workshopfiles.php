<?php
    require_once ("Includes/session.php");
     require_once('Classes/class.workshopfile.php');    
    require_once("workshop_post_methods.php");     

     $workshopid = $_REQUEST['workshopid'];
    
                 $workshopFiles = getWorkshopFiles($databaseConnection, $workshopid);
                 if($workshopFiles != NULL && sizeof($workshopFiles) > 0)
                 {
                     echo "<table>";
                     echo "<tr><th>Name</th><th>Size</th><th>Uploaded By</th><th>Created</th><th>Download</th><th>Hide</th><th>Delete</th></tr>";
                     foreach($workshopFiles as $workshopFile)
                     {
                     echo "<tr>"; 
                     echo "<td>$workshopFile->filename</td>";
                     echo "<td>". getFileSizeString($workshopFile->size) . "</td>";
                     echo "<td>No Name</td>";
                     echo "<td>$workshopFile->createddate</td>";
                     echo "<td><a href=\"\">Here</a></td>";
                     echo "<td>Hide</td>";
                     echo "<td><a class=\"delete-workshopfile\" data-workshopfileid=\"$workshopFile->workshopfileid\" href=\"#\">X</a></td>";
                 }
             echo "</table>";
                 }
    
?>


