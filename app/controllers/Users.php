<?php
    
class Users extends Controller {
        public function __construct() {
            $this->userModel = $this->model('User');
        }
        
        public function register() {
            // Sanatize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];
                
                //Validation
                // Validate Email
                if(empty($data['email'])){
                    $data['email_err'] = 'Pleae enter email';
                }else {
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = 'Email is already taken';
                    }
                }
                
                // Validate Name
                if(empty($data['name'])){
                    $data['name_err'] = 'Pleae enter name';
                }
                
                // Validate Password
                if(empty($data['password'])){
                    $data['password_err'] = 'Pleae enter password';
                } elseif(strlen($data['password']) < 6){
                    $data['password_err'] = 'Password must be at least 6 characters';
                }
                
                // Validate Confirm Password
                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Pleae confirm password';
                } else {
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_err'] = 'Passwords do not match';
                    }
                }
                
                // Make sure errors are empty
                if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    // Validated
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    
                    if ($this->userModel->register($data)) {
                        flash('register_success', 'You are registered & can log in');
                        redirect('users/login');
                    } else {
                        die('Register Error');
                    }
                } else {
                    // Load view with errors
                    $this->view('users/register', $data);
                }
            }else {
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];
                
                $this->view('users/register', $data);
            }
        }
        
        public function login() {
            if($_SERVER['REQUEST_METHOD']=='POST'){
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                // Init data
                $data =[
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];
                
                // Validate Email
                if(empty($data['email'])){
                    $data['email_err'] = 'Pleae enter email';
                }
                
                // Validate Password
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }

                if($this->userModel->findUserByEmail($data['email'])){
                    
                } else {
                    $data['email_err'] = 'No user found';
                }
                
                // Make sure errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])){
                    // Validated
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser) {
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['password_err'] = 'Password incorrect';
                        $this->view('users/login', $data);
                    }
                } else {
                    // Load view with errors
                    $this->view('users/login', $data);
                }
            }else {
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];
                
                $this->view('users/login', $data);
            }
        }

        function createUserSession($loggedInUser) {
            $_SESSION['user_id'] = $loggedInUser->id;
            $_SESSION['user_email'] = $loggedInUser->email;
            $_SESSION['user_name'] = $loggedInUser->name;
            echo $_SESSION['user_id'];
            //die();
            redirect('posts');
        }

        function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect('users/login');
        }
    }
?>