    <?php 
        include("Includes/header.php");         
        include("workshop_post_methods.php");         
        include ("/Scripts/script_workshop_edit.php");
     ?>

<?php
    $id = $_REQUEST[id];
    $workshop = getWorkshop($databaseConnection, $id);
   
    $workshopTranslations = getWorkshopTranslations($databaseConnection, $id);

?>

    <div id="main">

    <div class="section">  
        <h3>Editing workshop. <?php $workshop->workshopname ?></h3>
        <select>
            <?php 
                $languages = getLanguages($databaseConnection);
                foreach($languages as $language)
                {
                    echo "<option value=\"$language->languageid\">$language->name</option>";
                }
            ?>
        </select>
        <a id="Button_CreateNew" href="#">Create for New Language</a>
    </div>

    <div id="WorkshopForms">
    <?php 
        foreach($workshopTranslations as $translation)
        {
            createWorkshopTranslationForm($databaseConnection, $translation);
        }
    ?>
    </div>
   
</div> <!-- End of outer-wrapper which opens in header.pho -->

<div id="newtranslationpopup" class="popup" hidden="hidden">
    Select the language to create a translation for:
        <select>
            <?php
                $languages = getWorkshopsUntranslatedLanguages($databaseConnection, $id);
                foreach($languages as $language)
                {
                    echo "<option value=\"$language->languageid\">$language->name</option>";
                }
            ?>
        </select>
        <a id="AddLanguage" href="#" class="button">Add</a>        <a id="CloseAddLanguage" href="#" class="button">Close</a>

</div>

<?php 
    include ("/Includes/footer.php");
 ?>


