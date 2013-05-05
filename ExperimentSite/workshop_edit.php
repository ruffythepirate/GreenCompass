    <?php 
        include("Includes/header.php");         
        include("workshop_post_methods.php");         
     ?>

<?php
    $id = $_REQUEST[id];
    $workshop = getWorkshop($databaseConnection, $id);

    //$workshopTranslations = getWorkshopTranslations($databaseConnection, $_REQUEST['id']);
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
        <a href="#">Create for New Language</a>
    </div>

    <?php 
       // foreach($workshopTranslations as $translation)
       // {
       //     createWorkshopTranslationForm($databaseConnection, $translation);
       // }
    ?>

</div> <!-- End of outer-wrapper which opens in header.pho -->

<div id="newtranslationpopup" class="popup">
    Select the language to create a translation for:
    <form method="POST" action="">
        <select>
            <?php
                $languages = getWorkshopsUntranslatedLanguages($databaseConnection, $workshop->workshopid);
                foreach($languages as $language)
                {
                    echo "<option value=\"$language->languageid\">$language->name</option>";
                }
            ?>
        </select>
        <input type="submit" />
    </form>
</div>

<?php 
    include ("/Includes/footer.php");
 ?>
