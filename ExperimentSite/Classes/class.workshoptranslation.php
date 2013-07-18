<?php
class WorkshopTranslation {
    public $languageid;
    public $workshopid;
    public $workshoptranslationid;
    public $title;
    public $background;
    public $goals;
    public $timeline;
    public $expectedresults;

    public static function fromDictionary($dictionary)
    {
        $newItem = new WorkshopTranslation();

        $newItem->languageid = $dictionary['languageid'];
        $newItem->workshopid = $dictionary['workshopid'];
        $newItem->workshoptranslationid = $dictionary['workshoptranslationid'];
        $newItem->title = $dictionary['title'];
        $newItem->background = $dictionary['background'];
        $newItem->goals = $dictionary['goals'];
        $newItem->timeline = $dictionary['timeline'];
        $newItem->expectedresults = $dictionary['expectedresults'];

        return $newItem;
    }

    public static function fromDatabase($databaseConnection, $workshoptranslationid)
    {
        $query = "SELECT workshoptranslationid, workshopid, title, languageid, "
        . " background, goals, expectedresults, timeline, createddate FROM workshoptranslations "
        . "WHERE workshoptranslationid=$workshoptranslationid";
        $result = $databaseConnection->query($query);

        if($row = $result->fetch_object())
        {
            return $row;
        }
        return NULL;    
     }

    public static function fromWorkshopAndLanguageId($databaseConnection, $workshopid, $languageid)
    {
        $query = "SELECT workshoptranslationid, workshopid, title, languageid, "
        . " background, goals, expectedresults, timeline, createddate FROM workshoptranslations "
        . "WHERE workshopid=$workshopid AND languageid = $languageid";
        $result = $databaseConnection->query($query);

        if($row = $result->fetch_object())
        {
            return fromDBRow($row);
        }
        return NULL;    
     }

     public static function fromDBRow($other)
     {
                 $newItem = new WorkshopTranslation();

        $newItem->languageid =            $other->languageid;
        $newItem->workshopid =            $other->workshopid;
        $newItem->workshoptranslationid = $other->workshoptranslationid;
        $newItem->title =                 $other->title;
        $newItem->background =            $other->background;
        $newItem->goals =                 $other->goals;
        $newItem->timeline =              $other->timeline;
        $newItem->expectedresults =       $other->expectedresults;

        return $newItem;

     }

    public function saveToDatabase($databaseConnection)
    {

        //First we check if the translation already exists,
        if( $this->workshoptranslationid)
        {
        $existingWorkshop = WorkshopTranslation::fromDatabase($databaseConnection, $this->workshoptranslationid);
        if($existingWorkshop)
        {
            $this->updateToDatabase($databaseConnection);
        }
        else
        {
            $this->insertToDatabase($databaseConnection);            
        }
        }
        else
        {
            $this->insertToDatabase($databaseConnection);                        
        }
    }

    private function updateToDatabase($databaseConnection)
    {
        $query = "UPDATE workshoptranslations SET  "
        . "title = '$this->title', background = '$this->background', goals = '$this->goals',"
        . "timeline = '$this->timeline', expectedresults = '$this->expectedresults')"
        . " WHERE workshoptranslationid = $workshoptranslationid";

        if(!mysqli_query($databaseConnection, $query))
            {
                echo mysql_error();
                return FALSE;
            }

        return TRUE;
    }


    private function insertToDatabase($databaseConnection)
    {
        $query = "INSERT INTO workshoptranslations (languageid, workshopid, title, background, goals, timeline, expectedresults, createddate) "
        . "VALUES("
        . "$this->languageid, $this->workshopid, "
        . "'$this->title', '$this->background', '$this->goals',"
        . "'$this->timeline', '$this->expectedresults', NOW() )";

        if(!mysqli_query($databaseConnection, $query))
            {
                echo mysql_error();
                return FALSE;
            }

        return TRUE;
    }
}
?>