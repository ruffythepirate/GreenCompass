<?php
    class Batch {
        public $batchid;
        public $name;
        public $startdate;
        public $createddate;

        private static function fromDBRow($other)
        {
            $newItem = new Batch();
            $newItem->batchid = $other->batchid;
            $newItem->name = $other->name;
            $newItem->createddate = $other->createddate;
            $newItem->startdate = $other->startdate;
    
            return $newItem;
        }
    
        public static function getActive($databaseConnection)
        {
            $query = "SELECT * FROM batches";
    
            $result = $databaseConnection->query($query);
    
            $array = Array();
            while($row = $result->fetch_object())
            {
                array_push($array, Batch::fromDBRow($row));
            }
    
            return $array;
        }
    
        public static function fromPost($post)
        {
            $newItem = new Batch();
            $newItem->batchid =     $post['batchid'];
            $newItem->name =        $post['name'];
            $newItem->createddate = $post['createddate'];
            $newItem->startdate =   $post['startdate'];
            return $newItem;
        }
    
        public function saveToDatabase($databaseConnection)
        {
            if(isset($this->batchid))
            {
                $this->updateInDatabase($databaseConnection);
            }   
            else
            {
                $this->insertToDatabase($databaseConnection);
            }
        }
    
        private function updateInDatabase($databaseConnection)
        {
            $query = "UPDATE batches SET name = ? ";
            if(isset($this->startdate) && $this->startdate != '')
            {
                $query = $query . " , startdate = ? ";
            } else 
            {
                $query = $query . ", startdate = NULL ";
            }
    
            $query = $query . " WHERE batchid = ?";
    
            $statement = $databaseConnection->prepare($query);

            if(isset($this->startdate) && $this->startdate != '')
            {
                $statement->bind_param('ssi', $this->name, $this->startdate, $this->batchid);
            } else {
                $statement->bind_param('si',$this->name, $this->batchid);
            }
            
                        
            if(!$statement->execute() )
            {
                throw new Exception("Failed to Update Batch ($this->batchid) in DB! " . $query);     
            }
        }
    
        public static function fromId($databaseConnection, $batchId)
        {
            $query = "SELECT batchid, name, startdate, createddate FROM batches WHERE batchid = $batchId";

            $result = $databaseConnection->query($query);

            if($row = $result->fetch_object())
            {
                return Batch::fromDBRow($row);
            }
            return NULL;
        }

        private function insertToDatabase($databaseConnection)
        {
            $query = "INSERT INTO batches (name, startdate, createddate)";
            
            $query = $query . " VALUES (? ";
            $query = $query . ", NULL";
            $query = $query . ", NOW() )";

            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('s', $this->name);
                        
            if(!$statement->execute() )
            {
                throw new Exception("Failed to Insert Batch ($this->name) in DB! " . $query);     
            }

            $this->batchid = $databaseConnection->insert_id;
        }
    
    }
