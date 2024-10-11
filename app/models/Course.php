<?php 
require_once('../Dbconnect.php');

class Course extends Dbconnect {

    public $id;
    public $name;
    public $created_at;
    public $updated_at;
    private $table = 'courses';

    /**
     * Finds uesr with given id
     * 
     * @param int $id
     * 
     */

    public function __construct($id = null)
    {

        if($id !== null) {

            $conn = $this->connect();
            $query = "SELECT * FROM $this->table WHERE id = ?";
            $statement = $conn->prepare($query);
            $statement->bind_param('i', $id);
            $statement->execute();
            $result = $statement->get_result();
            $conn->close();
            if($result->num_rows > 0 ) {
                $course = $result->fetch_assoc();
                $this->id = $course['id'];
                $this->name = $course['name'];
                $this->created_at = $course['created_at'];
                $this->updated_at = $course['updated_at'];
            }
            
        }

    }

    /**
     * Inserts new course in db returns inserted id.
     * If record inserted successfully otherwise returns FALSE.
     *
     * @return int|bool
     */
    public function save() {

        $conn = $this->connect();
        $query = "INSERT INTO $this->table (name) 
        VALUES(?)";
        $statement = $conn->prepare($query);
        $statement->bind_param('s', $this->name);
        $statement->execute();
        $id = $conn->insert_id;
        $conn->close();
        
        return $id !== false ? $id  : false;

    }

    /**
     * returns all records from course table
     *
     * @return array
     */
    public function get() {

        $courses = [];
        $conn = $this->connect();
        $sql = "SELECT * FROM $this->table ";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }

        return $courses;
        
    }

    /**
     * updates course record using id 
     *
     * @return bool
     */
    public function update() {

        $conn = $this->connect();
        $sql = "UPDATE $this->table SET name = ? WHERE id = ? ";
        $statement = $conn->prepare($sql);
        $statement->bind_param('si', $this->name, $this->id);
        $result = $statement->execute();
        $conn->close();

        return $result;

    }

    /**
     * delets course and return true if deleted 
     *
     * @return bool
     */
    public function delete() {

        $conn = $this->connect();
        $sql = "DELETE FROM $this->table WHERE id = ? ";
        $statement = $conn->prepare($sql);
        $statement->bind_param('i', $this->id);
        $result = $statement->execute();
        $conn->close();

        return $result;
    }

    /**
     * returns array of formatted courses key = id, val = name
     *
     * @return array
     */
    public function get_formatted_course(){
        $courses = [];
        $conn = $this->connect();
        $sql = "SELECT id, name FROM $this->table ";

        $result = $conn->query($sql);
        $conn->close();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $courses[$row['id']] = $row['name'];
            }
        }
        return $courses;

    }
    

}