<?php
    $pageTitle = 'Edit Workshop';
    include("Includes/header.php");         
    require_once("Classes/class.workshoptranslation.php");     
    require_once("Classes/class.user.php");         
    
    include("workshop_post_methods.php");         
    include ("Scripts/script_workshop_edit.php");
?>

<?php
    $id = $_REQUEST[id];
    $workshopId = $id;
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

<script>
    window.workshopid = <?php echo "$id";?>
</script>

<div id="main">

    <div class="section">
        <h3>Editing workshop <?php echo "\"$workshop->workshopname\""; ?>.</h3>
        <?php
            
            $languages = getWorkshopsTranslatedLanguages($databaseConnection, $id);
            echo '<div id="select-language-div" ' . (count($languages) == 0 ? 'style="display: none;">' : '>');
            echo '<select id="translation-language">';
            foreach($languages as $language)
            {
                echo "<option value=\"$language->languageid\">$language->name</option>";
            }
            echo "</select>";
            echo '</div>';
            if(count($languages) == 0)
            {
                echo "<div id=\"info-no-translations\">There are currently no translations for this workshop.</div>";
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
    <div id="workshop-preview" class="section" style="display: none;">
        <div class="title"></div>
        <h3>Background</h3>
        <div class="background"></div>
        <h3>Goals</h3>
        <div class="goals"><ul></ul></div>
        <h3>Timeline</h3>
        <div class="timeline"><ul></ul></div>
        <h3>Expected Results</h3>
        <div class="expected-results"><ul></ul></div>
    </div>

    <div class="section">
        <div id="available-workshop-files">
        <?php include "Partials/partial_admin_workshop_files.php";?>
        </div>

        <?php include "Partials/partial_admin_upload_workshop.php";?>
    </div>


</div> <!-- End of outer-wrapper which opens in header.pho -->
<div id="new-translation-popup" class="popup" hidden="hidden">
    <?php
        echo "<input id=\"WorkshopId\" type=\"hidden\" value=\"$id\"/>";
    ?>
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
    
    include ("Includes/footer.php");
?>


