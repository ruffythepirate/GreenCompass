<?php
class BatchWorkshopFile {
    public $batchworkshopfileid;
    public $batchworkshopid;
    public $languageid;
    public $filename;
    public $size;
    public $userid;
    public $createddate;


    public static function GetByBatchWorkshopIdAndRole($databaseConnection, $batchWorkshopId, $roleValue)
    {
        $query = "SELECT bwf.* FROM BatchWorkshopFiles bwf "
               . "INNER JOIN Users u ON u.id = bwf.userid "
               . "INNER JOIN users_in_roles uir ON u.id = uir.user_id "
               . "INNER JOIN roles r ON r.id = uir.role_id "
               . "WHERE bwf.batchworkshopid = $batchWorkshopId "
               . "AND r.value = '$roleValue'";
               

         $returnArray = array();
         
         $result = $databaseConnection->query($query);

         while($row = $result->fetch_object())
         {
             $workshop = BatchWorkshopFile::fromDBRow($row);
             array_push($returnArray, $workshop);
         }

         return $returnArray;
    }

    private static function fromDBRow($other) {
        $returnValue = new BatchWorkshopFile();

        $returnValue->batchworkshopfileid =   $other->batchworkshopfileid;
        $returnValue->batchworkshopid     =       $other->batchworkshopid;
        $returnValue->languageid          =            $other->languageid;
        $returnValue->filename            =              $other->filename;
        $returnValue->size                =                  $other->size;
        $returnValue->userid              =                $other->userid;
        $returnValue->createddate         =           $other->createddate;

        return $returnValue;
    }

}
