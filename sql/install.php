<?php
/**
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dsdynamicprice` (
    `id_dsdynamicprice` int(11) NOT NULL AUTO_INCREMENT,
    `main_to` int(11) NOT NULL,
    `id_dsdynamicpriceprint` int(11) NOT NULL,
    `price_a` decimal(17,2) NOT NULL,
	`price_b` decimal(17,2) NOT NULL,
    PRIMARY KEY  (`id_dsdynamicprice`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dsdynamicpriceprint` (
    `id_dsdynamicpriceprint` int(11) NOT NULL,
    `print_scale` VARCHAR(64) NOT NULL,
    PRIMARY KEY  (`id_dsdynamicpriceprint`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dsdynamicprice_configuration` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_specific_price` INT(10) UNSIGNED NOT NULL,
	`two_side_printing` TINYINT(1) NULL DEFAULT NULL,
	`express` TINYINT(1) NULL DEFAULT NULL,
	`same_sides` TINYINT(1) NULL DEFAULT NULL,
	`percent_covarege_first` TINYINT(1) NULL DEFAULT NULL,
	`percent_covarege_second` TINYINT(1) NULL DEFAULT NULL,
	`colors_first` TINYINT(1) NULL DEFAULT NULL,
	`colors_second` TINYINT(1) NULL DEFAULT NULL,
	`file_to_print_first` VARCHAR(256) NULL DEFAULT NULL COLLATE `utf8mb4_general_ci`,
	`file_to_print_second` VARCHAR(256) NULL DEFAULT NULL COLLATE `utf8mb4_general_ci`,
    PRIMARY KEY  (`id`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dsdynamicprice_products` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_configuration` INT(11) NOT NULL,
	`id_cart` INT(11) NOT NULL,
	`id_product` INT(11) NOT NULL,
	`id_product_attribute` INT(11) NOT NULL,
    PRIMARY KEY  (`id`),
	INDEX `FK_' . _DB_PREFIX_ . 'dsdynamicprice_configuration` (`id_configuration`) USING BTREE,
	CONSTRAINT `FK_' . _DB_PREFIX_ . 'dsdynamicprice_configuration` FOREIGN KEY (`id_configuration`) REFERENCES `'._DB_NAME_.'`.`' . _DB_PREFIX_ . 'dsdynamicprice_configuration` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dsdynamicprice_state` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_state` INT(11) NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}


