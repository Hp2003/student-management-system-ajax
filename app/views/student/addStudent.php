<?php 

$root = $_SERVER['DOCUMENT_ROOT'];

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$navbar = include_once('../nav.php');


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
    <div class="container">
        <form action="" id="addStudentForm" method="POST">
            <input type="hidden" name="operation" value="add">
            <div class="mb-3">
                <label class="form-label">First name : </label>
                <input type="text" name="first_name" class="form-control" id=""  >
                <span class="text-danger" ></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Last name : </label>
                <input type="text" name="last_name" class="form-control" id="" >
                <span class="text-danger" > </span>
            </div>
            <div class="mb-3">
                <label class="form-label">Email : </label>
                <input type="email" name="email" class="form-control" id="">
                <span class="text-danger" > </span>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone number : </label>
                <input type="number" name="phone_number" class="form-control" id="">
                <span class="text-danger" ></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender : </label>
                Male : <input type="radio" name="gender" value="male" class="mx-2" id="" >
                Female : <input type="radio" name="gender" value="female" class="mx-2" id="" > 
                Other : <input type="radio" name="gender" value="other" class="mx-2" id="" >
            </div>
            <span class="text-danger" ></span>
            <div class="mb-3">
                <select class="form-select course-select" name="course_id" aria-label="Default select example" >
                    <option value="default">Select Course</option>
                </select>
                <span class="text-danger" > </span>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Add Student</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../../../public/js/validation.js"></script>
    <script>

        // getting course
        $.post('http://localhost/hiren/student_management_system/app/controllers/CourseController.php', { operation : 'get_all_course' }, function (data, status, xhr) {
            if(status === 'success'){
                setCourseSelectionList(data.courses);
            }
        })

        /**
         * displaying course names in select tag
         * 
         * @param array courses
         * 
         * @return void
         */
        function setCourseSelectionList(courses) {
            const courseSelectTag = $('.course-select');

            courses.forEach(course => {
                const option = $('<option></option>');
                option.text(course.name);
                option.val(course.id);
                courseSelectTag.append(option);
            })
        }

        $('#addStudentForm').submit(function (e) {
            e.preventDefault();

            const studentObject = {

                first_name : $(this).find('[name=first_name]').val(),
                last_name : $(this).find('[name=last_name]').val(),
                email : $(this).find('[name=email]').val(),
                phone_number : $(this).find('[name=phone_number]').val(),
                gender : $(this).find('[name=gender]:checked').val(),
                course : $(this).find('[name=course_id]').find(':selected').val(),

            }

            console.log(studentObject);
        })
    </script>
</body>

</html>
