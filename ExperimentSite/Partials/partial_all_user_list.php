<?php
    require_once "Includes/session.php";
    require_one_of_roles(array('admin', 'teacher') );
    require_once('Classes/class.user.php');
    require_once('Classes/class.school.php');
    require_once('Classes/class.country.php');

    function generateUsersTable($users)
    {
        echo "<table>\n";
        echo "    <tr>\n";
        echo "        <th>Name</th>\n";
        echo "        <th>E-mail</th>\n";
        echo "    </tr>\n";
        if(count($users) > 0)
        { 
            foreach($users as $user)
            {
                echo "<tr><td>$user->username</td>\n";
                echo "<td>$user->email</td>\n";
            }
        }
        echo "</table>\n";
    }

        $admins = User::getUsersInRole($databaseConnection, 'admin');
        generateUsersTable($admins);

        function getCountrySchools($country, $allSchools)
        {
                $countrySchools = array();
                foreach($allSchools as $school)
                {
                    if($school->countryid == $country->countryid)
                    {
                        array_push($countrySchools, $school);
                    }
                }
            return $countrySchools;
        }

        function getSchoolsTeachers($schools, $allTeachers)
        {
                $schoolsTeachers = array();
                foreach($schools as $school)
                {
                    $schoolTeachers = getSchoolTeachers($school, $allTeachers);
                    $schoolsTeachers = array_merge($schoolsTeachers, $schoolTeachers);
                }            
                return $schoolsTeachers;            
        }


        function getSchoolTeachers($school, $allTeachers)
        {
                $schoolTeachers = array();
                foreach($allTeachers as $teacher)
                {
                    if($teacher->schoolid == $school->schoolid)
                    {

                        array_push($schoolTeachers, $teacher);
                    }
                }            
                return $schoolTeachers;
        }

        $allTeachers = User::getUsersInRole($databaseConnection, 'teacher');

        if(count($allTeachers) > 0)
        {
            $allSchools = School::getAll($databaseConnection);
            $allCountries = Country::getAll($databaseConnection);
        
            usort($allCountries, "Country::countrySort");
        
            foreach($allCountries as $country)
            {
                $countrySchools = getCountrySchools($country, $allSchools);
                $countryTeachers = getSchoolsTeachers($countrySchools, $allTeachers);

                if(count($countryTeachers) > 0)
                {
                    usort($countrySchools, "School::NameSort");
                    foreach($countrySchools as $school)
                    {
                        $teachersForSchool = getSchoolTeachers($school, $countryTeachers);
                        if(count($teachersForSchool) > 0)
                        {
                            echo "<h3>Teachers - $country->name - $school->name</h3>\n"; 
                            generateUsersTable($teachersForSchool);
                        }
                    }
                }
            }
        }
?> 