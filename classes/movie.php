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
}
?>