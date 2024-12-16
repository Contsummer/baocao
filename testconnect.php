<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $servername = "sql308.byethost13.com";
    $dbname = "b13_37913435_yame";
    $username = "b13_37913435";
    $password = "@123456Vinh";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Kết nối cơ sở dữ liệu thành công!";
    } catch (PDOException $e) {
        echo "Lỗi kết nối: " . $e->getMessage();
    }
    ?>
</body>

</html>