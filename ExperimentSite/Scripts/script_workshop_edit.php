<script type="text/javascript">
    $(document).ready(function () {

        $('#Button_CreateNew').click(function () {
            loadPopupBox();
        });

        $('#CloseAddLanguage').click(function () {
            unloadPopupBox();
        });

        $('#AddLanguage').click(function () {
            //We Add a form to the page.

            var languageId = $('#NewLanguageSelect').val();
            var languageName = $('#NewLanguageSelect option:selected').text();
            var workshopId = $('#WorkshopId').val();
            $.ajax({
                type: "GET",
                url: "ajax_new_language.php",
                data: { languageid: languageId, workshopid: workshopId }
            })
                .done(
                function (result) {
                    $("#WorkshopForms").append(result);
                    $("#translationLanguage").append("<option value=" + languageId + ">" + languageName + "</option>");
                    $("#translationLanguage").val(languageId);
                    unloadPopupBox();
                    toggleVisibleTranslation();
                });
        });

        function unloadPopupBox() {    // TO Unload the Popupbox
            $('#newtranslationpopup').fadeOut("slow");
            $("#container").css({ // this is just for style        
                "opacity": "1"
            });
        }

        function loadPopupBox() {    // To Load the Popupbox
            $('#newtranslationpopup').fadeIn("slow");
            $("#container").css({ // this is just for style
                "opacity": "0.3"
            });
        }

        function toggleVisibleTranslation() {
            //Hides all the language sections.
            $('.translationSection').hide();
            //Displays the selected language section.
            var selectedLanguageId = $('#translationLanguage').val();
            if (selectedLanguageId != '') {
                $("#translationSection_" + selectedLanguageId).show();
            }
        }

        toggleVisibleTranslation();

        $('#translationLanguage').change(function () {
            toggleVisibleTranslation();
        });


    });
</script>   
