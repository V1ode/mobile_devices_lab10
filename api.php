<?php
header('Content-Type: application/json; charset=utf-8');


// Данные из файла
$host = "dpg-d4lfklfpm1nc73dgmcs0-a";
$port = "5432";
$database = "zoo_db_uvr3";
$username = "zoo_db_uvr3_user";
$password = "ODbxeYoLCqxlCyqXycZunltQMzgSsuMA";



try {
    // Подключение к PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'UTF8'");

    $prevAnimal = isset($_GET['prevAnimal']) ? $_GET['prevAnimal'] : "";

    $query = "SELECT name, sound FROM animals";
    $result = $pdo->query($query); 
    echo $result;
    
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row) {     
        echo "here" . "<br>";
        
        if($row['name'] != $prevAnimal) {            
            echo $row['name'] . "<br>";
            echo $row['text'];
        } else {
            echo "there" . "<br>";            
            $row = $result->fetch(PDO::FETCH_ASSOC);
            echo $row['name'] . "<br>";
            echo $row['text'];
        }

        echo $prevAnimal;
    } 

} catch (Exception $e) {
    echo "Ошибка сервера: $e->getMessage()";
}

echo "After";
exit();
?>
