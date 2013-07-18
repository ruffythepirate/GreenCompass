<?php
    session_start();
    require_once  ("Includes/connectDB.php");
    require_once  ("Classes/class.user.php");
    require_once  ("Classes/class.role.php");
    
    function logged_on()
    {
        return isset($_SESSION['userid']);
    }  
    
    function is_admin()
    {
            global $databaseConnection;
        return has_role('admin');
    }

    function require_role($roleName)
    {
        if(!has_role($roleName))
        {
            header("location: logon.php");
            exit();
        }
    }

    function get_user_id()
    {
        return $_SESSION['userid'];
    }
    
    function has_role($roleName)
    {
        global $databaseConnection;
        if(logged_on())
        {
            $userRoles = Role::getForUser($databaseConnection, $_SESSION['userid']);
            return array_key_exists($roleName, $userRoles);
        }
        return FALSE;

    }

    function confirm_is_admin() {
        if (!logged_on())
        {
            header ("Location: logon.php");
        }
    
        if (!is_admin())
        {
            header ("Location: index.php");
        }
    }
    
    function get_current_language()
    {
        global $databaseConnection;
        if(logged_on())
        {
            if(isset ($_SESSION['languageid']))
            {
                return $_SESSION['languageid'];
            }
            else
            {
                $user = User::fromId($databaseConnection, $_SESSION['userid']);
                if(isset($user) && isset($user->languageid))
                {
                    return $user->languageid;
                }
            }
            return NULL;
        }
    }
    
    
    function is_teacher()
    {
            global $databaseConnection;

        return has_role('teacher');
    }
?>