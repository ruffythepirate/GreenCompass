<?php
    class WorkshopFile {
        public $workshopfileid;
        public $workshopid;
        public $languageid;
        public $filename;
        public $size;
        public $userid;
        public $createddate;
    
        public static function fromDictionary($dictionary)
        {
            $return = new WorkshopFile();
    
            $return->workshopfileid = $dictionary['workshopfileid'];
            $return->workshopid = $dictionary['workshopid'];
            $return->languageid = $dictionary['languageid'];
            $return->filename = $dictionary['filename'];
            $return->size = $dictionary['size'];
            $return->userid = $dictionary['userid'];
            $return->createddate = $dictionary['createddate'];
    
            return $return;
        }
    
        public static function fromDatabase($databaseConnection, $id)
        {
            $query = "SELECT workshopfileid, workshopid, languageid, filename, size, userid, createddate FROM workshopfiles WHERE workshopfileid=$id";
            $result = $databaseConnection->query($query);
            if($row = $result->fetch_object())
            {
                return $row;
            }
            return NULL;    
        }
    
        public static function getWorkshopFiles($databaseConnection, $workshopid)
        {
            $query = "SELECT workshopfileid, workshopid, languageid, filename, size, userid, createddate FROM workshopfiles WHERE workshopid=$workshopid";

            $result = $databaseConnection->query($query);
            
            $workshopFiles = array();
            while($row = $result->fetch_object())
            {
                array_push($workshopFiles, $row);
            }
            $result->close();
            return $workshopFiles;
        }

        public static function deleteByNameAndWorkshopId($databaseConnection, $filename, $workshopid)
        {
            $query = "DELETE FROM workshopfiles WHERE workshopid=$workshopid AND filename='$filename'";
            if(!mysqli_query($databaseConnection, $query))
            {
                 return FALSE;
            }
            return TRUE;    
        }
    
        public function getJsonArray()
        {
            $array = array('workshopfileid' => $this->workshopfileid, 
            'workshopid' => $this->workshopid,
            'languageid' => $this->languageid,
            'filename' => $this->filename,
            'size' => $this->size,
            'userid' => $this->userid, 
            'createddate' => $this->createddate);
            return $array; 
         } 
    
        public function saveToDatabase($databaseConnection)
        {
            if($this->workshopfileid)
            {
                $exists = WorkshopFile::fromDatabase($databaseConnection, $this->workshopfileid) != null;            
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
            $query = "INSERT INTO workshopfiles (workshopid, languageid, filename, size, userid, createddate) "
                    . " VALUES ($this->workshopid, $this->languageid, '$this->filename', $this->size, $this->userid, NOW())";
    
                    if(!mysqli_query($databaseConnection, $query))
                    {
                        echo mysql_error();
                        return FALSE;
                    }
    
                    $this->workshopfileid = $databaseConnection->insert_id;
    
                    return TRUE;
        }
    
        private function updateToDatabase($databaseConnection)
        {
            $query = "UPDATE workshopfiles SET languageid = $this->languageid "
            .", filename='$this->filename', size=$this->size, userid=$this->userid"
            ." WHERE workshopfileid = $this->workshopfileid";
            if(!mysqli_query($databaseConnection, $query))
            {
                echo mysql_error();
                return FALSE;
            }        
            return TRUE;
        }
    }
    
    
?>
