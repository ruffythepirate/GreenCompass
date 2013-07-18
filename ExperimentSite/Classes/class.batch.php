<?php
class Batch {
    public $batchid;
    public $name;
    public $createddate;

    public static function getActive($databaseConnection)
    {
        $query = "SELECT * FROM batches";

        $result = $databaseConnection->query($query);

        $array = Array();
        while($row = $result->fetch_object())
        {
            array_push($array, fromDBRow($row));
        }

        return $array;
    }

    private static function fromDBRow($other)
    {
        $newItem = new Batch();
        $newItem->batchid = $other->batchid;
        $newItem->name = $other->name;
        $newItem->createddate = $other->createddate;

        return newItem;
    }


}
