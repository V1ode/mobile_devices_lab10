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
$host = "dpg-d4lfklfpm1nc73dgmcs0-a";
$port = "5432";
$database = "zoo_db_uvr3";
$username = "zoo_db_uvr3_user";
$password = "ODbxeYoLCqxlCyqXycZunltQMzgSsuMA";


$response = [];

try {
    // Подключение к PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'UTF8'");

    $prevAnimal = isset($_GET['prevAnimal']) ? $_GET['prevAnimal'] : "";
    $search_date = ($day == 1) ? date("Y-m-d") : date("Y-m-d", strtotime("+1 day"));

    $query = "SELECT name, sound FROM animals ORDER BY RANDOM()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "Inside";
    if ($row) {
        echo "Deep Inside";
        $response['success'] = true;
        if($row['name'][0] != $prevAnimal) {
            $response['name'] = $row['name'][0];
            $response['sound'] = $row['text'][0];
        } else {
            $response['name'] = $row['name'][1];
            $response['sound'] = $row['text'][1];
        }        
    } 

} catch (PDOException $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage(),
        'name' => 'Ошибка сервера',
        'sound' => 'Ошибка сервера'
    ];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
echo "After";
exit();
?>
