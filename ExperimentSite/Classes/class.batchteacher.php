<?php
class BatchTeacher {
    public $batchteacherid;
    public $batchid;
    public $userid;
    public $createddate;

    public static function AddBatchTeacher($databaseConnection, $batchId, $userId)
    {
        $query = "INSERT INTO BatchTeachers (batchid, userid, createddate) VALUES ($batchId, $userId, NOW())";

        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to add a batch teacher (batchid = $batchId, userId = $userId");

        }
    }

    public static function DeleteBatchTeacher($databaseConnection, $batchId, $userId)
    {
        $query = "DELETE FROM batchteachers WHERE batchid= $batchId AND userid = $userId";

        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to delete teacher from batch (batchId = $batchId, userId = $userId");
        }

    }
}
