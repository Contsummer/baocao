<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">BÁN HOA</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Trang chủ</a>
                <a class="nav-link" href="cart.php">Giỏ hàng</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Chào mừng, <?php echo htmlspecialchars($username); ?>!</h2>
        <p>Đây là trang cá nhân của bạn.</p>

        <div class="mt-4">
            <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
        </div>
    </div>

</body>

</html>