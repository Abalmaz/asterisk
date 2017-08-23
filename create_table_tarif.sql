CREATE TABLE `tarif` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `provider` varchar(20) DEFAULT NULL,
  `code` int(20) DEFAULT NULL,
  `Destination` varchar(100) DEFAULT NULL,
  `rate_usd` float(10,5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ind_code_prov` (`provider`,`code`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;