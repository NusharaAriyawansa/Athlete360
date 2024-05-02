<?php

class M_Profile extends Controller{
    private $profileModel;

    public function __construct() {
        $this->profileModel = $this->model('profileModel');
    }

   
    public function index() {
        $userId = $_SESSION['userID'];
        $memberData = $this->profileModel->getMemberDetails($userId); 
        if ($memberData) {
            $this->view('member/profile', 'member', ['profile' => $memberData]);
        } else {
            $this->view('member/profile', 'member', ['profile' => null, 'error' => 'No profile found.']);
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

            $memberData = [
                'school' => trim($_POST['school']),
                'pName' => trim($_POST['pName']),
                'pContactNo' => trim($_POST['pContactNo']),
                'pRelationship' => trim($_POST['pRelationship']),
            ];

            if ($this->profileModel->updateUser($userId, $userData) && $this->profileModel->updateMemberDetails($userId, $memberData)) {
                header('Location: ' . URLROOT . '/M_Profile/index');
            } else {
                die('Something went wrong');
            }
        }
    }


    public function changePassword() {
        // Make sure the request is a POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $userId = $_SESSION['userID']; // Ensure you have user's session management in place
            $oldPassword = trim($_POST['oldPassword']);
            $newPassword = trim($_POST['newPassword']);
            $confirmNewPassword = trim($_POST['confirmNewPassword']);

            // Basic validation
            if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
                // Handle errors; you can use a session to store the error message
                echo "<script type='text/javascript'>console.log('oops');</script>";
                $_SESSION['error_message'] = 'Please fill in all fields.';
                header('Location: ' . URLROOT . '/M_Profile/index');
            }

            if ($newPassword !== $confirmNewPassword) {
                $_SESSION['error_message'] = 'New passwords do not match.';
                header('Location: ' . URLROOT . '/M_Profile/index');
                exit();
            }

            // Check current password
            if (!$this->profileModel->checkPassword($userId, $oldPassword)) {
                $_SESSION['error_message'] = 'Your current password is incorrect.';
                header('Location: ' . URLROOT . '/M_Profile/index');
                exit();
            }

            // Hash new password
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password in database
            if ($this->profileModel->updatePassword($userId, $newPasswordHash)) {
                $_SESSION['success_message'] = 'Password successfully updated.';
                header('Location: ' . URLROOT . '/M_Profile/index');
                exit();
            } else {
                $_SESSION['error_message'] = 'Error updating password.';
                header('Location: ' . URLROOT . '/M_Profile/index');
                exit();
            }
        } else {
            // Redirect if the user directly accesses the method without POST request
            echo "<script type='text/javascript'>console.log('oops');</script>";
            header('Location: ' . URLROOT . '/M_Profile/index');
        }
    }
    
}

