<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('../models/Course.php');
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
      <a type="button" href="/hiren/mvc2/app/views/addCourseForm.php" class="btn btn-primary">Add Course</a>
      <a type="button" href="/hiren/mvc2/app/views/student.php" class="btn btn-primary">Students</a>
    </div>
    <div class="container mt-5">
        <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            foreach($courses as $course){

              ?>
          <tr>
            <th scope="row"><?php echo $course['id'] ?></th>
            <td><?php echo $course['name'] ?></td>
            <td><?php echo date( 'd-m-Y H : i', strtotime($course['created_at'])) ?></td>
            <td><?php echo date( 'd-m-Y H : i', strtotime($course['updated_at'])) ?></td>
            <td>
                <a type="button" href="<?php echo "/hiren/mvc2/app/views/editCourseForm.php?id=" . $course['id'] ?>" class="btn btn-primary">Edit</a>
            </td>
            <td>
              <form action="../controllers/CourseController.php" method="POST">
                <input type="hidden" name="operation" value="delete">
                <input type="hidden" name="id" value="<?php echo $course['id']?>">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          <?php   
      }
        ?>
        </tbody>
      </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>