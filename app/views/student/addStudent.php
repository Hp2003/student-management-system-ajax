<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');
$course = new Course();
$courses = $course->get();
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
    <div class="container">
        <form action="../../controllers/StudentController.php" method="POST">
            <input type="hidden" name="operation" value="add">
            <div class="mb-3">
                <label class="form-label">First name : </label>
                <input type="text" name="first_name" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label class="form-label">Last name : </label>
                <input type="text" name="last_name" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label class="form-label">Email : </label>
                <input type="email" name="email" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone number : </label>
                <input type="number" name="phone_number" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label class="form-label">Gender : </label>
                Male : <input type="radio" name="gender" value="male" class="mx-2" id="">
                Female : <input type="radio" name="gender" value="female" class="mx-2" id="">
                Other : <input type="radio" name="gender" value="other" class="mx-2" id="">
            </div>
            <select class="form-select" name="course_id" aria-label="Default select example">
                <?php foreach($courses as $course){ ?>
                <option value="<?php echo $course['id']?>" ><?php echo $course['name']?></option>
            <?php }?>
            </select>
            <button type="submit" class="btn btn-primary mt-3">Add Student</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>