<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$root = $_SERVER['DOCUMENT_ROOT'];
// require_once($root . '/hiren/mvc2/app/models/Student.php');
// require_once($root . '/hiren/mvc2/app/models/Course.php');
// require_once($root . '/hiren/mvc2/app/controllers/StudentController.php');

$navbar = include_once('../nav.php');

// Pattern to formate phone number
$pattern = "/^(\d{3})(\d{3})(\d{4})$/";







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
  <div class=" mx-auto mt-5" style="width : 90%;">
    <div class="container d-flex justify-content-around">
      <form class="w-25 limit-form d-flex ">
        <select class="form-select limit-options" onchange="setLimit()" aria-label="Default select example"  name="limit">
          <option class="limit-option" value="1">1</option>
          <option class="limit-option" value="5">5</option>
          <option class="limit-option" value="10">10</option>
          <option class="limit-option" value="20">20</option>
          <option class="limit-option" value="50">50</option>
        </select>
      </form>
      <form action="../../controllers/StudentController.php" method="post">
        <input type="hidden" name="operation" value="csv">
        <button type="submit" class="btn btn-primary">Download</button>
      </form>
    </div>
    <table class="table table-striped">
      <thead>
        <tr class="user-select-none">
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="id" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="id" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p class="mx-2">id</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="first_name" data-sort-type="ASC" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="first_name" data-sort-type="DESC" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>first_name</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="last_name" data-sort-type="ASC" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="last_name" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>last_name</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="email" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="email" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>email</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="gender" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="gender" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>gender</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="course_id" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="course_id" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>course</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="status" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="status" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>status</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="phone_number" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="phone_number" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>phone</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="created_at" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="created_at" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>created_at</p>
          </th>
          <th scope="col " class="heading">
              <button class="sort-by-btn" data-sort-by="updated_at" data-sort-type="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
              <button class="sort-by-btn" data-sort-by="updated_at" data-sort-type="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
            <p>updated_at</p>
          </th>
          <th scope="col "></th>
          <th scope="col "></th>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="../../../public/js/alert.js"></script>
  <script src="../../../public/js/students.js"></script>
  <script>
    
  </script>
</body>

</html>