<?php
    include('workshop_post_methods.php');
    include('/Classes/class.workshoptranslation.php');
    
    $newWorkshopTranslation = new WorkshopTranslation();
    $newWorkshopTranslation->languageid = $_REQUEST["languageid"];
    $newWorkshopTranslation->workshopid = $_REQUEST["workshopid"];
    createWorkshopTranslationForm($newWorkshopTranslation)
?>
