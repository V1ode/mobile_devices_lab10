<?php
header('Content-Type: application/json; charset=utf-8');


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
