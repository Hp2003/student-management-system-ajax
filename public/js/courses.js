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
getCourses();
/**
 * Function fetch students according to current page value
 *
 * @return void
 */
function getCourses() {
    setpageQueryStrings()
    $.get(
      `http://localhost/hiren/student_management_system/app/controllers/StudentController.php?page=${pageQueryStrings.currentPage}&limit=${pageQueryStrings.limit}&sort_by=${pageQueryStrings.sortby}&type=${pageQueryStrings.type}`,
      function (data, status) {
        if (status === 'success') {
          //   console.log(data.pagination_data[0].first_name);
        }
      }
    )
  }