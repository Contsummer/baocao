<?php

try {
    include('db_connect.php');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM chude");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo '<ul class="list-group">';
    $i = 1; 
    while ($row = $stmt->fetch()) {
        echo '<li class="list-group-item p-0">';
        echo '<a  href="/Topic.php?id=' . $i . '" class="text-decoration-none w-100 h-100 d-block text-black  px-3 py-2">' . $row['ten_chu_de'] . '</a>';
        echo '</li>';
        $i++;
    }
    echo '</ul>';
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>