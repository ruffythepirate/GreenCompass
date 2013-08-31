<?php
class BatchTeacher {
    public $batchteacherid;
    public $batchid;
    public $userid;
    public $createddate;

    public static function AddBatchTeacher($databaseConnection, $batchId, $userId)
    {
        $query = "INSERT INTO batchteachers (batchid, userid, createddate) VALUES (?, ?, NOW())";

        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ii', $batchId, $userId);
        
        if(!$statement->execute() )
        {
            throw new Exception("Exception occurred when trying to add a batch teacher (batchid = $batchId, userId = $userId");
        }
    }

    public static function DeleteBatchTeacher($databaseConnection, $batchId, $userId)
    {
        $query = "DELETE FROM batchteachers WHERE batchid= ? AND userid = ?";

        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ii', $batchId, $userId);
        
        if(!$statement->execute() )
        {
            throw new Exception("Exception occurred when trying to delete teacher from batch (batchId = $batchId, userId = $userId");
        }

    }
}
