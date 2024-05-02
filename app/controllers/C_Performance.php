<?php
class C_Performance extends Controller {
    
    private $coachPerformanceModel;

    public function __construct() {
        $this->coachPerformanceModel = $this->model('CoachPerformance');
    }

    // Display players (users with the role of 'player')
    public function index() {
        $userId = $_SESSION['userID'];
        $sessions = $this->coachPerformanceModel->getAllocatedSessions($userId);
        $this->view('coach/members', 'coach', ['sessions' => $sessions]);
    }

    // Display performance dashboard for a specific player
    public function performanceDashboard($userId) {
        try {
            $performances = $this->coachPerformanceModel->getPerformancesByUserId($userId);
            $matchStats = $this->coachPerformanceModel->getMatchStatsByUserId($userId);
            $videos = $this->coachPerformanceModel->getVideosByMember($userId);
            $videoId = $this->extractVideoIdFromUrl($_GET['videoUrl'] ?? null);
            
            $data = [
                'performances' => $performances, 
                'matchStats' => $matchStats,
                'videos' => $videos
            ];
            $this->view('coach/performance', 'coach', $data);
        } catch (Exception $e) {
            die('Database error: ' . $e->getMessage());
        }
    }

    private function extractVideoIdFromUrl($url) {
        if ($url) {
            $parsedUrl = parse_url(urldecode($url));
            if (!empty($parsedUrl['host']) && $parsedUrl['host'] === 'youtu.be') {
                $pathSegments = explode('/', trim($parsedUrl['path'], '/'));
                return $pathSegments[0];  // Assumes the video ID is the first segment
            }
        }
        return null;
    }


    public function getPerformanceToEdit($userId) {
        try {
            $performances = $this->coachPerformanceModel->getPerformancesByUserId($userId);
            echo $performances;
            $this->view('coach/updateperformance', 'coach', ['performances' => $performances]);
        } catch (Exception $e) {
            die('Database error: ' . $e->getMessage());
        }
    }


    public function getPlayerId($playerId) {
        $player = $this->coachPerformanceModel->getPlayerById($playerId);
        $this->view('add_performance_form', 'coach', ['player' => $player]);
    }


    // Handle the form submission to add a new performance
    public function addPerformance() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                // 'player_id' => trim($_POST['player_id']),
                'player_id' => 56,
                'date' => trim($_POST['date']),
                'batting' => trim($_POST['batting']),
                'batting_notes' => trim($_POST['batting_notes']),
                'bowling' => trim($_POST['bowling']),
                'bowling_notes' => trim($_POST['bowling_notes']),
                'fielding' => trim($_POST['fielding']),
                'fielding_notes' => trim($_POST['fielding_notes']),
                'fitness' => trim($_POST['fitness']),
                'fitness_notes' => trim($_POST['fitness_notes']),
                'additional_notes' => trim($_POST['additional_notes'])
            ];
            if ($this->coachPerformanceModel->addPerformance($data)) {
                header('Location: ' . URLROOT . '/C_Performance/performanceDashboard/' . $data['player_id']);

            } else {
                die('Something went wrong');
            }
        } else {
            $this->addPerformanceForm();  // Reload the form
        }
    }


    public function updatePerformance($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'id' => $id,
                'date' => trim($_POST['date']),
                'batting' => trim($_POST['batting']),
                'batting_notes' => trim($_POST['batting_notes']),
                'bowling' => trim($_POST['bowling']),
                'bowling_notes' => trim($_POST['bowling_notes']),
                'fielding' => trim($_POST['fielding']),
                'fielding_notes' => trim($_POST['fielding_notes']),
                'fitness' => trim($_POST['fitness']),
                'fitness_notes' => trim($_POST['fitness_notes']),
                'errors' => []
            ];
    
            if (empty($data['date'])) {
                $data['errors']['date'] = 'Please enter the date of the performance.';
            }
    
            if (empty($data['errors'])) {
                if ($this->coachPerformanceModel->updatePerformance($data)) {
                    header('Location: ' . URLROOT . '/C_Performance/performanceDashboard' . $data['id']);
                } else {
                    die('Something went wrong.');
                }
            } else {
                $this->view('coach/updateperformance', 'coach', $data);
            }
        } else {
            header('Location: ' . URLROOT . '/C_Performance/performanceDashboard' . $player_Id);
        }
    }
    

    public function deletePerformance($performance_id, $player_Id) {
        if ($this->coachPerformanceModel->deletePlayerPerformance($performance_id)) {
            header('Location: ' . URLROOT . '/C_Performance/performanceDashboard/' . $player_Id);
        } else {
            die('Failed to delete performance');
        }
    }


    public function addMatchStat() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                // 'player_id' => trim($_POST['player_id']),
                'player_id' => 56,
                'match_name' => trim($_POST['match_name']),
                'date' => trim($_POST['date']),
                'runs' => trim($_POST['runs']),
                'wickets' => trim($_POST['wickets']),
                'catches' => trim($_POST['catches']),
                'run_outs' => trim($_POST['run_outs']),
                'stumpings' => trim($_POST['stumpings']),
                'errors' => []
            ];
    
            if (empty($data['match_name'])) {
                $data['errors']['match_name'] = 'Match name is required';
            }
            if (empty($data['date'])) {
                $data['errors']['date'] = 'Date is required';
            }
            if ($this->coachPerformanceModel->addMatchStat($data)) {
                header('Location: ' . URLROOT . '/C_Performance/performanceDashboard/' . $data['player_id']);

            } else {
                die('Failed to add new match statistic');
            }
        }
    }

    public function editMatchStat($statId) {
        $statDetails = $this->coachPerformanceModel->getSpecificMatchStat($statId);
        if (!$statDetails) {
            die('Match statistic not found');
        }
        $this->view('coach/edit_match_stat', 'coach', ['statDetails' => $statDetails]);
    }
    
    public function getSpecificMatchStat($statId) {
        $this->query("SELECT * FROM match_statistics WHERE id = :statId");
        $this->bind(':statId', $statId);
        return $this->single();
    }

    public function processEditMatchStat() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $_POST['id'],
                'player_id' => $_POST['player_id'],
            ];
    
            if ($this->coachPerformanceModel->updateMatchStat($data)) {
                header('Location: ' . URLROOT . '/C_Performance/matchStats/' . $data['player_id']);
            } else {
                die('Failed to update match statistic');
            }
        }
    }

    public function deleteMatchStat($statId, $player_Id) {
        if ($this->coachPerformanceModel->deleteMatchStat($statId)) {
            header('Location: ' . URLROOT . '/C_Performance/performanceDashboard/' . $player_Id);
        } else {
            die('Failed to delete match statistic');
        }
    }

    public function getStatData($playerId, $statName) {
        header ('Content-Type: application/json');
        try {
            $data = $this->coachPerformanceModel->getMonthlyStatsData($playerId, $statName);
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }




    public function getSessionMembers($sessionId) {    
        $members = $this->coachPerformanceModel->getUsersBySession($sessionId);
        header('Content-Type: application/json');
        if ($members) {
            echo json_encode($members);
        } else {
            echo json_encode([]);
        }
    }
    












    public function addVideo() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $videoId = $data['videoUrl'] ?? null;
            $playerId = $data['playerId'] ?? null;
    
            if (!empty($videoId) && !empty($playerId)) {
                $videoUrl = "https://www.youtube.com/embed/" . $videoId;
                $videoUrl = urldecode($videoUrl);
                if ($this->coachPerformanceModel->addVideo($playerId, $videoUrl)) {
                    header('Location: ' . URLROOT . 'C_Performance/performanceDashboard' . $playerId);
                } else {
                    echo json_encode(['message' => 'Failed to add the video']);
                    http_response_code(500);
                }
            } else {
                echo json_encode(['message' => 'Invalid video ID']);
                http_response_code(400);
            }
        } else {
            http_response_code(405);
        }
    }
    

    private function redirectWithError($url, $errorMessage) {
        $_SESSION['error'] = $errorMessage;
        header('Location: ' . $url);
    }

    public function deleteMemberVideo($videoId) {
        $this->coachPerformanceModel->deleteVideo($videoId);
        header("Location: " . URLROOT . "/C_Performance/index");  
    }

    
}
