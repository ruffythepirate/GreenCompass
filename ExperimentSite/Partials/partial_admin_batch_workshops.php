<?php

require_once "Includes/session.php";
require_once "Classes/class.batchworkshop.php";
require_once "Classes/class.workshop.php";

global $databaseConnection;

$batchId = $_REQUEST['batchId'];

if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['workshopid']))
{
    if($_POST['action'] == 'add')
    {
        BatchWorkshop::AddBatchWorkshop($databaseConnection, $_REQUEST['batchId'], $_POST['workshopid']);        
    } else if($_POST['action'] == 'delete')
    {
        BatchWorkshop::DeleteBatchWorkshop($databaseConnection, $_REQUEST['batchId'], $_POST['workshopid']);        
    }
}

if(isset($batchId))
{
    //We read the values from the database.
    $availableWorkshops = Workshop::getAllNotInBatch($databaseConnection, $batchId);
    $batchWorkshops = Workshop::getAllInBatch($databaseConnection, $batchId);
}
else 
{
    $availableWorkshops = Workshop::getAll($databaseConnection);
    $batchWorkshops = array();
}


echo "<table>";
echo "<tr><th>Name</th><th>Remove</th></tr>";

    foreach($batchWorkshops as $workshop)
    {
        print "<tr><td>$workshop->workshopname</td>"
        . "<td><form method='POST' action=$postPath> <input type=\"hidden\" value=\"$workshop->workshopid\" name=\"workshopid\"> <input type=\"hidden\" name=\"action\" value=\"delete\"> <input type=\"submit\" value=\"Delete\"></form></td>" 
        . "</tr>";
    }
echo "</table>";
 ?>

<label for="school">Workshop</label>
<form method="post" action="<?php print "$postPath";?>">
    <input type="hidden" value="add" name="action">
<select name="workshopid">
    <?php
        $workshops = Workshop::getAllNotInBatch($databaseConnection, $batchId);
        foreach($workshops as $workshop)
        {
            print "<option value='$workshop->workshopid'>$workshop->workshopname</option>";
        }
    ?>
    </select>
    <input type="hidden" name="batchid" value="<?php print "$batchId";?>">
    <input type="submit" value="Add" id="add-workshop">
</form>
