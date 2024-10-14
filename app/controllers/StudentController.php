<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Student.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/utils/Validator.php');

class StudentController
{

    use Validator;

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $gender;
    public $course_id;

    /**
     * validate and call model to save new student
     *
     * @return bool
     */
    public function save()
    {

        $errors = $this->validate_inputs();

        // Checking for duplicate entrys
        $student = new Student();

        if (count($student->find_with_column('email', $this->email)) > 0) {
            $errors['email'] = 'Given email is already available';
        }

        if (count($student->find_with_column('phone_number', $this->phone_number)) > 0) {
            $errors['phone_number'] = 'Given phone number is already available';
        }

        if (count($errors) > 0) {
            $_SESSION['add_student_errors'] = $errors;
            $this->set_values_to_session('add_student_inputs');
            return false;
        }

        $student = new Student();
        $student->first_name = $this->first_name;
        $student->last_name = $this->last_name;
        $student->email = $this->email;
        $student->phone_number = $this->phone_number;
        $student->gender = $this->gender;
        $student->course_id = $this->course_id;

        return $student->save();     //Saves student in database

    }

    /**
     * set values of inputs to session when validation fails
     * to show in user form
     * 
     * @param string $key
     *
     * @return void
     */
    private function set_values_to_session($key)
    {


        $_SESSION[$key] = array(
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'course_id' => $this->course_id,
        );
    }

    /**
     * call model to update student in db
     *
     * @return bool
     */
    public function update()
    {

        $errors = $this->validate_inputs();
        $student = new Student($this->id);

        // Checking for duplicate entrys
        $student = new Student($this->id);

        if ($student->check_unique_except('email', $this->email)) {
            $errors['email'] = 'Given email is already available';
        }

        if ($student->check_unique_except('phone_number', $this->phone_number)) {
            $errors['phone_number'] = 'Given phone number is already available';
        }

        if (count($errors) > 0) {
            $_SESSION['edit_student_errors'] = $errors;
            $this->set_values_to_session('edit_student_inputs');
            return false;
        }

        $student->first_name = $this->first_name;
        $student->last_name = $this->last_name;
        $student->email = $this->email;
        $student->phone_number = $this->phone_number;
        $student->gender = $this->gender;
        $student->course_id = $this->course_id;

        // return $student->update();
        return false;

    }

    /**
     * delets a single student from db 
     *
     * @return bool
     */
    public function delete()
    {

        $student = new Student($this->id);
        return $student->delete();
    }

    /**
     * validates all user inputs
     *
     * @return array
     */
    public function validate_inputs()
    {
        $errors = [];

        // checking if input is empty or not
        if (empty($this->first_name)) {
            $errors['first_name']  = 'first name is required';
        }
        if (empty($this->last_name)) {
            $errors['last_name'] = 'last name is required';
        }
        if (empty($this->email)) {
            $errors['email'] = 'email is required';
        }
        if (empty($this->phone_number)) {
            $errors['phone_number'] = 'phone number is required';
        }
        if (empty($this->gender)) {
            $errors['gender'] = 'gender is required';
        }
        if (empty($this->course_id)) {
            $errors['course'] = 'please select a course';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        // Senitizing input
        $this->first_name = $this->test_input($this->first_name);
        $this->last_name = $this->test_input($this->last_name);
        $this->email = $this->test_input($this->email);
        $this->phone_number = $this->test_input($this->phone_number);
        $this->gender = $this->test_input($this->gender);
        $this->course_id = $this->test_input($this->course_id);

        // Validating all inputs
        if (!$this->test_email($this->email)) {
            $errors['email'] = 'please enter a valid email';
        }
        if (!$this->test_name($this->first_name)) {
            $errors['first_name'] = "first name should only contain a-z or ' ";
        }
        if (!$this->test_name($this->last_name)) {
            $errors['last_name'] = "first name should only contain a-z or ' ";
        }
        if (!$this->test_course($this->course_id)) {
            $errors['course_id'] = 'please enter a valid course';
        }
        if (!$this->test_phone_number($this->phone_number)) {
            $errors['phone_number'] = 'please enter a valid phone number eg: 1234567890';
        }

        // var_dump($student->email);
        return $errors;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['operation'] === 'add') {

        $student_controller = new StudentController();
        $student_controller->first_name = $_POST['first_name'] ?? '';
        $student_controller->last_name = $_POST['last_name'] ?? '';
        $student_controller->email = $_POST['email'] ?? '';
        $student_controller->phone_number = $_POST['phone_number'] ?? '';
        $student_controller->gender = $_POST['gender'] ?? '';
        $student_controller->course_id = $_POST['course_id'] ?? '';


        if ($student_controller->save()) {
            header('Location:' . '/hiren/mvc2/app/views/student');
        } else {
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    } else if ($_POST['operation'] === 'edit') {

        $student_controller = new StudentController();

        $student_controller->id = $_POST['id'];
        $student_controller->first_name = $_POST['first_name'];
        $student_controller->last_name = $_POST['last_name'];
        $student_controller->email = $_POST['email'];
        $student_controller->phone_number = $_POST['phone_number'];
        $student_controller->gender = $_POST['gender'];
        $student_controller->course_id = $_POST['course_id'];

        if ($student_controller->update()) {
            header('Location:' . '/hiren/mvc2/app/views/student');
        }else{
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    } else if ($_POST['operation'] === 'delete') {

        $student_controller = new StudentController();
        $student_controller->id = $_POST['id'];

        if ($student_controller->delete()) {
            header('Location:' . '/hiren/mvc2/app/views/student');
        }
    }
}
