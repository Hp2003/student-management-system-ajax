<?php

$root = $_SERVER['DOCUMENT_ROOT'];

require_once __DIR__ . '/../Dbconnect.php';
require_once __DIR__ . '/Student.php';
require_once __DIR__ . '/../../utils/Paginator.php';

class Course extends Paginator
{

    public $id;
    public $name;
    public $created_at;
    public $updated_at;
    protected $table = 'courses';

    /**
     * Finds uesr with given id returns false if no record is found
     * 
     * @param int $id
     * 
     * @return bool
     */

    public function find($id = null)
    {
        if ($id === null || empty($id)) {
            throw new Error('id is not provided');
        }
        $conn = $this->connect();
        $query = "SELECT * FROM $this->table WHERE id = ?";
        $statement = $conn->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = $statement->get_result();
        $conn->close();
        if ($result->num_rows > 0) {
            $course = $result->fetch_assoc();
            $this->id = $course['id'];
            $this->name = $course['name'];
            $this->created_at = $course['created_at'];
            $this->updated_at = $course['updated_at'];

            return true;
        }
        return false;
    }
    /**
     * makes connection with database
     *
     * @return object
     */
    public function connect()
    {
        $conn = new Dbconnect();
        return $conn->connect();
    }

    /**
     * Inserts new course in db returns inserted id.
     * If record inserted successfully otherwise returns FALSE 
     * if entry is duplicate.
     *
     * @return int|bool|string
     */
    public function save()
    {

        $conn = $this->connect();
        $query = "INSERT INTO $this->table (name) 
        VALUES(?)";
        $statement = $conn->prepare($query);
        $name = strtoupper($this->name);
        $statement->bind_param('s', $name);
        $id = $conn->insert_id;
        // $conn->close();

        try {
            $statement->execute();
            return $id !== false ? $id  : false;
        } catch (Exception $e) {
            if ($conn->errno === 1062) {
                return FALSE;
            }
        } finally {
            $conn->close();
        }
    }

    /**
     * returns all records from course table
     *
     * @return array
     */
    public function get()
    {

        $courses = [];
        $conn = $this->connect();
        $sql = "select count(students.id) as students_count, courses.* from courses right join students on courses.id = students.course_id GROUP BY courses.id ";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }

        return $courses;
    }

    /**
     * returns all students in a course
     *
     * @param int $id refrese to id of targeted course
     * 
     * @return array
     */
    public function get_all_students() {
        $students = [];
        $conn = $this->connect();
        $sql = "SELECT students.*, courses.name as course_name from students join courses on students.course_id = courses.id WHERE course_id = $this->id";

        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        return $students;

    }

    /**
     * updates course record using id 
     *
     * @return bool
     */
    public function update()
    {

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
    public function delete()
    {

        // Setting course value to null for all students with this course
        $student = new Student();
        $student->set_course_to_null($this->id);

        // Deleting course
        $conn = $this->connect();
        $sql = "DELETE FROM $this->table WHERE id = ? ";
        $statement = $conn->prepare($sql);
        $statement->bind_param('i', $this->id);
        $result = $statement->execute();
        $affected_rows = $conn->affected_rows;
        $conn->close();

        return $affected_rows > 0 ;
        
    }

    /**
     * returns array of formatted courses key = id, val = name
     *
     * @return array
     */
    public function get_formatted_course()
    {
        $courses = [];
        $conn = $this->connect();
        $sql = "SELECT id, name FROM $this->table ";

        $result = $conn->query($sql);
        $conn->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $courses[$row['id']] = $row['name'];
            }
        }
        return $courses;
    }

    /**
     * Returns paginated data
     *
     * @param string $page
     * @param int $limit
     * @param string $column
     * @param string $type
     * 
     * 
     * @return array
     */
    public function paginate($page, $limit, $order_by = "", $type = "")
    {
        return $this->pagination($page, $limit, $order_by, $type);
    }
}
