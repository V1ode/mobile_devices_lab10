<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Данные из файла
$host = "";
$port = "";
$database = "";
$username = "";
$password = "";


$response = [];

try {
    // Подключение к PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'UTF8'");

    $day = isset($_GET['day']) ? intval($_GET['day']) : 1;
    $search_date = ($day == 1) ? date("Y-m-d") : date("Y-m-d", strtotime("+1 day"));

    $query = "SELECT text FROM holidays WHERE data_gregorian = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$search_date]);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $response['success'] = true;
        $response['holiday'] = $row['text'];
        $response['date'] = $search_date;
        $response['day_type'] = $day;
    } else {
        $response['success'] = false;
        $response['holiday'] = "На " . $search_date . " праздников не найдено";
        $response['date'] = $search_date;
        $response['day_type'] = $day;
    }

} catch (PDOException $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage(),
        'holiday' => 'Ошибка сервера',
        'date' => date("Y-m-d"),
        'day_type' => isset($day) ? $day : 1
    ];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
?>
