<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/utils/Validator.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');
class CourseController {

    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    /**
     * saves new course in db and return inserted id
     *
     * @return int
     */
    public function save() {

        $course = new Course();
        $course->name = $this->name;
        $result = $course->save();
        return $result;

    }

    /**
     * validates all user inputs and return array of errors
     *
     * @return array
     */
    public function validate() {
        $errors = [];

        if(empty($this->name)){
            $errors[] = ['name' => 'Name is required'];
        }
    }

    /**
     * updates course using id and return true or false
     *
     * @return bool
     */
    public function update() {
        
        $course = new Course($_POST['id']);
        $course->name = $_POST['name'];
        return $course->update();

    }

    /**
     * call model to delete course from database
     *
     * @return bool
     */
    public function delete() {
        
        $course = new Course($this->id);
        return $course->delete();

    }

}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['operation'] === 'edit'){
        $course_controller = new CourseController();
        $course_controller->update();        
    }

    elseif($_POST['operation'] === 'delete') {
        $course_controller = new CourseController();
        $course_controller->id = $_POST['id'];
        $course_controller->delete();
    }

    else{
        $course_controller = new CourseController();
        $course_controller->name = $_POST['name'];
        if($course_controller->save() === FALSE ) {
            // $_SESSION['add_course_failed'] = true;
        }
        
    }
    header('Location:' .  '/hiren/mvc2/app/views/course'  );
}
