<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/hiren/mvc2/app/models/Student.php');
require_once($root . '/hiren/mvc2/app/models/Course.php');
require_once($root . '/hiren/mvc2/app/controllers/StudentController.php');

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
  <?php if (!empty($_SESSION['student_message'])) {
    $alert = $_SESSION['student_message'];
  ?>
    <div class="alert alert-<?php echo $alert['type'] ?> alert-dismissible fade show" role="alert">
      <strong></strong> <?php echo $alert['message'] ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php } ?>
  <div class=" mx-auto mt-5" style="width : 90%;">
    <?php
    if (count($students) <= 0) {
    ?>
      <h1 class="text-center mt-5"> No records found :( </h1>
    <?php
    } else {
    ?>
      <div class="container d-flex justify-content-around">
        <form action="/hiren/mvc2/app/views/student" class="w-25 limit-form d-flex ">
          <?php /*<input type="hidden" name="sort_by" value=<?php echo $sort_by ?>>
          <input type="hidden" name="type" value=<?php echo $type ?>> */ ?>
          <select class="form-select limit" aria-label="Default select example" name="limit">
            <option value="5" <?php echo $limit == 5 ? 'selected' : '' ?>>5</option>
            <option value="10" <?php echo $limit == 10 ? 'selected' : '' ?>>10</option>
            <option value="20" <?php echo $limit == 20 ? 'selected' : '' ?>>20</option>
            <option value="50" <?php echo $limit == 50 ? 'selected' : '' ?>>50</option>
          </select>
          <input type="submit" value="Filter" class="btn btn-primary">
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
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="id">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p class="mx-2">id</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="first_name">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>first_name</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="last_name">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>last_name</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="email">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>email</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="gender">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>gender</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="course_id">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>course</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="status">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>status</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="phone_number">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>phone</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="created_at">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>created_at</p>
            </th>
            <th scope="col " class="heading">
              <form action="/hiren/mvc2/app/views/student/">
                <input type="hidden" name="sort_by" value="updated_at">
                <?php /*<input type="hidden" name="page" value="<?php echo $page ?>"> */ ?>
                <input type="hidden" name="limit" value="<?php echo $limit ?>">
                <button class="" value="ASC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2191;</button>
                <button class="" value="DESC" name="type" style="font-size: 2rem; padding : 0; margin : 0; ">&#x2193;</button>
              </form>
              <p>updated_at</p>
            </th>
            <th scope="col "></th>
            <th scope="col "></th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
  </div>

  <div class="container d-flex justify-content-center h-auto user-select-none">
    <nav aria-label="Page navigation example">
      <ul class="pagination">

      </ul>
    </nav>
  </div>
<?php } ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!-- <script src="../../../public/js/index.js"></script> -->
<script>
  let url = window.href;
  let params = new URL(document.location.toString()).searchParams;

  getStudents(params.get('page'));

  function getStudents(currentPage) {

    $.get(`http://localhost/hiren/student_management_system/app/controllers/StudentController.php?page=${currentPage}&limit=${params.get('limit') }&sort_by=${params.get('sort_by')}&type=${params.get('type')}`,function(data) {
      const paginationData = JSON.parse(data);
      
      console.log(paginationData);
      // console.log(JSON.parse(data));
      if (paginationData.total_pages > 1) {
        if (paginationData.prev_page) {
          $('.pagination').append(`
        <li class="page-item ">
          <a class="page-link" onclick="getStudents(${params.get('page') - 1})">Previous</a>
        </li>`)
        }

        for (let page = paginationData.from; page <= paginationData.to; page++) {
          $('.pagination').append(`
          <li class="page-item">
            <a class="page-link"  onclick="getStudents(${page}) >${page}</a>
          </li>
        `)
        }

        if (paginationData.next_page) {

          $('.pagination').append(`
          <li class="page-item ">
             <a class="page-link"  onclick="getStudents(${params.get('page') + 1})>Next</a>
          </li>
        `)
        }
      }
    })
  }
</script>
</body>

</html>

<?php if (!empty($pages) && $pages['page'] <= $pages['total_pages']) unset($_SESSION['student_message']) ?>