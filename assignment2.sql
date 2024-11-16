CREATE DATABASE assignment2;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON assignment2.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE assignment2;

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