<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Student extends BaseModel
{

    public function all()
    {
        $sql = "SELECT * FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

    public function getStudentCode() {
        $sql = "SELECT student_code FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

    public function getEmail() {
        $sql = "SELECT email FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

    public function getFullName() {
        $sql = "SELECT first_name || ' ' || last_name FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

    public function find($student_code) {
        $sql = "SELECT * FROM students WHERE student_code = :student_code";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':student_code', $student_code);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

}