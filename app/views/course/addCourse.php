<?php 
$navbar = include_once('../nav.php');

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$duplicate_course_error = $_SESSION['duplicate_course_error'] ?? '';
$error_inputs = $_SESSION['add_course_form_input_values'];

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
    <div class="container mt-5 w-25">
        <form action="../../controllers/CourseController.php" method="post">
            <input type="hidden" name="operation" value="add">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label" >Course Name : </label>
                <input type="text" name="name" class="form-control" id="" value="<?php echo $error_inputs['name'] ?>" required>
                <span class="text-danger"><?php echo $duplicate_course_error   ?></span>
                <span class="text-danger"><?php echo $_SESSION['errors']['name']   ?></span>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Course</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php 
    unset($_SESSION['duplicate_course_error']);
    unset($_SESSION['add_course_form_input_values']);
    unset($_SESSION['errors']);
?>