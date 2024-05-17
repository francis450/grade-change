<?php
class Request {
    public function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function path() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function params() {
        $params = [];
        if ($this->method() === 'GET') {
            foreach ($_GET as $key => $value) {
                $params[$key] = $value;
            }
        } elseif ($this->method() === 'POST') {
            foreach ($_POST as $key => $value) {
                $params[$key] = $value;
            }
        }
        return $params;
    }
}
?>
