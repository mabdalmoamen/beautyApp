ALTER TABLE
    `customers` CHANGE COLUMN `points` `points` DOUBLE NULL DEFAULT '0';

ALTER TABLE `mixins_info`
ADD
    COLUMN `bill_lang` VARCHAR(45) NULL DEFAULT 'ar' AFTER `active_point`;

ALTER TABLE `mixins_info`
ADD
    COLUMN `mixins_background` VARCHAR(255) NULL AFTER `bill_lang`;
