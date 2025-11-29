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
    $result = $pdo->query($query);    
    
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row) {        
        if($row['name'] != $prevAnimal) {
            echo "here" . "<br>";
            echo $row;
            echo $row['name'] . "<br>";
            echo $row['text'];
        } else {
            echo "there" . "<br>";
            $row = $result->fetch(PDO::FETCH_ASSOC);
            echo $row['name'] . "<br>";
            echo $row['text'];
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

echo "After";
exit();
?>
