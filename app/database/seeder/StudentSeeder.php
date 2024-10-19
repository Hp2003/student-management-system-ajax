<?php 
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ .'/../../models/Student.php';
require_once __DIR__ . '/../../models/Course.php';

class StudentSeeder {
    public $faker ;

    public function __construct($count = 1)
    {
        $this->faker = Faker\Factory::create();
        $this->seed_data($count);
    }
    /**
     * Main function to seed date in table
     * takes no arguments
     *
     * @return void
     */
    public function seed() {

        $gender = array('male', 'female', 'other');
        $course = new Course();
        $corurses = $course->get_formatted_course();

        $course_ids = array_keys($corurses);

        $student = new Student();
        $student->first_name = $this->faker->firstName();
        $student->last_name = $this->faker->lastName();
        $student->email = $this->faker->safeEmail();
        $student->phone_number = $this->faker->numerify('##########');
        $student->gender = $gender[rand(0, 2)];
        $student->course_id = $course_ids[rand(0, count($course_ids) - 1)];

        $student->save();
    }

    /**
     * seeds data in database 
     *
     * @param int $count
     * @return void
     */
    public function seed_data($count) {
        for($i = 0 ; $i < $count ; $i++){
            $this->seed();
        }
    }
}

$seeder = new StudentSeeder(100);





