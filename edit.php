<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    try {
        include('db_connect.php');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

        $sql = "SELECT p.id, p.ten_san_pham, p.gia, p.mo_ta, p.hinh_anh, b.ten_bo_suu_tap, c.ten_chu_de, d.ten_doi_tuong, k.ten_kieu_dang, m.ten_mau_sac
                FROM sanpham AS p 
                JOIN bosuutap AS b ON p.bo_suu_tap_id = b.id 
                JOIN chude AS c ON c.id = p.chu_de_id 
                JOIN doituong AS d ON p.doi_tuong_id = d.id 
                JOIN kieudang AS k ON k.id = p.kieu_dang_id 
                JOIN mausac AS m ON m.id = p.mau_sac_id 
                WHERE p.id = :product_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo "Sản phẩm không tìm thấy.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

    $conn = null;
} else {
    echo "Yêu cầu không hợp lệ.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Sản phẩm</title>
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
            <h2>Chỉnh sửa Sản phẩm</h2>
            <form action="update_product.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <div class="form-group">
                    <label for="product_name" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($row['ten_san_pham']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Giá</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['gia']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Hình ảnh</label>
                    <input type="text" class="form-control" id="image" name="image">
                    <img src="<?php echo htmlspecialchars($row['hinh_anh']); ?>" alt="Product Image" class="img-preview">
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Mô tả</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($row['mo_ta']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Chủ đề</label>
                    <select class="form-control" id="category" name="category" required>
                        <?php
                        while ($chude = $chude_result->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row['chu_de_id'] == $chude['id']) ? 'selected' : '';
                            echo "<option value='{$chude['id']}' {$selected}>{$chude['ten_chu_de']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="collection" class="form-label">Bộ sưu tập</label>
                    <select class="form-control" id="collection" name="collection" required>
                        <?php
                        while ($collection = $bosuutap_result->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row['bo_suu_tap_id'] == $collection['id']) ? 'selected' : '';
                            echo "<option value='{$collection['id']}' {$selected}>{$collection['ten_bo_suu_tap']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="target" class="form-label">Đối tượng</label>
                    <select class="form-control" id="target" name="target" required>
                        <?php
                        while ($target = $doituong_result->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row['doi_tuong_id'] == $target['id']) ? 'selected' : '';
                            echo "<option value='{$target['id']}' {$selected}>{$target['ten_doi_tuong']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="style" class="form-label">Kiểu dáng</label>
                    <select class="form-control" id="style" name="style" required>
                        <?php
                        while ($style = $kieudang_result->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row['kieu_dang_id'] == $style['id']) ? 'selected' : '';
                            echo "<option value='{$style['id']}' {$selected}>{$style['ten_kieu_dang']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="color" class="form-label">Màu sắc</label>
                    <select class="form-control" id="color" name="color" required>
                        <?php
                        while ($color = $mausac_result->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row['mau_sac_id'] == $color['id']) ? 'selected' : '';
                            echo "<option value='{$color['id']}' {$selected}>{$color['ten_mau_sac']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            </form>
        </div>
    </div>
</body>

</html>