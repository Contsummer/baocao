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

<?php if (!empty($products)): ?>
    <?php if ($topic_id): ?>
        <h1>Hoa <?php echo htmlspecialchars($products[0]['ten_chu_de']); ?></h1> <!-- Display topic name only when 'id' is provided -->
    <?php endif; ?>
    <?php foreach ($products as $product): ?>
        <div class="col-md-3 mb-4">
            <a href="productdetail.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="text-decoration-none text-black">
                <div class="card">
                    <div style="background-image: url('<?php echo htmlspecialchars($product['hinh_anh']); ?>'); background-size: contain;background-repeat: no-repeat;   background-position: center; width: 100%; height: 200px; display: block;"></div>
                    <hr />
                    <div class="card-body">
                        <span class="card-title fs-6 fw-bold"><?php echo htmlspecialchars($product['ten_san_pham']); ?></span>
                        <p class="card-text">Giá: <?php echo number_format($product['gia'], 0, ',', '.') . ' VNĐ'; ?></p>
                        <a href="productdetail.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </a>
        </div>

    <?php endforeach; ?>

<?php else: ?>
    <div class="col-12">
        <p class="text-center">Không có sản phẩm nào trong chủ đề này.</p>
    </div>
<?php endif; ?>