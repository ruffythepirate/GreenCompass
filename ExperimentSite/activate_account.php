<?php
    require_once("Includes/session.php");

    $verificationcode = $_REQUEST['verificationcode'];

    $password = $_REQUEST['password'];
    $retype_password = $_REQUEST['retype_password']

    $user = User::fromVerificationCode($verificationcode);

    $isActivated = FALSE;
    if($user == null)
    {
        header("location: index.php");
        exit();
    }

    require_once("Includes/Header.php");
    if($_REQUEST['METHOD'] == 'POST' && $password = $retype_password)
    {
        if($user->activateUser($databaseConnection, $verificationcode,
        $password)
        {
            $isActivated = TRUE;
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
            <form method="POST" target="activate_account.php">
                <input type="hidden" value="<?php echo "$verificationcode";?>">
                <fieldset>
                    Password
                    <input type="password" name="password"/>
                    Password again
                    <input type="password" name="retype_password"/>
                    <input type="submit">
                </fieldset>
            </form>
        </php
<?php
    }
?>
</div>
<?php 
require_once("Includes/Footer.php");


