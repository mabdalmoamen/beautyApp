ALTER TABLE
    `customers` CHANGE COLUMN `points` `points` DOUBLE NULL DEFAULT '0';

ALTER TABLE `mixins_info`
ADD
    COLUMN `bill_lang` VARCHAR(45) NULL DEFAULT 'ar' AFTER `active_point`;

ALTER TABLE `mixins_info`
ADD
    COLUMN `mixins_background` VARCHAR(255) NULL AFTER `bill_lang`;


    ALTER TABLE `mixins_info`
ADD COLUMN `must_insert_worker` TINYINT(1) NULL DEFAULT 1 AFTER `mixins_background`;

ALTER TABLE `mixins_info`
ADD COLUMN `is_for_women` TINYINT(1) NULL DEFAULT 1 AFTER `must_insert_worker`;
