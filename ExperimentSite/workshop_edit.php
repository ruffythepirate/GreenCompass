<?php
    
    $pageTitle = 'Edit Workshop';
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

        <?php
            
                $workshopFiles = getWorkshopFiles($databaseConnection, $id);
                echo"Constructing table.... if workshopfiles is not null or empty.";
                if($workshopFiles != NULL && sizeof($workshopFiles) > 0)
                {
            echo "<table>";
                echo "<tr><th>Name</th><th>Size</th><th>Uploaded By</th><th>Created</th><th>Download</th><th>Hide</th><th>Delete</th></tr>";
                foreach($workshopFiles as $workshopFile)
                {
                    echo "<tr>"; 
                    echo "<td>$workshopFile->filename</td>";
                    echo "<td>". getFileSizeString($workshopFile->size) . "</td>";
                    echo "<td>No Name</td>";
                    echo "<td>$workshopFile->createddate</td>";
                    echo "<td><a href=\"\">Here</a></td>";
                    echo "<td>Hide</td>";
                    echo "<td><a class=\"delete-workshopfile\" data-look=\"hey\" data-workshopfileid=\"$workshopFile->workshopfileid\" href=\"#\">X</a></td>";
                }
            echo "</table>";
                }
        ?>

        <form id="upload-file" action="admin_upload.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="30000000" />
            <input type="hidden" id="workshopid" name="workshopid" value="<?php echo "$id";?>" />
            <input type="hidden" id="languageid" name="languageid" value="NULL" />

            <fieldset>
                <legend>Workshop File Upload</legend>
                <div><input type="file" id="file-select" name="fileselect[]" multiple="multiple" />
                    <div id="file-drop-zone">or drop files here</div>
                </div>
                <div id="submit-button">
                    <a id="ajax-upload-button" href="#">Ajax Upload Button</a>
                    <button type="submit">Upload Files</button>
                </div>
            </fieldset>
        </form>
        <div id="upload-feedback">
        </div>
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
    
    include ("/Includes/footer.php");
?>


