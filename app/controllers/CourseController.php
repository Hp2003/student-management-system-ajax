<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/utils/Validator.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');

class CourseController extends Validator
{

    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    /**
     * saves new course in db and return inserted id
     *
     * @return int
     */
    public function save()
    {

        $course = new Course();
        $course->name = $this->name;
        $result = $course->save();
        if ($result === FALSE) {
            $_SESSION['duplicate_course_error'] = 'The course name is already avaialble';
            $this->set_values_to_session('add_course_form_input_values');
        } 
        return $result;
    }

    /**
     * validates all user inputs and return array of errors
     *
     * @return array
     */
    public function validate()
    {
        $errors = [];

        if (empty($this->name)) {
            $errors[] = ['name' => 'Name is required'];
        }
    }

    /**
     * updates course using id and return true or false
     *
     * @return bool
     */
    public function update()
    {
        $is_duplicate = $this->test_duplicate_course(strtoupper($this->name));
        if ($is_duplicate) {
            $_SESSION['update_form_duplicate_course_error'] = 'The course name is already avaialble';
            $this->set_values_to_session('update_course_form_input_values');
            return false;
        }
        $course = new Course();
        $course->find($this->id);
        $course->name = $_POST['name'];
        return $course->update();
    }

    /**
     * call model to delete course from database
     *
     * @return bool
     */
    public function delete()
    {

        $course = new Course();
        $course->find($this->id);
        return $course->delete();
    }

    /**
     * Adds input values to session to show user
     * @param string $name
     *
     * @return void
     */
    public function set_values_to_session($key_name) {
        $_SESSION[$key_name] = array (
            'name' => $this->name,
        );
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['operation'] === 'edit') {
        $course_controller = new CourseController();
        $course_controller->name = $_POST['name'] ?? '';
        $course_controller->id = $_POST['id'] ?? '';
        if ($course_controller->update() === FALSE) {
            header('Location:' .  htmlspecialchars($_SERVER['HTTP_REFERER']));
        } else {
            header('Location:' .  '/hiren/mvc2/app/views/course');
        }
    } elseif ($_POST['operation'] === 'delete') {
        $course_controller = new CourseController();
        $course_controller->id = $_POST['id'];
        $course_controller->delete();
        header('Location:' .  htmlspecialchars($_SERVER['HTTP_REFERER']));
    } else {
        $course_controller = new CourseController();
        $course_controller->name = $_POST['name'];
        if ($course_controller->save() === FALSE) {
            header('Location:' .  htmlspecialchars($_SERVER['HTTP_REFERER']));
        } else {
            header('Location:' .  '/hiren/mvc2/app/views/course');
        }
    }
}
