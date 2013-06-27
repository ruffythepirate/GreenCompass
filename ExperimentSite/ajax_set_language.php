<?php
    require_once("Includes/session.php");
    require_role('admin');

    require_once('Includes/session.php');
    require_once('Classes/class.user.php');

    if(logged_on())
    {
        $languageid = $_REQUEST['languageid'];
        $user = User::fromId($databaseConnection, $_SESSION['userid']);

        if(isset($user))
        {
            $user->setLanguage($databaseConnection, $languageid);
            $_SESSION['languageid'] = $languageid;
        }
    }



