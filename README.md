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

## Начало работы с проектом
- **создать .env и взять данные с .env.example**
- **Вставить VERIFICATION_KEY который мне отправили и MYSQL_ROOT_PASSWORD, DB_PASSWORD**
- **Написать в консоль docker compose up -d**
- **Для засеевание данных в консоле: php artisan db:seed**
- **Для получение данных с апи серверов test:integration. У команды есть флажки для изменения вариации**

## Для проверки базы данные
- **Пройдите по пути [Adminer](http://144.31.26.206:8080)**
- **Возмите данные с сервера cd test_safi/test-integration, nano .env**
- **Снизу пример введение данных**
- <img width="391" height="208" alt="Снимок экрана 2025-09-25 в 23 02 58" src="https://github.com/user-attachments/assets/6134d8cd-1f86-474e-b86b-73bd6d3fb76b" />


