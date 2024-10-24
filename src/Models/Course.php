<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Course extends BaseModel
{
    public function all()
    {
        $sql = "SELECT c.id, c.course_name, c.course_code, 
                c.description, c.credits, 
                COUNT(e.student_code) AS student_count
                FROM courses c 
                JOIN course_enrollments e ON c.course_code = e.course_code 
                GROUP BY e.course_code;";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
        return $result;
    }

    public function find($code)
    {
        $sql = "SELECT * FROM courses WHERE course_code=?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$code]);
        $result = $statement->fetchObject('\App\Models\Course');
        return $result;
    }

    public function getEnrolees($course_code)
    {
        $sql = "SELECT s.student_code AS student_code, CONCAT(s.first_name, ' ', s.last_name) AS full_name, s.email
                FROM course_enrollments ce
                LEFT JOIN students s ON s.student_code = ce.student_code
                WHERE ce.course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'course_code' => $course_code
        ]);
        $result = $statement->fetchAll();
        return $result;
    }

    public function getCourseCode()
    {
        $sql = "SELECT course_code FROM courses";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject('\App\Models\Course');
        return $result;
    }

    public function getCourseName()
    {
        $sql = "SELECT course_name FROM courses";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject('\App\Models\Course');
        return $result;
    }

}
