<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Student.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/controllers/StudentController.php');

$navbar = include_once('../nav.php');

$studnet = new Student();
$students = $studnet->get();
$course = new Course();
$courses = $course->get_formatted_course();

$pattern = "/^(\d{3})(\d{3})(\d{4})$/";

if (!empty($_GET['page'])) {
  $student = new Student();
  $pagination_data = $student->paginate($_GET['page']);
  // $students = $pagination_data[0];
  $pages = $pagination_data['pagination_numbers'];
  unset($pagination_data['pagination_numbers']);
  $students = $pagination_data;
}

$current_page = $_GET['page'];

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
    <?php
    if (count($students) <= 0) {
    ?>
      <h1 class="text-center mt-5"> No records available :( </h1>
    <?php
    } else {
    ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">first_name</th>
            <th scope="col">last_name</th>
            <th scope="col">email</th>
            <th scope="col">gender</th>
            <th scope="col">course</th>
            <th scope="col">status</th>
            <th scope="col">phone</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $student) { ?>
            <tr>
              <th scope="row"><?php echo $student['id'] ?></th>
              <td><?php echo $student['first_name'] ?></td>
              <td><?php echo $student['last_name'] ?></td>
              <td><?php echo $student['email'] ?></td>
              <td><?php echo $student['gender'] ?></td>
              <td><?php echo $courses[$student['course_id']] ?? 'N/A' ?></td>
              <td><?php echo !empty($student['course_id']) ? 'Active' : 'Inactive' ?></td>
              <td><?php echo preg_replace($pattern, '$1-$2-$3', $student['phone_number']) ?></td>
              <td><?php echo date('d-m-Y h : i a', strtotime($student['created_at'])) ?></td>
              <td><?php echo date('d-m-Y h : i a', strtotime($student['updated_at'])) ?></td>
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

  <?php if ($pages['total_pages'] > 1) { ?>
    <div class="container d-flex justify-content-center">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <?php if ($pages['prev_page']) { ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['prev_page'] ?>">Previous</a></li>
            <?php if ($pages['from'] != 1) { ?>
              <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=1" ?>">1</a></li>
              <li class="page-item"><a class="page-link disabled" href="#">...</a></li>
            <?php } ?>
          <?php } ?>
          <?php for ($page = $pages['from']; $page <= $pages['to']; $page++) { ?>
            <li class="page-item"><a class="page-link <?php echo $current_page == $page ? 'active' : '' ?>" href="<?php echo $_SERVER['PHP_SELF'] . "?page=$page" ?>"><?php echo $page ?></a></li>
          <?php } ?>
          <?php if ($pages['next_page']) { ?>
            <?php if ($pages['to'] != $pages['total_pages']) { ?>
              <li class="page-item"><a class="page-link disabled" href="#">...</a></li>
              <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['total_pages'] ?>"><?php echo $pages['total_pages'] ?></a></li>
            <?php } ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['next_page'] ?>">Next</a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  <?php } ?>
<?php } ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>