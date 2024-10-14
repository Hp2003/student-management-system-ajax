<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Student.php');

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$navbar = include_once('../nav.php');
$course = new Course();
$courses = $course->get_formatted_course();

if(!isset($_GET['id']) || empty($_GET['id'])){
    header('Location:' . ($_SERVER['HTTP_ACCEPT'] ? 'http://' : 'https://')  .  $_SERVER['HTTP_HOST'] . '/hiren/mvc2/app/views/404.php'  )   ;
}
$student = new Student($_GET['id']);
$errors = $_SESSION['edit_student_errors'] ?? [];
$inputs = $_SESSION['edit_student_inputs'] ?? [];


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php $navbar ?>
    <div class="container mt-5">
        <h1 class="text-center">Update Student</h1>
        <form action="../../controllers/StudentController.php" method="POST">
            <input type="hidden" name="operation" value="edit">
            <input type="hidden" name="id" value="<?php echo $student->id ?>">
            <div class="mb-3">
                <label class="form-label">First name : </label>
                <input type="text" name="first_name" class="form-control" value="<?php echo $inputs['first_name'] ?? $student->first_name ?>" id="">
                <span class="text-danger" > <?php echo $errors['first_name'] ?? '' ?></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Last name : </label>
                <input type="text" name="last_name" class="form-control" value="<?php echo $inputs['last_name'] ?? $student->last_name ?>" id="">
                <span class="text-danger" > <?php echo $errors['last_name'] ?? '' ?></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Email : </label>
                <input type="email" name="email" class="form-control" value="<?php echo $inputs['email'] ?? $student->email ?>" id="">
                <span class="text-danger" > <?php echo $errors['email'] ?? '' ?></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone number : </label>
                <input type="number" name="phone_number" class="form-control" value="<?php echo $inputs['phone_number'] ?? $student->phone_number ?>" id="">
                <span class="text-danger" > <?php echo $errors['phone_number'] ?? '' ?></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender : </label>
                Male : <input type="radio" name="gender" value="male" class="mx-2" checked = <?php echo ($inputs['gender'] ?? $student->gender) === 'male' ? 'checked' : '' ?> id="">
                Female : <input type="radio" name="gender" value="female" class="mx-2" <?php echo ($inputs['gender'] ?? $student->gender) === 'female' ? 'checked' : '' ?> id="">
                Other : <input type="radio" name="gender" value="other" class="mx-2" <?php echo ($inputs['gender'] ?? $student->gender) === 'other' ? 'checked' : '' ?> id="">
                <span class="text-danger" > <?php echo $errors['gender'] ?? '' ?></span>
            </div>
            <div class="mb-3">
                <select class="form-select" name="course_id" aria-label="Default select example">
                    <option value="">Course</option>
                    <?php foreach($courses as $id => $name){ ?>
                    <option value="<?php echo $id ?>" <?php echo $id === ($inputs['course_id'] ?? $student->course_id) ? 'selected'  : '' ?> ><?php echo $name?></option>
                <?php }?>
                </select>
                <span class="text-danger" > <?php echo $errors['course_id'] ?? '' ?></span>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Student</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php 
    unset($_SESSION['edit_student_errors']);
    unset($_SESSION['edit_student_inputs']);
?>