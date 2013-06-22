<?php
class User {
    public $id;
    public $username;
    public $schoolid;
    public $languageid;

    function __construct($id, $username, $schoolid, $languageid )
    {
        $this->id = $id;
        $this->username = $username;
        $this->schoolid = $schoolid;
        $this->languageid = $languageid;
    }

    public static function fromDatabase($databaseConnection, $userId)
    {
        $query = "SELECT id, username, schoolid, languageid "
        .  " FROM Users "
        . " WHERE id = $userId";

        $result = $databaseConnection->query($query);
        if($row = $result->fetch_object())
        {
            return new User($row->id, $row->username,
                $row->schoolid, $row->languageid);
        }
        return NULL;
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