CREATE TABLE `code_city` (
  `code_country` int(10) NOT NULL,
  `code_oper` int(20) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `reg_latin` varchar(100) DEFAULT NULL,
  `deffrom` varchar(15) DEFAULT NULL,
  `defto` varchar(15) DEFAULT NULL,
  `timezone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;