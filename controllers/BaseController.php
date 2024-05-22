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
            $this->redirect('/grade-change/login');
        }
    }

    protected function uploadFile($file, $location){
        $target_dir = 'public/'.$location;
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        // Check file size
        if ($file["size"] > 500000) {
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "txt" && $imageFileType != "doc" && $imageFileType != "docx") {
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return false;
        // if everything is ok, try to upload file
        } else {
         
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                return false;
            }
        }
    }
}
?>
