        <form id="upload-file" action="admin_upload.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="50000000" />
            <input type="hidden" id="workshopid" name="workshopid" value="<?php echo "$id";?>" />
            <input type="hidden" id="languageid" name="languageid" value="NULL" />

            <fieldset>
                <legend>Workshop File Upload</legend>
                <div id="file-drop-zone">Drop files here</div>
            </fieldset>
        </form>
        <div id="upload-progress"></div>
        <div id="upload-feedback">
        </div>
