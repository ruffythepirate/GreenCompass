<?php
     class News
    {
        public $newsid;
        public $userid;
        public $username;
        public $text;
        public $ispublished;
        public $created;
        public $formatcreated;
    
        public static function getNews($databaseConnection)
        {
    
            $query = "SELECT n.newsid, n.userid, n.text, n.ispublished, n.created, u.username FROM news n "
                   . "LEFT JOIN users u ON n.userid = u.id"
                   . " ORDER BY n.created DESC";
    
            $result = $databaseConnection->query($query);
    
            $newsItems = array();
    
            while($row = $result->fetch_object())
            {
                $newsObject = News::fromObject($row);
                array_push($newsItems, $newsObject);
            }
    
            return $newsItems;
        }
    
        public function saveToDatabase($databaseConnection)
        {
            if(!isset($this->newsid))
            {
                $this->insertToDatabase($databaseConnection);
            }
            else {
                $this->updateInDatabase($databaseConnection);
            }
        }

        public static function deleteNews($databaseConnection, $newsid)
        {
            $query = "DELETE FROM news WHERE newsid = $newsid";

            if(! mysqli_query($databaseConnection, $query))
            {
                throw new Exception("Failed to delete news ($newsid) from DB! " . mysql_error());                
            }
        }

        public static function toggleNewsPublish($databaseConnection, $newsid)
        {
            $query = "Update news SET ispublished = ispublished ^ 1 WHERE newsid = $newsid";

            if(! mysqli_query($databaseConnection, $query))
            {
                throw new Exception("Failed to toggle publish ($newsid) from DB! " . mysql_error());                
            }
        }

        private function insertToDatabase($databaseConnection)
        {
            $query = "INSERT INTO news (userid, text, ispublished, created) "
                   . " VALUES ($this->userid, '$this->text', $this->ispublished, NOW() )";
            
            if(! mysqli_query($databaseConnection, $query))
            {
                throw new Exception("Failed to insert into DB! " . mysql_error());
            }
            $this->newsid = $databaseConnection->insert_id;
        }

        private function updateInDatabase($databaseConnection)
        {
            if(!isset($this->newsid))
            {
                throw new Exception("Cannot update news when newsid is null!");
            }

            $query = "UPDATE news SET text = '$this->text', ispublished='$this->ispublished' "
                    . " WHERE newsid = $this->newsid";

            if(! mysqli_query($databaseConnection, $query))
            {
                throw new Exception("Failed to update in DB! " . mysql_error());
            }            
        }

        public static function fromPost($post)
        {
            $newsItem = new News();
    
            $newsItem->newsid       = $post['newsid'];
            $newsItem->userid       = $post['userid'];
            $newsItem->text         = $post['text'];
            $newsItem->ispublished  = $post['ispublished'];
            return $newsItem;            
        } 

        public static function fromObject($otherObject)
        {
            $newsItem = new News();
    
            $newsItem->newsid       = $otherObject->newsid;
            $newsItem->userid       = $otherObject->userid;
            $newsItem->username     = $otherObject->username;
            $newsItem->text         = $otherObject->text;
            $newsItem->ispublished  = $otherObject->ispublished;
            $newsItem->created      = $otherObject->created;
           
            $date = new DateTime( $newsItem->created, new DateTimeZone('Etc/GMT+1'));
            $newsItem->formatcreated = $date->format("Y-m-d");

            return $newsItem;
        }
    
    
    }
