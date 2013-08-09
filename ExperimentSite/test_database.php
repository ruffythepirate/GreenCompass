

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Test Database...</title>
    </head>
    <body>
        Testing if the database can be connected to...
   <?php
    require_once ("Includes/simplecms-config.php");
    
    $databaseConnection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($databaseConnection->connect_error)
    {
        print "Database selection failed: " . $databaseConnection->connect_error;
    }
    else {
        print "Well... this worked fine.";
    }
?>     
    Men, varför fungerar det inte då!
    </body>
</html>
