<?php
class User {
    public $id;
    public $username;
    public $schoolid;
    public $languageid;
    public $email;
    public $created;

    function __construct($id, $username, $schoolid, $languageid, $email, $created )
    {
        $this->id = $id;
        $this->username = $username;
        $this->schoolid = $schoolid;
        $this->languageid = $languageid;
        $this->email = $email;
        $this->created = $created;
    }

    public static function fromDatabase($databaseConnection, $userId)
    {
        $query = "SELECT id, username, schoolid, languageid, email, created "
        .  " FROM Users "
        . " WHERE id = $userId";

        $result = $databaseConnection->query($query);
        if($row = $result->fetch_object())
        {
            return new User($row->id, $row->username,
                $row->schoolid, $row->languageid, $row->email, $row->created);
        }
        return NULL;
    }

    public static function getUsersInRole($databaseConnection, $roleValue)
    {
        $query = "SELECT u.id as id, u.username as username , u.schoolid as schoolid, u.languageid as languageid, u.email as email, u.created as created"
        .  " FROM Users u"
        .  " INNER JOIN users_in_roles ur ON ur.user_id = u.id "
        .  " INNER JOIN roles r ON ur.role_id = r.id"
        .  " WHERE r.value = '$roleValue'";

        $array = array();
        $result = $databaseConnection->query($query);
        while($row = $result->fetch_object())
        {
            array_push($array, new User($row->id, $row->username,
                $row->schoolid, $row->languageid, $row->email, $row->created));
        }
        return $array;
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