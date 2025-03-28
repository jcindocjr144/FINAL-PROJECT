<?php
class Driver {
    private $conn;
    private $table = 'drivers';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getDriverByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($username, $new_username, $new_password) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET username = :username, password = :password WHERE username = :current_username");
        $stmt->bindParam(':username', $new_username);
        $stmt->bindParam(':password', $new_password);
        $stmt->bindParam(':current_username', $username);
        return $stmt->execute();
    }

    public function updateCarUnit($driver_id, $unit, $plate_no, $body_no) {
        $stmt = $this->conn->prepare("UPDATE registrations SET unit = :unit, plate_no = :plate_no, body_no = :body_no WHERE driver_id = :driver_id");
        $stmt->bindParam(':unit', $unit);
        $stmt->bindParam(':plate_no', $plate_no);
        $stmt->bindParam(':body_no', $body_no);
        $stmt->bindParam(':driver_id', $driver_id);
        return $stmt->execute();
    }

    public function updateRentStatus($username, $is_for_rent) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET is_for_rent = :is_for_rent WHERE username = :username");
        $stmt->bindParam(':is_for_rent', $is_for_rent);
        $stmt->bindParam(':username', $username);
        return $stmt->execute();
    }

    public function uploadCarImage($username, $car_image) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET car_image = :car_image WHERE username = :username");
        $stmt->bindParam(':car_image', $car_image);
        $stmt->bindParam(':username', $username);
        return $stmt->execute();
    }

    public function deleteCarImage($username) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET car_image = NULL WHERE username = :username");
        $stmt->bindParam(':username', $username);
        return $stmt->execute();
    }
}
?>
