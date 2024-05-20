<?php
class BaseController {
    protected $viewPath = 'views/';
    protected $layout = 'layout/main.php';

    // Render a view with optional data
    protected function render($view, $data = []) {
        extract($data);
        ob_start(); //turn on buffering
        require $this->viewPath . $view . '.php'; // require the view file
        $content = ob_get_clean(); //Get current buffer contents and delete current output buffer

        require $this->viewPath . $this->layout;
    }

    // Redirect to a different URL
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    // Set a flash message (requires session_start() in your app)
    protected function setFlash($message, $type = 'success') {
        $_SESSION['flash'] = [
            'message' => $message,
            'type' => $type,
        ];
    }

    // Get and clear the flash message
    protected function getFlash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    protected function checkAuthentication() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}
?>
