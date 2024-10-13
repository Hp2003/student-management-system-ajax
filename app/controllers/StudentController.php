<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
require_once('../models/Student.php');

class StudentController {

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
    public function save() {

        $student = new Student();
        $student->first_name = $this->first_name;
        $student->last_name = $this->last_name;
        $student->email = $this->email;
        $student->phone_number = $this->phone_number;
        $student->gender = $this->gender;
        $student->course_id = $this->course_id;

        return $student->save();

    }

    /**
     * call model to update student in db
     *
     * @return bool
     */
    public function update() {

        $student = new Student($this->id);

        $student->first_name = $this->first_name;
        $student->last_name = $this->last_name;
        $student->email = $this->email;
        $student->phone_number = $this->phone_number;
        $student->gender = $this->gender;
        $student->course_id = $this->course_id;

        return $student->update();

    }

    /**
     * delets a single student from db 
     *
     * @return bool
     */
    public function delete() {

        $student = new Student($this->id);
        return $student->delete();

    }

    /**
     * validates all user inputs
     *
     * @return array
     */
    public function validate_inputs() {
        $errors = [];

        if(empty($this->first_name)) {
            $errors[] = ['first_name' => 'first name is required'];
        }
        if(empty($this->last_name)) {
            $errors[] = ['last_name' => 'last name is required'];
        }
        if(empty($this->email)) {
            $errors[] = ['email' => 'email is required'];
        }
        if(empty($this->phone_number)){
            $errors[] = ['phone_number' => 'phone number is required'];
        }
        if(empty($this->gender)){
            $errors[] = ['gender' => 'gender is required'];
        }
        if(empty($this->course)){
            $errors[] = ['course' => 'please select a course'];
        }

        if(count($errors) > 0){
            return $errors;
        }

        if(in_array($this->gender, ['male', 'female', 'other'])){
            $errors[] = ['gender' => 'invalid input valid input'];
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $errors[] = ['email' => 'please enter valid email'];
        }

        return $errors;

    }

}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if($_POST['operation'] === 'add'){

        $student_controller = new StudentController();
        $student_controller->first_name = $_POST['first_name'];
        $student_controller->last_name = $_POST['last_name'];
        $student_controller->email = $_POST['email'];
        $student_controller->phone_number = $_POST['phone_number'];
        $student_controller->gender = $_POST['gender'];
        $student_controller->course_id = $_POST['course_id'];

        // var_dump($student_controller->save());
        if($student_controller->save()){
            header('Location:' . ($_SERVER['HTTP_ACCEPT'] ? 'http://' : 'https://')  .  $_SERVER['HTTP_HOST'] . '/hiren/mvc2/app/views/student'  );
        }
        
    }
    else if($_POST['operation'] === 'edit'){

        $student_controller = new StudentController();

        $student_controller->id = $_POST['id'];
        $student_controller->first_name = $_POST['first_name'];
        $student_controller->last_name = $_POST['last_name'];
        $student_controller->email = $_POST['email'];
        $student_controller->phone_number = $_POST['phone_number'];
        $student_controller->gender = $_POST['gender'];
        $student_controller->course_id = $_POST['course_id'];

        if($student_controller->update()){
            header('Location:' . '/hiren/mvc2/app/views/student'  );
        }
        
    }
    else if($_POST['operation'] === 'delete'){
        
        $student_controller = new StudentController();
        $student_controller->id = $_POST['id'];
        
        if($student_controller->delete()){
            header('Location:' . '/hiren/mvc2/app/views/student'  );
        }

    }
}