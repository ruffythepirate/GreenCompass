<?php
    require_once('Includes/session.php');
    require_once('Classes/class.user.php');

    if(logged_on())
    {

        $languageid = $_REQUEST['languageid'];
        echo "Setting language to $languageid";
        $user = User::fromDatabase($databaseConnection, $_SESSION['userid']);

        if(isset($user))
        {
            echo "Calling set language on user $user->id";
            $user->setLanguage($databaseConnection, $languageid);
            echo "Setting session languageid to $languageid";
            $_SESSION['languageid'] = $languageid;

        }

    }



