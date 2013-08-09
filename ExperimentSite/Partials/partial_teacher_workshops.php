<?php
require_once ("Classes/class.batchworkshop.php");
require_once ("Classes/class.workshoptranslation.php");
require_once ("Includes/session.php");

if(!logged_on())
{
    exit();
}

$user_id = get_user_id();

global $databaseConnection;


$batchworkshops = BatchWorkshop::publishedForUser($databaseConnection, $user_id);

if(count($batchworkshops) > 0)
{
    //We have workshops, create table with them.
?>
    <table>
    <tr><th>Name</th><th>Files</th><th>Status</th><th>Published</th></tr>
    <?php
        foreach($batchworkshops as $workshop)
        {
            $translation = WorkshopTranslation::fromWorkshopAndLanguageId($databaseConnection, 
                                                                        $workshop->workshopid,
                                                                        get_current_language());
            if($translation != NULL)
            {

            echo "<tr>";
            echo "<td><a href=\"teacher_workshop.php?batchworkshopid=$workshop->batchworkshopid\">$translation->title</a></td>";
            echo "<td>0</td>";
            echo "<td>N/A</td>";
            echo "<td>$workshop->publishdate</td>";
            echo "</tr>";
            }
            else
            {
                echo "<tr><td colspan=\"4\">No Translation Available.</td></tr>";                
            }
        }
 ?>    
    </table>

<?php

} else 
{
    //No workshops available. Show text saying no active workshops available.
            echo "No workshops available!";

}


