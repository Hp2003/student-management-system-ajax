<?php 
$current_page = 1;
if(!empty($_GET['page'])){
    $current_page = $_GET['page'];
}
?>
<?php if ($pages['total_pages'] > 1) { ?>
    <div class="container d-flex justify-content-center">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <?php if ($pages['prev_page']) { ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['prev_page'] ?>">Previous</a></li>
            <?php if ($pages['from'] != 1) { ?>
              <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=1" ?>">1</a></li>
              <li class="page-item"><a class="page-link disabled" href="#">...</a></li>
            <?php } ?>
          <?php } ?>
          <?php for ($page = $pages['from']; $page <= $pages['to']; $page++) { ?>
            <li class="page-item"><a class="page-link <?php echo $current_page == $page ? 'active' : '' ?>" href="<?php echo $_SERVER['PHP_SELF'] . "?page=$page" ?>"><?php echo $page ?></a></li>
          <?php } ?>
          <?php if ($pages['next_page']) { ?>
            <?php if ($pages['to'] != $pages['total_pages']) { ?>
              <li class="page-item"><a class="page-link disabled" href="#">...</a></li>
              <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['total_pages'] ?>"><?php echo $pages['total_pages'] ?></a></li>
            <?php } ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['next_page'] ?>">Next</a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  <?php } ?>