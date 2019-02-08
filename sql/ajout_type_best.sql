ALTER TABLE `best`
ADD COLUMN `type` ENUM('image', 'video', 'lien', 'autre') NULL DEFAULT 'image' AFTER `id_utilisateur_fk`;

ALTER TABLE `best`
CHANGE COLUMN `type` `type` ENUM('photo', 'image', 'video', 'lien', 'autre') NULL DEFAULT 'photo' ;

update best
set type='photo'
where type = 'image' and id_best < 9999;

ALTER TABLE `best`
CHANGE COLUMN `type` `type` ENUM('photo', 'video', 'lien', 'autre') NULL DEFAULT 'photo' ;
