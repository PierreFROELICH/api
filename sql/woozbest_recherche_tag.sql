
CREATE TABLE `recherche_tag` (
                               `id_recherche_tag` int(11) NOT NULL AUTO_INCREMENT,
                               `id_recherche_fk` int(11) NOT NULL,
                               `id_mot_cle_fk` int(11) DEFAULT NULL,
                               `mot_cle` varchar(45) NOT NULL COMMENT 'Tag tel qu''ecrit par l''utilisateur si faute de grappe on le raproche du vrai tag et on le sbeste dans la table tag_avec_faute',
                               `date_creation` datetime NOT NULL,
                               `date_modification` datetime DEFAULT NULL,
                               PRIMARY KEY (`id_recherche_tag`),
                               KEY `tt_id_recherche_fk_INDEX` (`id_recherche_fk`),
                               KEY `tt_id_mot_cle_fk_INDEX` (`id_mot_cle_fk`),
                               KEY `tt_mot_cle_origine` (`mot_cle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

