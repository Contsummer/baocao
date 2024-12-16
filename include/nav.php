<?php
session_start();
if (isset($_SESSION['cart'])) {
    $totalItems = array_sum($_SESSION['cart']);
} else {
    $totalItems = 0;
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <div class="row w-100">
            <div class="col-9 d-flex align-items-center">
                <a class="navbar-brand" href="#">BÁN HOA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav d-flex justify-content-between w-100">
                        <a class="nav-link fw-bold" aria-current="page" href="index.php">TRANG CHỦ</a>
                        <a class="nav-link fw-bold" href="/Topic.php">CHỦ ĐỀ</a>
                        <a class="nav-link fw-bold" href="#">KIỂU DÁNG</a>
                        <a class="nav-link fw-bold" href="#">HOA TƯƠI</a>
                        <a class="nav-link fw-bold" href="#">MÀU SẮC</a>
                        <a class="nav-link fw-bold" href="#">BỘ SƯU TẬP</a>
                        <a class="nav-link fw-bold" href="#">QUÀ TẶNG KÈM</a>
                    </div>
                </div>
            </div>
            <div class="col-3 d-flex justify-content-end align-items-center">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="profile.php" class="user-info d-flex align-items-center me-3  text-decoration-none">
                        <span class="navbar-text fw-bold user-name me-3">
                            Chào, <?php echo $_SESSION['username']; ?>
                        </span>
                    </a>

                    <a href="cart.php" id="cart-btn" class="btn btn-outline-success d-flex align-items-center">
                        <i class="bi bi-cart cart-count me-2"></i>
                        <?php if ($totalItems > 0): ?>
                            <span class="cart-item-count"><?php echo $totalItems; ?></span>
                        <?php endif; ?>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-primary me-3">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartButton = document.getElementById('cart-btn');
        cartButton.addEventListener('click', function(event) {
            if (<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>) {
                window.location.href = 'cart.php';
            } else {
                event.preventDefault();
                alert('Vui lòng đăng nhập để xem giỏ hàng!');
            }
        });
    });
</script>