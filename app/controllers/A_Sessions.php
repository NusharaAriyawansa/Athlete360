<?php
class A_Sessions extends Controller {
    private $sessionModel;

    public function __construct() {
        $this->sessionModel = $this->model('SessionModel');
    }

    public function index() {
        $sessions = $this->sessionModel->getAllSessions();
        $this->view('admin/sessions', 'admin', ['sessions' => $sessions]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'session_name' => trim($_POST['session_name']),
                'day' => trim($_POST['day']),
                'start_time' => trim($_POST['start_time']),
                'end_time' => trim($_POST['end_time']),
                'status' => trim($_POST['status'])
            ];
    
            if (!$this->sessionModel->sessionNameExists($data['session_name'])) {
            }
    
            if ($this->sessionModel->addSession($data)) {
                header('Location: ' . URLROOT . '/A_Sessions/index');
                exit;
            } else {
                die('Something went wrong while adding the session');
            }
        } else {
            $this->index();
        }
    }
    

    public function delete($session_id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionName = $this->sessionModel->getSessionById($session_id);
    
            if ($this->sessionModel->deleteSession($session_id)) {
                header('Location: ' . URLROOT . '/A_Sessions/index');
                exit;
            } else {
                die('Something went wrong while deleting the session');
            }
        } else {
            $this->index();
        }
    }
    

    public function update($sessionId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $session_id = $sessionId;
            $session_name = $_POST['session_name'] ?? '';
            $day = $_POST['day'] ?? '';
            $start_time = $_POST['start_time'] ?? '';
            $end_time = $_POST['end_time'] ?? '';
            $status = $_POST['status'] ?? '';
    
            $data = [
                'session_id' => $session_id,
                'session_name' => $session_name,
                'day' => $day,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'status' => $status,
            ];
    
            if ($this->sessionModel->updateSession($session_id, $data)) {
                header('Location: ' . URLROOT . '/A_Sessions/index');
                exit;
            } else {
                die('Something went wrong while updating the session');
            }
        } else {
            $this->index(); 
        }
    }
    

    public function edit($session_id) {
        $session = $this->sessionModel->getSessionById($session_id);
        if ($session) {
            $this->view('admin/edit_session', 'admin', ['session' => $session]); 
        } else {
            $this->view('admin/edit_session', 'admin', ['session' => null]); 
        }
    }
    
    
    public function sessionDetails($sessionId) {
        $sessionDetails = $this->sessionModel->getSessionById($sessionId);
        $members = $this->sessionModel->getSessionMembers($sessionId); 
        $coaches = $this->sessionModel->getSessionCoaches($sessionId);
        $equipments = $this->sessionModel->getEquipmentForSession($sessionId);
    
        $this->view('admin/session_details', 'admin', [
            'session' => $sessionDetails,
            'members' => $members,
            'coaches' => $coaches,
            'sessionId' => $sessionId,
            'equipments' => $equipments
        ]);
    }

    public function addMemberToSession($sessionId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
            $memberId = $_POST['user_id'];
            if ($this->sessionModel->addMemberToSession($sessionId, $memberId)) {
                echo 'Member added successfully.';
            } else {
                http_response_code(400);  
                echo 'Failed to add member to the session';
            }
        } else {
            http_response_code(400);
            echo 'No user ID provided';
        }
    }

    public function addCoachToSession($sessionId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
            $coachId = $_POST['user_id'];
            echo $coachId;
            if ($this->sessionModel->addCoachToSession($sessionId, $coachId)) {
                echo 'Coach added successfully.';
            } else {
                http_response_code(400);  
                echo 'Failed to add coach to the session';
            }
        } else {
            http_response_code(400);
            echo 'No user ID provided';
        }
    }
    

    public function searchMembers() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
            $query = $_POST['query'];
            $results = $this->sessionModel->searchMembersByName($query); 
            $output = '<form id="memberResultsForm">';
            foreach ($results as $result) {
                $output .= '<div><input type="checkbox" name="member" value="' . $result['memberID'] . '">' . htmlspecialchars($result['name']) . '</div>';
            }
            $output .= '</form>';
            echo $output;
        }
    }

    public function searchCoaches() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
            $query = $_POST['query'];
            $results = $this->sessionModel->searchCoachesByName($query);
            $output = '<form id="coachResultsForm">';
            foreach ($results as $result) {
                $output .= '<div><input type="checkbox" name="coach" value="' . $result['coachID'] . '">' . htmlspecialchars($result['name']) . '</div>';
            }
            $output .= '</form>';
            echo $output;
        }
    }

    public function removeMemberFromSession() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['user_id'], $_POST['session_id'])) {
                $userId = $_POST['user_id'];
                $sessionId = $_POST['session_id'];

                if ($this->sessionModel->removeMemberFromSession($userId, $sessionId)) {
                    echo 'Member removed successfully.';
                } else {
                    http_response_code(500);  
                    echo 'Failed to remove member.';
                }
            } else {
                http_response_code(400); 
                echo 'Missing user_id or session_id.';
            }
        } else {
            http_response_code(405);
            echo 'Invalid request method.';
        }
    }


    public function removeCoachFromSession() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_POST['user_id'];
            $sessionId = $_POST['session_id'];
            
            if ($this->sessionModel->removeCoachFromSession($userId, $sessionId)) {
                echo 'Coach removed successfully.';
            } else {
                http_response_code(500);
                echo 'Failed to remove coach.';
            }
        } else {
            http_response_code(405);
            echo 'Invalid request method.';
        }
    }
    

    public function getOccurrences($sessionId) {
        $occurrences = $this->sessionModel->getSessionOccurrences($sessionId);
        $this->view('admin/list_occurrences', 'admin', ['occurrences' => $occurrences]);
    }

    public function getEditableAttendance() {
        $occurrenceId = $_POST['occurrence_id'];
        $attendanceData = $this->sessionModel->getAttendanceByOccurrence($occurrenceId);
    
        $output = '<form id="attendanceForm">';
        foreach ($attendanceData as $attendance) {
            $checked = $attendance['attended'] ? 'checked' : '';
            $output .= '<div><input type="checkbox" ' . $checked . ' data-user-id="' . $attendance['user_id'] . '">' . htmlspecialchars($attendance['user_name']) . '</div>';
        }
        $output .= '</form>';
        echo $output;
    }
    
    public function updateAttendance() {
        $data = json_decode(file_get_contents('php://input'), true);
        $occurrenceId = $data['occurrence_id'];
        $attendanceData = $data['attendance'];
    
        foreach ($attendanceData as $attendance) {
            $this->sessionModel->updateAttendance($occurrenceId, $attendance['user_id'], $attendance['attended']);
        }
    
        echo 'Attendance updated successfully.';
    }

    
    

}
