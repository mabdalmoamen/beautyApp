ALTER TABLE
    `codies`.`bill_types`
ADD
    COLUMN `total_return_qty` DOUBLE NULL DEFAULT 0 AFTER `is_print`;

ALTER TABLE
    `codies`.`bill_types`
ADD
    COLUMN `main_type_id` BIGINT(20) NULL AFTER `total_return_qty`;

ALTER TABLE
    `codies`.`mixins_info`
ADD
    COLUMN `info_text` VARCHAR(255) NULL DEFAULT NULL AFTER `default_printer`;

ALTER TABLE `codies`.`type_units` DROP FOREIGN KEY `uu_unit_id`;

ALTER TABLE
    `codies`.`type_units`
ADD
    CONSTRAINT `uu_unit_id` FOREIGN KEY (`unit_id`) REFERENCES `codies`.`units` (`unit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
