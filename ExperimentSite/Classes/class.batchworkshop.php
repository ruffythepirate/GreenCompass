<?php
    
    class BatchWorkshop {
    
        public $batchworkshopid;
        public $batchid;
        public $workshopid;
        public $publishdate;
        public $createddate;
    
    public static function UpdatePublishDate($databaseConnection, $batchWorkshopId, $newPublishDate)
    {
        $query = "UPDATE BatchWorkshops SET publishdate = "
                 . (isset($newPublishDate) && $newPublishDate != '' ? " '$newPublishDate'" : " NULL ")
                 . " WHERE batchworkshopid = $batchWorkshopId";
                 
         if(!mysqli_query($databaseConnection, $query))
         {
             throw new Exception("Exception occurred when trying to update the publish date to ($newPublishDate) for batchWorkshopId = $batchWorkshopId");
         } 
    }
    
    public static function AddBatchWorkshop($databaseConnection, $batchId, $workshopId)
    {
        $query="INSERT INTO BatchWorkshops (batchid, workshopid, createddate ) VALUES ($batchId, $workshopId, NOW())";

        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to add batch workshop (batchid = $batchId, workshopId = $workshopId");
        }
    }

    public static function DeleteBatchWorkshop($databaseConnection, $batchId, $workshopId)
    {
        $query="DELETE FROM BatchWorkshops WHERE batchid = $batchId AND workshopId = $workshopId";

        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to delete batch workshop (batchid = $batchId, workshopId = $workshopId)");
        }
    }

        public static function forUser($databaseConnection, $userId)
        {
            $query = "SELECT bw.* FROM batchworkshops bw "
                   . "INNER JOIN batchteachers bt ON bw.batchid = bt.batchid "
                   . "WHERE bt.userid = $userId";
    
            $result = $databaseConnection->query($query);
    
            $array = array();
            while($row = $result->fetch_object())
            {
                $batchWorkshop = BatchWorkshop::fromDBRow($row);
                array_push($array, $batchWorkshop);
            }
            return $array;
        }

        public static function fromId($databaseConnection, $batchWorkshopId)
        {
            $query = "SELECT bw.* FROM batchworkshops bw "
                   . "WHERE bw.batchworkshopid = $batchWorkshopId";

            $result = $databaseConnection->query($query);

            if($row = $result->fetch_object())
            {
                return BatchWorkshop::fromDBRow($row);
            }
            return NULL;
        }

        public static function publishedForUser($databaseConnection, $userId)
        {
            $query = "SELECT bw.* FROM batchworkshops bw "
                   . "INNER JOIN batchteachers bt ON bw.batchid = bt.batchid "
                   . "WHERE bt.userid = $userId AND bw.publishdate <= NOW()";
    
            $result = $databaseConnection->query($query);
    
            $array = array();
            while($row = $result->fetch_object())
            {
                $batchWorkshop = BatchWorkshop::fromDBRow($row);
                array_push($array, $batchWorkshop);
            }
            return $array;
        }

    
        public static function fromDBRow($other)
        {
            $newBatchWorkshop = new BatchWorkshop();
    
           $newBatchWorkshop->batchworkshopid = $other->batchworkshopid;
           $newBatchWorkshop->batchid         = $other->batchid        ;
           $newBatchWorkshop->workshopid      = $other->workshopid ;
           $newBatchWorkshop->publishdate     = $other->publishdate;
           $newBatchWorkshop->createddate     = $other->createddate;

           return $newBatchWorkshop;
        }
    
    }
