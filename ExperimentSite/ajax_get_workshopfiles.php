<?php
    require_once("Includes/session.php");
    require_role('admin');

    require_once ("Includes/session.php");
     require_once('Classes/class.user.php');    

     require_once('Classes/class.workshopfile.php');    
    require_once("workshop_post_methods.php");     

     $workshopid = $_REQUEST['workshopid'];
    
                 function getUserName($databaseConnection, $userId)
            {
                    $uploader = User::fromId($databaseConnection, $userid);
                if(isset($uploader))
                {
                    return $uploader->username;
                }                
                return "N/A";
            }

                 $workshopFiles = getWorkshopFiles($databaseConnection, $workshopid);
                 if($workshopFiles != NULL && sizeof($workshopFiles) > 0)
                 {
                     echo "<table>";
                     echo "<tr><th>Name</th><th>Size</th><th>Uploaded By</th><th>Created</th><th>Download</th><th>Hide</th><th>Delete</th></tr>";
                     foreach($workshopFiles as $workshopFile)
                     {
                                             $username = getUserName($databaseConnection, $workshopFile->userid);

                     echo "<tr>"; 
                     echo "<td>$workshopFile->filename</td>";
                     echo "<td>". getFileSizeString($workshopFile->size) . "</td>";
                     echo "<td>$username</td>";
                     echo "<td>$workshopFile->createddate</td>";
                     echo "<td><a href=\"\">Here</a></td>";
                     echo "<td>Hide</td>";
                     echo "<td><a class=\"delete-workshopfile\" data-workshopfileid=\"$workshopFile->workshopfileid\" href=\"#\">X</a></td>";
                 }
             echo "</table>";
                 }


