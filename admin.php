<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

try {
    include('db_connect.php');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sử dụng PDO với câu lệnh chuẩn
$sql = "SELECT p.id, p.ten_san_pham, p.gia, p.mo_ta, p.hinh_anh, b.ten_bo_suu_tap, c.ten_chu_de, d.ten_doi_tuong, k.ten_kieu_dang, m.ten_mau_sac 
        FROM sanpham AS p 
        JOIN bosuutap AS b ON p.bo_suu_tap_id = b.id 
        JOIN chude AS c ON c.id = p.chu_de_id 
        JOIN doituong AS d ON p.doi_tuong_id = d.id 
        JOIN kieudang AS k ON k.id = p.kieu_dang_id 
        JOIN mausac AS m ON m.id = p.mau_sac_id 
        ORDER BY p.id ASC LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$sql_count = "SELECT COUNT(*) AS total FROM sanpham";
$result_count = $conn->query($sql_count);
$total = $result_count->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <title>Admin Dashboard</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-3 sidebaradmin">
                <div class="sidebaradmin ">
                    <div class="sidebar">
                        <h2 class="sidebar-title">Admin Dashboard</h2>
                        <ul class="sidebar-menu">
                            <li><a href="/admin.php">Sản phẩm </a></li>
                            <li><a href="/orderlist.php">Đơn hàng </a></li>
                            <li><a href="/logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-9 p-3">
                <div class="dashbroad row">
                    <h3 class="mb-4">Welcome to the Admin Dashboard</h3>

                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Product List</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <a href="add_product.php" class="btn-add btn btn-success float-end my-2">
                                        thêm sản phẩm
                                    </a>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Collection</th>
                                            <th>Category</th>
                                            <th>Target</th>
                                            <th>Color</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($stmt->rowCount() > 0) {
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td>" . $row['ten_san_pham'] . "</td>";
                                                echo "<td><div style='background-image: url(\"" . htmlspecialchars($row['hinh_anh']) . "\");'></div></td>";
                                                echo "<td>" . $row['gia'] . "</td>";
                                                echo "<td>" . $row['ten_bo_suu_tap'] . "</td>";
                                                echo "<td>" . $row['ten_chu_de'] . "</td>";
                                                echo "<td>" . $row['ten_doi_tuong'] . "</td>";
                                                echo "<td>" . $row['ten_mau_sac'] . "</td>";
                                                echo "<td><a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                                <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this product?')\">Delete</a>
                                                </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='9' class='text-center'>No products found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                        <a href="?page=<?= $i ?>"><?= $i ?></a>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $conn = null;
    ?>

</body>

</html>