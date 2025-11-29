<?php
header('Content-Type: text/html; charset=utf-8');

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
    
    // Установка кодировки
    $pdo->exec("SET NAMES 'UTF8'");
    
    echo "Connected successfully to PostgreSQL database!<br>";
    
    // Создание таблицы
    $create_table = "CREATE TABLE IF NOT EXISTS animals (
        id SERIAL PRIMARY KEY,
        name TEXT NOT NULL,
        sound TEXT NOT NULL
    )";
    
    $pdo->exec($create_table);
    echo "Table 'animals' created successfully!<br>";
    
    // Очистка старых данных
    $pdo->exec("DELETE FROM animals");
    echo "Old data cleared<br>";
    
    // Данные для вставки
    $data = [
        ['Кошка', 'Мяу'],
        ['Собака', 'Гав-Гав'], 
        ['Корова', 'Муу'], 
        ['Овца', 'Бее'], 
        ['Курица', 'Кудах-Тах-Тах'],
        ['Утка', 'Кря-Кря'], 
        ['Лошадь', 'Иго-го'], 
        ['Свинья', 'Хрю-Хрю'],
        ['Коза', 'Мее'],
        ['Петух', 'Кукарекуу'],
        ['Мышь', 'Пи-Пи'],
        ['Лягушка', 'Ква-а'],
        ['Сова', 'Угу-Угу'],
        ['Волк', 'Ауу'],
        ['Лев', 'Ррр'],
        ['Слон', 'Туту'],
        ['Обезьяна', 'Уа-Уа'],
        ['Попугай', 'Привет'],
        ['Ворона', 'Кар-Кар'],
        ['Лиса', 'Вав-Вав-Вав'],
        ['Шмель', 'Ж-Ж-Ж-Ж'], 
        ['Рыба', 'Буль-Буль']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO animals (name, sound) VALUES (?, ?)");
    
    $inserted = 0;
    foreach ($data as $row) {
        $name = $row[0];
        $sound = $row[1];
        
        try {
            $stmt->execute([$name, $sound]);
            $inserted++;
            echo "✓ Added animal: " . $name . "<br>";
        } catch (PDOException $e) {
            echo "✗ Error adding animal - " . $name . ": " . $e->getMessage() . "<br>";
        }
    }
    
    // Проверка данных
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM animals");
    $row = $stmt->fetch();
    echo "<br><strong>Total animals in database: " . $row['count'] . "</strong><br>";
    
    echo "<br><h3>Database initialization complete! Inserted: " . $inserted . " animals.</h3>";
    // echo "<p><a href='api.php?day=1'>Test API for today</a></p>";
    // echo "<p><a href='api.php?day=2'>Test API for tomorrow</a></p>";
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
