<?php
  $connection_string = "host='dpg-d4lfklfpm1nc73dgmcs0-a' port=5432 dbname='zoo_db_uvr3'" .
                        "user='zoo_db_uvr3_user' password='ODbxeYoLCqxlCyqXycZunltQMzgSsuMA'";

  $connection = pg_connect($connection_string) or die("Could not connect to the database: " . pg_last_error());

  $create_table_query = "CREATE TABLE animals ( id SERIAL PRIMARY KEY, name VARCHAR(100) NOT NULL, sound VARCHAR(100) NOT NULL )";
  $insert_query = "INSERT INTO animals (name, sound) VALUES " .
    "('Кошка', 'Мяу'), " .
    "('Собака', 'Гав-Гав'), " .
    "('Корова', 'Муу'), " .
    "('Овца', 'Бее'), " .
    "('Курица', 'Кудах-Тах-Тах'), " .
    "('Утка', 'Кря-Кря'), " .
    "('Лошадь', 'Иго-го'), " .
    "('Свинья', 'Хрю-Хрю'), " .
    "('Коза', 'Мее'), " .
    "('Петух', 'Кукарекуу'), " .
    "('Мышь', 'Пи-Пи'), " .
    "('Лягушка', 'Ква-а'), " .
    "('Сова', 'Угу-Угу'), " .
    "('Волк', 'Ауу'), " .
    "('Лев', 'Ррр'), " .
    "('Слон', 'Туту'), " .
    "('Обезьяна', 'Уа-Уа'), " .
    "('Попугай', 'Привет'), " .
    "('Ворона', 'Кар-Кар'), " .
    "('Лиса', 'Вав-Вав-Вав')" .
    "('Шмель', 'Ж-Ж-Ж-Ж')" .
    "('Рыба', 'Буль-Буль')" .;

  pg_close($connection);

?>
