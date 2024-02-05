-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 05, 2024 at 02:00 PM
-- Server version: 5.7.44-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beautytoday9`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `leave_date` timestamp NULL DEFAULT NULL,
  `late_over` double DEFAULT '0',
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `barcodes`
--

CREATE TABLE `barcodes` (
  `id` int(11) NOT NULL,
  `format` varchar(45) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `displayValue` tinyint(1) DEFAULT '0',
  `text` varchar(45) DEFAULT NULL,
  `fontOptions` varchar(45) DEFAULT NULL,
  `font` varchar(45) DEFAULT NULL,
  `textAlign` varchar(45) DEFAULT NULL,
  `textPosition` varchar(45) DEFAULT NULL,
  `textMargin` int(11) DEFAULT NULL,
  `fontSize` int(11) DEFAULT NULL,
  `background` varchar(45) DEFAULT NULL,
  `lineColor` varchar(45) DEFAULT NULL,
  `margin` int(11) DEFAULT NULL,
  `marginTop` int(11) DEFAULT NULL,
  `marginBottom` int(11) DEFAULT NULL,
  `marginLeft` int(11) DEFAULT NULL,
  `marginRight` int(11) DEFAULT NULL,
  `flat` tinyint(1) DEFAULT '0',
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barcodes`
--

INSERT INTO `barcodes` (`id`, `format`, `width`, `height`, `displayValue`, `text`, `fontOptions`, `font`, `textAlign`, `textPosition`, `textMargin`, `fontSize`, `background`, `lineColor`, `margin`, `marginTop`, `marginBottom`, `marginLeft`, `marginRight`, `flat`, `branch_id`) VALUES
(1, 'pharmacode', 4, 100, 1, '022222', 'normal', 'monospace', 'center', 'bottom', 2, 20, '#ffffff', '#000000', 9, NULL, NULL, NULL, NULL, 0, 1),
(2, 'CODE128', 3, 20, 1, '2222', 'normal', 'monospace', 'center', 'bottom', -10, 35, '#ffffff', '#000000', 9, NULL, NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_no` bigint(20) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `cust_id` bigint(20) DEFAULT NULL,
  `bill_sum` double DEFAULT '0' COMMENT 'Tha actual sum for the bill',
  `bill_discount` double DEFAULT '0',
  `bill_total` double DEFAULT '0' COMMENT 'The summation after discount',
  `bill_date` datetime DEFAULT NULL,
  `bill_is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `bill_extra` double DEFAULT '0',
  `bill_remain_val` double DEFAULT NULL,
  `bill_paid_val` double DEFAULT NULL,
  `delete_date` date DEFAULT NULL,
  `bill_notes` text,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `bill_vat_val` double DEFAULT NULL,
  `bill_paid_type` tinyint(1) DEFAULT '1',
  `cust_balance_after` double DEFAULT NULL,
  `cust_balance_before` varchar(45) DEFAULT NULL,
  `mixins_store` int(11) DEFAULT NULL,
  `hold_bill` tinyint(1) DEFAULT '0',
  `total_returned` double DEFAULT '0',
  `all_returned_val` double DEFAULT '0',
  `bill_discount_percent` tinyint(1) DEFAULT NULL,
  `returned` tinyint(1) DEFAULT '0',
  `offer_discount` double DEFAULT '0',
  `return_sum` double DEFAULT '0',
  `return_vat` double DEFAULT '0',
  `sale_type` int(11) DEFAULT NULL,
  `sale_discount` double DEFAULT '0',
  `sum_after_discount` double DEFAULT '0',
  `is_included` tinyint(1) DEFAULT '0',
  `vat` double DEFAULT '0',
  `card` double DEFAULT '0',
  `cash` varchar(45) DEFAULT '0',
  `branch_id` int(11) DEFAULT '1',
  `id` bigint(20) DEFAULT '0',
  `worker_id` int(11) DEFAULT NULL,
  `commission` double DEFAULT '0',
  `reserve_date` datetime DEFAULT NULL,
  `pay_from_points` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='The bill for customer';

-- --------------------------------------------------------

--
-- Table structure for table `bill_types`
--

CREATE TABLE `bill_types` (
  `bill_type_id` bigint(20) NOT NULL,
  `bill_no` bigint(20) DEFAULT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `type_count` double DEFAULT '0',
  `type_price` double DEFAULT '0',
  `type_total_price` double DEFAULT '0',
  `type_discount` double DEFAULT '0',
  `type_vat` double DEFAULT '0',
  `type_exp_date` date DEFAULT NULL,
  `sell_unit` int(11) DEFAULT NULL,
  `returned` tinyint(1) DEFAULT '0',
  `returned_qty` double DEFAULT '0',
  `type_cost` double DEFAULT '0',
  `type_note` varchar(555) DEFAULT NULL,
  `returned_total` double DEFAULT '0',
  `without_stock` tinyint(1) DEFAULT NULL,
  `calc_count` double DEFAULT NULL,
  `type_purchases_price` double DEFAULT NULL,
  `type_discount_percent` double DEFAULT '0',
  `is_print` tinyint(1) DEFAULT '1',
  `total_return_qty` double DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `main_type` int(11) DEFAULT NULL,
  `main_type_id` bigint(20) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1',
  `worker_id` int(11) DEFAULT NULL,
  `commission` double DEFAULT '0',
  `reserve_date` datetime DEFAULT NULL,
  `end_reserve_date` datetime DEFAULT NULL,
  `chair_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `currency_ar` varchar(45) DEFAULT NULL,
  `currency_en` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency_ar`, `currency_en`) VALUES
(1, 'ريال', 'Riyal'),
(2, 'دينار', 'Dinar'),
(3, 'درهم', 'Derham'),
(4, 'جنية', 'Pound'),
(5, 'دولار', 'Dollar'),
(6, 'يورو', 'Euro'),
(7, 'فلس', 'Fels'),
(8, 'شيلينغ', 'Shilling'),
(9, 'هللة', 'Halala');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` bigint(20) NOT NULL,
  `cust_name` varchar(50) DEFAULT NULL,
  `cust_mobile` varchar(25) DEFAULT NULL,
  `cust_address` varchar(50) DEFAULT NULL,
  `cust_balance` double DEFAULT '0',
  `cust_discount_val` double DEFAULT '0',
  `cust_discount_percent` double DEFAULT '0',
  `active_customer` tinyint(1) DEFAULT '1',
  `pay_method` int(11) DEFAULT '0',
  `max_balance` double DEFAULT NULL,
  `cust_vat_num` varchar(50) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `identity` varchar(45) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1',
  `points` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Customers for laundry';

-- --------------------------------------------------------

--
-- Table structure for table `customer_pay`
--

CREATE TABLE `customer_pay` (
  `customer_cash_id` bigint(20) NOT NULL,
  `paid_value` double DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `cust_id` bigint(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pay_method` int(11) DEFAULT '0',
  `cust_after_after` double DEFAULT NULL,
  `cust_balance_before` double DEFAULT NULL,
  `is_pay` tinyint(1) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) NOT NULL,
  `expense_title` varchar(255) DEFAULT NULL,
  `expense_cost` double DEFAULT NULL,
  `expense_icon` varchar(255) DEFAULT NULL,
  `expense_date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expense_vat` double DEFAULT NULL,
  `paid_Type` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gusto_stocks`
--

CREATE TABLE `gusto_stocks` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `stock` double DEFAULT '0',
  `type_price` double DEFAULT '0',
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gusto_type_stock`
--

CREATE TABLE `gusto_type_stock` (
  `id` bigint(20) NOT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `stock_id` bigint(20) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `mount` double DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `uid`, `status`, `created_at`, `updated_at`, `branch_id`) VALUES
(10, 5, 0, '2022-10-02 22:49:47', '2022-10-02 22:49:47', 1),
(11, 1, 1, '2022-10-02 23:06:24', '2022-10-02 23:06:24', 1),
(12, 1, 0, '2022-10-19 18:57:29', '2022-10-19 18:57:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2022_06_27_143930_create_bill_types_table', 0),
(2, '2022_06_27_143930_create_bills_table', 0),
(3, '2022_06_27_143930_create_currencies_table', 0),
(4, '2022_06_27_143930_create_customer_pay_table', 0),
(5, '2022_06_27_143930_create_customers_table', 0),
(6, '2022_06_27_143930_create_expenses_table', 0),
(7, '2022_06_27_143930_create_gusto_stocks_table', 0),
(8, '2022_06_27_143930_create_gusto_type_stock_table', 0),
(9, '2022_06_27_143930_create_mixins_cash_table', 0),
(10, '2022_06_27_143930_create_mixins_info_table', 0),
(11, '2022_06_27_143930_create_mixins_item_request_table', 0),
(12, '2022_06_27_143930_create_mixins_main_types_table', 0),
(13, '2022_06_27_143930_create_mixins_purchase_bills_table', 0),
(14, '2022_06_27_143930_create_mixins_roles_table', 0),
(15, '2022_06_27_143930_create_mixins_store_table', 0),
(16, '2022_06_27_143930_create_mixins_suppliers_table', 0),
(17, '2022_06_27_143930_create_mixins_type_stock_table', 0),
(18, '2022_06_27_143930_create_offers_table', 0),
(19, '2022_06_27_143930_create_pay_methods_table', 0),
(20, '2022_06_27_143930_create_purchase_bill_types_table', 0),
(21, '2022_06_27_143930_create_return_types_table', 0),
(22, '2022_06_27_143930_create_returns_table', 0),
(23, '2022_06_27_143930_create_sales_type_table', 0),
(24, '2022_06_27_143930_create_shifts_table', 0),
(25, '2022_06_27_143930_create_table_types_table', 0),
(26, '2022_06_27_143930_create_tables_table', 0),
(27, '2022_06_27_143930_create_tables_bill_table', 0),
(28, '2022_06_27_143930_create_type_units_table', 0),
(29, '2022_06_27_143930_create_types_table', 0),
(30, '2022_06_27_143930_create_types_sold_without_balance_table', 0),
(31, '2022_06_27_143930_create_units_table', 0),
(32, '2022_06_27_143930_create_user_roles_table', 0),
(33, '2022_06_27_143930_create_users_table', 0),
(34, '2022_06_27_143931_add_foreign_keys_to_bill_types_table', 0),
(35, '2022_06_27_143931_add_foreign_keys_to_customer_pay_table', 0),
(36, '2022_06_27_143931_add_foreign_keys_to_gusto_type_stock_table', 0),
(37, '2022_06_27_143931_add_foreign_keys_to_mixins_cash_table', 0),
(38, '2022_06_27_143931_add_foreign_keys_to_return_types_table', 0),
(39, '2022_06_27_143931_add_foreign_keys_to_types_table', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mixins_cash`
--

CREATE TABLE `mixins_cash` (
  `cash_id` bigint(20) NOT NULL,
  `cash_sill_point` double DEFAULT NULL,
  `cash_drawer` double DEFAULT NULL,
  `cash_transfer` double DEFAULT NULL,
  `cash_remain` double DEFAULT NULL,
  `cash_later` double DEFAULT NULL,
  `cash_total` double DEFAULT NULL,
  `start_period` tinyint(1) DEFAULT NULL,
  `end_period` tinyint(1) DEFAULT NULL,
  `cash_end_date` datetime DEFAULT NULL,
  `cash_start_date` datetime DEFAULT NULL,
  `cash_current_user` int(11) DEFAULT NULL,
  `cash_recieve_user` int(11) DEFAULT NULL,
  `deficit_or_increase` double DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mixins_info`
--

CREATE TABLE `mixins_info` (
  `id` int(11) NOT NULL,
  `mixins_name` text,
  `mixins_adress` text,
  `mixins_mobile` text,
  `mixins_vat_val` text,
  `mixins_price_include_vat` tinyint(1) DEFAULT '1',
  `mixins_note` text,
  `main_mixins_store` int(11) DEFAULT NULL,
  `closure_hour` varchar(45) DEFAULT NULL,
  `mixins_logo` varchar(60) DEFAULT NULL,
  `mixins_mac_serial` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `render_bills` tinyint(1) DEFAULT '0',
  `render_new_bill` tinyint(1) DEFAULT '0',
  `render_bill_reports` tinyint(1) DEFAULT '0',
  `render_purchase_bills` tinyint(1) DEFAULT '0',
  `render_purchase_bills_reports` tinyint(1) DEFAULT '0',
  `render_withdraw_cash` tinyint(1) DEFAULT '0',
  `render_cash` tinyint(1) DEFAULT '0',
  `end_support_date` date DEFAULT NULL,
  `mixins_font_size` int(11) DEFAULT '15',
  `mixins_font_color` varchar(45) DEFAULT '#FFF',
  `default_lang` varchar(45) DEFAULT 'ar',
  `bill_with_main_type` tinyint(1) DEFAULT '0',
  `mixins_theme` int(11) DEFAULT '1',
  `render_en_names` tinyint(1) DEFAULT '0',
  `bill_type` tinyint(1) DEFAULT '0',
  `item_request_qty` int(11) DEFAULT NULL,
  `mixins_main_payment_method` int(11) DEFAULT '1',
  `bill_column_num` int(11) DEFAULT '3',
  `render_bill_img` tinyint(1) DEFAULT '1',
  `main_type_column_num` int(11) DEFAULT '2',
  `use_type_uints` tinyint(1) DEFAULT '1',
  `render_bill_note` tinyint(1) DEFAULT NULL,
  `render_types_note` tinyint(1) DEFAULT NULL,
  `render_bill_footer_note` tinyint(1) DEFAULT NULL,
  `partition_folder` varchar(45) DEFAULT 'E',
  `contruct_no` varchar(255) DEFAULT NULL,
  `render_cash_point` tinyint(1) DEFAULT '1',
  `logo_width` int(11) DEFAULT '250',
  `logo_height` int(11) DEFAULT '250',
  `type_discount` int(11) DEFAULT '0',
  `bill_discount` int(11) DEFAULT '0',
  `show_reset_btn` tinyint(1) DEFAULT '0',
  `active_type_offer` tinyint(1) DEFAULT NULL,
  `offer_start_date` date DEFAULT NULL,
  `offer_end_date` date DEFAULT NULL,
  `offer_value` int(11) DEFAULT '0',
  `offer_percenet` int(11) DEFAULT '0',
  `active_offer` tinyint(1) DEFAULT '0',
  `fixed_vat` tinyint(1) DEFAULT NULL,
  `process_bills` tinyint(1) DEFAULT '1',
  `currency` int(11) DEFAULT NULL,
  `digit` varchar(45) DEFAULT '00',
  `mixins_name_en` text,
  `mixins_adress_en` text,
  `printer_type` tinyint(1) DEFAULT '1',
  `email_from` varchar(255) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `send_time` varchar(45) DEFAULT NULL,
  `reqeust_alert` tinyint(1) DEFAULT NULL,
  `weight_barcode` tinyint(1) DEFAULT NULL,
  `weight_barcode_count` varchar(45) DEFAULT NULL,
  `weight` tinyint(1) DEFAULT NULL,
  `codies_type` tinyint(1) DEFAULT '1',
  `country` tinyint(1) DEFAULT '0',
  `sale_type` int(11) DEFAULT NULL,
  `show_side_menu` tinyint(1) DEFAULT '1',
  `as_card` tinyint(1) DEFAULT '0',
  `count_in_row_bill` varchar(45) DEFAULT 'col-4',
  `count_in_row_main` varchar(45) DEFAULT 'col-4',
  `printer_count` int(11) DEFAULT '1',
  `pretty` tinyint(1) DEFAULT '1',
  `smoken_vat` tinyint(1) NOT NULL DEFAULT '0',
  `active_distributing` int(11) DEFAULT '0',
  `default_printer` varchar(45) DEFAULT NULL,
  `info_text` varchar(255) DEFAULT NULL,
  `same_type` tinyint(1) DEFAULT '1',
  `point_every` int(11) DEFAULT '10',
  `valid_days` int(11) DEFAULT '90',
  `point_price` int(11) DEFAULT '0',
  `active_point` tinyint(1) DEFAULT '0',
  `bill_lang` varchar(45) DEFAULT 'ar',
  `mixins_background` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mixins_info`
--

INSERT INTO `mixins_info` (`id`, `mixins_name`, `mixins_adress`, `mixins_mobile`, `mixins_vat_val`, `mixins_price_include_vat`, `mixins_note`, `main_mixins_store`, `closure_hour`, `mixins_logo`, `mixins_mac_serial`, `image_path`, `render_bills`, `render_new_bill`, `render_bill_reports`, `render_purchase_bills`, `render_purchase_bills_reports`, `render_withdraw_cash`, `render_cash`, `end_support_date`, `mixins_font_size`, `mixins_font_color`, `default_lang`, `bill_with_main_type`, `mixins_theme`, `render_en_names`, `bill_type`, `item_request_qty`, `mixins_main_payment_method`, `bill_column_num`, `render_bill_img`, `main_type_column_num`, `use_type_uints`, `render_bill_note`, `render_types_note`, `render_bill_footer_note`, `partition_folder`, `contruct_no`, `render_cash_point`, `logo_width`, `logo_height`, `type_discount`, `bill_discount`, `show_reset_btn`, `active_type_offer`, `offer_start_date`, `offer_end_date`, `offer_value`, `offer_percenet`, `active_offer`, `fixed_vat`, `process_bills`, `currency`, `digit`, `mixins_name_en`, `mixins_adress_en`, `printer_type`, `email_from`, `email_to`, `send_time`, `reqeust_alert`, `weight_barcode`, `weight_barcode_count`, `weight`, `codies_type`, `country`, `sale_type`, `show_side_menu`, `as_card`, `count_in_row_bill`, `count_in_row_main`, `printer_count`, `pretty`, `smoken_vat`, `active_distributing`, `default_printer`, `info_text`, `same_type`, `point_every`, `valid_days`, `point_price`, `active_point`, `bill_lang`, `mixins_background`) VALUES
(1, 'لمسات ايوان', 'الرياض -حي السعادة', '0500060963', '15', 1, NULL, 2, '00', 'backend/mixins/1679878700.jpeg', '6479_A7FF_F000_4675', NULL, 1, 1, 1, 0, 0, 0, 0, '2021-12-16', 20, 'white', 'ar', 1, 0, 0, 1, 1, NULL, 3, 1, 2, 1, NULL, NULL, NULL, 'E', '000000000', 1, 125, 125, 0, 0, 0, 0, '2022-05-01', '2022-10-22', 0, 0, 0, 1, 1, 1, '2', NULL, NULL, 1, 'chaircoder@gmail.com', NULL, '22:50', 0, 0, '13', 0, 0, 2, 1, 1, 0, 'col-4', 'col-2', 1, 0, 0, 1, NULL, NULL, 1, 10, 90, 0, 0, 'ar', NULL),
(2, 'مطعم لمسات هلية - فرع ضرما', 'حى الورود - شارع الملك عبدالعزيز', '0561420027- 0562710488', '15', 1, NULL, 2, '00', 'backend/mixins/1673969198.jpeg', '6479_A7FF_F000_4675', NULL, 1, 1, 1, 0, 0, 0, 0, '2023-12-16', 20, 'white', 'ar', 1, 0, 0, 1, 1, 1, 3, 1, 2, 1, NULL, NULL, NULL, 'E', '300489989300003', 1, 125, 125, 0, 0, 0, 0, '2022-05-01', '2022-10-22', 0, 0, 0, 1, 1, 1, '2', NULL, NULL, 1, 'chaircoder@gmail.com', NULL, '16:52', 0, 1, '12', 1, 0, 2, 2, 1, 0, 'col-4', 'col-2', 1, 0, 0, 1, 'Microsoft Print to PDF', NULL, 1, 10, 90, 0, 0, 'ar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mixins_item_request`
--

CREATE TABLE `mixins_item_request` (
  `mixins_item_request_id` int(11) NOT NULL,
  `add_to_request` tinyint(1) DEFAULT '1',
  `type_request` bigint(20) DEFAULT NULL,
  `added_request_date` date DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mixins_main_types`
--

CREATE TABLE `mixins_main_types` (
  `main_type_id` int(11) NOT NULL,
  `main_type_title_ar` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `main_type_title_en` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `printer_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT 'kitchen',
  `number_of_copies` int(11) DEFAULT '1',
  `branch_id` int(11) DEFAULT '1',
  `type_icon` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mixins_purchase_bills`
--

CREATE TABLE `mixins_purchase_bills` (
  `purchase_bill_no` bigint(20) NOT NULL,
  `supplier_name` int(11) DEFAULT NULL,
  `bill_serial` varchar(255) DEFAULT NULL,
  `bill_sum` double DEFAULT NULL,
  `bill_discount` double DEFAULT NULL,
  `bill_extra` varchar(45) DEFAULT NULL,
  `bill_vat_val` double DEFAULT NULL,
  `bill_total` double DEFAULT NULL,
  `bill_paid_val` double DEFAULT NULL,
  `bill_remain_val` double DEFAULT NULL,
  `bill_paid_type` varchar(45) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mixins_purchase_billscol` double DEFAULT NULL,
  `bill_notes` text,
  `deleted_bill` tinyint(1) DEFAULT '0',
  `mixins_store` int(11) DEFAULT NULL,
  `purchase_img` varchar(45) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mixins_roles`
--

CREATE TABLE `mixins_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_admin_role` tinyint(1) DEFAULT '1',
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mixins_roles`
--

INSERT INTO `mixins_roles` (`role_id`, `role_name`, `is_admin_role`, `branch_id`) VALUES
(1, 'الأصناف', 1, 1),
(2, 'الإعدادات', 1, 1),
(3, 'فواتير البيع', 1, 1),
(4, 'اعدادات الباركود', 1, 1),
(5, 'مرتجعات البيع', 1, 1),
(6, 'أصناف مباعة بدون رصيد', 1, 1),
(7, 'فواتير الشراء', 1, 1),
(8, 'تقرير المبيعات', 1, 1),
(9, 'صرف نقدية', 1, 1),
(10, 'العملاء', 1, 1),
(11, 'المستخدمون', 1, 1),
(12, 'خصم ع الفاتورة', 1, 1),
(13, 'توريد نقدية', 1, 1),
(14, 'تعديل العملاء', 1, 1),
(15, 'الصلاحيات', 1, 1),
(16, 'تعديل المستخدمون', 1, 1),
(17, 'حذف مستخدم', 1, 1),
(18, 'حذف فاتورة', 1, 1),
(19, 'اعادة الطباعة', 1, 1),
(20, 'حذف عميل', 1, 1),
(21, 'ايقاف  \\تفعيل العملاء', 1, 1),
(22, 'تعديل سعر البيع ', 1, 1),
(23, 'نقطة البيع', 1, 1),
(24, 'اظهار كلمات المرور', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mixins_store`
--

CREATE TABLE `mixins_store` (
  `mixins_store_id` int(11) NOT NULL,
  `mixins_store_name` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mixins_store`
--

INSERT INTO `mixins_store` (`mixins_store_id`, `mixins_store_name`, `branch_id`) VALUES
(1, 'منفذ البيع', 1),
(2, 'مخزن ترانزيت', 1),
(3, 'المخزن', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mixins_suppliers`
--

CREATE TABLE `mixins_suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(45) NOT NULL,
  `supplier_mobile` varchar(45) NOT NULL,
  `supplier_total_withdrawals` double DEFAULT NULL,
  `supplier_total_paid` double DEFAULT NULL,
  `supplier_total_remain` double DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mixins_type_stock`
--

CREATE TABLE `mixins_type_stock` (
  `mixins_type_stock_id` bigint(20) NOT NULL,
  `mixins_type_stock` double DEFAULT '0',
  `type_stock_id` bigint(20) DEFAULT NULL,
  `type_exp_date` date DEFAULT NULL,
  `mixins_store` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `types_id` bigint(20) NOT NULL,
  `note` text,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `main_type` bigint(20) DEFAULT NULL,
  `sup_type` bigint(20) DEFAULT NULL,
  `offer_discount_percent` int(11) DEFAULT NULL,
  `main_type_count` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pay_methods`
--

CREATE TABLE `pay_methods` (
  `id` int(11) NOT NULL,
  `pay_method_name` varchar(45) DEFAULT NULL,
  `pay_method_name_en` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pay_methods`
--

INSERT INTO `pay_methods` (`id`, `pay_method_name`, `pay_method_name_en`) VALUES
(1, 'كاش/Cash', 'Cash'),
(2, 'شبكة/Card', 'Card'),
(3, 'آجل/Later', 'Later'),
(4, 'تقسيم/Mixed', 'Mixed');

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` int(11) NOT NULL,
  `point_count` int(11) DEFAULT NULL,
  `user_id` bigint(10) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `is_valid` tinyint(1) DEFAULT '1',
  `valid_to` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_bill_types`
--

CREATE TABLE `purchase_bill_types` (
  `purchase_bill_types_id` bigint(20) NOT NULL,
  `purchase_bills` bigint(20) DEFAULT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `type_count` double DEFAULT NULL,
  `type_purchase_price` double DEFAULT NULL,
  `type_sill_price` double DEFAULT NULL,
  `total_purchase_price` double DEFAULT NULL,
  `type_vat` double DEFAULT NULL,
  `mixins_type_stock` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `recover_password`
--

CREATE TABLE `recover_password` (
  `id` int(11) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `return_id` bigint(20) NOT NULL,
  `bill_no` bigint(20) DEFAULT NULL,
  `vat` bigint(20) DEFAULT NULL,
  `sum` double DEFAULT '0',
  `total` double DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `returns_date` datetime DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `return_types`
--

CREATE TABLE `return_types` (
  `return_type_id` bigint(20) NOT NULL,
  `return_id` bigint(20) DEFAULT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `type_count` double DEFAULT '0',
  `type_price` double DEFAULT '0',
  `type_total_price` double DEFAULT '0',
  `type_discount` double DEFAULT '0',
  `type_vat` double DEFAULT '0',
  `type_exp_date` date DEFAULT NULL,
  `sell_unit` int(11) DEFAULT NULL,
  `returned` tinyint(1) DEFAULT '0',
  `returned_qty` double DEFAULT '0',
  `type_cost` double DEFAULT '0',
  `type_note` varchar(555) DEFAULT NULL,
  `returned_total` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sales_type`
--

CREATE TABLE `sales_type` (
  `id` int(11) NOT NULL,
  `sill_type_name` varchar(45) DEFAULT NULL,
  `cost` double DEFAULT '0',
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_type`
--

INSERT INTO `sales_type` (`id`, `sill_type_name`, `cost`, `branch_id`) VALUES
(1, 'سفري', 0, 1),
(2, 'محلي', 0, 1),
(3, 'هنجر', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) NOT NULL,
  `current_user` int(11) DEFAULT NULL,
  `recived_user` int(11) DEFAULT NULL,
  `starter_point` double DEFAULT NULL,
  `cash` double DEFAULT '0',
  `later` double DEFAULT '0',
  `card` double DEFAULT '0',
  `transfer` double DEFAULT '0',
  `increase` double DEFAULT '0',
  `deficit` double DEFAULT '0',
  `remain` double DEFAULT '0',
  `starter_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1',
  `cash_entered` varchar(45) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) NOT NULL,
  `table_no` varchar(255) DEFAULT NULL,
  `room` varchar(255) DEFAULT NULL,
  `is_resrved` tinyint(1) DEFAULT '0',
  `mini_charge` decimal(8,0) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `isNoty` tinyint(1) DEFAULT '0',
  `branch_id` int(11) DEFAULT '1',
  `reserve_date` datetime DEFAULT NULL,
  `end_reserve_date` datetime DEFAULT NULL,
  `is_chair` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='The bill for customer';

-- --------------------------------------------------------

--
-- Table structure for table `tables_bill`
--

CREATE TABLE `tables_bill` (
  `id` bigint(20) NOT NULL,
  `table_id` bigint(20) DEFAULT NULL,
  `cust_id` bigint(20) DEFAULT NULL,
  `bill_sum` double DEFAULT '0' COMMENT 'Tha actual sum for the bill',
  `bill_total` double DEFAULT '0' COMMENT 'The summation after discount',
  `bill_extra` double DEFAULT '0',
  `bill_notes` text,
  `user_id` int(11) DEFAULT NULL,
  `bill_date` datetime DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1',
  `bill_paid_val` double DEFAULT '0',
  `bill_remain_val` double DEFAULT '0',
  `bill_paid_type` tinyint(1) DEFAULT '1',
  `bill_vat_val` double DEFAULT '0',
  `bill_discount` double DEFAULT '0',
  `offer_discount` double DEFAULT '0',
  `sum_after_discount` double DEFAULT '0',
  `bill_discount_percent` double DEFAULT '0',
  `card` double DEFAULT NULL,
  `cash` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='The bill for customer';

-- --------------------------------------------------------

--
-- Table structure for table `table_types`
--

CREATE TABLE `table_types` (
  `table_type_id` bigint(20) NOT NULL,
  `table_bill_id` bigint(20) DEFAULT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `type_count` double DEFAULT '0',
  `type_price` double DEFAULT '0',
  `type_total_price` double DEFAULT '0',
  `type_discount` double DEFAULT '0',
  `type_vat` double DEFAULT '0',
  `sell_unit` int(11) DEFAULT NULL,
  `type_cost` double DEFAULT '0',
  `type_note` varchar(555) DEFAULT NULL,
  `type_purchases_price` double DEFAULT '0',
  `type_unit_id` int(11) DEFAULT NULL,
  `type_vat_percent` int(11) DEFAULT '0',
  `is_print` tinyint(1) DEFAULT '0',
  `reserve_date` datetime DEFAULT NULL,
  `end_reserve_date` datetime DEFAULT NULL,
  `chair_id` int(11) DEFAULT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `commission` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `type_id` bigint(20) NOT NULL,
  `type_name_ar` varchar(200) DEFAULT NULL,
  `type_name_en` varchar(100) DEFAULT NULL,
  `type_icon` varchar(100) DEFAULT NULL,
  `type_location` int(11) DEFAULT '0',
  `type_purchases_price` double DEFAULT '0',
  `type_count` double DEFAULT '0',
  `type_has_vat` tinyint(1) NOT NULL DEFAULT '1',
  `type_vat_value` double NOT NULL DEFAULT '0',
  `type_vat_percent` int(11) DEFAULT '0',
  `type_note` varchar(255) DEFAULT NULL,
  `type_sill_price` double DEFAULT '0',
  `type_discount_value` double DEFAULT '0',
  `type_discount_percent` int(11) DEFAULT '0',
  `total_type_cost` double DEFAULT '0',
  `type_barcode` varchar(45) DEFAULT NULL,
  `type_unit` int(11) DEFAULT NULL,
  `type_exp_date` date DEFAULT NULL,
  `main_type` int(11) DEFAULT NULL,
  `sell_unit` int(11) DEFAULT NULL,
  `lg_unit` varchar(255) DEFAULT 'وحدة كبرى',
  `md_unit` varchar(255) DEFAULT 'وحدة كبرى',
  `no_md_unit` int(11) DEFAULT '1',
  `sm_unit` varchar(255) DEFAULT 'وحدة كبرى',
  `no_sm_unit` int(11) DEFAULT '1',
  `diff_md_unit_price` double DEFAULT '0',
  `diff_sm_unit_price` double DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `minimum_sill_price` double DEFAULT '0',
  `type_code` varchar(45) DEFAULT '0',
  `has_offer` tinyint(1) DEFAULT '0',
  `calc_count` double DEFAULT NULL,
  `is_print` tinyint(1) DEFAULT '0',
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='types';

-- --------------------------------------------------------

--
-- Table structure for table `types_sold_without_balance`
--

CREATE TABLE `types_sold_without_balance` (
  `types_sold_without_balance_id` bigint(20) NOT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_units`
--

CREATE TABLE `type_units` (
  `type_unit_id` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `no_of_unit` int(11) DEFAULT NULL,
  `deff_price` double DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL,
  `unit_ar_name` varchar(255) DEFAULT NULL,
  `unit_en_name` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `tables` tinyint(1) DEFAULT '1',
  `sales` tinyint(1) DEFAULT '1',
  `mobile` varchar(45) DEFAULT NULL,
  `salary` double DEFAULT NULL,
  `full_name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `is_user` tinyint(1) DEFAULT '1',
  `hour_price` varchar(45) DEFAULT NULL,
  `work_hour_count` varchar(45) DEFAULT NULL,
  `jop_title` varchar(45) DEFAULT NULL,
  `bill_details` tinyint(1) DEFAULT '0',
  `bills` tinyint(1) DEFAULT '0',
  `new_bill` tinyint(1) DEFAULT '0',
  `puraches_bill` tinyint(1) DEFAULT '0',
  `expenses` tinyint(1) DEFAULT '0',
  `puraches_bills` tinyint(1) DEFAULT '0',
  `customers` tinyint(1) DEFAULT '0',
  `delete_customer` tinyint(1) DEFAULT '0',
  `edit_customer` tinyint(1) DEFAULT '0',
  `create_customer` tinyint(1) DEFAULT '0',
  `users` tinyint(1) DEFAULT '0',
  `delete_user` tinyint(1) DEFAULT '0',
  `edit_user` tinyint(1) DEFAULT '0',
  `create_user` tinyint(1) DEFAULT '0',
  `user_roles` tinyint(1) DEFAULT '0',
  `change_price` tinyint(1) DEFAULT '0',
  `types` tinyint(1) DEFAULT '0',
  `create_type` tinyint(1) DEFAULT '0',
  `delete_type` tinyint(1) DEFAULT '0',
  `edit_type` tinyint(1) DEFAULT '0',
  `reports` tinyint(1) DEFAULT '0',
  `daily_report` tinyint(1) DEFAULT '0',
  `monthly_report` tinyint(1) DEFAULT '0',
  `bills_report` tinyint(1) DEFAULT '0',
  `puraches_bill_report` tinyint(1) DEFAULT '0',
  `expenses_reports` tinyint(1) DEFAULT '0',
  `process_bill` tinyint(1) DEFAULT '0',
  `process_bill_report` tinyint(1) DEFAULT '0',
  `stock` tinyint(1) DEFAULT '0',
  `pay_bill` tinyint(1) DEFAULT '0',
  `remove_from_cart` tinyint(1) DEFAULT '0',
  `bill_discount` tinyint(1) DEFAULT '0',
  `type_discount` tinyint(1) DEFAULT '0',
  `bill_extra` tinyint(1) DEFAULT '0',
  `shift` tinyint(1) DEFAULT '0',
  `shift_report` tinyint(1) DEFAULT '0',
  `customer_pay` tinyint(1) DEFAULT '0',
  `customer_pay_report` tinyint(1) DEFAULT '0',
  `suppliers` tinyint(1) DEFAULT '0',
  `supplier_report` tinyint(1) DEFAULT '0',
  `create_supplier` tinyint(1) DEFAULT '0',
  `edit_supplier` tinyint(1) DEFAULT '0',
  `delete_supplier` tinyint(1) DEFAULT '0',
  `settings` tinyint(1) DEFAULT '0',
  `period_report` tinyint(1) DEFAULT '0',
  `units` tinyint(1) DEFAULT '0',
  `create_unit` tinyint(1) DEFAULT '0',
  `add_unit` tinyint(1) DEFAULT '0',
  `edit_unit` tinyint(1) DEFAULT '0',
  `offers` tinyint(1) DEFAULT '0',
  `create_offer` tinyint(1) DEFAULT '0',
  `edit_offer` tinyint(1) DEFAULT '0',
  `delete_offer` tinyint(1) DEFAULT '0',
  `barcode_settings` tinyint(1) DEFAULT '0',
  `print_barcode` tinyint(1) DEFAULT '0',
  `reprint_bill` tinyint(1) DEFAULT '0',
  `main_types` tinyint(1) DEFAULT '0',
  `create_main_type` tinyint(1) DEFAULT '0',
  `edit_main_type` tinyint(1) DEFAULT '0',
  `delete_unit` tinyint(1) DEFAULT '0',
  `delete_main_type` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `pin_code` varchar(255) DEFAULT NULL,
  `change_type_in_kitchen` tinyint(1) DEFAULT '0',
  `resend` tinyint(1) DEFAULT '0',
  `delete_reserved_type` tinyint(1) DEFAULT '0',
  `delete_bill` tinyint(1) DEFAULT '0',
  `branch_id` int(11) DEFAULT '1',
  `android_printer` tinyint(1) DEFAULT '0',
  `commission` varchar(45) DEFAULT '0',
  `is_percent_commission` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `is_admin`, `tables`, `sales`, `mobile`, `salary`, `full_name`, `email`, `is_user`, `hour_price`, `work_hour_count`, `jop_title`, `bill_details`, `bills`, `new_bill`, `puraches_bill`, `expenses`, `puraches_bills`, `customers`, `delete_customer`, `edit_customer`, `create_customer`, `users`, `delete_user`, `edit_user`, `create_user`, `user_roles`, `change_price`, `types`, `create_type`, `delete_type`, `edit_type`, `reports`, `daily_report`, `monthly_report`, `bills_report`, `puraches_bill_report`, `expenses_reports`, `process_bill`, `process_bill_report`, `stock`, `pay_bill`, `remove_from_cart`, `bill_discount`, `type_discount`, `bill_extra`, `shift`, `shift_report`, `customer_pay`, `customer_pay_report`, `suppliers`, `supplier_report`, `create_supplier`, `edit_supplier`, `delete_supplier`, `settings`, `period_report`, `units`, `create_unit`, `add_unit`, `edit_unit`, `offers`, `create_offer`, `edit_offer`, `delete_offer`, `barcode_settings`, `print_barcode`, `reprint_bill`, `main_types`, `create_main_type`, `edit_main_type`, `delete_unit`, `delete_main_type`, `status`, `pin_code`, `change_type_in_kitchen`, `resend`, `delete_reserved_type`, `delete_bill`, `branch_id`, `android_printer`, `commission`, `is_percent_commission`) VALUES
(-1, 'codies', '$2y$10$zYygvrgsUDrhu/MLJq.ZH.CyEnHp59CYxFX5EOe92bUcaJbr7UT6O', 1, 1, 1, '01002208627', 0, NULL, 'codeis.solutions@gmail.com', 100, '5', '8', NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, NULL, 1, 1, 1, 1, 1, 0, '0', 0),
(1, 'admin', '$2y$10$0zStbIwSk71QfXo7DtnFF.RGPdYhfl1OheV2AGNsBto/tnnmPGRGO', 1, 1, 1, NULL, 0, NULL, NULL, 1, '0', '8', NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, 1, 1, 1, 1, 0, '0', 0),
(2, 'user', '$2y$10$6HYkvaL82zXhLsF1gKgap..F.9cfSdAEYGJBiG2cc0aMPp.VUxWPy', 0, 1, 1, NULL, 0, NULL, NULL, 1, '0', '8', NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, NULL, 1, 1, 1, 1, 1, 0, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_role_id` int(11) NOT NULL,
  `mixins_role` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_role_id`, `mixins_role`, `user_id`, `branch_id`) VALUES
(27, 24, 1, 1),
(39, 3, 1, 1),
(41, 5, 1, 1),
(43, 7, 1, 1),
(44, 8, 1, 1),
(45, 9, 1, 1),
(46, 10, 1, 1),
(47, 22, 1, 1),
(50, 11, 1, 1),
(51, 16, 1, 1),
(52, 15, 1, 1),
(53, 1, 1, 1),
(54, 2, 1, 1),
(55, 12, 1, 1),
(56, 13, 1, 1),
(57, 14, 1, 1),
(58, 17, 1, 1),
(59, 4, 1, 1),
(60, 6, 1, 1),
(61, 18, 1, 1),
(62, 19, 1, 1),
(63, 20, 1, 1),
(64, 21, 1, 1),
(65, 23, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid2s_idx` (`uid`);

--
-- Indexes for table `barcodes`
--
ALTER TABLE `barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_no`),
  ADD KEY `bill_cust_idx` (`cust_id`),
  ADD KEY `bill_user_idx` (`user_id`),
  ADD KEY `bill_store_idx` (`mixins_store`),
  ADD KEY `stype_idx` (`sale_type`);

--
-- Indexes for table `bill_types`
--
ALTER TABLE `bill_types`
  ADD PRIMARY KEY (`bill_type_id`),
  ADD KEY `bill_no_idx` (`bill_no`),
  ADD KEY `bill_type_id_idx` (`type_id`),
  ADD KEY `cr_id` (`created_at`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `customer_pay`
--
ALTER TABLE `customer_pay`
  ADD PRIMARY KEY (`customer_cash_id`),
  ADD KEY `for_cust_id_idx` (`cust_id`),
  ADD KEY `for_user_id_idx` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exp_user_id_idx` (`user_id`);

--
-- Indexes for table `gusto_stocks`
--
ALTER TABLE `gusto_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gusto_type_stock`
--
ALTER TABLE `gusto_type_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `for_type_id_idx` (`type_id`),
  ADD KEY `for_stoc_id_idx` (`stock_id`),
  ADD KEY `for_op_id_idx` (`unit_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid_idx` (`uid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mixins_cash`
--
ALTER TABLE `mixins_cash`
  ADD PRIMARY KEY (`cash_id`),
  ADD KEY `curr_user_idx` (`cash_current_user`),
  ADD KEY `re_user_idx` (`cash_recieve_user`);

--
-- Indexes for table `mixins_info`
--
ALTER TABLE `mixins_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curr_id_idx` (`currency`),
  ADD KEY `pay_method_idx` (`mixins_main_payment_method`),
  ADD KEY `pay_method_idsx` (`mixins_main_payment_method`),
  ADD KEY `salType_idx` (`sale_type`);

--
-- Indexes for table `mixins_item_request`
--
ALTER TABLE `mixins_item_request`
  ADD PRIMARY KEY (`mixins_item_request_id`),
  ADD KEY `type_request_id_idx` (`type_request`),
  ADD KEY `type_request_id_idxs` (`type_request`),
  ADD KEY `type_request_id_id_idx` (`type_request`),
  ADD KEY `type_request_id_idsx` (`type_request`),
  ADD KEY `type_requests_id_idsx` (`type_request`);

--
-- Indexes for table `mixins_main_types`
--
ALTER TABLE `mixins_main_types`
  ADD PRIMARY KEY (`main_type_id`);

--
-- Indexes for table `mixins_purchase_bills`
--
ALTER TABLE `mixins_purchase_bills`
  ADD PRIMARY KEY (`purchase_bill_no`),
  ADD KEY `p_user_id_idx` (`user_id`),
  ADD KEY `p_supp_id_idx` (`supplier_name`);

--
-- Indexes for table `mixins_roles`
--
ALTER TABLE `mixins_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `mixins_store`
--
ALTER TABLE `mixins_store`
  ADD PRIMARY KEY (`mixins_store_id`),
  ADD UNIQUE KEY `mixins_stoke_name_UNIQUE` (`mixins_store_name`);

--
-- Indexes for table `mixins_suppliers`
--
ALTER TABLE `mixins_suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `mixins_type_stock`
--
ALTER TABLE `mixins_type_stock`
  ADD PRIMARY KEY (`mixins_type_stock_id`),
  ADD KEY `type_stoke_id_idx` (`type_stock_id`),
  ADD KEY `mixins_store_id_idx` (`mixins_store`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tpe_id_note_idx` (`types_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `off_main_type_idx` (`main_type`),
  ADD KEY `off_sub_type_idx` (`sup_type`);

--
-- Indexes for table `pay_methods`
--
ALTER TABLE `pay_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_bill_types`
--
ALTER TABLE `purchase_bill_types`
  ADD PRIMARY KEY (`purchase_bill_types_id`),
  ADD KEY `purchase_bills_id_idx` (`purchase_bills`),
  ADD KEY `purchase_bills_ids_idx` (`purchase_bills`),
  ADD KEY `pur_type_id_idx` (`type_id`);

--
-- Indexes for table `recover_password`
--
ALTER TABLE `recover_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `bill_no_idx` (`bill_no`);

--
-- Indexes for table `return_types`
--
ALTER TABLE `return_types`
  ADD PRIMARY KEY (`return_type_id`),
  ADD KEY `return_id_idx` (`return_id`),
  ADD KEY `retur_type_idx` (`type_id`),
  ADD KEY `returs_type_idx` (`type_id`);

--
-- Indexes for table `sales_type`
--
ALTER TABLE `sales_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recived_user_id_idx` (`recived_user`),
  ADD KEY `curr_u_id_idx` (`current_user`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables_bill`
--
ALTER TABLE `tables_bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_user_idx` (`user_id`),
  ADD KEY `tb_cus_idx` (`cust_id`);

--
-- Indexes for table `table_types`
--
ALTER TABLE `table_types`
  ADD PRIMARY KEY (`table_type_id`),
  ADD KEY `table_bill_id_idx` (`table_bill_id`),
  ADD KEY `ta_type_id_idx` (`type_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`),
  ADD UNIQUE KEY `type_barcode_UNIQUE` (`type_barcode`),
  ADD KEY `mainType_idx` (`main_type`);

--
-- Indexes for table `types_sold_without_balance`
--
ALTER TABLE `types_sold_without_balance`
  ADD PRIMARY KEY (`types_sold_without_balance_id`),
  ADD KEY `so_type_id_idx` (`type_id`),
  ADD KEY `sold_type_id_idx` (`type_id`),
  ADD KEY `sold_type_ids_idx` (`type_id`);

--
-- Indexes for table `type_units`
--
ALTER TABLE `type_units`
  ADD PRIMARY KEY (`type_unit_id`),
  ADD UNIQUE KEY `barcode_UNIQUE` (`barcode`),
  ADD KEY `tu_type_id_idx` (`type_id`),
  ADD KEY `uu_unit_id_idx` (`unit_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_role_id`),
  ADD KEY `role_us_id_idx` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barcodes`
--
ALTER TABLE `barcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_no` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_types`
--
ALTER TABLE `bill_types`
  MODIFY `bill_type_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_pay`
--
ALTER TABLE `customer_pay`
  MODIFY `customer_cash_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gusto_stocks`
--
ALTER TABLE `gusto_stocks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gusto_type_stock`
--
ALTER TABLE `gusto_type_stock`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `mixins_cash`
--
ALTER TABLE `mixins_cash`
  MODIFY `cash_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mixins_info`
--
ALTER TABLE `mixins_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mixins_item_request`
--
ALTER TABLE `mixins_item_request`
  MODIFY `mixins_item_request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mixins_main_types`
--
ALTER TABLE `mixins_main_types`
  MODIFY `main_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mixins_purchase_bills`
--
ALTER TABLE `mixins_purchase_bills`
  MODIFY `purchase_bill_no` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mixins_roles`
--
ALTER TABLE `mixins_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `mixins_store`
--
ALTER TABLE `mixins_store`
  MODIFY `mixins_store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mixins_suppliers`
--
ALTER TABLE `mixins_suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mixins_type_stock`
--
ALTER TABLE `mixins_type_stock`
  MODIFY `mixins_type_stock_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_methods`
--
ALTER TABLE `pay_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_bill_types`
--
ALTER TABLE `purchase_bill_types`
  MODIFY `purchase_bill_types_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recover_password`
--
ALTER TABLE `recover_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_types`
--
ALTER TABLE `return_types`
  MODIFY `return_type_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_type`
--
ALTER TABLE `sales_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables_bill`
--
ALTER TABLE `tables_bill`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_types`
--
ALTER TABLE `table_types`
  MODIFY `table_type_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `type_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types_sold_without_balance`
--
ALTER TABLE `types_sold_without_balance`
  MODIFY `types_sold_without_balance_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_units`
--
ALTER TABLE `type_units`
  MODIFY `type_unit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bill_cust` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `bill_store` FOREIGN KEY (`mixins_store`) REFERENCES `mixins_store` (`mixins_store_id`),
  ADD CONSTRAINT `bill_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stype` FOREIGN KEY (`sale_type`) REFERENCES `sales_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
