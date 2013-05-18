,
<?php
    function validate($params)
    {
        $validationArray = array();

    }

    function addWorkshop($connection, $params)
    {
        
        $sqlQuery="INSERT INTO workshops (workshopname, createddate)
            VALUES ('$params[workshopname]', NOW())";

            if(!mysqli_query($connection, $sqlQuery))
            {
                echo mysql_error();
                return FALSE;
            }
       return TRUE;
    }

    function getWorkshopNames($databaseConnection)
    {
        //We load the countries so that we can group on the later.        
        $query = 'SELECT workshopname FROM Workshops';
        $result = $databaseConnection->query($query);
        $workshops = array();
        while($row = $result->fetch_object())
        {
            array_push($workshops, $row);
        }
        $result->close();

        return $workshops;
    }

     function getWorkshops($databaseConnection)
    {
        //We load the countries so that we can group on the later.        
        $query = 'SELECT workshopid, workshopname, createddate FROM Workshops';
        $result = $databaseConnection->query($query);
        $workshops = array();
        while($row = $result->fetch_object())
        {
            array_push($workshops, $row);
        }
        $result->close();

        return $workshops;
    }

    function getLanguages($databaseConnection)
    {
       //We load the countries so that we can group on the later.        
        $query = 'SELECT languageid, name FROM languages';
        $result = $databaseConnection->query($query);
        $languages = array();
        while($row = $result->fetch_object())
        {
            array_push($languages, $row);
        }
        $result->close();
        return $languages;    
    }

    function getWorkshopsUntranslatedLanguages($databaseConnection, $workshopid)
    {
        //mysql_real_escape_string($workshopid);
       //We load the countries so that we can group on the later.        
        $query = "SELECT languageid, name FROM languages WHERE languageid NOT IN (SELECT languageid FROM workshoptranslations WHERE workshopid=$workshopid)";
        $result = $databaseConnection->query($query);
        $languages = array();
        while($row = $result->fetch_object())
        {
            array_push($languages, $row);
        }
        $result->close();
        return $languages;    
    }

    function getWorkshopsTranslatedLanguages($databaseConnection, $workshopid)
    {
        //mysql_real_escape_string($workshopid);
       //We load the countries so that we can group on the later.        
        $query = "SELECT languageid, name FROM languages WHERE languageid IN (SELECT languageid FROM workshoptranslations WHERE workshopid=$workshopid)";
        $result = $databaseConnection->query($query);
        $languages = array();
        while($row = $result->fetch_object())
        {
            array_push($languages, $row);
        }
        $result->close();
        return $languages;    
    }

    function getWorkshop($databaseConnection, $workshopid)
    {
        $workshopid;
        //We load the countries so that we can group on the later.        
        $query = "SELECT workshopid, workshopname, createddate FROM Workshops WHERE workshopid='$workshopid'";
        $result = $databaseConnection->query($query);
        $returnResult = NULL;
        $row = $result->fetch_object();
        if($row)
        {
            $returnResult = $row;
        }
        $result->close();

        return $returnResult;
    }

    function getWorkshopTranslations($databaseConnection, $workshopid)
    {
        //$workshopid = mysql_real_escape_string($workshopid);
        //We load the countries so that we can group on the later.        
        $query = "SELECT workshoptranslationid, workshopid, title, languageid, background, goals, expectedresults, timeline, createddate FROM workshoptranslations WHERE workshopid=$workshopid";
        $result = $databaseConnection->query($query);

        $workshopTranslations = array();
        while($row = $result->fetch_object())
        {
            array_push($workshopTranslations, $row);
        }
        $result->close();

        return $workshopTranslations;
    }

    function createWorkshopTranslationForm($workshopTranslation)
    {
        echo '<div class="section">';
        echo '<h3>Translation</h3>';
        echo '<form action="workshop_edit.php" method="POST">';
        echo '<fieldset>';
        echo "<input type=\"hidden\" name=\"languageid\" value=\"$workshopTranslation->languageid\"/>";
        echo "<input type=\"hidden\" name=\"workshopid\" value=\"$workshopTranslation->workshopid\"/>";
        echo "<input type=\"hidden\" name=\"workshoptranslationid\" value=\"$workshopTranslation->workshoptranslationid\"/>";
        echo "<h3>Title</h3>";
        echo "<input type=\"text\" name=\"title\" value=\"$workshopTranslation->title\"/>";
        echo "<h3>Background</h3>";
        echo "<input type=\"text\" name=\"background\" value=\"$workshopTranslation->background\"/>";
        echo "<h3>Goals</h3>";
        echo "<input type=\"text\" name=\"goals\" value=\"$workshopTranslation->goals\"/>";
        echo "<h3>Timeplan</h3>";
        echo "<input type=\"text\" name=\"timeplan\" value=\"$workshopTranslation->timeline\"/>";
        echo "<h3>Expected Information</h3>";
        echo "<input type=\"text\" name=\"expectedinformation\" value=\"$workshopTranslation->expectedresults\"/>";
        echo "<input type=\"submit\" value=\"save\"/>";
        echo '</fieldset>';
        echo '</form>';
        echo '</div>';

    }
?>

