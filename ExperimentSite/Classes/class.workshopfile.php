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
    
        public function saveToDatabase($databaseConnection)
        {
            if($this->workshopfileid)
            {
                $exists = WorkshopFile::fromDatabase($databaseConnection, $this->workshopfileid) != null;            
                if($exists)
                {
                    $this->updateToDatabase($databaseConnection);
                }
                else{
                    $this->insertToDatabase($databaseConnection);
                }
            } else 
            {
                $this->insertToDatabase($databaseConnection);
            }
        }
    
        private function insertToDatabase($databaseConnection)
        {
            $query = "INSERT INTO workshopfiles workshopid, languageid, filename, size, userid, createddate "
                    . " VALUES ($this->workshopid, $this->languageid, '$this->filename', $this->size, $this->userid, NOW())";
    
                    if(!mysqli_query($databaseConnection, $query))
                    {
                        echo mysql_error();
                        return FALSE;
                    }
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
