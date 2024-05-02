<?php

class A_EquipmentManage extends Controller {

    private $equipmentModel;

    public function __construct() {
        $this->equipmentModel = $this->model('EquipmentModel');
    }


    public function index() {
        $availableEquipments = $this->equipmentModel->getAllAvailableEquipment();  
        $allocatedSessions = $this->equipmentModel->getAllAvailableEquipment();
        $maintainingEquipments = $this->equipmentModel->getMaintainingEquipment();
        $this->view('admin/resourceManage', 'admin', [
            'availableEquipments' => $availableEquipments,
            'allocatedSessions' => $allocatedSessions,
            'maintainingEquipments' => $maintainingEquipments,
        ]);
    }


    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $availability = filter_var($_POST['availability'], FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_var($_POST['price_for_hiring'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    
            $isAdded = $this->equipmentModel->addEquipment($name, $availability, $price);
    
            if ($isAdded) {
                $_SESSION['success_message'] = "Equipment added successfully!";
                header("Location: "  . URLROOT . "/A_EquipmentManage/index");
                exit();
            } else {
                $_SESSION['error_message'] = "Failed to add equipment. Please check the details and try again.";
                header("Location: "  . URLROOT . "/A_EquipmentManage/index");
                exit();
            }
        } else {
            header("Location: "  . URLROOT . "/A_EquipmentManage/index");
        }
    }
    

    public function delete($id) {
        $this->equipmentModel->deleteEquipment($id);
        header('Location:' . URLROOT . "/A_EquipmentManage/index");
    }

    public function setToMaintaining($equipmentId) {
        if ($this->equipmentModel->setToMaintaining($equipmentId)) {
            header("Location: " . URLROOT . "/A_Equipment/index");
        } else {
            die("Failed to set equipment to maintaining");
        }
    }


    public function doneMaintaining($equipmentId) {
        if($this->equipmentModel->doneMaintaining($equipmentId)) {
            header('Location: ' . URLROOT . '/A_Equipment/index');
        } else {
            die("Failed to set equipment to done maintaining");
        }
    }

    public function addSessionToEquipment() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $equipmentId = $data['equipmentId'] ?? null;
            $sessionId = $data['sessionId'] ?? null;
    
            if (!$equipmentId || !$sessionId) {
                echo json_encode(['success' => false, 'message' => 'Necessary parameters are missing.']);
                exit;  
            }
    
            try {
                $result = $this->equipmentModel->addSessionToEquipment($equipmentId, $sessionId);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Session successfully added to equipment.']);
                    exit;
                } else {
                    throw new Exception("Failed to add equipment to the session.");
                }
            } catch (Exception $e) {
                http_response_code(500); // Set an appropriate HTTP status code
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }
    }
    
    

    public function deleteEquipmentSession($equipmentId, $sessionId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $this->equipmentModel->deleteEquipmentSession($equipmentId, $sessionId);

            if ($result) {
                $_SESSION['message'] = "Session successfully unlinked from equipment.";
                header("Location: " . URLROOT . "/A_EquipmentManage/index");
            } else {
                $_SESSION['error'] = "Failed to unlink session from equipment.";
                header("Location: " . URLROOT . "/A_EquipmentManage/index");
            }
        } else {
            header("Location: " . URLROOT . "/A_EquipmentManage/index");
        }
    }


  

    public function getAllSessions() {
        $sessions = $this->equipmentModel->getAllSessions();
 
    
        header('Content-Type: application/json');
        echo json_encode(['sessions' => $sessions]);  // Encapsulating sessions in an object
    }

    public function getEquipmentDetails($equipmentId) {
        $equipment = $this->equipmentModel->getEquipmentDetails($equipmentId);
        $sessions = $this->equipmentModel->getSessionsForEquipment($equipmentId);
        echo json_encode(['equipment' => $equipment, 'sessions' => $sessions]);
    }
    

    
}

