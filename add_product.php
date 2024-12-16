<?php
include('db_connect.php'); 

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

try {
    $chude_query = "SELECT * FROM chude";
    $chude_result = $conn->query($chude_query);

    $bosuutap_query = "SELECT * FROM bosuutap";
    $bosuutap_result = $conn->query($bosuutap_query);

    $doituong_query = "SELECT * FROM doituong";
    $doituong_result = $conn->query($doituong_query);

    $kieudang_query = "SELECT * FROM kieudang";
    $kieudang_result = $conn->query($kieudang_query);

    $mausac_query = "SELECT * FROM mausac";
    $mausac_result = $conn->query($mausac_query);
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/admin.css">
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-title">Bảng điều khiển Quản trị viên</div>
        <ul class="sidebar-menu">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="products.php">Sản phẩm</a></li>
            <li><a href="/logout.php">Đăng xuất</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="form-container">
            <h2>Thêm Sản phẩm</h2>
            <form action="add_product_action.php" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="product_name" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Giá</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Hình ảnh</label>
                    <input type="text" class="form-control" id="image" name="image" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Mô tả</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Chủ đề</label>
                    <select class="form-control" id="category" name="category" required>
                        <?php
                        while ($chude = $chude_result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$chude['id']}'>{$chude['ten_chu_de']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="collection" class="form-label">Bộ sưu tập</label>
                    <select class="form-control" id="collection" name="collection" required>
                        <?php
                        while ($collection = $bosuutap_result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$collection['id']}'>{$collection['ten_bo_suu_tap']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="target" class="form-label">Đối tượng</label>
                    <select class="form-control" id="target" name="target" required>
                        <?php
                        while ($target = $doituong_result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$target['id']}'>{$target['ten_doi_tuong']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="style" class="form-label">Kiểu dáng</label>
                    <select class="form-control" id="style" name="style" required>
                        <?php
                        while ($style = $kieudang_result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$style['id']}'>{$style['ten_kieu_dang']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="color" class="form-label">Màu sắc</label>
                    <select class="form-control" id="color" name="color" required>
                        <?php
                        while ($color = $mausac_result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$color['id']}'>{$color['ten_mau_sac']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
            </form>
        </div>
    </div>
     <script>
        function validateForm(event) {
            const priceInput = document.getElementById('price');
            const priceValue = parseFloat(priceInput.value);

            if (priceValue <= 0) {
                event.preventDefault(); 
                alert("Giá sản phẩm phải là một số dương!");
                priceInput.focus(); 
            }
        }

        // Gắn sự kiện "submit" cho form
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            form.addEventListener('submit', validateForm);
        });
    </script>
</body>

</html> 

