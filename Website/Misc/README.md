# smv
Za projekt Mark Žan in js/
v databazo dodat naloge/
azure host
-- Drop the foreign key constraint
ALTER TABLE `ucilnica` DROP FOREIGN KEY `fk_user_id`;

-- Modify the column to be auto-incremented
ALTER TABLE `user` MODIFY COLUMN id_user INT AUTO_INCREMENT;

-- Recreate the foreign key constraint
ALTER TABLE `ucilnica` ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
