    <?php 
        include("Includes/header.php");         
        include("Classes/class.workshoptranslation.php");         
        include("workshop_post_methods.php");         
        include ("/Scripts/script_workshop_edit.php");
     ?>

<?php
    $id = $_REQUEST[id];
    $workshop = getWorkshop($databaseConnection, $id);

    //We save the data that has been entered.
    if('POST' == $_SERVER['REQUEST_METHOD'])
    {
        $postedWorkshop = WorkshopTranslation::fromDictionary($_POST);
        $successful = $postedWorkshop->saveToDatabase($databaseConnection);
        if(successful)
        {
            echo "Translation has been saved to the database!";
        }
        else
        {
            echo "Saving translation to database failed!";
            
        }
    
    }

?>

    <div id="main">

    <div class="section">  
        <h3>Editing workshop <?php echo "\"$workshop->workshopname\""; ?>.</h3>
            <?php 
                $languages = getWorkshopsTranslatedLanguages($databaseConnection, $id);
                if(count($languages) > 0)
                {
                echo '<select id="translation-language">';
                foreach($languages as $language)
                {
                    echo "<option value=\"$language->languageid\">$language->name</option>";
                }
                echo "</select>";
                } else 
                {
                echo "There are currently no translations for this workshop.";                   
                }
            ?>
        <a id="button-create-new" href="#">Create for New Language</a>
    </div>

    <div id="workshop-forms">
    <?php 
        $workshopTranslations = getWorkshopTranslations($databaseConnection, $id);

        foreach($workshopTranslations as $translation)
        {
            createWorkshopTranslationForm($translation);
        }
    ?>
    </div>
        <div id="workshop-preview" class="section">
            <div class="title"></div>
            <div class="background"></div>
            <div class="goals"></div>
            <div class="timeline"></div>
            <div class="expectedresults"></div>
        </div>
   
</div> <!-- End of outer-wrapper which opens in header.pho -->

<div id="new-translation-popup" class="popup" hidden="hidden">
    <?php
        echo "<input id=\"WorkshopId\" type=\"hidden\" value=\"$id\"/>";?>
    Select the language to create a translation for:
        <select id="new-language-select">
            <?php
                $languages = getWorkshopsUntranslatedLanguages($databaseConnection, $id);
                foreach($languages as $language)
                {
                    echo "<option value=\"$language->languageid\">$language->name</option>";
                }
            ?>
        </select>
        <a id="add-language" href="#" class="button">Add</a>        <a id="close-add-language" href="#" class="button">Close</a>

</div>

<?php 
    include ("/Includes/footer.php");
 ?>


