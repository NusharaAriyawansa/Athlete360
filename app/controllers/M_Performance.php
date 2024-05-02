<?php

class M_Performance extends Controller{

    private $memberPerformanceModel;

    public function __construct() {
        $this->memberPerformanceModel = $this->model('CoachPerformance');
    }

   
    public function index() {
        $userId = $_SESSION['userID'];
        try {
            $performances = $this->memberPerformanceModel->getPerformancesByUserId($userId);
            $matchStats = $this->memberPerformanceModel->getMatchStatsByUserId($userId);

            $this->view('member/performance', 'member', [
                'performances' => $performances, 
                'matchStats' => $matchStats,
                'userId' => $userId
            ]);
        } catch (Exception $e) {
            die('Database error: ' . $e->getMessage());
        }
    }
    

    public function getStatData($statName) {
        $playerId = $_SESSION['userID'];
        header ('Content-Type: application/json');
        try {
            $data = $this->memberPerformanceModel->getMonthlyStatsData($playerId, $statName);
            echo json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    
}

