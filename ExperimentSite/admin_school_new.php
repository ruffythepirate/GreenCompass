<?php 
    require_once("Classes/Validator.class.php");
    require_once("Classes/class.school.php");   
    require_once("Classes/class.country.php");

    
    //Defines the validation rules
    $validationRules = array(
        'rules' => array(
        'name' => 'required',
        'countryid' => 'required')
        ,
        'messages' => array(
            'name' => array('required' => 'Name is required',
            'countryid' => array(
                'required' => 'Country is required')
                )
         ));

    //POST logic to make sure that school is created.
    if(isset($_POST['name']))
    {
        $formValidator = new Validator($validationRules);

        require_once("Includes/session.php");         
        global $databaseConnection;

        $schoolToSave = School::fromPost($_POST);
        
        if($schoolToSave->insertToDatabase($databaseConnection))
        {
            header("location: admin_schools.php");
            exit();
        } else
        {
            echo "Failed to save school >.<";
        }

    }
    

        include("Includes/header.php");         
     ?>

<?php
$messages = array (
    'se'=> array( //ok
        'Admin Schools' =>
            'Administrera skolor',
        'Schools' => 'Skolor',
        'No Schools Available' => 'Inga skolor är tillgängliga'
    )
);

function msg($s) {
    global $LANG;
    global $messages;
    
    if (isset($messages[$LANG][$s])) {
        return $messages[$LANG][$s];
    } else {
        return $s;
    }
}?>

    <div id="main">
    <div class="section">
    <h3><?php print msg('Create School')?></h3>
    </div>
    <div class="section">
    <h3><?php print msg('Create School')?></h3>
        <form id="create_school_form" method="post">
            <fieldset>
            <label for="name">Name:</label> 
            <input type="text" name="name" id="name"><br>
            <label for="countryid">Country:</label> 
            <select id="countryid" name="countryid">
                <?php 

        //We load the countries so that we can group on the later.        
        $query = 'SELECT countryid, name FROM Countries';
        $result = $databaseConnection->query($query);
        while($row = $result->fetch_object())
        {
            $countries[] = $row;
        }
        $result->close();
                    
        usort( $countries, 'Country::countrySort' );    
        
        foreach($countries as $country)
        {
            print "<option value=\"$country->countryid\">";
            print "$country->name";
            print "</option>";
        }
        ?>
                </select><br>
            <input type="submit" value="Create">
                </fieldset>
        </form>
    </div>

    </div>

</div>


<script type="text/javascript">
    $('#create_school_form').validate(<?php echo json_encode($validationRules); ?>);
</script>

<?php 
    include ("/Includes/footer.php");
