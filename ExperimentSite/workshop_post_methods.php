<?php
    require_once "Util/FileHelp.php";    

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

    require_once "Classes/WorkshopFile.php";

    function getWorkshopFiles($databaseConnection, $workshopid)
    {
        return WorkshopFile::getWorkshopFiles($databaseConnection, $workshopid);
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
        echo "\n".'<div id="translation-section-'.$workshopTranslation->languageid .'"class="section translation-section">';
        echo "\n".'<h3>Translation</h3>';
        echo "\n"."<form action=\"admin_workshop_edit.php?id=$workshopTranslation->workshopid\" method=\"POST\">";
        echo "\n".'<fieldset>';
        echo "\n"."<input type=\"hidden\" name=\"languageid\" value=\"$workshopTranslation->languageid\"/>";
        echo "\n"."<input type=\"hidden\" name=\"workshopid\" value=\"$workshopTranslation->workshopid\"/>";
        echo "\n"."<input type=\"hidden\" name=\"workshoptranslationid\" value=\"$workshopTranslation->workshoptranslationid\"/>";
        echo "\n"."<h3>Title</h3>";
        echo "\n"."<input id=\"input-title-$workshopTranslation->languageid\" type=\"text\" name=\"title\" value=\"$workshopTranslation->title\"/>";
        echo "\n"."<h3>Background</h3>";
        echo "\n"."<textarea id=\"input-background-$workshopTranslation->languageid\" name=\"background\">$workshopTranslation->background</textarea>";
        echo "\n"."<h3>Goals</h3>";
        echo "\n"."<textarea id=\"input-goals-$workshopTranslation->languageid\" name=\"goals\">$workshopTranslation->goals</textarea>";
        echo "\n"."<h3>Timeplan</h3>";
        echo "\n"."<textarea id=\"input-timeline-$workshopTranslation->languageid\" name=\"timeline\">$workshopTranslation->timeline</textarea>";
        echo "\n"."<h3>Expected Information</h3>";
        echo "\n"."<textarea id=\"input-expected-information-$workshopTranslation->languageid\" name=\"expectedresults\">$workshopTranslation->expectedresults</textarea>";
        echo "\n"."<input type=\"submit\" value=\"save\"/>";
        echo "\n".'</fieldset>';
        echo "\n".'</form>';
        echo "\n".'</div>';
        echo "\n".'<script>';
        echo "\n".'$(document).ready(function () {';
        echo "\n"."$('#input-title-$workshopTranslation->languageid').change(function() { ";
        echo "\n".'updateWorkshopPreview();';
        echo "\n".'});';
        echo "\n"."$('#input-background-$workshopTranslation->languageid').change(function() { ";
        echo "\n".'updateWorkshopPreview();';
        echo "\n".'});';
        echo "\n"."$('#translation-section-$workshopTranslation->languageid textarea').change(function() { ";
        echo "\n".'updateWorkshopPreview();';
        echo "\n".'});';
        echo "\n".'});';
        echo "\n".'</script>';
    }
?>

