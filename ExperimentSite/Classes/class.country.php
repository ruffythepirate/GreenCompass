<?php
    class Country {
        public $countryid;
        public $name;
    
        function __construct($countryid, $name )
        {
            $this->countryid=$countryid;
            $this->name     =$name;
        }

        public static function getAll($databaseConnection)
        {
            $query = "SELECT * FROM countries";

            $result = $databaseConnection->query($query);

            $array = array();
            while($row = $result->fetch_object())
            {
                array_push($array, new Country($row->countryid, $row->name));
            }
            return $array;            
        }

        public static function CountrySort( $a, $b ) {
            return $a->name == $b->name ? 0 : ( $a->name > $b->name ) ? 1 : -1;
        }
    }
