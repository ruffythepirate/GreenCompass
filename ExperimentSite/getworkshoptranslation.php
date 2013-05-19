<?php
    require_once ("Includes/session.php");

    //We read the language id and the workshop id from the query string.
        $languageid = $_GET['languageid'];
        $workshopid = $_GET['workshopid']
        
        $query = 'SELECT workshoptranslationid, background, goals, expectedresults, timeline FROM workshoptranslations WHERE workshopid = ? AND languageid = ? LIMIT 1';
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('s', $languageid);
        $statement->bind_param('s', $workshopid);
        $statement->execute();
        $statement->store_result();
        if ($statement->error)
        {
            die('Database query failed: ' . $statement->error);
        }

        if ($statement->num_rows == 1)
        {
            $statement->bind_result($workshoptranslationid, $background, $goals, $expectedresults, $timeline);
            $statement->fetch();
        }


        $messages = array (
            'se'=> array(
                'Background' => 'Bakgrund',
                'Goals' => 'Mål',
                'Timeplan' => 'Tidsplan',
                'Expected Information' => 'Förväntad information')
);

function msg($s) {
    global $LANG;
    global $messages;
    
    if (isset($messages[$LANG][$s])) {
        return $messages[$LANG][$s];
    } else {
        return $s;
    }
}?>
<form action="getworkshoptranslation.php">
    <input type="hidden" value="<?php $workshoptranslationid?>">
    <h3><?php print msg('Background')?></h3>
    <textarea id="background"><?php print $background ?></textarea>
    <h3><?php print msg('Goals')?></h3>
    <textarea id="goals"><?php print $goals ?></textarea>
    <h3><?php print msg('Timeplan')?></h3>
    <textarea id="timeline"><?php print $timeline ?></textarea>
    <h3><?php print msg('Expected Information')?></h3>
    <textarea id="expected information"><?php print $expectedresults ?></textarea>

    <input type="button">
</form>