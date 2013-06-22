<?php
    class Language {
    
        public $languageid;
        public $name;
    
            function __construct($languageid, $name)
            {
                $this->languageid = $languageid;
                $this->name = $name;
            }
    
        public static function getLanguages($databaseConnection)
        {
                $query = "SELECT languageid, name FROM languages";
                $result = $databaseConnection->query($query);
                $resultList = array();
                while($row = $result->fetch_object())
                {
                    $newLanguage = new Language($row->languageid, $row->name);
                    array_push($resultList, $newLanguage);
                }
                return $resultList;    
        }
    }
