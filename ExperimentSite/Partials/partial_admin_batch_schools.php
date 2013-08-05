<?php

require_once "Classes/class.school.php";
require_once "Includes/session.php";

global $databaseConnection;

$batchId = $_REQUEST['batchid'];

if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schoolid']))
{
    
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

?> 
<table> 
    <tr><th>Name</th><th>Users</th><th>Country</th><th>Remove</th></tr>
<?php
 ?>
</table>

<label for="school">School</label>
<select name="school">
    <?php
        $schools = School::getAllNotInBatch($databaseConnection, $batchId);
        foreach($schools as $school)
        {
            print "<option value='$school->schoolid'>$school->name</option>";
        }
    ?>
</select>
<a id="add-school">Add</a>


<script type="text/javascript">
    $(document).ready(function () {
        $('#add-school').click(function () {

        });
    });

</script>