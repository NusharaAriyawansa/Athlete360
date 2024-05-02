<?php

class M_Attendance extends Controller{

    private $attendanceModel;

    public function __construct() {
        $this->attendanceModel = $this->model('AttendanceModel');
    }

    public function index() {
        $userId = $_SESSION['userID'];  
        $presentAttendance = $this->attendanceModel->getUserAttendance($userId, 'Present');
        $absentAttendance = $this->attendanceModel->getUserAttendance($userId, 'Absent');
        $this->view('member/attendance','member', [
            'presentAttendance' => $presentAttendance,
            'absentAttendance' => $absentAttendance
        ]);
    }

    public function getMonthlyAttendanceData() {
        header('Content-Type: application/json');
        $userId = $_SESSION['userID']; 
        $data = $this->attendanceModel->getMonthlyAttendanceForLastSixMonths($userId);
        if (empty($data)) {
            http_response_code(404); 
            echo json_encode(['error' => 'No attendance data found for the user']);
        } else {
            echo json_encode($data);
        }
        exit;
    }
    

    public function getSessionAttendanceData() {
        header('Content-Type: application/json');
        $userId = $_SESSION['userID'];
        $data = $this->attendanceModel->getSessionAttendanceData($userId);
        if (empty($data)) {
            http_response_code(404); 
            echo json_encode(['error' => 'No attendance data found for the user']);
        } else {
            echo json_encode($data);
        }
        exit;
    }



    


    
}

