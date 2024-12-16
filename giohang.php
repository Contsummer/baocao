<?php

try {
    include('db_connect.php');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $topic_id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($topic_id) {
        $stmt = $conn->prepare("SELECT sanpham.id, sanpham.ten_san_pham, sanpham.gia, sanpham.hinh_anh, chude.ten_chu_de, sanpham.chu_de_id 
                                FROM sanpham 
                                JOIN chude ON sanpham.chu_de_id = chude.id 
                                WHERE sanpham.chu_de_id = :topic_id");
        $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare("SELECT sanpham.id, sanpham.ten_san_pham, sanpham.gia, sanpham.hinh_anh, chude.ten_chu_de, sanpham.chu_de_id 
                                FROM sanpham 
                                JOIN chude ON sanpham.chu_de_id = chude.id");
    }
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $products = [];
}
?>
