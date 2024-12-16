<?php
session_start();
include('db_connect.php');
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $userId = $_SESSION['user_id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = isset($_SESSION['product_id']) ? intval($_SESSION['product_id']) : 0;
    $quantity = isset($_SESSION['quantity']) ? intval($_SESSION['quantity']) : 1;
    if ($productId > 0 && $quantity > 0) {
        $stmt = $conn->prepare("SELECT id FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            $cartId = $cart['id'];
            $stmt = $conn->prepare("SELECT * FROM cart_details WHERE cart_id = :cart_id AND product_id = :product_id");
            $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $cartDetail = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cartDetail) {
                $newQuantity = $cartDetail['quantity'] + $quantity;
                $stmt = $conn->prepare("UPDATE cart_details SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id");
                $stmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
                $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("INSERT INTO cart_details (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
                $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->execute();
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO cart (user_id) VALUES (:user_id)");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $cartId = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO cart_details (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
            $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();
        }

        echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm hoặc số lượng không hợp lệ.' . $productId . "số  user"  . $userId]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
