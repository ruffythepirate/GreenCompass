<?php global $batchWorkshopId; ?>
    <div class="section">

        <div id="available-own-workshop-files">
            <?php include "Partials/partial_teacher_own_batchworkshop_files.php"?>
        </div>

        <form id="upload-file" action="admin_upload.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="50000000" />
            <input type="hidden" id="batchworkshopid" name="batchworkshopid" value="<?php echo "$batchWorkshopId";?>" />

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


<script type="text/javascript">

    function updateWorkshopFiles(workshopid) {
        $.ajax({
                type: "GET",
                url: "ajax_get_user_batchworkshopfiles.php",
                data: { batchworkshopid: workshopid }
            })
                .done(
                function (result) {
                    $("#available-own-workshop-files").html(result);
                });
    }

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

    $(document).ready(function () {
        $('#ajax-upload-button').click(function () {
            var fileSelect = $('#file-select');
            uploadFile(fileSelect.val());
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
    });

    function uploadFile(file) {
        var formData = new FormData($('#upload-file')[0]);
        formData.append('file', file)
        formData.append('size', file.size)
        formData.append('userid', 0)
        formData.append('filename', file.name)
        $.ajax({
            url: 'batchfile_upload.php',  //server script to process data
            type: 'POST',
            xhr: function () {  // custom xhr
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // check if upload property exists
                    //    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // for handling the progress of the upload
                }
                return myXhr;
            },
            //Ajax events
            beforeSend: function () {
                $('#upload-feedback').html('<h3>Upload starting...</h3>')
            },
            success: function (data, textStatus, jqXHR) {
                //var obj = jQuery.parseJSON(data);
                $('#upload-feedback').html('<h3>file uploaded!</h3>' + data); // + obj.message);
                updateWorkshopFiles(window.workshopid)

            },
            error: function () {
                $('#upload-feedback').html('<h3>file upload failed!</h3>')
            },
            // Form data
            data: formData,
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        });
    }
</script>