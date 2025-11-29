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

    $prevAnimal = isset($_POST['prevAnimal']) ? $_POST['prevAnimal'] : "1";

    $query = "SELECT name, sound FROM animals";
    $result = $pdo->query($query); 
    
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row) {            
        if($row['name'] != $prevAnimal) {            
            echo $row['name'] . " ";
            echo $row['sound'];
        } else {           
            $row = $result->fetch(PDO::FETCH_ASSOC);
            
            echo $row['name'] . " ";
            echo $row['sound'];
        }
    } 

} catch (Exception $e) {
    echo "Ошибка сервера: $e->getMessage()";
}

exit();
?>
