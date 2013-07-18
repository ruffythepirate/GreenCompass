<div class="news">
    <h1>News</h1>
    <form id="news-form" method="post" action="ajax_news_get.php">
        <input type="hidden" value="1" id="form-ispublished" name="ispublished"> 
        <input type="text" name="text" id="form-text">
        <a id="submit_news" href="#" class="ajax_submit">Post</a>
    </form>

    <div class="news-list-container">
        <?php include('partial_admin_news_list.php');?>
    </div>

        <script>

            function getNews() {
                $.ajax({
                    type: "GET",
                    url: "ajax_news_get.php"
                }).done(
                     function (result) {
                         $('.news-list-container').html(result);
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

</div>