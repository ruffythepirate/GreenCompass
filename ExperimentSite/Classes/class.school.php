<?php
    class School {
        public $schoolid;
        public $name;
        public $countryid;
        public $created;
    
        function __construct($schoolid, $name, $countryid, $created)
        {
            $this->schoolid= $schoolid;
            $this->name     =$name;
            $this->countryid=$countryid;
            $this->created = $created;
        }

        public static function getAll($databaseConnection)
        {
            $query = "SELECT schoolid, name, countryid, createddate FROM schools";

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                array_push($array, new School($row->schoolid, $row->name, $row->countryid, $row->createddate));
            }
            return $array;            
        }

        public static function getById($databaseConnection, $schoolid)
        {
            $query = "SELECT schoolid, name, countryid, createddate FROM schools WHERE schoolid = $schoolid";

            $result = $databaseConnection->query($query);

            if($row = $result->fetch_object())
            {
                return new School($row->schoolid, $row->name, $row->countryid, $row->createddate);
            }
            return NULL;
        }

        public static function deleteById($databaseConnection, $schoolid)
        {
            $query = "DELETE FROM schools WHERE schoolid = $schoolid";

            if(!mysqli_query($databaseConnection, $query))
            {
                throw new Exception("Exception occurred when deleting school! " . $schoolid);
            }
        }

        public static function getAllNotInBatch($databaseConnection, $batchId)
        {
            $query = "SELECT schoolid, name, countryid, createddate FROM schools";

            if(isset($batchId))
            {
                $query = $query . " WHERE schoolid NOT IN (SELECT schoolid from batchschools WHERE batchid = $batchId)";
            }

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                array_push($array, new School($row->schoolid, $row->name, $row->countryid, $row->createddate));
            }
            return $array;            
        }

        public static function getAllInBatch($databaseConnection, $batchId)
        {
            $query = "SELECT schoolid, name, countryid, createddate FROM schools"
                   . " WHERE schoolid IN (SELECT schoolid from batchschools WHERE batchid = $batchId)";

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                array_push($array, new School($row->schoolid, $row->name, $row->countryid, $row->createddate));
            }
            return $array;            
        }

        public static function fromPost($post)
        {
            $schoolid =$post['schoolid'];
            $name     =$post['name'];
            $countryid=$post['countryid'];
            return new School($schoolid, $name, $countryid, NULL);            
        }

        public function insertToDatabase($databaseConnection)
        {
            $query = "INSERT INTO schools (name, countryid, createddate) VALUES "
            ." ('$this->name', $this->countryid, NOW()) ";

            if(! mysqli_query($databaseConnection, $query))
            {
                echo mysql_error();
                return FALSE;
            }
            $this->schoolid = $databaseConnection->insert_id;
            return TRUE;
        }

        public static function NameSort( $a, $b ) {
            return $a->name == $b->name ? 0 : ( $a->name > $b->name ) ? 1 : -1;
        }
    }
