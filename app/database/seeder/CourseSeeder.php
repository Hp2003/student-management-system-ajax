<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../models/Course.php';

class CourseSeeder
{

    public $courses;

    /**
     * takes name of courses as an array default courses are used
     * if course name is not provided
     *
     * @param array $courses
     */
    public function __construct($courses = null)
    {
        $this->courses = $courses ?? ['B.A', 'M.A', 'B.E', 'C.S.E', 'M.B.A', 'B.COM', 'M.COM', 'L.L.B', 'M.B.B.S', 'M.Tech', 'B.Tech', 'B.C.A', 'M.C.A'] ;
        $this->seed();
    }
    /**
     * Main function to seed date in table
     * takes no arguments
     *
     * @return void
     */
    public function seed() {
        foreach($this->courses as $course_name){
            $course = new Course();
            $course->name = $course_name;
            $course->save();
        }
    }
}

// $course_seeder = new CourseSeeder();
