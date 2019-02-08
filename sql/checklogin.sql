ALTER TABLE `woozbest`.`utilisateur`
DROP COLUMN `debut_session`,
DROP COLUMN `token_session`,
DROP INDEX `token_session_INDEX` ;
