<?php

require_once "Includes/session.php";
require_once "Classes/class.batchteacher.php";
require_once "Classes/class.school.php";
require_once "Classes/class.user.php";

global $databaseConnection;

$batchId = $_REQUEST['batchId'];

if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userid']))
{
    if($_POST['action'] == 'add')
    {
        BatchTeacher::AddBatchTeacher($databaseConnection, $_REQUEST['batchId'], $_POST['userid']);        
    } else if($_POST['action'] == 'delete')
    {
        BatchTeacher::DeleteBatchTeacher($databaseConnection, $_REQUEST['batchId'], $_POST['userid']);        
    }
}

if(isset($batchId))
{
    //We read the values from the database.
    $batchSchools = School::getAllInBatch($databaseConnection, $batchId);
    $batchTeachers = User::getBatchSchoolTeachersInBatch($databaseConnection, $batchId);
    $availableTeachers = User::getBatchSchoolTeachersNotInBatch($databaseConnection, $batchId);
}
else 
{
    $batchSchools = array();
    $batchTeachers = array();
    $availableTeachers = array();
}


echo "<table>";
echo "<tr><th>Name</th><th>E-Mail</th><th>School</th><th>Remove</th></tr>";

    //We sort the teachers according to school.
    usort( $batchTeachers, 'User::CompareBySchool' ); 

    foreach($batchTeachers as $teacher)
    {
        //We find the school for the teacher.
        if(!isset($school) || $school->schoolid != $teacher->schoolid)
        {
            $school = School::getById($databaseConnection, $teacher->schoolid);
        }
        print "<tr><td>$teacher->username</td><td>$teacher->email</td><td>$school->name</td>"
        . "<td><form method='POST' action=$postPath> <input type=\"hidden\" value=\"$teacher->userid\" name=\"userid\"> <input type=\"hidden\" name=\"action\" value=\"delete\"> <input type=\"submit\" value=\"Delete\"></form></td>" 
        . "</tr>";
    }
echo "</table>";
 ?>

<label for="userid">Teachers</label>
<form method="post" action="<?php print "$postPath";?>">
    <input type="hidden" value="add" name="action">
<select name="userid">
    <?php
        foreach($availableTeachers as $user)
        {
            print "<option value='$user->userid'>$user->username</option>";
        }
    ?>
    </select>
    <input type="hidden" name="batchid" value="<?php print "$batchId";?>">
    <input type="submit" value="Add" id="add-user">
</form>
