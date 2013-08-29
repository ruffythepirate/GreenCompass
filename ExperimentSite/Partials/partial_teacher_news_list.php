<?php
require_once ("Classes/class.news.php");
require_once ("Includes/session.php");
require_role('teacher');
    global $databaseConnection;
    $allNewsItems = News::getNews($databaseConnection);
?>
    <ul class="news-list">
        <?php
            foreach($allNewsItems as $newsItem)
            {
                if($newsItem->ispublished)
                {
                    echo "<li><div class=\"news-container\"><b>$newsItem->username</b> - $newsItem->text [$newsItem->formatcreated]";
                    echo "</div></li>";
                }
            }
        ?>

    </ul>
 
