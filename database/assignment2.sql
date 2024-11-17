CREATE DATABASE assignment2;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON assignment2.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE assignment2;

DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS post;

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `account` (`id`, `username`, `email`, `password`) VALUES
(1, 'Roland Mendel', 'aAaAaAaA@gmail.com', 'aAaAaAaA'),
(2, 'Victoria Ashworth', 'bBbBbBbB@gmail.com', 'bBbBbBbB'),
(3, 'Martin Blank', 'cCcCcCcC@gmail.com', 'cCcCcCcC');


CREATE TABLE IF NOT EXISTS `post` (
  `post_id` INT NOT NULL AUTO_INCREMENT,  
  `user_id` INT NOT NULL,                   
  `title` VARCHAR(255) NOT NULL,              -- 文章標題
  `content` TEXT NOT NULL,                    -- 文章內容
  `state` ENUM('Africa', 'Asia', 'Europe', 'North America', 'South America', 'Oceania') NOT NULL,
  `country` VARCHAR(50) NOT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,     -- 圖片檔案路徑
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- 文章建立時間
  PRIMARY KEY (`post_id`),                    
  FOREIGN KEY (`user_id`) REFERENCES `account`(`id`) 
) ENGINE=InnoDB;

INSERT INTO post(user_id, title, content, state, country) VALUES
(1, 'Test 1', 'Test laaaaaaa', 'Asia', 'Japan');