<?php
require_once "Includes/session.php";
require_role('admin');    

  require_once "Classes/class.batch.php";
  global $databaseConnection;

    $batchId = $_REQUEST['batchId'];

    $postPath = "admin_batch_edit.php" . (isset($batchId) ? "?batchId=$batchId" : "");

    if(isset($batchId))
    {
        $batch = Batch::fromId($databaseConnection, $batchId);
    }


if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    if( ! isset($batchId))
    {
        //1. We create a new batch with the given values
        global $databaseConnection;

        $newBatch = Batch::fromPost($_POST);
        $newBatch->saveToDatabase($databaseConnection);

        //2. We redirect to edit the newly created batch.
        header("location: admin_batch_edit?batchId=$newBatch->batchid".".php");
        exit();
    } else if($_POST['part'] == 'general')
    {
        $batchToUpdate = Batch::fromPost($_POST);
        $batchToUpdate->batchid = $batchId;
        $batchToUpdate->saveToDatabase($databaseConnection);  
        
        $batch = Batch::fromId($databaseConnection, $batchId);
    }
}  

include "Includes/header.php";
?>
<div class="section"><h2>Batch General Info</h2>
    <form method="POST" action="<?php print "$postPath";?>">
    <input type="hidden" name="part" value="general">
        <label for="name">Name</label> <br>
        <input type="text" name="name" <?php if(isset($batch)) {print "value=\"$batch->name\"";}?>><br>
    <label for="start-date">Start Date</label><br>
        <input type="date" name="startdate" <?php if(isset($batch) && isset($batch->startdate)) {print "value=$batch->startdate";}?>><br>
    <label for="state">State</label>    <br>
    <select name="state">
        <option value="1">Not activated</option>
        <option value="2">Active</option>
        <option value="3">Finished</option>
    </select>
        <input type="submit" value="Save">
    </form>
</div>
<div class="section"><h2>Batch Workshops</h2>
<?php include "Partials/partial_admin_batch_workshops.php"; ?>
</div>
<div class="section"><h2>Batch Schools</h2>
<?php include "Partials/partial_admin_batch_schools.php"; ?>
</div>
<div class="section"><h2>Batch Users</h2>
<?php include "Partials/partial_admin_batch_teachers.php"; ?>
</div>
</div>
<?php
include "Includes/Footer.php";
    