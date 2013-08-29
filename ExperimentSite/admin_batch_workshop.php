<?php
    require_once("Includes/session.php");
    require_role('admin');

    global $databaseConnection;

    require_once('Includes/header.php');


    require_once('Classes/class.workshoptranslation.php');
    require_once('Classes/class.batchworkshop.php');

    $batchWorkshopId = $_REQUEST['batchworkshopid'];

    $batchWorkshop = BatchWorkshop::fromId($databaseConnection, $batchWorkshopId);

    $workshopId = $batchWorkshop->workshopid;

    $workshopTranslation = WorkshopTranslation::fromWorkshopAndLanguageId($databaseConnection, 
                                                                        $batchWorkshop->workshopid,
                                                                        get_current_language());

    print "<div class=\"section\">";
    print "<h1>$workshopTranslation->title</h1>";
    print "</div>";

    print "<div class=\"section\">";
    include "Partials/partial_workshop_summary.php";
    print "</div>";

    print "<div class=\"section\">";
    include "Partials/partial_teacher_workshop_files.php";
    print "</div>";

    include "Partials/partial_teacher_upload_batch.php";

    ?>
    </div>
