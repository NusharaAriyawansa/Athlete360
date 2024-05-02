<?php 

class CoachPerformance {

    use Database;

    public function getUsersBySession($sessionId) {
        $con = $this->connect();
        $sql = "SELECT u.* FROM Users u
                JOIN memberdetails m ON m.userID = u.userID
                JOIN sessionmembers sm ON m.memberID = sm.member_id
                WHERE sm.session_id = ?";;
        $stmt = $con->prepare($sql);
    
        if (!$stmt) {
            error_log("MySQL Prep Failed: " . $con->error);
            return []; 
        }
    
        $stmt->bind_param('i', $sessionId);
        if (!$stmt->execute()) {
            error_log("Execute Failed: " . $stmt->error);
            return [];
        }
    
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function getPerformancesByUserId($userId) {
        $con = $this->connect();
        $sql = "SELECT * FROM player_performances WHERE player_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMatchStatsByUserId($userId) {
        $con = $this->connect();
        $sql = "SELECT * FROM match_statistics WHERE player_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addPerformance($data) {
        $con = $this->connect();
        $sql = "INSERT INTO player_performances (player_id, date, batting, batting_notes, bowling, bowling_notes, fielding, fielding_notes, fitness, fitness_notes, additional_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('issssssssss', $data['player_id'], $data['date'], $data['batting'], $data['batting_notes'], $data['bowling'], $data['bowling_notes'], $data['fielding'], $data['fielding_notes'], $data['fitness'], $data['fitness_notes'], $data['additional_notes']);
        return $stmt->execute();
    }

    public function updatePerformance($id, $data) {
        $con = $this->connect();
        $sql = "UPDATE player_performances SET date = ?, batting = ?, batting_notes = ?, bowling = ?, bowling_notes = ?, fielding = ?, fielding_notes = ?, fitness = ?, fitness_notes = ?, additional_notes = ?, WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ssssssssssi', $data['date'], $data['batting'], $data['batting_notes'], $data['bowling'], $data['bowling_notes'], $data['fielding'], $data['fielding_notes'], $data['fitness'], $data['fitness_notes'], $data['addtional_notes'], $id);
        return $stmt->execute();
    }

    public function deletePlayerPerformance($performance_id) {
        $con = $this->connect();
        $sql = "DELETE FROM player_performances WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $performance_id);
        return $stmt->execute();
    }

    public function addMatchStat($data) {
        $con = $this->connect();
        $sql = "INSERT INTO match_statistics (player_id, match_name, date, runs, wickets, catches, run_outs, stumpings) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('isssssss', $data['player_id'], $data['match_name'], $data['date'], $data['runs'], $data['wickets'], $data['catches'], $data['run_outs'], $data['stumpings']);
        return $stmt->execute();
    }

    public function deleteMatchStat($id) {
        $con = $this->connect();
        $sql = "DELETE FROM match_statistics WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getMonthlyStatsData($playerId, $statName) {
        try {
            $allowedStats = ['runs', 'wickets', 'catches', 'run_outs', 'stumpings'];
            if (!in_array($statName, $allowedStats)) {
                throw new InvalidArgumentException("Invalid statistic name");
            }
            $con = $this->connect();
            $sql = "SELECT MONTHNAME(date) AS month, YEAR(date) AS year, SUM(`$statName`) AS total
                    FROM match_statistics
                    WHERE player_id = ? AND date > DATE_SUB(NOW(), INTERVAL 12 MONTH)
                    GROUP BY YEAR(date), MONTH(date), MONTHNAME(date)
                    ORDER BY YEAR(date) ASC, MONTH(date)";

            $stmt = $con->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $con->error);
            }

            if (!$stmt->bind_param('i', $playerId)) {
                throw new Exception("Binding parameter failed: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = ['month' => $row['month'], 'total' => $row['total']];
            }

            $stmt->close();
            return $data;

        } catch (mysqli_sql_exception $e) {
            echo json_encode('Database error: ' . $e->getMessage());
            return []; // Return an empty array in case of error
        }
    }



    public function getAllSessions() {
        $query = "SELECT * FROM Sessions ORDER BY session_name ASC";
        $result = $this->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllocatedSessions($userId) {
        $query = "SELECT s.*
            FROM sessions s
            JOIN sessioncoaches sc ON s.session_id = sc.session_id
            WHERE sc.coach_id = $userId;
            ";
        $result = $this->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }












    public function getVideosByMember($memberId) {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT video_url FROM video_links WHERE member_id = ?");
        $stmt->bind_param("i", $memberId);
        $stmt->execute();
        $result = $stmt->get_result();
        $videos = [];
        while ($row = $result->fetch_assoc()) {
            $videos[] = $row['video_url'];
        }
        $stmt->close();
        return $videos;
    }

    public function addVideo($memberId, $videoUrl) {
        $db = $this->connect();
    
        if ($stmt = $db->prepare("INSERT INTO video_links (member_id, video_url) VALUES (?, ?)")) {
            $stmt->bind_param("is", $memberId, $videoUrl);
    
            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error adding video: " . $stmt->error;
            }
    
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $db->error;
        }
    }
    

    public function deleteVideo($videoId) {
        $db = $this->connect();
        $stmt = $db->prepare("DELETE FROM video_links WHERE id = ?");
        $stmt->bind_param("i", $videoId);
        $stmt->execute();
        $stmt->close();
    }
    
    
}
