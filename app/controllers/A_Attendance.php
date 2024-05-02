<?php

class A_Attendance extends Controller{
    use model;
    private $sessionModel;

    public function __construct() {
        $this->sessionModel = $this->model('AttendanceModel');
    }

    public function index() {
        $sessions = $this->sessionModel->getAllSessions();
        $this->view('admin/sessions', 'admin', ['sessions' => $sessions]);
    }

    public function getOccurrences($sessionId) {
        $occurrences = $this->sessionModel->getSessionOccurrences($sessionId);
        header('Content-Type: application/json');
        echo json_encode($occurrences);
    }

    public function getPastAttendance($sessionId, $date) {
        $attendanceData = $this->sessionModel->getPastAttendance($sessionId, $date);
    
        if (!$attendanceData) {
            http_response_code(404); 
            echo json_encode(["error" => "Attendance data not found"]);
            return;
        }
    
        header('Content-Type: application/json');
        echo json_encode($attendanceData);
    }
    
    
    public function getTodayAttendanceForm($sessionId) {
        $members = $this->sessionModel->getMembersForSession($sessionId, date("Y-m-d"));
        $coaches = $this->sessionModel->getCoachesForSession($sessionId, date("Y-m-d"));
    
        $output = '<form id="todayAttendanceForm" method="POST">';
        $output .= '<h3>Member Attendance</h3>';
        $output .= '<ul>';
        foreach ($members as $member) {
            $checked = ($member['attendance_status'] === 'Present') ? 'checked' : '';
            $output .= '<li><div>';
            $output .= '<input type="hidden" name="attendance[members][' . $member['memberID'] . ']" value="Absent">';
            $output .= '<input type="checkbox" name="attendance[members][' . $member['memberID'] . ']" value="Present" ' . $checked . '> ' . $member['name'];
            $output .= '</div></li>';
        }
        $output .= '</ul>';
    
        $output .= '<h3>Coach Attendance</h3>';
        $output .= '<ul>';
        foreach ($coaches as $coach) {
            $checked = ($coach['attendance_status'] === 'Present') ? 'checked' : '';
            $output .= '<li><div>';
            $output .= '<input type="hidden" name="attendance[coaches][' . $coach['coachID'] . ']" value="Absent">';
            $output .= '<input type="checkbox" name="attendance[coaches][' . $coach['coachID'] . ']" value="Present" ' . $checked . '> ' . $coach['name'];
            $output .= '</div></li>';
        }
        $output .= '</ul>';

        $output .= '<button type="submit" class="btn-save">Submit Attendance</button>';
        $output .= '<input type="hidden" name="session_id" value="' . $sessionId . '">';
        $output .= '</form>';
        echo $output;
    }
    
    
    public function markAttendanceToday() {
        $sessionId = $_POST['session_id'] ?? null;
        $attendanceData = $_POST['attendance'] ?? [];
    
        if (!$sessionId) {
            echo json_encode(['success' => false, 'message' => 'Session ID missing.']);
            return;
        }
    
        $membersAttendance = $attendanceData['members'] ?? [];
        $resultMembers = $this->sessionModel->markAttendance($sessionId, $membersAttendance, date("Y-m-d"));
    
        $coachesAttendance = $attendanceData['coaches'] ?? [];
        $resultCoaches = $this->sessionModel->markAttendance($sessionId, $coachesAttendance, date("Y-m-d"));

        $this->fill_table();


    
        if ($resultMembers && $resultCoaches) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to mark attendance.']);
        }
    }

    public function fill_table(){
        $sql_update="UPDATE attendance a
        JOIN sessioncoaches sc ON a.session_id = sc.session_id
        JOIN sessionoccurrences so ON a.session_id = so.session_id AND a.attendance_date = so.session_date
        SET a.coach_id = sc.coach_id, a.occurrence_id = so.occurrence_id;";

        $this->insert($sql_update);
        

        $sql_update = "UPDATE attendance a
        JOIN sessioncoaches sc ON a.session_id = sc.session_id
        JOIN sessionoccurrences so ON a.session_id = so.session_id AND a.attendance_date = so.session_date
        SET a.coach_id = sc.coach_id, a.occurrence_id = so.occurrence_id;";


    }
    
    
    
    
    
    
}