<?php
class Movie {
    private $conn;
    private $table = 'movies';
    public $id;
    public $title;
    public $is_watched;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (title) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->title);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        return $this->conn->query($query);
    }

    public function set_watched($id) {
        $query = "UPDATE " . $this->table . " SET is_watched = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function unset_watched($id) {
        $query = "UPDATE " . $this->table . " SET is_watched = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>