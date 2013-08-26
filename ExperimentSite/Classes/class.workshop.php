<?php

class Workshop {
    
    public $workshopid;
    public $workshopname;
    public $createddate;


        public static function getAllNotInBatch($databaseConnection, $batchId)
        {
            $query = "SELECT workshopid, workshopname, createddate FROM workshops";

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
            $query = "SELECT workshopid, workshopname, createddate FROM workshops";

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
            $query = "SELECT ws.workshopid AS workshopid, ws.workshopname as workshopname, ws.createddate as createddate, bws.batchworkshopid as batchworkshopid, bws.publishdate as publishdate"
                   . " FROM workshops ws"
                   . " INNER JOIN batchworkshops bws ON bws.workshopid = ws.workshopid "
                   . " WHERE bws.batchid = $batchId";

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                $extendedWorkshop = Workshop::fromDBRow($row);
                $extendedWorkshop->batchworkshopid = $row->batchworkshopid;
                $extendedWorkshop->publishdate = $row->publishdate;
                array_push($array, $extendedWorkshop);
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

    public static function deleteById($databaseConnection, $workshopId)
    {
        $query = "DELETE FROM workshops "
        . " WHERE workshopid = ?";

        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('i', $workshopId);
            
        if(!$statement->execute() )
        {
            throw new Exception("Failed to delete a workshop!");
        }
        return NULL;
    }

}
