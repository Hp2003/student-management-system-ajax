<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');
    $course = new Course($_GET['id']);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5 w-25">
        <h1>Edit Course</h1>
        <form action="../../controllers/CourseController.php" method="post">
            <div class="mb-3">
                <input type="hidden" name="operation" value="edit">
                <input type="hidden" name="id" value="<?php echo $course->id ?>">
                <label for="exampleInputEmail1" class="form-label" >Course Name : </label>
                <input type="text" name="name" class="form-control" value="<?php echo $course->name ?>" id="" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Edit Course</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>