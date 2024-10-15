<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/hiren/mvc2/app/Dbconnect.php');

trait Paginator {

    private $page ; // current page
    private $total_page;  // total pages can be generated from current table
    private $limit = 2;
    private $from;
    private $to;
    /**
     * Returns array containing first page last page data for current page 
     *
     * @return array
     */
    public function pagination($page) {
        $this->page = $page;
        $conn = $this->connect();
        $data = [];
        $offset = $this->limit * ( $page - 1 );

        $sql = "SELECT * FROM $this->table LIMIT  ? OFFSET  ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $this->limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }
        $data['pagination_numbers'] = $this->pagination_numbers();
        return $data;
    }

    /**
     * Returns an array containing total pages, next page, previous page
     *
     * @return array
     */
    public function pagination_numbers() {
        $total_page = $this->total_page = round($this->get_total_records() / $this->limit);
        $to = $this->to = $this->get_to();
        $total_records = $this->get_total_records();
        $prev_page = $this->get_prev_page();
        $next_page = $this->get_next_page();
        $last_page = $this->get_last_page();
        return array (
            'page' => $this->page,
            'total_pages' => $total_page,
            'total_records' => $total_records,
            'prev_page' => $prev_page,
            'next_page' => $next_page,
            'last_page' => $last_page,
            'current' => $this->page,
            'from' => $this->get_from(),
            'to' => $to,
        );
    }

    /**
     * Returns total number of records from current table
     *
     * @return int
     */
    public function get_total_records() {
        $conn = $this->connect();
        $sql = "SELECT COUNT(*) AS total FROM $this->table ";
        $result = $conn->query($sql);
        $conn->close();
        return $result->fetch_assoc()['total'];
    }

    /**
     * Returns number of next page if current page is last then return false
     * else return page no.
     *
     * @return int|bool
     */
    public function get_next_page() {
        if($this->page < $this->total_page) {
            return $this->page + 1;
        }
        return false;
    }

    /**
     * Returns number of prev page if current page is first page then returns false
     * else return page no.
     *
     * @return int|bool
     */
    public function get_prev_page() {
        if(( $this->page <= $this->total_page ) && ( $this->page != 1 )) {
            return $this->page - 1;
        }
        return false;
    }

    public function get_last_page() {
        $total_pages = $this->total_page;

        if( ( $this->page + 10) === $total_pages ){
            $this->page += 9;
        }
       
        return ( $this->page + 10) < $total_pages ? $this->page + 9 : $total_pages;
    }

    /**
     * Returns starting value of number buttons
     *
     * @return int
     */
    public function get_from() {

        $end = 10;
        $start = $this->page;

        if($start > $this->total_page){
            return 0;
        }

        if($start >= $this->total_page - 4 && $start - 9 > 0){
            return $this->total_page - 9;
        }
        if($start > $end / 2 && ( $this->page <= $this->total_page )) {
            return $start - ($end / 2) + 1;
        }
        
        return 1;

    }
    
    /**
     * Returns end value of number buttons
     *
     * @return int
     */
    public function get_to() {
        $end = 10 ;
        $start = $this->page;
        if($start > $this->total_page){
            return 0;
        }

        if($start > 5 && ($this->total_page > $start + 5 ) ) {
            return $start + 5;
        }

        if($end < $this->total_page && ( $this->page < $end )){
            return $end;
        }

        return $this->total_page;
        
    }

}