<?php

namespace App\Controllers;

use App\Models\Course;
use App\Controllers\BaseController;

require 'vendor/autoload.php';
use Fpdf\Fpdf;


class CourseController extends BaseController
{
    public function list()
    {
        $obj = new Course();
        $courses = $obj->all();

        $template = 'courses';
        $data = [
            'items' => $courses
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    public function viewCourse($course_code)
    {
        $courseObj = new Course();
        $course = $courseObj->find($course_code);
        $enrollees = $courseObj->getEnrolees($course_code);
        
        $template = 'single-course';
        $data = [
            'course' => $course,
            'enrollees' => $enrollees
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    public function exportToPDF($course_code)
    {
        // Initialize Course object
        $obj = new Course();
        
        // Fetch course data and enrollees
        $course_data = $obj->all(); // Assuming this fetches data for all courses
        $enrollees = $obj->getEnrolees($course_code);
    
        // Create instance of FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Set title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'Course Information', 0, 1, 'C');
    
        // Iterate through $course_data to find the selected course
        foreach ($course_data as $course) {
            if ($course->course_code == $course_code) {
                // Add course information to PDF
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(50, 10, 'Course Code: ' . $course->course_code, 0, 1);
                $pdf->Cell(50, 10, 'Course Name: ' . $course->course_name, 0, 1);
                $pdf->Cell(50, 10, 'Description: ' . $course->description, 0, 1);
                $pdf->Cell(50, 10, 'Credits: ' . $course->credits, 0, 1);
                $pdf->Ln(10); // Line break after course info
                break;
            }
        }
    
        // Enrollees list title
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(190, 10, 'List of Enrollees', 0, 1, 'C');
    
        // Set header for enrollees
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'ID', 1);
        $pdf->Cell(50, 10, 'Full Name', 1);
        $pdf->Cell(100, 10, 'Email', 1);
        $pdf->Ln();
    
        // Loop through enrollees and add to PDF
        $pdf->SetFont('Arial', '', 12);
        foreach ($enrollees as $enrollee) {
            $pdf->Cell(40, 10, $enrollee["student_code"], 1);
            $pdf->Cell(50, 10, $enrollee["full_name"], 1);
            $pdf->Cell(100, 10, $enrollee["email"], 1);
            $pdf->Ln();
        }
    
        // Output the PDF (either download or display)
        $pdf->Output('D', 'course_'.$course_code.'_enrollees.pdf'); // 'D' forces download
    }
    
}
