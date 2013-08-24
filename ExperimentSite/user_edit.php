<?php 
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    $currentUser = get_user();

    if(!isset($currentUser))
    {   
        header("location: logon.php");
        exit();
    }

    if (isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $retype_new_password = $_POST['retype_new_password'];

        if($retype_new_password == $new_password)
        {
    
            global $databaseConnection;
            $query = "SELECT id, username FROM users WHERE email = ? AND password = SHA(?) LIMIT 1";
            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('ss', $email, $password);
    
            $statement->execute();
            $statement->store_result();
    
            if ($statement->num_rows >= 1)
            {
                $currentUser->setPassword($databaseConnection, $new_password);
                $feedback = "Password has been changed!";
            }
            else
            {
                $feedback = "Username/password combination is incorrect.";
            }
        } else 
        {
            $feedback = "You did not write the same password two times!";            
        }
    }
    include ("Includes/header.php");
?>
<div id="main">
    <h2>Edit User</h2>
        <form action="user_edit.php" method="post">
            <fieldset>
            <legend>Change Password</legend>
            <ol>
                <li>
                    <label for="email">Email:</label> 
                    <input type="text" name="email" value="<?php if(isset($currentUser)) {echo "$currentUser->email";}?>" id="email" readonly/>
                </li>
                <li>
                    <label for="old_password">Old Password:</label>
                    <input type="password" name="old_password" value="" id="old_password" />
                </li>
                <li>
                    <label for="old_password">New Password:</label>
                    <input type="password" name="new_password" value="" id="new_password" />
                </li>
                <li>
                    <label for="old_password">New Password Again:</label>
                    <input type="password" name="retype_new_password" value="" id="retype_new_password" />
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