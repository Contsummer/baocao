<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    session_start();
    $data = json_decode(file_get_contents('php://input'), true);
    $product_id = $data['product_id'];
    $user_id = $data['user_id'];

    try {
        include('db_connect.php');

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE dc FROM cart_details dc
                JOIN carts c ON dc.cart_id = c.id
                WHERE dc.product_id = :product_id AND c.user_id = :user_id";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Kết nối cơ sở dữ liệu thất bại: ' . $e->getMessage()]);
    } finally {
        $conn = null;
    }
}
