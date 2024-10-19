<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/hiren/mvc2/app/models/Student.php');
require_once($root . '/hiren/mvc2/utils/Validator.php');

class StudentController extends Validator
{

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
        
        // var_dump(empty($this->course_id));

        $errors = $this->validate_inputs();

        // Checking for duplicate entrys
        $student = new Student();
        $student->find($this->id);

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

        return $student->update();
    }

    /**
     * delets a single student from db 
     *
     * @return bool
     */
    public function delete()
    {

        $student = new Student();
        $student->find($this->id);
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
        // if (empty($this->course_id)) {
        //     $errors['course_id'] = 'please select a course';
        // }

        if (!empty($errors['email']) || !empty($errors['phone_number'])) {
            return $errors;
        }

        // Senitizing input
        $this->first_name = $this->test_input($this->first_name);
        $this->last_name = $this->test_input($this->last_name);
        $this->email = $this->test_input($this->email);
        $this->phone_number = $this->test_input($this->phone_number);
        $this->gender = $this->test_input($this->gender);
        // $this->course_id = $this->test_input($this->course_id);

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
        if (!$this->test_course($this->course_id) && $this->course_id != NULL) {
            $errors['course_id'] = 'please select a valid course';
        }
        if (!$this->test_phone_number($this->phone_number)) {
            $errors['phone_number'] = 'please enter a valid phone number eg: 1234567890';
        }
        if (!$this->test_gender($this->gender)) {
            $errors['gender'] = 'please select a valid gender';
        }
        return $errors;
    }

    /**
     * Returns pagination data 
     *
     * @param int $page
     * @param int $limit
     * @param string $column
     * @param string $type
     * 
     * 
     * @return array
     */
    public function paginate($page, $limit, $column = "", $type = "") {
        $student = new Student();
        return $student->paginate($page, $limit, $column, $type);
    }

    /**
     * generates csv file for studdnts
     * 
     * @return bool
     */
    public function gen_csv() {
        $student = new Student();
        $data = $student->get();

        $file = fopen(__DIR__ . '/../../storage/csv/students.csv', 'w');
        $headings = "id, first_name, last_name, email, status, course, created_at, updated_at\n";

        fwrite($file, $headings);
        foreach($data as $row) {
            $status = $row['status'] ? 'active' : 'inactive';
            $line = $row['id'] . ',' . $row['first_name'] . ',' . $row['last_name'] . ',' . $row['email'] . ',' . $status . ',' . $row['course_name'] . ',' . $row['created_at'] . ',' . $row['updated_at'] . "\n";
            fwrite($file, $line);
        }

        fclose($file);

        return true;
        
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
        $student_controller->course_id = empty($_POST['course_id']) ? NULL : $_POST['course_id'];

        // $student_controller->save();
        if ($student_controller->save()) {

            $_SESSION['student_message'] = array(
                'type' => 'success',
                'message' => 'Student has been added',
            );

            header('Location:' . '/hiren/mvc2/app/views/student');
        } else {
            header('Location:' . htmlspecialchars($_SERVER['HTTP_REFERER']));
        }
    } else if ($_POST['operation'] === 'edit') {

        $student_controller = new StudentController();

        $student_controller->id = $_POST['id'] ?? '';
        $student_controller->first_name = $_POST['first_name'] ?? '';
        $student_controller->last_name = $_POST['last_name'] ?? '';
        $student_controller->email = $_POST['email'] ?? '';
        $student_controller->phone_number = $_POST['phone_number'] ?? '';
        $student_controller->gender = $_POST['gender'] ?? '';
        $student_controller->course_id = empty($_POST['course_id']) ? NULL : $_POST['course_id'];

        if ($student_controller->update()) {

            $_SESSION['student_message'] = array(
                'type' => 'success',
                'message' => 'Student has been updated',
            );

            header('Location:' . '/hiren/mvc2/app/views/student');
        } else {
            header('Location:' . htmlspecialchars($_SERVER['HTTP_REFERER']));
        }
    } else if ($_POST['operation'] === 'delete') {

        $student_controller = new StudentController();
        $student_controller->id = $_POST['id'];

        if ($student_controller->delete()) {
            $_SESSION['student_message'] = array(
                'type' => 'success',
                'message' => 'Student has been deleted',
            );

            header('Location:' . $_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['student_message'] = array(
                'type' => 'danger',
                'message' => 'Failed deleting student',
            );
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }else if($_POST['operation'] === 'csv'){
        $id = $_POST['id'] ?? null;
        $student_controller = new StudentController();
        $student_controller->gen_csv();

        $file_path = '../../storage/csv/students.csv';

        header('Content-Type: application/octet-stream');

        header('Content-Disposition: attachment; filename="'. basename($file_path));

        readfile($file_path);

        unlink($file_path);
        // header('Location:' . $_SERVER['HTTP_REFERER']);
    }
}
