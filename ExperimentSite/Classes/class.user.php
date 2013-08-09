<?php
class User {
    public $userid;
    public $username;
    public $schoolid;
    public $languageid;
    public $email;
    public $created;
    public $isactivated;
    public $verificationcode;

    function __construct($id, $username, $schoolid, $languageid, $email, $created, $verificationcode, $isactivated )
    {
        $this->userid = $id;
        $this->username = $username;
        $this->schoolid = $schoolid;
        $this->languageid = $languageid;
        $this->email = $email;
        $this->created = $created;
        $this->verificationcode = $verificationcode;
        $this->isactivated = $isactivated;
    }

    private static function fromDBRow($row)
    {
                    return new User($row->id, $row->username,
                $row->schoolid, $row->languageid, $row->email, $row->created, $row->verificationcode, $row->isactivated);
    }

    public static function fromPostParameters($postParameters )
    {
        $userid = NULL;
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
        .  " FROM users "
        . " WHERE id = $userId AND isactivated = 1";

        $result = $databaseConnection->query($query);
        if($row = $result->fetch_object())
        {
            return User::fromDBRow($row);
        }
        return NULL;
    }

    public static function fromVerificationCode($databaseConnection, $verificationcode)
    {
        $query = "SELECT id, username, schoolid, languageid, email, created, verificationcode, isactivated "
        .  " FROM users "
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
                . " SELECT $this->userid, r.id "
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
        .  " FROM users u"
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
        $query = "UPDATE users SET password = SHA('$password'), isactivated = 1"
                 ." WHERE verificationcode = '$verificationcode' AND isactivated = 0 ";
        if(! mysqli_query($databaseConnection, $query))
        {
            echo mysql_error();
            return FALSE;
        }

        $this->userid = $databaseConnection->insert_id;

        return TRUE;

    }

    public function insertToDatabase($databaseConnection)
    {

        $isactivated = $this->isactivated == TRUE ? '1' : '0';

        $query = "INSERT INTO users (username, schoolid, languageid, "
                    . "email, created, isactivated, verificationcode  ) "
                    . "VALUES ('$this->username', $this->schoolid, $this->languageid"
                    . ", '$this->email', NOW(), $isactivated, '$this->verificationcode')";

        echo "query: $query";
        if(!mysqli_query($databaseConnection, $query))
        {
            
            return FALSE;
        }

        $this->userid = $databaseConnection->insert_id;

        return TRUE;
    }

    public function setLanguage($databaseConnection, $newLanguageId)
    {
        $query = "UPDATE users "
                . " SET languageId = $newLanguageId "
                . " WHERE id = $this->userid";
        
        if(!mysqli_query($databaseConnection, $query))
        {
            throw new Exception("Failed to update user $this->userid with languageId = $newLanguageId");
        }
        return TRUE;
    }

    public static function getBatchSchoolTeachersInBatch($databaseConnection, $batchId)
    {
        $query = "SELECT id, username, schoolid, languageid, email, created, verificationcode, isactivated "
        .  " FROM users "
        . " WHERE isactivated = 1"
        . " AND id IN (SELECT userid from batchteachers WHERE batchid = $batchId)";

        $result = $databaseConnection->query($query);

        $array = array();
        while($row = $result->fetch_object())
        {
            array_push($array, User::fromDBRow($row) );
        }

        return $array;
    }

    public static function getBatchSchoolTeachersNotInBatch($databaseConnection, $batchId)
    {
        $query = "SELECT id, username, schoolid, languageid, email, created, verificationcode, isactivated "
        .  " FROM users "
        . " WHERE isactivated = 1"
        . " AND schoolid IN (SELECT schoolid from batchschools WHERE batchid = $batchId)"
        . " AND id NOT IN (SELECT userid from batchteachers WHERE batchid = $batchId)";

        $result = $databaseConnection->query($query);

        $array = array();
        while($row = $result->fetch_object())
        {
            array_push($array, User::fromDBRow($row) );
        }

        return $array;        
    }

    public static function CompareBySchool( $a, $b ) {
            return $a->schoolid - $b->schoolid;
    }
}