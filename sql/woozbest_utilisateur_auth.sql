CREATE TABLE `utilisateur_auth` (
                                  `id_utilisateur_auth` int(11) NOT NULL AUTO_INCREMENT,
                                  `id_utilisateur_fk` int(11) NOT NULL,
                                  `token_session` varchar(64) DEFAULT NULL,
                                  `debut_session` datetime DEFAULT NULL,
                                  `useragent` text,
                                  `ip` varchar(32) DEFAULT NULL,
                                  `guid` varchar(45) NOT NULL,
                                  `date_creation` datetime NOT NULL,
                                  `date_modification` datetime DEFAULT NULL,
                                  PRIMARY KEY (`id_utilisateur_auth`),
                                  KEY `ua_token_session_INDEX` (`token_session`),
                                  KEY `ua_guid_INDEX` (`guid`),
                                  KEY `ua_idutilisateur_INDEX` (`id_utilisateur_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
