import Psycopg2


connect = psycopg2.connect(dbname="zoo_db_uvr3", user="zoo_db_uvr3_user", password="ODbxeYoLCqxlCyqXycZunltQMzgSsuMA", host="dpg-d4lfklfpm1nc73dgmcs0-a" port="5432")      
print("Подключение установлено") 

cursor = conn.cursor() 
cursor.execute("CREATE TABLE animals ( id SERIAL PRIMARY KEY, name VARCHAR(100) NOT NULL, sound VARCHAR(100) NOT NULL )");
conn.commit()  
print("Таблица animals успешно создана")

cursor.execute('''INSERT INTO animals (name, sound) VALUES 
('Кошка', 'Мяу'),
('Собака', 'Гав-Гав'), 
('Корова', 'Муу'), 
('Овца', 'Бее'), 
('Курица', 'Кудах-Тах-Тах'),
('Утка', 'Кря-Кря'), 
('Лошадь', 'Иго-го'), 
('Свинья', 'Хрю-Хрю'),
('Коза', 'Мее'),
('Петух', 'Кукарекуу'),
('Мышь', 'Пи-Пи'),
('Лягушка', 'Ква-а'),
('Сова', 'Угу-Угу'),
('Волк', 'Ауу'),
('Лев', 'Ррр'),
('Слон', 'Туту'),
('Обезьяна', 'Уа-Уа'),
('Попугай', 'Привет'),
('Ворона', 'Кар-Кар'),
('Лиса', 'Вав-Вав-Вав'),
('Шмель', 'Ж-Ж-Ж-Ж'), 
('Рыба', 'Буль-Буль')''');

conn.close()
