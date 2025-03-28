<?php
require_once 'database.php';

if (isset($_GET['id'])) {
    $recordId = $_GET['id'];

    $db = new Database();
    $conn = $db->getDb();

    try {
        $conn->beginTransaction();

        $query1 = $conn->prepare("DELETE FROM registrations WHERE id = :id");
        $query1->bindParam(':id', $recordId, PDO::PARAM_INT);
        $query1->execute();

        $query2 = $conn->prepare("DELETE FROM users WHERE id = :id");
        $query2->bindParam(':id', $recordId, PDO::PARAM_INT);
        $query2->execute();

        $query3 = $conn->prepare("DELETE FROM guest WHERE id = :id");
        $query3->bindParam(':id', $recordId, PDO::PARAM_INT);
        $query3->execute();

        $query4 = $conn->prepare("DELETE FROM drivers WHERE id = :id");
        $query4->bindParam(':id', $recordId, PDO::PARAM_INT);
        $query4->execute();

        $conn->commit();

        header("Location: manageAccounts.php");
        exit;

    } catch (Exception $e) {
        $conn->rollBack();
        echo "Error deleting record: " . $e->getMessage();
    }
} else {
    echo "No record ID provided.";
}
?>
