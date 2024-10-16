<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Course.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/models/Student.php');

$navbar = include_once('../nav.php');

$student = new Student();

$course = new Course();
$pagination_data = $course->paginate($_GET['page'] ?? 1, $_GET['limit'] ?? 5);

$pages = $pagination_data['pagination_numbers'] ?? 0;
unset($pagination_data['pagination_numbers']);
$courses = $pagination_data;

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
  <?php if (count($courses) <= 0) { ?>
    <h1 class="text-center mt-5"> No records available :( </h1>
  <?php } else { ?>
    <div class="container mt-5">
    <div class="container d-flex justify-content-end">
      <form action="<?php echo $_SERVER['REQUEST_URI']  ?>" class="w-25 limit-form">
        <select class="form-select limit" aria-label="Default select example" name="limit"  onchange="submit()">
          <option value="5" <?php  echo ($_GET['limit'] ?? 5) == 5 ? 'selected' : '' ?>  >5</option>
          <option value="10" <?php echo  ($_GET['limit'] ?? 5) == 10 ? 'selected' : '' ?>  >10</option>
          <option value="20" <?php echo  ($_GET['limit'] ?? 5) == 20 ? 'selected' : '' ?>  >20</option>
          <option value="50" <?php echo  ($_GET['limit'] ?? 5) == 50 ? 'selected' : '' ?>  >50</option>
        </select>
      </form>
    </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">students</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($courses as $course) {

          ?>
            <tr>
              <th scope="row"><?php echo $course['id'] ?></th>
              <td><?php echo $course['name'] ?></td>
              <td><?php echo $student->get_total_students($course['id']) ?></td>
              <td><?php echo date('d-m-Y h : i a', strtotime($course['created_at'])) ?></td>
              <td><?php echo date('d-m-Y h : i a', strtotime($course['updated_at'])) ?></td>
              <td>
                <a type="button" href="<?php echo "../course/editCourse.php?id=" . $course['id'] ?>" class="btn btn-primary">Edit</a>
              </td>
              <td>
                <form action="../../controllers/CourseController.php" method="POST">
                  <input type="hidden" name="operation" value="delete">
                  <input type="hidden" name="id" value="<?php echo $course['id'] ?>">
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
    <?php require_once('../paginator.php') ?>
  <?php } ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    function send_request() {
      let limit = document.querySelector('.limit').value;
      let form = document.querySelector('.limit-form');

      
    }
  </script>
</body>

</html>