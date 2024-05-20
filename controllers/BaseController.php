<?php
class BaseController {
    protected $viewPath = 'views/';
    protected $layout = 'layout/main.php';

    // Render a view with optional data
    protected function render($view, $data = [], $useLayout = true) {
        extract($data);
        ob_start(); // Start output buffering
        require $this->viewPath . $view . '.php';
        $content = ob_get_clean(); // Get buffered content and clean buffer

        if ($useLayout) {
            require $this->viewPath . $this->layout;
        } else {
            echo $content; // Directly output the content without layout
        }
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
