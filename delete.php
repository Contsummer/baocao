<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

try {
    include('db_connect.php');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $product_id = (int)$_GET['id'];

        // Prepare DELETE statement
        $sql_delete = "DELETE FROM sanpham WHERE id = :id";
        $stmt = $conn->prepare($sql_delete);

        // Bind parameter
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;  // Close the PDO connection
?>
