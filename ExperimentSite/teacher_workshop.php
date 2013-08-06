<?php
    require_once("Includes/session.php");
    require_role('teacher');

    global $databaseConnection;

    require_once('Includes/Header.php');


    require_once('Classes/class.workshoptranslation.php');
    require_once('Classes/class.batchworkshop.php');

    $batchWorkshopId = $_REQUEST['batchworkshopid'];

    $batchWorkshop = BatchWorkshop::fromId($databaseConnection, $batchWorkshopId);

    $workshopId = $batchWorkshop->workshopid;

    $workshopTranslation = WorkshopTranslation::fromWorkshopAndLanguageId($databaseConnection, 
                                                                        $batchWorkshop->workshopid,
                                                                        get_current_language());

    include "Partials/partial_teacher_workshop_files.php";
    ?>

    </div>
