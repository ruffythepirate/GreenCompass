<?php

require_once "Includes/session.php";
require_once "Classes/class.batchschool.php";
require_once "Classes/class.school.php";

global $databaseConnection;

$batchId = $_REQUEST['batchId'];

if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schoolid']))
{
    if($_POST['action'] == 'add')
    {

        BatchSchool::AddBatchSchool($databaseConnection, $_REQUEST['batchId'], $_POST['schoolid']);        
    }
}

if(isset($batchId))
{
    //We read the values from the database.
    $availableSchools = School::getAllNotInBatch($databaseConnection, $batchId);
    $batchSchools = School::getAllInBatch($databaseConnection, $batchId);
}
else 
{
    $availableSchools = School::getAll($databaseConnection);
    $batchSchools = array();
}


echo "<table>";
echo "<tr><th>Name</th><th>Users</th><th>Country</th><th>Remove</th></tr>";

    foreach($batchSchools as $school)
    {
        print "<tr><td>$school->name</td><td></td><td></td><td></td></tr>";
    }
echo "</table>";
 ?>

<label for="school">School</label>
<form method="post" action="<?php print "$postPath";?>">
    <input type="hidden" value="add" name="action">
<select name="schoolid">
    <?php
        $schools = School::getAllNotInBatch($databaseConnection, $batchId);
        foreach($schools as $school)
        {
            print "<option value='$school->schoolid'>$school->name</option>";
        }
    ?>
    </select>
    <input type="hidden" name="batchid" value="<?php print "$batchId";?>">
    <input type="submit" value="Add" id="add-school">
</form>
