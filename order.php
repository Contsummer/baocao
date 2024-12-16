<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ten_nguoi_mua'], $_POST['dia_chi'], $_POST['so_dien_thoai'], $_POST['tong_tien'], $_POST['user_id'], $_POST['cart_items'])) {
        $ten_nguoi_mua = $_POST['ten_nguoi_mua'];
        $dia_chi = $_POST['dia_chi'];
        $so_dien_thoai = $_POST['so_dien_thoai'];
        $tong_tien = $_POST['tong_tien'];
        $user_id = $_POST['user_id'];
        $cart_items = json_decode($_POST['cart_items'], true);
        try {
            include('db_connect.php');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->beginTransaction();
            
            $sql = "INSERT INTO hoadon (user_id, ten_nguoi_mua, dia_chi, so_dien_thoai, tong_tien) 
                    VALUES (:user_id, :ten_nguoi_mua, :dia_chi, :so_dien_thoai, :tong_tien)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':ten_nguoi_mua', $ten_nguoi_mua, PDO::PARAM_STR);
            $stmt->bindParam(':dia_chi', $dia_chi, PDO::PARAM_STR);
            $stmt->bindParam(':so_dien_thoai', $so_dien_thoai, PDO::PARAM_STR);
            $stmt->bindParam(':tong_tien', $tong_tien, PDO::PARAM_STR);
            $stmt->execute();
            
            $hoadon_id = $conn->lastInsertId();
            
            $sql = "INSERT INTO chitiet_hoadon (hoadon_id, product_id, ten_san_pham, so_luong, gia, thanh_tien) 
                    VALUES (:hoadon_id, :product_id, :ten_san_pham, :so_luong, :gia, :thanh_tien)";
            $stmt = $conn->prepare($sql);
            foreach ($cart_items as $item) {
                $thanh_tien = $item['quantity'] * $item['gia'];
                $stmt->bindParam(':hoadon_id', $hoadon_id, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
                $stmt->bindParam(':ten_san_pham', $item['ten_san_pham'], PDO::PARAM_STR);
                $stmt->bindParam(':so_luong', $item['quantity'], PDO::PARAM_INT);
                $stmt->bindParam(':gia', $item['gia'], PDO::PARAM_STR);
                $stmt->bindParam(':thanh_tien', $thanh_tien, PDO::PARAM_STR);
                $stmt->execute();
            }

            $delete_cart_details_sql = "DELETE FROM cart_details WHERE cart_id IN (SELECT id FROM carts WHERE user_id = :user_id)";
            $delete_cart_stmt = $conn->prepare($delete_cart_details_sql);
            $delete_cart_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $delete_cart_stmt->execute();

            $conn->commit();

            session_start();
            unset($_SESSION['cart']); // Clear cart from session after successful order

            echo json_encode(['success' => true, 'message' => 'Đặt hàng thành công!']);
            header("Location: cart.php");

        } catch (PDOException $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Đặt hàng thất bại. Vui lòng thử lại.']);
        }
        $conn = null;
    } else {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin.']);
    }
}
?>
