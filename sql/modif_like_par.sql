ALTER TABLE `best_like_par`
ADD COLUMN `date_suppression` DATETIME NULL DEFAULT NULL AFTER `date_modification`;

ALTER TABLE `top_like_par`
ADD COLUMN `date_suppression` DATETIME NULL DEFAULT NULL AFTER `date_modification`;

