<?php
class BaseModel {
    protected $table;
    protected $conn;

    public function __construct() {
        // get a new database instance
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function read($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');
        $sql = "UPDATE {$this->table} SET $fields WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE $this->table.    id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function where($column, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE $column = :value";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
