<?php
require_once 'BaseController.php';
require_once './models/User.php';

class AuthController extends BaseController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // Check if the given hash matches the given options.
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $this->setFlash('Login successful');
                $this->redirect('/dashboard');
            } else {
                // return error message without using flash message
                echo 'Invalid email or password';
            }
        } else {
            $this->render('auth/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user) {
                // return message without using flash message
                echo 'Email already exists';
            } else {
                $userModel->create([
                    'full_name' => $fullname,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ]);
                
                echo 'success';
            }
        } else {
            $this->render('auth/register');
        }
    }


    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}
?>
