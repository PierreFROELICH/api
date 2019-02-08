ALTER TABLE `woozbest`.`best`
CHANGE COLUMN `type` `type` ENUM('photo', 'video', 'lien', 'autre', 'geo') NULL DEFAULT 'photo' ;
