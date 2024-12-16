<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Không có quyền truy cập']);
    exit();
}
include('db_connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $collection = $_POST['collection'];
    $target = $_POST['target'];
    $style = $_POST['style'];
    $color = $_POST['color'];
    try {
include('db_connect.php');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE sanpham SET 
                ten_san_pham = ?, 
                gia = ?, 
                mo_ta = ?, 
                chu_de_id = ?, 
                bo_suu_tap_id = ?, 
                doi_tuong_id = ?, 
                kieu_dang_id = ?, 
                mau_sac_id = ?";

        if ($image) {
            $sql .= ", hinh_anh = ?";
        }
        $sql .= " WHERE id = ?";

        $stmt = $conn->prepare($sql);

        // Bind giá trị vào câu lệnh SQL
        $params = [
            $product_name,
            $price,
            $description,
            $category,
            $collection,
            $target,
            $style,
            $color
        ];

        if ($image) {
            $params[] = $image;
        }
        $params[] = $product_id;
        if ($stmt->execute($params)) {
            header("Location: admin.php");
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cập nhật sản phẩm thất bại']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Kết nối cơ sở dữ liệu thất bại: ' . $e->getMessage()]);
        exit();
    }
}
