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
echo "<tr><th>Name</th><th>Publish Date</th><th>Remove</th></tr>";

    foreach($batchWorkshops as $workshop)
    {
        print "<tr><td>$workshop->workshopname</td>"
        . "<td class=\"publish-date-container\"><input type=\"date\" value=$workshop->publishdate min=". date("Y-m-d") ." data-batchworkshopid=\"$workshop->batchworkshopid\" ></td>"
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

<script type="text/javascript">

    function setValueChangingClass(container, newClass) {
        container.removeClass('value-changing');
        container.removeClass('value-updated');
        container.removeClass('value-change-failed');

        container.addClass(newClass);

        if (newClass == 'value-updated' || newClass == 'value-change-failed') 
        { 
            setTimeout(function(){
                container.removeClass(newClass);
            },1000);
        }
    }

    $(document).ready(function () {
        $('.publish-date-container input[type="date"]').change(function () {

            //we read the value and the batchworkshopid.
            var newDate = $(this).val();
            var batchWorkshopId = $(this).attr('data-batchworkshopid');

            var container = $(this).closest('.publish-date-container');
            setValueChangingClass(container, 'value-changing');

            $.ajax({
                url: "ajax_batchworkshop_set_date.php",
                type: "POST",
                success: function (data, textStatus, jqXHR) {
                    setValueChangingClass(container, 'value-updated');
                },
                error: function () {
                    setValueChangingClass(container, 'value-change-failed');
                },
                data: { batchworkshopid: batchWorkshopId, publishdate: newDate }
            });

        });
    });
</script>
