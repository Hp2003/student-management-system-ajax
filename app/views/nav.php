<?php 
  $full_path_array = explode('/', $_SERVER['SCRIPT_FILENAME']);
  $folder = $full_path_array[count($full_path_array) - 2];
  $file = $full_path_array[count($full_path_array) - 1];

  $file_name = $folder . '/' . $file;
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php echo $file_name === 'student/index.php' ? 'active' : '' ?>" href="/hiren/student_management_system/app/views/student">Student</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $file_name === 'course/index.php' ? 'active' : '' ?>" href="/hiren/student_management_system/app/views/course">Course</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $file_name === 'student/addStudent.php' ? 'active' : '' ?>" href="/hiren/student_management_system/app/views/student/addStudent.php">Add Student</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $file_name === 'course/addCourse.php' ? 'active' : '' ?>" href="/hiren/student_management_system/app/views/course/addCourse.php">Add Course</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>