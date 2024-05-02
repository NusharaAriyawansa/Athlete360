<?php

class C_Profile extends Controller{

    private $profileModel;

    public function __construct() {
        $this->profileModel = $this->model('profileModel');
    }

   
    public function index() {
        $userId = $_SESSION['userID'];
        $coachData = $this->profileModel->getCoachDetails($userId); 
        if ($coachData) {
            $this->view('coach/profile', 'coach', ['profile' => $coachData]);
        } else {
            $this->view('coach/profile', 'coach', ['profile' => null, 'error' => 'No profile found.']);
        }
    }
    
    
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userId = trim($_POST['userID']);
            
            $userData = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'contactNo' => trim($_POST['contactNo']),
                'nic' => trim($_POST['nic']),
                'gender' => trim($_POST['gender']),
                'address' => trim($_POST['address']),
                'dob' => trim($_POST['dob'])
            ];

            $coachData = [
                'qualifications' => trim($_POST['qualifications']),
                
            ];

            if ($this->profileModel->updateUser($userId, $userData) && $this->profileModel->updateCoachDetails($userId, $coachData)) {
                header('Location: ' . URLROOT . '/C_Profile/index');
            } else {
                die('Something went wrong');
            }
        }
    }

   

    public function changePassword() {
        // Make sure the request is a POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data

            $userId = $_SESSION['userID']; // Ensure you have user's session management in place
            $oldPassword = trim($_POST['oldPassword']);
            $newPassword = trim($_POST['newPassword']);
            $confirmNewPassword = trim($_POST['confirmNewPassword']);

            // Basic validation
            if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
                // Handle errors; you can use a session to store the error message
                $_SESSION['error_message'] = 'Please fill in all fields.';
                header('Location: ' . URLROOT . '/C_Profile/index');
                exit();
            }

            if ($newPassword !== $confirmNewPassword) {
                $_SESSION['error_message'] = 'New passwords do not match.';
                header('Location: ' . URLROOT . '/C_Profile/index');
                exit();
            }

            // Check current password
            if (!$this->profileModel->checkPassword($userId, $oldPassword)) {
                $_SESSION['error_message'] = 'Your current password is incorrect.';
                header('Location: ' . URLROOT . '/C_Profile/index');
                exit();
            }

            // Hash new password
            // $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password in database
            if ($this->profileModel->updatePassword($userId, $newPassword)) {
                $_SESSION['success_message'] = 'Password successfully updated.';
                header('Location: ' . URLROOT . '/C_Profile/index');
                exit();
            } else {
                $_SESSION['error_message'] = 'Error updating password.';
                header('Location: ' . URLROOT . '/C_Profile/index');
                exit();
            }
        } else {
            // Redirect if the user directly accesses the method without POST request
            header('Location: ' . URLROOT . '/C_Profile/index');
            exit();
        }
    }



    


    
}

