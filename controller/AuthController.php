<?php
require_once 'BaseController.php';
require_once 'User.php';

class AuthController extends BaseController {
    public function __construct() {
        // No need to check authentication for login and register actions
    }

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
                $this->setFlash('Invalid email or password', 'error');
                $this->redirect('/login');
            }
        } else {
            $this->render('auth/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}
?>
