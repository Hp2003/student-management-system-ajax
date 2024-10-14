<?php 
/**
 * 
 * Main trait used to make validation in all modules
 * 
 */ 
trait Validator {
    /**
     * Filters input and return senitized data
     *
     * @param int|bool|string|float $data
     * @return int|bool|string|float
     */
    protected function test_input($data) {

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
    protected function test_email($email) {

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
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
    protected function test_phone_number($phone) {

        if(preg_match('/^\d{10}$/', $phone)) {
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
    protected function test_name($name) {

        if(preg_match("/^[a-zA-Z-']*$/", $name)){
            return true;
        }
        return false;

    }
}