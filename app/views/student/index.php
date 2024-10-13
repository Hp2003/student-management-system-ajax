<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Student.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');

    $studnet = new Student();
    $students = $studnet->get();
    $course = new Course();
    $courses = $course->get_formatted_course();

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
  <a  href="../student/addStudent.php" class="btn btn-primary">Add Student</a>
  <a  href="../views/course.php" class="btn btn-primary">Course</a>
    <div class="container mt-5">
      <table class="table">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">first_name</th>
          <th scope="col">last_name</th>
          <th scope="col">email</th>
          <th scope="col">gender</th>
          <th scope="col">course</th>
          <th scope="col">phone</th>
          <th scope="col">created_at</th>
          <th scope="col">updated_at</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($students as $student){ ?>
        <tr>
          <th scope="row"><?php echo $student['id']?></th>
          <td><?php echo $student['first_name']?></td>
          <td><?php echo $student['last_name']?></td>
          <td><?php echo $student['email']?></td>
          <td><?php echo $student['gender']?></td>
          <td><?php echo $courses[$student['course_id']] ?></td>
          <td><?php echo $student['phone_number'] ?></td>
          <td><?php echo date('d-m-Y H : i', strtotime($student['created_at']))?></td>
          <td><?php echo date('d-m-Y H : i', strtotime($student['updated_at']))?></td>
          <td><a type="button" href="<?php echo "/hiren/mvc2/app/views/student/editStudent.php?id=" . $student['id']  ?>" class="btn btn-primary">Edit</a></td>
          <td>
            <form action="../../controllers/StudentController.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $student['id'] ?>">
                <input type="hidden" name="operation" value="delete">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>