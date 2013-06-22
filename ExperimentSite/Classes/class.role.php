<?php
class Role{
    public $id;
    public $name;
    public $value;

    function __construct($id, $name, $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public static function getForUser($databaseConnection, $userId)
    {
        $query = "SELECT r.id as id, r.name as name, r.value as value "
               . "FROM roles r "
               . "INNER JOIN users_in_roles ur ON r.id = ur.role_id "
               . "WHERE ur.user_id = $userId";

         $dictionary = array();
         $result = $databaseConnection->query($query);
         
         while($row = $result->fetch_object())
         {
             $newItem = new Role($row->id, $row->name, $row->value);
             $dictionary[$newItem->value] = $newItem;
         }
         return $dictionary;
    }
}
