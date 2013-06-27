<?php
class User {
    public $id;
    public $username;
    public $schoolid;
    public $languageid;
    public $email;
    public $created;
    public $isactivated;
    public $verificationcode;

    function __construct($id, $username, $schoolid, $languageid, $email, $created, $verificationcode, $isactivated )
    {
        $this->id = $id;
        $this->username = $username;
        $this->schoolid = $schoolid;
        $this->languageid = $languageid;
        $this->email = $email;
        $this->created = $created;
        $this->verificationcode = $verificationcode;
        $this->isactivated = $isactivated;
    }

    public static function fromPostParameters($postParameters )
    {
        $id = NULL;
        $username = $postParameters['username'];
        $schoolid = $postParameters['schoolid'];
        $languageid = $postParameters['schoolid'];
        $email = $postParameters['email'];
        $created = NULL;
        $isactivated = FALSE;
        $verificationcode = md5(time().'post-it'.rand(0,9999));

        $user = new User($id, $username, $schoolid, $languageid, $email, 
            $created, $verificationcode, $isactivated);
        return $user;
    }

    public static function fromId($databaseConnection, $userId)
    {
        $query = "SELECT id, username, schoolid, languageid, email, created, verificationcode, isactivated "
        .  " FROM Users "
        . " WHERE id = $userId AND isactivated = 1";

        $result = $databaseConnection->query($query);
        if($row = $result->fetch_object())
        {
            return new User($row->id, $row->username,
                $row->schoolid, $row->languageid, $row->email, $row->created, $row->verificationcode, $row->isactivated);
        }
        return NULL;
    }

    public static function fromVerificationCode($databaseConnection, $verificationcode)
    {
        $query = "SELECT id, username, schoolid, languageid, email, created, verificationcode, isactivated "
        .  " FROM Users "
        . " WHERE verificationcode = '$verificationcode' AND isactivated = 0";

        $result = $databaseConnection->query($query);
        if($row = $result->fetch_object())
        {
            return new User($row->id, $row->username,
                $row->schoolid, $row->languageid, $row->email, $row->created, $row->verificationcode, $row->isactivated);
        }
        return NULL;
    }

    public function sendVerificationEmail()
    {
        mail("Verification", "Subject of email", "This is the mail you just received...");
        echo "Mail has been sent!\n";

    }

    public function addRole($databaseConnection, $userRoleName)
    {

        $query = "INSERT INTO users_in_roles (user_id, role_id) "
                . " SELECT $this->id, r.id "
                . " FROM roles r WHERE r.value = '$userRoleName'";
    
        echo "<br>Query: $query <br>";
        if(! mysqli_query($databaseConnection, $query))
        {
            return FALSE;
        }
        return TRUE;
    }


    public static function getUsersInRole($databaseConnection, $roleValue)
    {
        $query = "SELECT u.id as id, u.username as username , u.schoolid as schoolid, u.languageid as languageid, u.email as email, u.created as created, u.verificationcode as verificationcode, u.isactivated as isactivated"
        .  " FROM Users u"
        .  " INNER JOIN users_in_roles ur ON ur.user_id = u.id "
        .  " INNER JOIN roles r ON ur.role_id = r.id"
        .  " WHERE r.value = '$roleValue'";

        $array = array();
        $result = $databaseConnection->query($query);
        while($row = $result->fetch_object())
        {
            array_push($array, new User($row->id, $row->username,
                $row->schoolid, $row->languageid, $row->email, $row->created, $row->verificationcode, $row->isactivated));
        }
        return $array;
    }

    public function activateUser($databaseConnection, $verificationcode, $password)
    {
        $query = "UPDATE Users SET password = SHA('$password'), isactivated = 1"
                 ." WHERE verificationcode = '$verificationcode' AND isactivated = 0 ";
        if(! mysqli_query($databaseConnection, $query))
        {
            echo mysql_error();
            return FALSE;
        }

        $this->id = $databaseConnection->insert_id;

        return TRUE;

    }

    public function insertToDatabase($databaseConnection)
    {

        $isactivated = $this->isactivated == TRUE ? '1' : '0';

        $query = "INSERT INTO Users (username, schoolid, languageid, "
                    . "email, created, isactivated, verificationcode  ) "
                    . "VALUES ('$this->username', $this->schoolid, $this->languageid"
                    . ", '$this->email', NOW(), $isactivated, '$this->verificationcode')";

        echo "query: $query";
        if(!mysqli_query($databaseConnection, $query))
        {
            
            return FALSE;
        }

        $this->id = $databaseConnection->insert_id;

        return TRUE;
    }

    public function setLanguage($databaseConnection, $newLanguageId)
    {
        $query = "UPDATE Users "
                . " SET LanguageId = $newLanguageId "
                . " WHERE id = $this->id";
        
        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Failed to update user $this->id with languageId = $newLanguageId");
        }
        return TRUE;
    }
}