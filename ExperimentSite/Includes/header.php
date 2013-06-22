<?php require_once ("Includes/session.php"); ?>
<?php require_once ("Classes/class.language.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php 
            if($pageTitle != null)
            {
                echo "$pageTitle";                
            }
            else
            {
                echo "Green Compass";
            }
    ?></title>
        <link href="/Styles/Site.css" rel="stylesheet" type="text/css" />
        <link href="/Styles/GreenCompass.css" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <script type="text/javascript" src="Scripts/modernizr.development.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
    </head>
    <body>
        <div class="outer-wrapper">
        <header>
            <div class="content-wrapper">
                <div class="float-left">
                    <p class="site-title"><a href="/index.php">Green Compass Network</a></p>
                </div>
                <div class="float-right">
                    <section id="login">
                        <ul id="login">
                        <?php
                        if (logged_on())
                        {
                            echo '<li><a href="/logoff.php">Sign out</a></li>' . "\n";
                            if (is_admin())
                            {
                                echo '<li><a href="/addpage.php">Add</a></li>' . "\n";
                                echo '<li><a href="/selectpagetoedit.php">Edit</a></li>' . "\n";
                                echo '<li><a href="/deletepage.php">Delete</a></li>' . "\n";
                            }
                        }
                        else
                        {
                            echo '<li><a href="/logon.php">Login</a></li>' . "\n";
                            echo '<li><a href="/register.php">Register</a></li>' . "\n";
                        }
                        ?>
                        </ul>
                        <?php if (logged_on()) {
                            echo "<div class=\"welcomeMessage\">Welcome, <strong>{$_SESSION['username']}</strong></div>\n";
                            $languages = Language::getLanguages($databaseConnection);

                            $currentLanguageId = get_current_language();

                            if(count( $languages) > 0)
                            {
                                echo '<select id="page_language">';
                                foreach($languages as $language)
                                {
                                    if($language->languageid == $currentLanguageId)
                                    {
                                        echo "<option value='$language->languageid' selected>$language->name</option>";
                                    }   
                                    else
                                    {
                                        echo "<option value='$language->languageid'>$language->name</option>";                                        
                                    }  
                                }
                                echo '</select>';
                                echo 'languageid = ' . $currentLanguageId;
                                ?>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                var current_language_id = $('#page_language').val();
                                
                                $('#page_language').change(function () {
                                    var new_language_id = $('#page_language').val();
                                    if (new_language_id != current_language_id) {
                                        $.ajax({
                                            url: 'ajax_set_language.php?languageid=' + new_language_id,
                                            type: 'POST',
                                            success: function (data, textStatus, jqXHR) {
                                                location.reload(true);
                                            }
                                        });
                                    }
                                });
                            });
                        </script>
                            <?php 
                            } 


                        } ?>
                    </section>
                </div>

                <div class="clear-fix"></div>
            </div>

                <section class="navigation" data-role="navbar">
                    <nav>
                        <ul id="menu">
                            <?php if(is_admin()) {
                            echo '<li><a href="/admin_dashboard.php">Admin Dashboard</a></li>';
                            echo '<li><a href="/admin_users.php">Users</a></li>';
                            echo '<li><a href="/admin_workshop_create.php">Workshops</a></li>';
                            echo '<li><a href="/admin_schools.php">Workshops</a></li>';
                            echo '<li><a href="/admin_batches.php">Workshops</a></li>';
                            } elseif(is_teacher()) {
                            echo '<li><a href="/teacher_dashboard.php">Teacher Dashboard</a></li>';
                             }?>

                        </ul>
                    </nav>
            </section>
        </header>
