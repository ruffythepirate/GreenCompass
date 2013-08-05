<?php

class Workshop {
    
    public $workshopid;
    public $workshopname;
    public $createddate;


        public static function getAllNotInBatch($databaseConnection, $batchId)
        {
            $query = "SELECT workshopid, workshopname, createddate FROM Workshops";

            if(isset($batchId))
            {
                $query = $query . " WHERE workshopid NOT IN (SELECT workshopid from batchworkshops WHERE batchid = $batchId)";
            }

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                array_push($array, Workshop::fromDBRow($row));
            }
            return $array;            
        }

        public static function getAll($databaseConnection)
        {
            $query = "SELECT workshopid, workshopname, createddate FROM Workshops";

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                array_push($array, Workshop::fromDBRow($row));
            }
            return $array;            
        }

        public static function getAllInBatch($databaseConnection, $batchId)
        {
            $query = "SELECT workshopid, workshopname, createddate FROM Workshops"
                   . " WHERE workshopid IN (SELECT workshopid from batchworkshops WHERE batchid = $batchId)";

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                array_push($array, Workshop::fromDBRow($row));
            }
            return $array;            
        }

        private static function fromDBRow($other)
        {
            $newItem = new Workshop();

            $newItem->workshopid = $other->workshopid;
            $newItem->workshopname = $other->workshopname;
            $newItem->createddate = $other->createddate;

            return $newItem;
        }



}
