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
    <?php
        include "Includes/partial_includes.php";
    ?>
    </head>
    <body>
            <div class="navbar navbar-inverse navbar-static-top">
                <div class="navbar-inner">
                <div class="container">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="brand" href="/">Green Compass</a>
                <div class="nav-collapse collapse">
                        <ul id="menu" class="nav">
                            <?php if(is_admin()) {
                            echo '<li><a href="/admin_dashboard.php">Admin Dashboard</a></li>';
                            echo '<li><a href="/admin_users.php">Users</a></li>';
                            echo '<li><a href="/admin_workshops.php">Workshops</a></li>';
                            echo '<li><a href="/admin_schools.php">Schools</a></li>';
                            echo '<li><a href="/admin_batches.php">Batches</a></li>';
                            } elseif(is_teacher()) {
                            echo '<li><a href="/teacher_dashboard.php">Teacher Dashboard</a></li>';
                             }?>

                        </ul>
                    <div class="pull-right">
                        <ul id="login" class="nav">
                        <?php
                        if (logged_on())
                        {
                            echo '<li><a href="/user_edit.php">Change Password</a></li>' . "\n";
                            echo '<li><a href="/logoff.php">Sign out</a></li>' . "\n";
                        }
                        else
                        {
                            echo '<li><a href="/logon.php">Login</a></li>' . "\n";
                        }
                        ?>
                        </ul>

                    </div>
                    </div>
                    </div>                    
                </div>
                </div>
         <div class="outer-wrapper">

