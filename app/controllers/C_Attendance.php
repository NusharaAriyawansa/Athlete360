<?php

class C_Attendance extends Controller{

    private $attendanceModel;

    public function __construct() {
        $this->attendanceModel = $this->model('AttendanceModel');
    }

    public function index() {
        $userId = $_SESSION['userID'];  
        $presentAttendance = $this->attendanceModel->getUserAttendance($userId, 'Present');
        $absentAttendance = $this->attendanceModel->getUserAttendance($userId, 'Absent');
        $this->view('coach/attendance','coach', [
            'presentAttendance' => $presentAttendance,
            'absentAttendance' => $absentAttendance
        ]);
    }

    public function getMonthlyAttendanceData() {
        header('Content-Type: application/json');
        $userId = $_SESSION['userID']; 
        $data = $this->attendanceModel->getMonthlyAttendanceForLastSixMonths($userId);
        if (empty($data)) {
            echo json_encode([]);
        } else {
            echo json_encode($data);
        }
        exit;
    }
    

    



    


    
}

