<?php
require_once "Includes/Session.php";
require_once "Classes/class.batch.php";

global $databaseConnection;

$activeBatches = Batch::getActive($databaseConnection);

if(count($activeBatches) > 0)
{
    ?>
    <table>
        <tr><th>Name</th><th>Created</th></tr>
    <?php
    foreach($activeBatches as $batch) 
    {
        echo "<tr>";
        echo "<td><a href=\"admin_batch_edit.php?batchId=$batch->batchid\">$batch->name</a></td><td>$batch->createddate</td>";
        echo "</tr>";
    }
    ?>
    </table>
<?php
}else
{
    echo "No active batches available...";
}
