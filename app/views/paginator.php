<?php 
$current_page = 1;
if(!empty($_GET['page'])){
    $current_page = $_GET['page'];
}
$limit = 5;
if(!empty($_GET['limit'])){
  $limit = $_GET['limit'];
}
$sort_by = !empty($_GET['sort_by']) ? $_GET['sort_by'] : "";
$type = !empty($_GET['type']) ? $_GET['type'] : "";
?>
<?php if ($pages['total_pages'] > 1) { ?>
    <div class="container d-flex justify-content-center h-auto user-select-none">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <?php if ($pages['prev_page']) { ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['prev_page'] . "&limit=" . $limit . "&sort_by=" . $sort_by . "&type=" . $type ?>">Previous</a></li>
            <?php if ($pages['from'] != 1) { ?>
              <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=1" . "&limit=" . $limit . "&sort_by=" . $sort_by . "&type=" . $type ?>">1</a></li>
              <li class="page-item"><a class="page-link disabled" href="#">...</a></li>
            <?php } ?>
          <?php } ?>
          <?php for ($page = $pages['from']; $page <= $pages['to']; $page++) { ?>
            <li class="page-item"><a class="page-link <?php echo $current_page == $page ? 'active' : '' ?>" href="<?php echo $_SERVER['PHP_SELF'] . "?page=$page" . "&limit=" . $limit . "&sort_by=" . $sort_by . "&type=" . $type?>"><?php echo $page ?></a></li>
          <?php } ?>
          <?php if ($pages['next_page']) { ?>
            <?php if ($pages['to'] != $pages['total_pages']) { ?>
              <li class="page-item"><a class="page-link disabled" href="#">...</a></li>
              <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['total_pages'] . "&limit=" . $limit . "&sort_by=" . $sort_by . "&type=" . $type  ?>"><?php echo $pages['total_pages'] ?></a></li>
            <?php } ?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $pages['next_page'] . "&limit=" . $limit . "&sort_by=" . $sort_by . "&type=" . $type ?>">Next</a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  <?php } ?>