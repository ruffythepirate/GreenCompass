<script type="text/javascript">
    $(document).ready(function () {

        $('#button-create-new').click(function () {
            loadPopupBox();
        });

        $('#close-add-language').click(function () {
            unloadPopupBox();
        });

        $('#add-language').click(function () {
            //We Add a form to the page.

            var languageId = $('#new-language-select').val();
            var languageName = $('#new-language-select option:selected').text();
            var workshopId = $('#WorkshopId').val();
            $.ajax({
                type: "GET",
                url: "ajax_new_language.php",
                data: { languageid: languageId, workshopid: workshopId }
            })
                .done(
                function (result) {
                    $("#workshop-forms").append(result);
                    $("#translation-language").append("<option value=" + languageId + ">" + languageName + "</option>");
                    $("#translation-language").val(languageId);
                    unloadPopupBox();
                    toggleVisibleTranslation();
                });
        });

        function unloadPopupBox() {    // TO Unload the Popupbox
            $('#new-translation-popup').fadeOut("slow");
            $("#container").css({ // this is just for style        
                "opacity": "1"
            });
        }

        function loadPopupBox() {    // To Load the Popupbox
            $('#new-translation-popup').fadeIn("slow");
            $("#container").css({ // this is just for style
                "opacity": "0.3"
            });
        }

        function toggleVisibleTranslation() {
            //Hides all the language sections.
            $('.translation-section').hide();
            //Displays the selected language section.
            var selectedLanguageId = $('#translation-language').val();
            if (selectedLanguageId != '') {
                $("#translation-section-" + selectedLanguageId).show();
            }
        }

        toggleVisibleTranslation();

        $('#translation-language').change(function () {
            toggleVisibleTranslation();
        });


        updateWorkshopPreview();
    });
    function getTranslationLanguageId() {
        return $('#translation-language').val();
    }

    function createBulletList(stringToMakeListFrom) {
        var bulletList = '';
        var bullets = new Array();
        if (stringToMakeListFrom != "" && typeof stringToMakeListFrom != "undefined") {
            bullets = stringToMakeListFrom.split('\n');
        }
        $.each(bullets, function (idx, bullet) {
            bulletList += ('<li>' + bullet.replace(/(<\/?)script/g, "$1noscript") + '</li>');
        });
        return bulletList;
    }

    function getPreviewWorkshopTitle() {
        return $('#input-title-' + getTranslationLanguageId()).val();
    }

    function getPreviewWorkshopBackground() {
        return $('#input-background-' + getTranslationLanguageId()).val();
    }

    function getPreviewGoals() {
        return createBulletList($('#input-goals-' + getTranslationLanguageId()).val());
    }

    function getPreviewTimeline() {
        return createBulletList($('#input-timeline-' + getTranslationLanguageId()).val());
    }

    function getPreviewExpectedResults() {
        return createBulletList($('#input-expected-information-' + getTranslationLanguageId()).val());
    }

    function updateWorkshopPreview() {
        var title = getPreviewWorkshopTitle();
        $('.title').html(title);
        $('#workshop-preview .background').html(getPreviewWorkshopBackground());
        $('#workshop-preview .goals ul').html(getPreviewGoals());
        $('#workshop-preview .timeline ul').html(getPreviewTimeline());
        $('#workshop-preview .expected-results ul').html(getPreviewExpectedResults());
    }

</script>
