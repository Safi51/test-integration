# 📡 API Data Fetcher

Проект для получения данных по предоставленным **REST API endpoint-ам** и их обработки.  
Приложение успешно развернуто на бесплатном хостинге Beget с использованием MySQL.

---

## 🚀 Возможности
- Получение и обработка данных с заданных endpoint-ов.
- Хранение данных в базе MySQL.
- Развёртывание на бесплатном Beget-хостинге.
- Поддержка конфигурации через `.env`.
- Добавление докера в проект
---

## 🛠 Технологии
- **Backend:** Laravel 11 (PHP 8.1+)
- **База данных:** MySQL
- **Docker**
- **Хостинг:** [Beget](https://beget.com)  

---

## 📂 Путь до удаленного БД
- **Url:** [PhpMyAdmin](https://free29.beget.com/phpMyAdmin/db_structure.php?server=1&db=q70192e7_safi)
- **DB_USERNAME: q70192e7_safi**
- **DB_PASSWORD: l@ravel_safi51**

## Начало рабоыт с проектом
- **создать .env и взять данные с .env.example**
- **Вставить VERIFICATION_KEY который мне отправили**
- **Написать в консоль docker compose up -d**
- **Для засеевание данных в консоле: php artisan db:seed**
- **Для получение данных с апи серверов test:integration. У команды есть флажки для изменения вариации**
