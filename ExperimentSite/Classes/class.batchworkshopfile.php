<?php
class BatchWorkshopFile {
    public $batchworkshopfileid;
    public $batchworkshopid;
    public $languageid;
    public $filename;
    public $size;
    public $userid;
    public $createddate;

    public static function fromDictionary($dictionary)
     {
         $return = new BatchWorkshopFile();
    
         $return->batchworkshopfileid = $dictionary['batchworkshopfileid'];
         $return->batchworkshopid = $dictionary['batchworkshopid'];
         $return->languageid = $dictionary['languageid'];
         $return->filename = $dictionary['filename'];
         $return->size = $dictionary['size'];
         $return->userid = $dictionary['userid'];
         $return->createddate = $dictionary['createddate'];
         return $return;
    }

    public static function GetByBatchWorkshopIdAndRole($databaseConnection, $batchWorkshopId, $roleValue)
    {
        $query = "SELECT bwf.* FROM batchworkshopfiles bwf "
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

    public static function getById($databaseConnection, $batchWorkshopFileId)
    {
        $query = "SELECT bwf.* FROM batchworkshopfiles bwf "
               . "WHERE bwf.batchworkshopfileid = $batchWorkshopFileId";

        $result = $databaseConnection->query($query);

        if($row = $result->fetch_object())
        {
            return BatchWorkshopFile::fromDBRow($row);
        }
        return NULL;
    }

    public static function deleteById($databaseConnection, $batchWorkshopFileId)
    {
        $query = "DELETE FROM batchworkshopfiles "
               . "WHERE batchworkshopfileid = $batchWorkshopFileId";

        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to delete batchworkshopfile ($batchWorkshopFileId)");
        }
    }
    
    public static function deleteByNameAndBatchWorkshopId($databaseConnection, $batchWorkshopId, $filename)
    {
        $query = "DELETE FROM batchworkshopfiles "
               . "WHERE batchworkshopid = $batchWorkshopId "
               . "AND filename = '$filename'";

        echo "$query";

        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to delete batchworkshopfile ($batchWorkshopId, $filename)");
        }
    }

    public static function GetByBatchWorkshopIdAndUserId($databaseConnection, $batchWorkshopId, $userId)
    {
        $query = "SELECT bwf.* FROM batchworkshopfiles bwf "
               . "WHERE bwf.batchworkshopid = $batchWorkshopId "
               . "AND bwf.userid = $userId";

         $returnArray = array();
        
         $result = $databaseConnection->query($query);

         while($row = $result->fetch_object())
         {
             $workshop = BatchWorkshopFile::fromDBRow($row);
             array_push($returnArray, $workshop);
         }

         return $returnArray;
    }

    public static function GetByBatchWorkshopId($databaseConnection, $batchWorkshopId)
    {
        $query = "SELECT bwf.* FROM batchworkshopfiles bwf "
               . "WHERE bwf.batchworkshopid = $batchWorkshopId ";
               

         $returnArray = array();
         
         $result = $databaseConnection->query($query);

         while($row = $result->fetch_object())
         {
             $workshop = BatchWorkshopFile::fromDBRow($row);
             array_push($returnArray, $workshop);
         }

         return $returnArray;
    }

    public function saveToDatabase($databaseConnection)
    {
        if($this->batchworkshopfileid)
        {
            $exists = BatchWorkshopFile::fromDatabase($databaseConnection, $this->batchworkshopfileid) != null;            
            if($exists)
            {
                return $this->updateToDatabase($databaseConnection);
            }
            else{
                return $this->insertToDatabase($databaseConnection);
            }
        } else 
        {
            return $this->insertToDatabase($databaseConnection);
        }
    }
    
    private function insertToDatabase($databaseConnection)
    {
        $query = "INSERT INTO batchworkshopfiles (batchworkshopid, filename, size, userid, createddate) "
                . " VALUES ($this->batchworkshopid, '$this->filename', $this->size, $this->userid, NOW())";
    
        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to save a batch workshop file ($this->filename) " . mysql_error() );
        }
    
        $this->batchworkshopfileid = $databaseConnection->insert_id;
    }
    
    private function updateToDatabase($databaseConnection)
    {
        $query = "UPDATE batchworkshopfiles SET languageid = $this->languageid "
        .", filename='$this->filename', size=$this->size, userid=$this->userid"
        ." WHERE batchworkshopfileid = $this->batchworkshopfileid";
        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Exception occurred when trying to update a batch workshop file ($this->filename) " . mysql_error() );
        }
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
