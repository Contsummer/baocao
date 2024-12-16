<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/main.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Giỏ Hàng</title>
    <style>
        .overlay {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .overlay-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .overlay h3 {
            font-size: 1.25rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }




        #close-overlay {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ccc;
        }

        #close-overlay:hover {
            background-color: #e9ecef;
        }
    </style>
</head>


<body>
    <div class="row">
        <?php include './include/nav.php'; ?>
    </div>

    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $user_id = $_SESSION['user_id'];
    include('db_connect.php');

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT dc.product_id, s.ten_san_pham, dc.quantity, s.hinh_anh, s.gia
                FROM carts c
                JOIN cart_details dc ON c.id = dc.cart_id
                JOIN sanpham s ON dc.product_id = s.id
                WHERE c.user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Tính toán tổng tiền và VAT
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal += $item['quantity'] * $item['gia'];
        }

        $vat = $subtotal * 0.1;
        $total = $subtotal + $vat;

        // Lưu thông tin giỏ hàng vào session
        $_SESSION['cart_items'] = $cart_items;
        $_SESSION['subtotal'] = $subtotal;
        $_SESSION['vat'] = $vat;
        $_SESSION['total'] = $total;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
    ?>

    <div class="container">
        <div class="row">
            <!-- Giỏ hàng -->
            <div class="col-md-9" id="cart-items-container">
                <?php foreach ($_SESSION['cart_items'] as $item) { ?>
                    <div class="cart-item" data-id="<?php echo $item['product_id']; ?>">
                        <div class="img">
                            <img src="<?php echo $item['hinh_anh']; ?>" alt="<?php echo $item['ten_san_pham']; ?>" class="img-fluid">
                        </div>
                        <div class="text">
                            <a class="text-decorate-none" href="/shop-hoa/bo-hoa-tuoi/<?php echo $item['product_id']; ?>">
                                <?php echo $item['ten_san_pham']; ?>
                            </a>
                            <p><span><?php echo number_format($item['gia'], 0, ',', '.'); ?> đ</span></p>
                            <div class="ctrl-qty">
                                <span>Số lượng: <?php echo $item['quantity']; ?></span>
                                <span class="remove-item mx-4" onclick="removeItem(<?php echo $item['product_id']; ?>)">Xóa</span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Cột tổng cộng -->
            <div class="col-md-3">
                <div class="total">
                    <div class="each-row">
                        <span>Tạm tính:</span>
                        <strong id="subtotal"><?php echo number_format($_SESSION['subtotal'], 0, ',', '.'); ?> đ</strong>
                    </div>
                    <div class="each-row">
                        <span>Phụ phí: </span>
                        <strong id="sub-fee">0 đ</strong>
                    </div>
                    <div class="each-row">
                        <span>Giảm giá: </span>
                        <strong id="discount">0 đ</strong>
                    </div>
                    <div class="each-row">
                        <span>Hóa đơn VAT: </span>
                        <strong id="vat"><?php echo number_format($_SESSION['vat'], 0, ',', '.'); ?> đ</strong>
                    </div>
                    <div class="each-row last">
                        <span>Tổng cộng: </span>
                        <strong id="total"><?php echo number_format($_SESSION['total'], 0, ',', '.'); ?> đ</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="overlay-content">
                    <h3>Thông tin đặt hàng</h3>
                    <form action="order.php" method="POST" id="order-form">
                        <div class="form-group">
                            <label for="ten_nguoi_mua">Tên người mua:</label>
                            <input type="text" id="ten_nguoi_mua" name="ten_nguoi_mua" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="dia_chi">Địa chỉ:</label>
                            <input type="text" id="dia_chi" name="dia_chi" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="so_dien_thoai">Số điện thoại:</label>
                            <input type="text" id="so_dien_thoai" name="so_dien_thoai" class="form-control" required>
                        </div>
                        <input type="hidden" id="tong_tien" name="tong_tien" value="<?php echo $_SESSION['total']; ?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="hidden" id="cart_items" name="cart_items" value="<?php echo json_encode($_SESSION['cart_items']); ?>">

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Gửi đơn hàng</button>
                            <button type="button" class="btn btn-secondary" id="close-overlay">Hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $conn = null; ?>
    <?php include './include/footer.php'; ?>
</body>



</html>