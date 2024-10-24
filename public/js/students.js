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

getStudents() // Getting students when page first loads

/**
 * Function fetch students according to current page value
 *
 * @return void
 */
function getStudents() {
  setpageQueryStrings()
  let maxPage = 0;
  $.get(
    `http://localhost/hiren/student_management_system/app/controllers/StudentController.php?page=${pageQueryStrings.currentPage}&limit=${pageQueryStrings.limit}&sort_by=${pageQueryStrings.sortby}&type=${pageQueryStrings.type}`,
    function (data, status) {
      if (status === 'success') {
        displayStudents(data.pagination_data)
        displayPaginationLinks(data.pagination_numbers)
      }
    }
  )
}

$(document).ajaxSuccess(function (event, xhr, options) {
  console.log(event)
})
/**
 * Main function to display students
 *
 * @param students bool
 *
 * @return void
 */

function displayStudents(students) {
  const tableBody = $('.table-body')
  tableBody.empty()
  students.forEach((student) => {
    let row = $('<tr></tr>')
    row.append(`<th>${student.id}</th>`)
    row.append(`<td>${student.first_name}</td>`)
    row.append(`<td>${student.last_name}</td>`)
    row.append(`<td>${student.email}</td>`)
    row.append(`<td>${student.gender}</td>`)
    row.append(`<td>${student.course_name ?? 'N/A'}</td>`)
    row.append(`<td>${student.status ? 'Active' : 'Inactive'}</td>`)
    row.append(`<td>${student.phone_number}</td>`)
    row.append(`<td>${student.created_at}</td>`)
    row.append(`<td>${student.updated_at}</td>`)
    row.append(`<td>
            <button class="btn btn-primary">Edit</button>
          </td>`)
    row.append(
      `<td><button class="btn btn-danger" onclick="showToast(${student.id}, '${student.first_name}', '${student.last_name}')">Delete</button></td>`
    )

    tableBody.append(row)
  })
}

/**
 * sets values in pageQueryStrings object according to current querystirng
 *
 * @return void
 */
function setpageQueryStrings() {
  // getting querystrings
  let url = window.href
  let params = new URL(document.location.toString()).searchParams;

  pageQueryStrings.limit = params.get('limit') ?? 5
  pageQueryStrings.currentPage = params.get('page') ?? 1
  pageQueryStrings.sortby = params.get('sort_by') ?? 'id'
  pageQueryStrings.type = params.get('type') ?? 'DESC'
}

/**
 * displays pagination links in ui param links should contain object of page numbers returned by server
 *
 * @param links object
 *
 * @return void
 */
function displayPaginationLinks(links) {
  const mainPaginationContainer = $('.pagination')
  mainPaginationContainer.empty()

  if (links.total_pages > 1) {
    if (links.prev_page) {
      const row = $('<li class="page-item"></li>')
      row.append(
        `<a class="page-link" href="#" data-page-value="${
          pageQueryStrings.currentPage - 1
        }" onclick="changePage(event)" >Previous</a>`
      )
      mainPaginationContainer.append(row)

      if (links.page >= 6) {
        const firstPage = $('<li class="page-item"></li>')
        firstPage.append(
          `<a class="page-link" href="#" data-page-value="1" onclick="changePage(event)" >1</a>`
        )
        mainPaginationContainer.append(firstPage)
      }

      const disabledRow = $('<li class="page-item"></li>')
      disabledRow.append(`<a class="page-link disabled" href="#">...</a>`)
      mainPaginationContainer.append(disabledRow)
    }

    for (let page = links.from; page <= links.to; page++) {
      const row = $('<li class="page-item"></li>')
      row
        .append(
          `<a class="page-link" href="#" data-page-value="${page}" onclick="changePage(event)" >${page}</a>`
        )
        .addClass(pageQueryStrings.currentPage == page ? 'active' : '')
      mainPaginationContainer.append(row)
    }

    if (links.next_page) {
      const disabledRow = $('<li class="page-item"></li>')
      disabledRow.append(`<a class="page-link disabled" href="#">...</a>`)
      mainPaginationContainer.append(disabledRow)

      if (links.total_pages > 10 && links.page < links.total_pages - 5) {
        const lastPage = $('<li class="page-item"></li>')
        lastPage.append(
          `<a class="page-link " data-page-value="${links.total_pages}" onclick="changePage(event)"  href="#">${links.total_pages}</a>`
        )
        mainPaginationContainer.append(lastPage)
      }

      const row = $('<li class="page-item"></li>')
      row.append(
        `<a class="page-link" href="#" data-page-value="${links.next_page}" onclick="changePage(event)">Next</a>`
      )
      mainPaginationContainer.append(row)
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
  event.preventDefault()
  const pageNumber = event.target.getAttribute('data-page-value')

  pageQueryStrings.currentPage = pageNumber
  changeQueryString()
  getStudents()
}

/**
 * Changing querystring in current url
 *
 * @return void
 */
function changeQueryString() {
  let newurl =
    window.location.protocol +
    '//' +
    window.location.host +
    window.location.pathname +
    `?page=${pageQueryStrings.currentPage}&type=${pageQueryStrings.type}&limit=${pageQueryStrings.limit}&sort_by=${pageQueryStrings.sortby}`
  window.history.pushState({}, '', newurl)
}

/**
 * Changing limit to user's selected limit and displays new data
 *
 * @return void
 */
function setLimit() {
  pageQueryStrings.limit = Number($('.limit-options').val())

  pageQueryStrings.currentPage = 1
  changeQueryString()
  getStudents()
}

// setting limit option to selected according to current query string
$('.limit-option').each(function () {
  if ($(this).val() == pageQueryStrings.limit) {
    $(this).attr('selected', 'selected')
  }
})

// sorting by column asc or desc
$('.sort-by-btn').on('click', function () {
  pageQueryStrings.sortby = $(this).attr('data-sort-by')
  pageQueryStrings.type = $(this).attr('data-sort-type')
  pageQueryStrings.currentPage = 1
  changeQueryString()
  getStudents()
})

/**
 * makes request to delete student
 *
 * @return void
 */
function deleteStudent(id) {
  $.post(
    'http://localhost/hiren/student_management_system/app/controllers/StudentController.php',
    { operation: 'delete', id: id },
    function (data, status, xhr) {
      if (status === 'success') {
        console.log('deleted')
        displayAlert('success', 'Deleted!', ' Student deleted successfully!')
        getStudents()
      }
    }
  )
}

/**
 * shows delete student toast
 *
 * @param int id
 * @param string first_name
 * @param string last_name
 *
 * @return void
 */
function showToast(id, first_name, last_name) {
  const toastLiveExample = document.getElementById('liveToast')

  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

  $('.toast-del-button').attr('data-del-id', id)
  $('.toast-message').text('student ' + first_name + ' ' + last_name + '?')

  toastBootstrap.show()
}

/**
 * calles delete function after use clicks on delete button
 * in confirmation toast
 */
$('.toast-del-button').click(function () {
  deleteStudent($(this).attr('data-del-id'))

  const toastLiveExample = document.getElementById('liveToast')

  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

  toastBootstrap.hide()
})
