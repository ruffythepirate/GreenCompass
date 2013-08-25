        <form id="upload-file" action="admin_upload.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="50000000" />
            <input type="hidden" id="workshopid" name="workshopid" value="<?php echo "$id";?>" />
            <input type="hidden" id="languageid" name="languageid" value="NULL" />

            <fieldset>
                <legend>Workshop File Upload</legend>
                <div><input type="file" id="file-select" name="fileselect[]" multiple="multiple" />
                    <div id="file-drop-zone">or drop files here</div>
                </div>
                <div id="submit-button">
                    <button type="submit">Upload Files</button>
                </div>
            </fieldset>
        </form>
        <div id="upload-progress"></div>
        <div id="upload-feedback">
        </div>
