<?php
    session_start();
    require_once  ("Includes/connectDB.php");
    require_once  ("Classes/class.user.php");
    
    function logged_on()
    {
        return isset($_SESSION['userid']);
    }  
        function is_admin()
    {
        global $databaseConnection;
        $query = "SELECT user_id FROM users_in_roles UIR INNER JOIN roles R on UIR.role_id = R.id WHERE R.name = 'admin' AND UIR.user_id = ? LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d', $_SESSION['userid']);
        $statement->execute();
        $statement->store_result();
        return $statement->num_rows == 1;
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
                $user = User::fromDatabase($databaseConnection, $_SESSION['userid']);
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
    return TRUE;
    }
?>