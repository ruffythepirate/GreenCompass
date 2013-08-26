<?php
    require_once("Includes/session.php");
    require_role('admin');

    require_once("Classes/Validator.class.php");
    require_once("Classes/class.user.php");
    
    //Defines the validation rules
    $validationRules = array(
        'rules' => array(
        'username' => 'required',
        'email' => array(
            'required' => TRUE,
            'email' => TRUE
            )
        ),
        'messages' => array(
            'username' => array('required' => 'Username is required',
            'email' => array(
                'required' => 'if you have a name, also provide your email'),
                'email' => 'this is not an email address'
                )
         ));
    
    if( $_SERVER["REQUEST_METHOD"] == "POST" )
    {
        $formValidator = new Validator($validationRules);
        $errorMessages = $formValidator->validate($_POST);
        if(count($errorMessages) > 0)
        {
            echo "Validation failed!\n";
            foreach($errorMessages as $errorMessage)
            {
                echo "error: $errorMessage \n";
            }
        } else{
            $newUser = User::fromPostParameters($_POST);
            require_once("Includes/session.php");
            global $databaseConnection;
            mysqli_autocommit( $databaseConnection, FALSE);
            if($newUser->insertToDatabase($databaseConnection))
            {
                if($newUser->addRole($databaseConnection, $_POST['type']))
                {
                    //$newUser->sendVerificationEmail();
    
                    mysqli_commit($databaseConnection);

                    //Give info on new user
                    $feedbackToUser = "A new user has been created! Send this link to the user to activate him: "
                     . "<a href=\"activate_account.php?verificationcode=$newUser->verificationcode\">"
                     . $_SERVER['HTTP_HOST'] . "/activate_account.php?verificationcode=$newUser->verificationcode"
                     . "</a>.";

                }
                else {
                    echo "Failed to give role to user! role = '".$_POST['type'] ."'";
                }
            } else
            {
                echo "Failed to insert user to database!";
            }
        }
    
    }
    
    include("Includes/header.php");
    require_once("Classes/class.school.php");
?>


<section class="section">
    <h1>Create User</h1>
</section>
<?php 
    if(isset($feedbackToUser))
    {
        echo '<div class="section">'
            . "$feedbackToUser"
            . '</div>';
    }
?>
<section class="section">
    <h2>Create Teacher</h2>
    <form id="create_teacher_form" action="admin_user_new.php" method="post">
        <input type="hidden" name="type" value="teacher" />
        <fieldset>
            <label for="schoolid">School</label>
            <select name="schoolid">
                <?php
                    $schools = School::getAll($databaseConnection);
                    foreach($schools as $school)
                    {
                        echo "<option value='$school->schoolid'>$school->name</option>";
                    }
                ?>
            </select>
            <label for="email">E-mail</label>
            <input type="text" name="email" />
            <label for="name">Name</label>
            <input type="text" name="username" />
            <input type="submit" value="Create" />
        </fieldset>
    </form>

</section>
<section class="section">
    <h2>Create Admin</h2>
    <form action="admin_user_new.php" method="post">
        <input type="hidden" name="type" value="admin" />
        <fieldset>
            <label for="email">E-mail</label>
            <input type="text" name="email" />
            <label for="name">Name</label>
            <input type="text" name="name" />
            <input type="submit" value="Create" />
        </fieldset>
    </form>
</section>
</div>
<script type="text/javascript">
    $('#create_teacher_form').validate(<?php echo json_encode($validationRules); ?>);
</script>

<?php
    include("Includes/footer.php");
    
    
