<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once(__DIR__ . '/../app/models/Course.php');

/**
 * 
 * Main class used to make validation in all modules
 * 
 */
class Validator
{
    /**
     * Filters input and return senitized data
     *
     * @param int|bool|string|float $data
     * 
     * @return int|bool|string|float
     */
    public function test_input($data)
    {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    /**
     * Tests if email is valid or not 
     * returns true if email is valid false if not
     *
     * @param string $email
     * @return bool
     */
    public function test_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * tests phone number for 10 digits only 
     * returns true if number is valid false if not
     *
     * @param string $phone
     * @return bool
     */
    public function test_phone_number($phone)
    {

        return preg_match('/^\d{10}$/', $phone);
    }

    /**
     * test name for only letters from a to z or A-Z and '
     * returns true if string is valid else false
     *
     * @param string $name
     * @return bool
     */
    public function test_name($name)
    {

        return preg_match("/^[a-zA-Z-']*$/", $name);
    }

    /**
     * checks if gender is valid or not according to enum in db
     *
     * @param string $gender
     * @return bool
     */
    public function test_gender($gender)
    {

        $genders = array('male', 'female', 'other');
        return in_array($gender, $genders) ;
    }

    /**
     * checks if course is available in db or not
     *
     * @param int $course_id
     * @return bool
     */
    public function test_course($course_id)
    {

        $course = new Course();
        $courses = $course->get_formatted_course();
        if ($courses[$course_id]) {
            return true;
        }
        return false;
    }

    /**
     * checks if course is available in db using course name
     *
     * @param string $course_name
     * @return bool
     */
    public function test_duplicate_course($course_name)
    {

        $course = new Course();
        $courses = $course->get_formatted_course();
        $course_names = array_values($courses);
        return in_array($course_name, $course_names) ;

    }
}
