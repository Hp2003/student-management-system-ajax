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
    public function test_input($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;

    }

}