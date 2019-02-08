CREATE TABLE `recherche` (
                           `id_recherche` int(11) NOT NULL AUTO_INCREMENT,
                           `q` text NOT NULL,
                           `id_utilisateur_fk` int(11) NOT NULL,
                           PRIMARY KEY (`id_recherche`),
                           KEY `recherche_idu_INDEX` (`id_utilisateur_fk`)
) ENGINE=Innodb DEFAULT CHARSET=utf8;
