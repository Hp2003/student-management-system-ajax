<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/hiren/mvc2/app/models/Course.php');
require_once($root . '/hiren/mvc2/app/models/Student.php');
require_once($root . '/hiren/mvc2/app/controllers/CourseController.php');
$navbar = include_once('../nav.php');

$page = !empty($_GET['page']) ? $_GET['page'] : 1;
$sort_by = !empty($_GET['sort_by']) ? $_GET['sort_by'] : "";
$type = !empty($_GET['type']) ? $_GET['type'] : "";
$limit = $_GET['limit'] ?? 5;

// Getting paginated data
$course_controller = new CourseController();
$pagination_data = $course_controller->paginate($page, $limit, $sort_by, $type);

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
  <?php if(!empty($_SESSION['course_message'])){ 
    $alert = $_SESSION['course_message'];
    ?>
  <div class="alert alert-<?php echo $alert['type'] ?> alert-dismissible fade show" role="alert">
    <strong></strong> <?php echo $alert['message'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php } ?>
  <?php $navbar ?>
  <?php if (count($courses) <= 0) { ?>
    <h1 class="text-center mt-5"> No records available :( </h1>
  <?php } else { ?>
    <div class="container mt-5">
      <div class="container d-flex justify-content-center ">
        <form action="/hiren/mvc2/app/views/course/" class="w-25 limit-form d-flex">
          <select class="form-select limit" aria-label="Default select example" name="limit" >
            <option value="5" <?php  echo $limit == 5 ? 'selected' : '' ?>>5</option>
            <option value="10" <?php echo $limit == 10 ? 'selected' : '' ?>>10</option>
            <option value="20" <?php echo $limit == 20 ? 'selected' : '' ?>>20</option>
            <option value="50" <?php echo $limit == 50 ? 'selected' : '' ?>>50</option>
          </select>
          <input type="submit" value="filter" class="btn btn-primary">
        </form>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
            <form action="/hiren/mvc2/app/views/course/">
                <input type="hidden" name="sort_by" value="id">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <input type="hidden" name="type" value="<?php echo $type ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              id
            </th>
            <th scope="col">
            <form action="/hiren/mvc2/app/views/course/">
                <input type="hidden" name="sort_by" value="name">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <input type="hidden" name="type" value="<?php echo $type ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              name
            </th>
            <th scope="col">
            <form action="/hiren/mvc2/app/views/course/">
                <input type="hidden" name="sort_by" value="student_count">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <input type="hidden" name="type" value="<?php echo $type ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              students
            </th>
            <th scope="col">
            <form action="/hiren/mvc2/app/views/course/">
                <input type="hidden" name="sort_by" value="created_at">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <input type="hidden" name="type" value="<?php echo $type ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              created_at
            </th>
            <th scope="col">
            <form action="/hiren/mvc2/app/views/course/">
                <input type="hidden" name="sort_by" value="updated_at">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <input type="hidden" name="type" value="<?php echo $type ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              updated_at
            </th>
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
              <td><?php echo $course['student_count'] ?></td>
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

</body>

</html>
<?php unset($_SESSION['course_message']); ?>