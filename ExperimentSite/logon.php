<?php 
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");

    if (isset($_POST['submit']))
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
            header ("Location: index.php");
            exit();
        }
        else
        {
            $feedback = "Username/password combination is incorrect.";
        }
    }
    include ("Includes/header.php");
?>
<div id="main">
    <h2>Log on</h2>
        <form action="logon.php" method="post">
            <fieldset>
            <legend>Log on</legend>
            <ol>
                <li>
                    <label for="username">Email:</label> 
                    <input type="text" name="email" value="" id="username" />
                </li>
                <li>
                    <label for="password">Password:</label>
                    <input type="password" name="password" value="" id="password" />
                </li>
            </ol>
            <input type="submit" name="submit" value="Submit" />
            <p>
                <a href="index.php">Cancel</a>
            </p>
        </fieldset>
    </form>
    <?php echo "$feedback";?>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>