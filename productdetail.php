<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="./assets/css/main.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>

    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php include './include/nav.php'; ?>
        </div>
        <?php
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        try {
            include('db_connect.php');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $stmt = $conn->prepare("
                SELECT 
                    sp.id AS product_id, 
                    sp.ten_san_pham AS product_name, 
                    sp.gia AS price, 
                    sp.mo_ta AS description, 
                    sp.hinh_anh AS image_url, 
                    sp.danh_gia AS rating, 
                    cd.ten_chu_de AS category_name, 
                    dt.ten_doi_tuong AS target_group_name, 
                    kd.ten_kieu_dang AS style_name, 
                    ms.ten_mau_sac AS color_name, 
                    bst.ten_bo_suu_tap AS collection_name 
                FROM sanpham sp 
                JOIN chude cd ON sp.chu_de_id = cd.id 
                JOIN doituong dt ON sp.doi_tuong_id = dt.id 
                JOIN kieudang kd ON sp.kieu_dang_id = kd.id 
                JOIN mausac ms ON sp.mau_sac_id = ms.id 
                JOIN bosuutap bst ON sp.bo_suu_tap_id = bst.id 
                WHERE sp.id = :id
            ");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            $product = null;
        }
        ?>
        <?php if ($product): ?>
            <div class="row">
                <div class="col-md-6 d-flex align-items-center justify-content-center" style="height: 500px;">
                    <img
                        src="<?php echo htmlspecialchars($product['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                        class="product-image img-fluid object-fit-contain"
                        style="max-height: 100%; max-width: 100%;">
                </div>
                <div class="col-md-6">
                    <div class="product-details">
                        <h1 class="mb-4"><?php echo htmlspecialchars($product['product_name']); ?></h1>

                        <div class="product-rating mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $product['rating']
                                            ? '<i class="bi bi-star-fill"></i>'
                                            : '<i class="bi bi-star"></i>';
                                    }
                                    ?>
                                </div>
                                <span class="text-muted">(<?php echo $product['rating']; ?>/5)</span>
                            </div>
                        </div>

                        <div class="product-price mb-4">
                            <h3 class="text-primary">
                                <?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?>
                            </h3>
                        </div>

                        <div class="product-info row mb-4">
                            <div class="col-6 mb-2">
                                <small class="info-label">Category</small>
                                <p class="mb-0"><?php echo htmlspecialchars($product['category_name']); ?></p>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="info-label">Target Group</small>
                                <p class="mb-0"><?php echo htmlspecialchars($product['target_group_name']); ?></p>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="info-label">Style</small>
                                <p class="mb-0"><?php echo htmlspecialchars($product['style_name']); ?></p>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="info-label">Color</small>
                                <p class="mb-0"><?php echo htmlspecialchars($product['color_name']); ?></p>
                            </div>
                        </div>

                        <div class="product-description mb-4">
                            <h5>Description</h5>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>

                        <div class="product-actions">
                            <div class="d-grid gap-2 d-md-block">
                                <button
                                    class="btn btn-primary btn-lg me-2 add-to-cart my-3"
                                    data-product-id="<?php echo htmlspecialchars($product['product_id']); ?>">
                                    <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                                </button>
                                <button class="btn btn-success btn-lg">
                                    <i class="bi bi-bag-check me-2"></i>Mua ngay
                                </button>
                                <a href="tel:+0123456789" class="btn btn-success btn-lg">
                                    <i class="bi  bi-telephone me-2"></i>0123456789
                                </a>
                            </div>
                        </div>
                        <div class="product-sale my-3">
                            <h4>ƯU ĐÃI ĐẶC BIỆT</h2>
                                <ul class="list-group ">
                                    <li class="list-group-item disabled text-black">1. Tặng Banner Hoạc Thiệp (Trị Giá 20.0000 - 50.0000) Miễn Phí</li>
                                    <li class="list-group-item disabled text-black">2. Giảm Tiếp 3% Cho Đơn Hàng Bạn Tạo ONLINE Lần Thứ 2, 5% Cho Đơn Hàng Bạn Tạo ONLINE Lần Thứ 6 Và 10% Cho Đơn Hàng Bạn Tạo ONLINE Lần Thứ 12</li>
                                    <li class="list-group-item disabled text-black">3. Miễn Phí Giao Khư Vực Nội Thành (Chỉ Tiết)</li>
                                    <li class="list-group-item disabled text-black">4. Giao Gấp Trong Vòng 2 Giờ</li>
                                    <li class="list-group-item disabled text-black">5. Cam Kết 100% Hoàn Lại Tiền Nếu Bạn Không Hài Lòng</li>
                                    <li class="list-group-item disabled text-black">6. Cam Kết Hoa Tươi Trên 3 Ngày</li>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>Product not found
            </div>
        <?php endif; ?>

        <div class="row">
            <?php include './include/footer.php'; ?>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                const productId = $(this).data('product-id');
                const userId = <?php echo json_encode($user_id); ?>; // Lấy user_id từ PHP và truyền vào JavaScript

                $.ajax({
                    url: './checklogin.php',
                    method: 'GET',
                    success: function(response) {
                        if (response.is_logged_in) {
                            $.ajax({
                                url: './add_to_cart.php',
                                method: 'POST',
                                data: {
                                    product_id: productId,
                                    user_id: userId // Gửi cả user_id
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('.cart-count').text(`${response.cart_count}`);
                                        alert('Thêm sản phẩm vào giỏ hàng thành công!');
                                    } else {
                                        alert('Thêm vào giỏ hàng thất bại: ' + response.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Lỗi xảy ra:", error);
                                    alert('Đã xảy ra lỗi khi thêm vào giỏ hàng.');
                                }
                            });
                        } else {
                            alert('Bạn cần đăng nhập trước khi thêm sản phẩm vào giỏ hàng.');
                            window.location.href = './login.php';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi xảy ra khi kiểm tra trạng thái đăng nhập:", error);
                        alert('Đã xảy ra lỗi khi kiểm tra trạng thái đăng nhập.');
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">



    </script>





</body>

</html>