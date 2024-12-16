<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banhoa";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT *  FROM chude");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $chudes = $stmt->fetchAll();
    echo "Connection failed: " . $e->getMessage();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $chudes = [];
}
?>
<?php
function renderChudeList($chudes)
{
    $html = '<ul class="list-group">';
    foreach ($chudes as $chude) {
        $html .= '<li class="list-group-item">';
        $html .= '<a href="./ChuDe/' . strtolower(str_replace(' ', '_', $chude['ten_chu_de'])) . '.php" class="text-decoration-none w-100 h-100 d-block text-black">' . $chude['ten_chu_de'] . '</a>';
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}
?>

<?php
echo renderChudeList($chudes);
?>