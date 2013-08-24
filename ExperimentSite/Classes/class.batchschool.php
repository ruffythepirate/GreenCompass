<?php
class BatchSchool 
{
    public $batchschoolid;
    public $batchid;
    public $schoolid;


    public static function AddBatchSchool($databaseConnection, $batchId, $schoolId)
    {
        $query="INSERT INTO batchschools (batchid, schoolid, createddate ) VALUES (?, ?, NOW())";

        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ii', $batchId, $schoolId);
        
        if(!$statement->execute() )
        {
            throw new Exception("Exception occurred when trying to add batch school (batchid = $batchId, schoolId = $schoolId.. $query");
        }
    }

    public static function DeleteBatchSchool($databaseConnection, $batchId, $schoolId)
    {
        $query="DELETE FROM batchschools WHERE batchid = ? AND schoolid = ?";

        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ii', $batchId, $schoolId);
        
        if(!$statement->execute() )
        {
            throw new Exception("Exception occurred when trying to delete batch school (batchid = $batchId, schoolid = $schoolId).. $query");
        }
    }
}
