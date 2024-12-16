<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $collection = $_POST['collection'];
        $target = $_POST['target'];
        $style = $_POST['style'];
        $color = $_POST['color'];
        $image = $_POST['image'];

        $sql =
        "INSERT INTO sanpham (ten_san_pham, gia, mo_ta, hinh_anh, chu_de_id, bo_suu_tap_id, doi_tuong_id, kieu_dang_id, mau_sac_id) 
                VALUES (:product_name, :price, :description, :image, :category, :collection, :target, :style, :color)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        $stmt->bindParam(':collection', $collection, PDO::PARAM_INT);
        $stmt->bindParam(':target', $target, PDO::PARAM_INT);
        $stmt->bindParam(':style', $style, PDO::PARAM_INT);
        $stmt->bindParam(':color', $color, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: admin.php");
            echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được thêm thành công.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra khi thêm sản phẩm.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Có lỗi trong khi chuẩn bị câu lệnh SQL: ' . $e->getMessage()]);
    }
}
?>
