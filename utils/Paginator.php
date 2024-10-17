<?php 

$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/hiren/mvc2/app/Dbconnect.php');

class Paginator extends Dbconnect {

    private $page ; // current page
    private $total_page;  // total pages can be generated from current table
    private $limit = 10;
    // private $from;
    // private $to;

    /**
     * Returns array containing first page last page data for current page 
     *
     * @return array
     */
    public function pagination($page, $limit, $order_by = "", $type = "") {

        if($page <= 0 ) {
            return [];
        }
        $type = ($type === "") ? "DESC" : $type;
        $order_by = ($order_by === "") ? "id"  : $order_by;
        $this->limit = $limit;
        $this->page = $page;
        $conn = $this->connect();
        $data = [];
        $offset = $this->limit * ( $page - 1 );
        $sql = "";

        // if($order_by === 'students') $order_by = 'student_count';

        if($this->table === 'students'){
            $sql = "select students.*, courses.name as course_name from students left join courses on students.course_id = courses.id ORDER BY $order_by $type LIMIT ? OFFSET ?  ";
            if($order_by === 'course_id'){
                $sql = "select students.*, courses.name as course_name from students left join courses on students.course_id = courses.id ORDER BY CASE WHEN courses.name IS NULL THEN 1 ELSE 0 END, courses.name $type LIMIT ? OFFSET ?";
            }
        }else{
            $sql = "select courses.*, count(students.id) as student_count from courses left join students on courses.id = students.course_id GROUP BY courses.id ORDER BY $order_by $type LIMIT  ? OFFSET  ?";
        }


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
        $total_page = ceil($this->get_total_records() / $this->limit);
        $this->total_page  = $total_page;
        $to = $this->get_to();
        $total_records = $this->get_total_records();
        $prev_page = $this->get_prev_page();
        $next_page = $this->get_next_page();
        $last_page = $this->get_last_page();
        $from = $this->get_from();
        
        return array (
            'page' => $this->page,
            'total_pages' => (int) $total_page,
            'total_records' => $total_records,
            'prev_page' => $prev_page,
            'next_page' => $next_page,
            'last_page' => $last_page,
            'current' => $this->page,
            'from' => $from,
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

    /**
     * Returns last page of pagination
     *
     * @return int
     */
    public function get_last_page() {
        $total_pages = $this->total_page;
        $page = $this->page;
        if( ( $this->page + 10) === $total_pages ){
            $page += 9;
        }
       
        return ( $page + 10) < $total_pages ? $page + 9 : $total_pages;
    }

    /**
     * Returns starting value of number buttons
     *
     * @return int
     */
    public function get_from() {

        $page = $this->page;
        $total_page = $this->total_page;

        if($page > $total_page) {
            return 0;
        }

        if($total_page < 10 ){
            return 1;
        }
        
        // Checking if current page is in last list
        if($page - ( $total_page - $page ) >= $total_page - 10) {
            return $total_page - 9 ;
        }

        if($page < $total_page && $page - 4 > 0 ) {
            return $page - 4;
        }else{
            return 1;
        }
    }
    
    /**
     * Returns end value of number buttons
     *
     * @return int
     */
    public function get_to() {
        $end = 10 ;
        $start = $this->page;

        // base case if user give wrong page number
        if($start > $this->total_page){
            return 0;
        }

        // returns extra 5 page if there can be more then 5 pages
        if($start > 5 && ($this->total_page > $start + 5 ) ) {
            return $start + 5;
        }

        // returns 10 ( max page link values ) if current page is lower then max pages and can't be having more 5 pages
        if($end < $this->total_page && ( $this->page < $end ) && $this->page + 5 < $this->total_page ){
            return $end;
        }

        return $this->total_page;
        
    }

}