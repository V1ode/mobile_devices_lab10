<?php
header('Content-Type: text/html; charset=utf-8');

// Данные из файла
$host = "";
$port = "";
$database = "";
$username = "";
$password = "";

try {
    // Подключение к PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Установка кодировки
    $pdo->exec("SET NAMES 'UTF8'");
    
    echo "Connected successfully to PostgreSQL database!<br>";
    
    // Создание таблицы
    $create_table = "CREATE TABLE IF NOT EXISTS holidays (
        id SERIAL PRIMARY KEY,
        data_gregorian DATE NOT NULL UNIQUE,
        text TEXT NOT NULL
    )";
    
    $pdo->exec($create_table);
    echo "Table 'holidays' created successfully!<br>";
    
    // Очистка старых данных
    $pdo->exec("DELETE FROM holidays");
    echo "Old data cleared<br>";
    
    // Данные для вставки
    $holidays = [
        [date("Y-m-d"), "Сегодня - Всемирный день приветствий! Поздоровайтесь с 10 незнакомцами сегодня."],
        [date("Y-m-d", strtotime("+1 day")), "Завтра - Международный день студента. Учитесь с удовольствием!"],
        ['2024-11-21', "Всемирный день телевидения"],
        ['2024-12-25', "Рождество Христово"],
        ['2024-12-31', "Канун Нового года"],
        ['2025-01-01', "Новый год!"],
        ['2025-01-07', "Рождество Христово (православное)"],
        ['2025-02-14', "День святого Валентина"],
        ['2025-02-23', "День защитника Отечества"],
        ['2025-03-08', "Международный женский день"],
        ['2025-03-21', "Всемирный день поэзии"],
        ['2025-04-01', "День смеха"],
        ['2025-04-12', "День космонавтики"],
        ['2025-05-01', "День труда"],
        ['2025-05-09', "День Победы"],
        ['2025-06-01', "Международный день защиты детей"],
        ['2025-06-12', "День России"],
        ['2025-09-01', "День знаний"],
        ['2025-11-04', "День народного единства"]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO holidays (data_gregorian, text) VALUES (?, ?)");
    
    $inserted = 0;
    foreach ($holidays as $holiday) {
        $date = $holiday[0];
        $text = $holiday[1];
        
        try {
            $stmt->execute([$date, $text]);
            $inserted++;
            echo "✓ Added holiday for: " . $date . " - " . $text . "<br>";
        } catch (PDOException $e) {
            echo "✗ Error adding holiday for " . $date . ": " . $e->getMessage() . "<br>";
        }
    }
    
    // Проверка данных
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM holidays");
    $row = $stmt->fetch();
    echo "<br><strong>Total holidays in database: " . $row['count'] . "</strong><br>";
    
    echo "<br><h3>Database initialization complete! Inserted: " . $inserted . " holidays.</h3>";
    echo "<p><a href='api.php?day=1'>Test API for today</a></p>";
    echo "<p><a href='api.php?day=2'>Test API for tomorrow</a></p>";
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
