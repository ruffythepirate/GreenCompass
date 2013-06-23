<?php
include("Include/header.php");
require_once("Classes/class.school.php");

if( $_SERVER["REQUEST_METHOD"] == "POST" )
{
        
    //redirect to all users page.
}
?>
<section class="section">
    <h1>Create User</h1>
</section>
<section class="section">
    <h2>Create Teacher</h2>
    <form action="admin_user_new.php" method="post">
        <input type="hidden" name="type" value="teacher"/>
        <fieldset>
            <label for="schoolid"></label> 

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
           <input type="text" name="email"/>
           <label for="name">Name</label>
           <input type="text" name="name"/>
            <input type="submit" value="Create"/>
        </fieldset>
    </form>
</section>
<section class="section">
    <h2>Create Admin</h2>
    <form action="admin_user_new.php" method="post">
        <input type="hidden" name="type" value="admin"/>
        <fieldset>
           <label for="email">E-mail</label>
           <input type="text" name="email"/>
           <label for="name">Name</label>
           <input type="text" name="name"/>
            <input type="submit" value="Create"/>
        </fieldset>
    </form>
</section>


<?php
    include("Include/footer.php");


