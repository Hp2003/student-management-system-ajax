<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

// $root = $_SERVER['DOCUMENT_ROOT'];
// require_once($root . '/hiren/mvc2/app/models/Course.php');
// require_once($root . '/hiren/mvc2/app/models/Student.php');
// require_once($root . '/hiren/mvc2/app/controllers/CourseController.php');
$navbar = include_once('../nav.php');



// Getting paginated data
// $course_controller = new CourseController();
// $pagination_data = $course_controller->paginate($page, $limit, $sort_by, $type);

// $pages = [];
// $courses = [];
// if($pagination_data !== false){
//   $pages = $pagination_data['pagination_numbers'] ?? 0;
//   unset($pagination_data['pagination_numbers']);
//   $courses = $pagination_data;
//   // var_dump($pages);
//   if($page > $pages['total_pages'] && $pages['total_pages'] > 0){
//     header("Location: /hiren/mvc2/app/views/course?limit=$limit&type=$type&sort_by=$sort_by&page=" . $pages['total_pages']);
//   }
// }else{
//   $courses = [];
// }

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
      <div class="container d-flex justify-content-center d-flex justify-content-around">
        <form action="/hiren/mvc2/app/views/course/" class="w-25 limit-form d-flex">
          <select class="form-select limit" aria-label="Default select example" name="limit" >
            <option value="5" <?php  echo $limit == 5 ? 'selected' : '' ?>>5</option>
            <option value="10" <?php echo $limit == 10 ? 'selected' : '' ?>>10</option>
            <option value="20" <?php echo $limit == 20 ? 'selected' : '' ?>>20</option>
            <option value="50" <?php echo $limit == 50 ? 'selected' : '' ?>>50</option>
          </select>
          <input type="submit" value="filter" class="btn btn-primary">
        </form>
        <form action="../../controllers/CourseController.php" method="post">
          <input type="hidden" name="operation" value="csv">
          <button type="submit" class="btn btn-primary">Download</button>
        </form>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
                <button class="sort-by-btn" data-sort-by="id"  data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="sort-by-btn" data-sort-by="id"  data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              <p>id</p>
            </th>
            <th scope="col">
                <button class="sort-by-btn" data-sort-by="name" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="sort-by-btn" data-sort-by="name" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              <p>name</p>
            </th>
            <th scope="col">
                <button class="sort-by-btn" data-sort-by="student_count" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="sort-by-btn" data-sort-by="student_count" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              <p>students</p>
            </th>
            <th scope="col">
                <button class="sort-by-btn" data-sort-by="created_at" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="sort-by-btn" data-sort-by="created_at" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              <p>created_at</p>
            </th>
            <th scope="col">
                <button class="sort-by-btn" data-sort-by="updated_at" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="sort-by-btn" data-sort-by="updated_at" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              <p>updated_at</p>
            </th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody class="table-body">
        
        </tbody>
      </table>
    </div>
    <div class="container d-flex justify-content-center h-auto user-select-none">
  <nav aria-label="Page navigation example">
    <ul class="pagination">

    </ul>
  </nav>
</div>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="../../../public/js/courses.js"></script>
</body>

</html>
