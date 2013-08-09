<?php
    require_once("Includes/session.php");
    
    global $databaseConnection;
    $verificationcode = $_REQUEST['verificationcode'];
    
    $password = $_REQUEST['password'];
    $retype_password = $_REQUEST['retype_password'];
    
    $user = User::fromVerificationCode($databaseConnection, $verificationcode);
    
    $isActivated = FALSE;
    if($user == null)
    {
        header("location: index.php");
        exit();
    }
    
    require_once("Includes/header.php");
    if(isset($_POST['verificationcode']))
    {
            echo "Is da post!";
    if( $password = $retype_password)
    {
        if($user->activateUser($databaseConnection, $verificationcode,
        $password))
        {
            $isActivated = TRUE;
        }   else {
            echo "Failed to activate user!";
        }     
    }
     else {
            echo "Password issues :(!";
        }     
    }
?>

<?php
    if($isActivated)
    {
?>
<div class="section">
            Congratulations! Your user has been successfully activated. Proceed to <a href="logon.php">logon page</a>.
</div>
<?php
    }else {
?>
<div class="section">
    <h1>Activate account</h1>
            Activate the user '<?php echo "$user->username"; ?>'
    <form method="POST" target="activate_account.php?verificationcode=<?php echo "$verificationcode";?>">
        <input type="hidden" name="verificationcode" value="<?php echo "$verificationcode";?>">
        <fieldset>
            <label for="password">Password</label>
            <input type="password" name="password" />
            <label for="retype_password">Password again</label>
            <input type="password" name="retype_password" />
            <input type="submit">
        </fieldset>
    </form>
</div>
<?php
    }
?>
</div>
<?php
    
    require_once("Includes/Footer.php");
    
    
