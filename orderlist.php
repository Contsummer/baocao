<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

try {
    include('db_connect.php');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_invoice = "SELECT id, ten_nguoi_mua, dia_chi, so_dien_thoai, ngay_dat_hang, tong_tien FROM hoadon";
    $stmt_invoice = $conn->prepare($sql_invoice);
    $stmt_invoice->execute();
    $hoa_don_data = $stmt_invoice->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
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
                <div class="sidebaradmin">
                    <div class="sidebar">
                        <h2 class="sidebar-title">Admin Dashboard</h2>
                        <ul class="sidebar-menu">
                            <li><a href="/admin.php">Dashboard</a></li>
                            <li><a href="orderlist.php">Đơn hàng</a></li>
                            <li><a href="/logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-9 p-3">
                <div class="dashbroad row">
                    <h3 class="mb-4">Invoice List</h3>

                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Invoice Details</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Order Date</th>
                                            <th>Total Amount</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($hoa_don_data) > 0) {
                                            foreach ($hoa_don_data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $row['ten_nguoi_mua'] . "</td>";
                                                echo "<td>" . $row['dia_chi'] . "</td>";
                                                echo "<td>" . $row['so_dien_thoai'] . "</td>";
                                                echo "<td>" . $row['ngay_dat_hang'] . "</td>";
                                                echo "<td>" . $row['tong_tien'] . "</td>";
                                    
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No invoices found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>