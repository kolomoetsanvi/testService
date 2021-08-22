/*//////////////////////////////////////1. Создание БД///////////////////////////////*/
-- создание базы данных и таблиц, задать кодировку и тип сортировки
CREATE DATABASE IF NOT EXISTS  api_db CHARSET=utf8;

use api_db;


-- Создаем таблицу продуктов
CREATE TABLE IF NOT EXISTS `products` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date_and_time` int(10) NOT NULL,
  `created` int(10) NOT NULL,
  `modified` int(10) NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 

