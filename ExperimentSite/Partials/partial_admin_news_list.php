<?php
require_once ("Classes/class.news.php");
require_once ("Includes/session.php");
    $isAdmin = is_admin();
    global $databaseConnection;
    $allNewsItems = News::getNews($databaseConnection);
?>
    <ul class="news-list">
        <?php
            foreach($allNewsItems as $newsItem)
            {
                if($newsItem->ispublished || $isAdmin)
                {
                    if($newsItem->ispublished)
                    {
                    echo "<li><div class=\"news-container\"><b>$newsItem->username</b> - $newsItem->text [$newsItem->formatcreated]";
                    } else 
                    {
                    echo "<li><div class=\"news-container\"><b>[UNPUBLISHED] $newsItem->username</b> - $newsItem->text [$newsItem->formatcreated]";                        
                    }
                    
                    if($isAdmin)
                    {
                        echo "<div class=\"news-action-menu\" style=\"display:none\"><form class=\"news-form\"><input type=\"hidden\" name=\"news-id\" class=\"news-id\" value=\"$newsItem->newsid\"/>";
                        if($newsItem->ispublished)
                        {
                            echo "<a href=\"#\" class=\"news-unpublish\">Unpublish</a>";
                        } else
                        {
                            echo "<a href=\"#\" class=\"news-unpublish\">Publish</a>";                            
                        }
                        echo "<a href=\"#\" class=\"news-edit\">Edit</a>";
                        echo "<a href=\"#\" class=\"news-delete\">Delete</a>";                        
                        echo "</form></div>";
                    }
                    
                    echo "</div></li>";
                }
            }
        ?>

    </ul>
    <script>

        $(document).ready(function () {
            //fixes the show and hide options of the menu.
            $('.news-container').mouseenter(function () {
                $(this).find('.news-action-menu').show();
            });

            $('.news-container').mouseleave(function () {
                $(this).find('.news-action-menu').hide();
            });

            $('.news-unpublish').click(function () {
                var newsid = $(this).closest('.news-form').find('input[name="news-id"]').val();                

                $.ajax({
                    type: "POST",
                    url: "ajax_news_action.php",
                    data: { operation : 'toggle_publish', newsid: newsid },
                    success: function (data, textStatus, jqXHR) {
                        getNews();
                    },
                    error: function () {
                        getNews();
                    }
                });


                //Posta request till att ändra publish.
            });
            $('.news-edit').click(function () {
                //Öppna upp en dialog där användaren får ange den uppdaterade nyheten.
            });

            $('.news-delete').click(function () {
                //Posta request till att ta bort nyhet.
                var newsid = $(this).closest('.news-form').find('input[name="news-id"]').val();                
                
                $.ajax({
                    type: "POST",
                    url: "ajax_news_action.php",
                    data: { operation : 'delete', newsid: newsid },
                    success: function (data, textStatus, jqXHR) {
                        getNews();
                    },
                    error: function () {
                        getNews();
                    }
                });
            });
        });
    </script>
