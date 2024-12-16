<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
if (isset($_SESSION['username'])) {
    echo json_encode(['is_logged_in' => true]);
} else {
    echo json_encode(['is_logged_in' => false]);
}
?>
