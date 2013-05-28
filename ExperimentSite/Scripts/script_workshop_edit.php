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


    });
</script>   
