function displayAlert(type, heading, description) {
  $('body').prepend(`
        <div class="alert alert-${type} alert-dismissible w-100 fade show position-fixed top-0 z-3" role="alert">
          <strong>${heading}</strong> ${description}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `)

  setTimeout(() => {
    $('.alert-dismissible').remove()
  }, 5000)
}
