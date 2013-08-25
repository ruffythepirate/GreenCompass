<?php 
    require_once ("Includes/session.php");
    //require_once ("Includes/simplecms-config.php"); 
    //require_once ("Includes/connectDB.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT id, username FROM users WHERE email = ? AND password = SHA(?) LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ss', $email, $password);

        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows >= 1)
        {
            $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
            $statement->fetch();
            $feedback = "Logon successful!";

            header ("Location: index.php");
            exit();
        }
        else
        {
            $feedback = "Username/password combination is incorrect.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php 
                echo "Logon: Green Compass";
    ?></title>
    <?php
        include "Includes/partial_includes.php";
    ?>
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    </head>
    <body>
<div class="container">
        <form action="logon.php" method="post" class="form-signin">
            <h2 class="form-signin-heading">Welcome</h2>
            <fieldset>
            <input type="text" class="input-block-level" name="email" placeholder="Email address" value="" id="username" />
            <input type="password" class="input-block-level" name="password" placeholder="Password" value="" id="password" />
            <button class="btn btn-large btn-primary" type="submit">Sign in</button>
        </fieldset>
    </form>
    <?php echo "$feedback";?>
</div>
    </body>
