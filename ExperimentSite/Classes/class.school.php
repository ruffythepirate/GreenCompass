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
            $query = "SELECT schoolid, name, countryid, createddate FROM Schools";

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                array_push($array, new School($row->schoolid, $row->name, $row->countryid, $row->createddate));
            }
            return $array;            
        }

        public static function NameSort( $a, $b ) {
            return $a->name == $b->name ? 0 : ( $a->name > $b->name ) ? 1 : -1;
        }
    }
