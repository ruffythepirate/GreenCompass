<?php global $workshopId;?>

<script type="text/javascript">


    function handleFileDrop(event) {
        $(event.target).removeClass("hover");

        event.preventDefault();
        event.stopPropagation();

        var files = event.dataTransfer.files;
        //Add the data to the form.
        for (var i = 0; i < files.length; i++) {
            uploadFile(files[i]);
        }
    }

    function updateWorkshopFiles(workshopid) {
        $.ajax({
            type: "GET",
            url: "ajax_get_workshopfiles.php",
            data: { workshopid: workshopid }
        })
                .done(
                function (result) {
                    $("#available-workshop-files").html(result);
                });
    }

    $(document).ready(function () {

        $('#button-create-new').click(function () {
            loadPopupBox();
            return false;
        });

        $('#close-add-language').click(function () {
            unloadPopupBox();
            return false;
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
                    $('#info-no-translations').hide();
                    $('#select-language-div').show();

                    unloadPopupBox();
                    toggleVisibleTranslation();
                });
                return false;
        });

        //Activates drag and drop
        if (window.FileReader && Modernizr.draganddrop) {
            var fileDrag = $('#file-drop-zone');

            fileDrag.bind('dragover', function (event) {
                $(event.target).addClass("hover");
            });

            fileDrag.bind('dragleave', function (event) {
                $(event.target).removeClass("hover");
            });

            $(document).bind('drop dragover', function (e) {
                e.preventDefault();
            });

            fileDrag.css('display', 'block');

            var fileDrop = document.getElementById('file-drop-zone');

            fileDrop.addEventListener('drop', handleFileDrop, false);
        }




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
            if (selectedLanguageId != '' && selectedLanguageId != null) {
                $("#translation-section-" + selectedLanguageId).show();
                $('#workshop-preview').show();
            } else {
                $('#workshop-preview').hide();
            }
        }

        toggleVisibleTranslation();

        $('#translation-language').change(function () {
            toggleVisibleTranslation();
        });

        updateWorkshopPreview();
    });

    function uploadFile(file) {
        var formData = new FormData($('#upload-file')[0]);
        formData.append('file', file)
        formData.append('size', file.size)
        formData.append('userid', 0)
        formData.append('filename', file.name)
        $.ajax({
            url: 'admin_upload.php',  //server script to process data
            type: 'POST',
            xhr: function () {  // custom xhr
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // check if upload property exists
                    myXhr.upload.addEventListener('progress', function (evt) {

                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded * 100) / evt.total);
                            $('#upload-progress').html('loaded '+ evt.loaded + ' total ' + evt.total + ' '+ percentComplete.toString() + "%");
                        } else {
                            $('#upload-progress').html("Unable to compute progress.");
                        }
                    }, false); // for handling the progress of the upload
                }
                return myXhr;
            },
            //Ajax events
            beforeSend: function () {
                $('#loading-screen-feedback').html('<h3>Uploading...</h3>')
            },
            success: function (data, textStatus, jqXHR) {
                $('#upload-feedback').html('<h3>File uploaded!</h3>');
                $('#upload-progress').html('');
                $('#loading-screen-feedback').html('')
            },
            error: function () {
                $('#upload-feedback').html('<h3>Upload failed!</h3>')
                $('#upload-progress').html('');
                $('#loading-screen-feedback').html('')
            },
            // Form data
            data: formData,
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        }).done(function(){
            updateWorkshopFiles(<?php echo"$workshopId";?>) 
        });
    }


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
        return '<h2>' + $('#input-title-' + getTranslationLanguageId()).val() + '</h2>';
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
