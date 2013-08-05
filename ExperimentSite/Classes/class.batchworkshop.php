<?php
    
    class BatchWorkshop {
    
        public $batchworkshopid;
        public $batchid;
        public $workshopid;
        public $publishdate;
        public $createddate;
    
    
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

        public static function publishedForUser($databaseConnection, $userId)
        {
            $query = "SELECT bw.* FROM batchworkshops bw "
                   . "INNER JOIN batchteachers bt ON bw.batchid = bt.batchid "
                   . "WHERE bt.userid = $userId AND bw.publishdate >= NOW()";
    
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