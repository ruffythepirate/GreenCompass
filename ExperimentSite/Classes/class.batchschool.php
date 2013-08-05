<?php
class BatchSchool 
{
    public $batchschoolid;
    public $batchid;
    public $schoolid;


    public static function AddBatchSchool($databaseConnection, $batchId, $schoolId)
    {
        $query="INSERT INTO BatchSchools (batchid, schoolid, createddate ) VALUES ($batchId, $schoolId, NOW())";

        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to add batch school (batchid = $batchId, schoolId = $schoolId");
        }
    }
}
