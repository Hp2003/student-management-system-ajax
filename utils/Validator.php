<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');

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

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
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

        if (preg_match('/^\d{10}$/', $phone)) {
            return true;
        }
        return false;
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

        if (preg_match("/^[a-zA-Z-']*$/", $name)) {
            return true;
        }
        return false;
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
        if (in_array($gender, $genders)) {
            return true;
        }
        return false;
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
        if (in_array($course_name, $course_names)) {
            return true;
        }
        return false;

    }
}
