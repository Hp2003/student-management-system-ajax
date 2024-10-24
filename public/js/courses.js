/**
 * Contains all values of current query string
 *
 */
const pageQueryStrings = {
  currentPage: 1,
  limit: 5,
  sortby: 'id',
  type: 'DESC',
}
getCourses()
/**
 * Function fetch students according to current page value
 *
 * @return void
 */
function getCourses() {
  // setpageQueryStrings()
  $.get(
    `http://localhost/hiren/student_management_system/app/controllers/CourseController.php`,
    function (data, status) {
      if (status === 'success') {
        displayCourse(data.pagination_data);
      }
    }
  )
}

/**
 * Main function to display courses
 *
 * @param courses array
 *
 * @return void
 */

function displayCourse(courses) {
    const tableBody = $('.table-body')
    tableBody.empty()
    courses.forEach((course) => {
      let row = $('<tr></tr>')
      row.append(`<th>${course.id}</th>`)
      row.append(`<td>${course.name}</td>`)
      row.append(`<td>${course.student_count}</td>`)
      row.append(`<td>${course.created_at}</td>`)
      row.append(`<td>${course.updated_at}</td>`)
      row.append(`<td>
              <button class="btn btn-primary">Edit</button>
            </td>`)
      row.append(`<td><button class="btn btn-danger">Delete</button></td>`)
  
      tableBody.append(row)
    })
  }