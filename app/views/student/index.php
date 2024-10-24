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

  <!-- <script src="../../../public/js/index.js"></script> -->
  <script>
    /**
     * Contains all values of current query string
     * 
     */
    const pageQueryStrings = {
      currentPage: 1,
      limit: 5,
      sortby: 'id',
      type: 'DESC',
    };

    getStudents(); // Getting students when page first loads


    /**
     * Function fetch students according to current page value
     * 
     * @return void
     */
    function getStudents() {
      setpageQueryStrings();
      $.get(`http://localhost/hiren/student_management_system/app/controllers/StudentController.php?page=${pageQueryStrings.currentPage}&limit=${pageQueryStrings.limit }&sort_by=${pageQueryStrings.sortby}&type=${pageQueryStrings.type}`,
        function(data, status) {
          if (status === 'success') {
            console.log(data.pagination_data);
            displayStudents(data.pagination_data);
            displayPaginationLinks(data.pagination_numbers);
          }
        })
    }

    /**
     * Main function to display students
     * 
     * @param students bool 
     * 
     * @return void
     */

    function displayStudents(students) {
      const tableBody = $('.table-body');
      tableBody.empty();
      students.forEach(student => {
        let row = $('<tr></tr>');
        row.append(`<th>${student.id}</th>`)
        row.append(`<td>${student.first_name}</td>`)
        row.append(`<td>${student.last_name}</td>`)
        row.append(`<td>${student.email}</td>`)
        row.append(`<td>${student.gender}</td>`)
        row.append(`<td>${student.course}</td>`)
        row.append(`<td>${student.status ? 'Active' : 'Inactive'}</td>`)
        row.append(`<td>${student.phone_number}</td>`)
        row.append(`<td>${student.created_at}</td>`)
        row.append(`<td>${student.updated_at}</td>`)
        row.append(`<td>
          <button class="btn btn-primary">Edit</button>
        </td>`)
        row.append(`<td><button class="btn btn-danger">Delete</button></td>`)

        tableBody.append(row);
      })
    }

    /**
     * sets values in pageQueryStrings object according to current querystirng
     *
     * @return void
     */
    function setpageQueryStrings() {
      // getting querystrings
      let url = window.href;
      let params = new URL(document.location.toString()).searchParams;

      pageQueryStrings.limit = params.get('limit') ?? 5;
      pageQueryStrings.currentPage = params.get('page') ?? 1;
      pageQueryStrings.sortby = params.get('sort_by') ?? 'id';
      pageQueryStrings.type = params.get('type') ?? 'DESC';

    }

    /**
     * displays pagination links in ui param links should contain object of page numbers returned by server
     * 
     * @param links object 
     * 
     * @return void
     */
    function displayPaginationLinks(links) {
      if (links.total_pages > 1) {
        const mainPaginationContainer = $('.pagination');
        mainPaginationContainer.empty();
        if (links.prev_page) {
          const row = $('<li class="page-item"></li>');
          row.append(`<a class="page-link" href="#" data-page-value="${pageQueryStrings.currentPage - 1}" onclick="changePage(event)" >Previous</a>`)
          mainPaginationContainer.append(row);

          const disabledRow = $('<li class="page-item"></li>');
          disabledRow.append(`<a class="page-link disabled" href="#">...</a>`)
          mainPaginationContainer.append(disabledRow);
        }

        for (let page = links.from; page <= links.to; page++) {
          const row = $('<li class="page-item"></li>');
          row.append(`<a class="page-link" href="#" data-page-value="${page}" onclick="changePage(event)" >${page}</a>`)
          mainPaginationContainer.append(row);
        }

        if (links.next_page) {
          const disabledRow = $('<li class="page-item"></li>');
          disabledRow.append(`<a class="page-link disabled" href="#">...</a>`)
          mainPaginationContainer.append(disabledRow);

          const row = $('<li class="page-item"></li>');
          row.append(`<a class="page-link" href="#" data-page-value="${pageQueryStrings.currentPage + 1}" onclick="changePage(event)">Next</a>`)
          mainPaginationContainer.append(row);
        }
      }
    }

    /**
     * Changes page according to selected link
     * 
     * @param event (javascript event) event 
     * 
     * @return void
     */
    function changePage(event) {
      event.preventDefault();
      const pageNumber = event.target.getAttribute('data-page-value');

      pageQueryStrings.currentPage = pageNumber;
      changeQueryString();
      getStudents();

    }

    /**
     * Changing querystring to current url
     *
     * @return void
     */
    function changeQueryString() {
      let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + `?page=${pageQueryStrings.currentPage}&type=${pageQueryStrings.type}&limit=${pageQueryStrings.limit}&sort_by=${pageQueryStrings.sortby}` ;
      window.history.pushState({},'',newurl);
    }

  </script>
</body>

</html>