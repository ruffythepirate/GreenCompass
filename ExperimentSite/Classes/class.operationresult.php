<?php
  class OperationResult
{
   function __construct($status, $message, $entity) {
       $this->status = $status;
       $this->message = $message;
   }
    public $status;
    public $message;
    public $entity;
    
   public function jsonEncode()
   {
       echo json_encode($this->getJsonArray());
   } 
   
   public function getJsonArray()
   {
       $array = array('status' => $this->status, 'message' => $this->message);
       if($entity != null)
       {
            $array['entity'] = $entity->getJsonArray(); 
       }
       else 
       {
            $array['entity'] = NULL; 
       }
       return $array; 
   } 
}

?>

