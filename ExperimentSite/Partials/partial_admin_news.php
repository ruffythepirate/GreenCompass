<?php
require_once ("/Classes/class.news.php");
require_once ("/Includes/session.php");
    global $databaseConnection;
    $allNewsItems = News::getNews($databaseConnection);
?>
    <h1>News</h1>
    <form id="news-form" method="post" action="ajax_news_get.php">
        <input type="hidden" value="1" id="form-ispublished" name="ispublished"> 
        <input type="text" name="text" id="form-text">
        <a id="submit_news" href="#" class="ajax_submit">Post</a>
    </form>
    <ul class="news-list">
        <?php
            foreach($allNewsItems as $newsItem)
            {
                if($newsItem->ispublished)
                {
                    echo "<li><b>$newsItem->username</b> - $newsItem->text</li>";
                }
            }
        ?>
    </ul>
    <script>

        function setShownNews(newsArray) {
            var newHtml = "";
            for (var i = 0; i < newsArray.length; i++) {
                var newsItem = newsArray[i];
                var itemHtml = "<li><b>" + newsItem.username + "</b> - "
                    + newsItem.text + "</li>";
                newHtml += itemHtml;
            }

            $('.news-list').html(newHtml);
        }

        function getNews() {
            $.ajax({
                type: "GET",
                url: "ajax_news_get.php"
            }).done(
                function (result) {
                    var receivedNews = $.parseJSON(result);
                    setShownNews(receivedNews);
                }); ;
        }

        function sendNews() {
            var newsText = $('#form-text').val();
            var newsIsPublished = $('#form-ispublished').val();

            $.ajax({
                url: "ajax_news_new.php",
                type: "POST",
                success: function (data, textStatus, jqXHR) {
                    getNews();
                },
                error: function () {
                    getNews();
                },
                data: { text: newsText, ispublished: newsIsPublished }
            });

        }

        $(document).ready(function () {
            $('#submit_news').click(function (button) {
                sendNews();
            });
        });
    </script>
