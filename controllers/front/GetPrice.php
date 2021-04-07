<?php
/**
* Advance Blog
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
*
* @author    Dark-Side.pro
* @copyright Copyright 2017 © Dark-Side.pro All right reserved
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* @category  FO Module
* @package   dsafillate
*/
class DsdynamicpriceGetPriceModuleFrontController extends ModuleFrontController
{
    public $guestAllowed = true;

    public function __construct($response = array())
    {
        parent::__construct($response);
        $this->display_header = false;
        $this->display_header_javascript = false;
        $this->display_footer = false;
    }

    public function initContent()
    {
        
        $this->ajax = true;
        parent::initContent();
    }

    public function postProcess()
    {
        if (!Tools::isSubmit('dsdynamicprice')) {
            return;
        }
        
        $cart = Context::getContext()->cart;
        
        $id_currency = (int) $cart->id_currency;
        $id_product = (int) Tools::getValue('id_product');
        

        if ($id_product === NULL || empty($id_product)) {
            return;
        }

        $id_product_attribute = Tools::getValue('id_product_attribute');
        
        if ($id_product_attribute === NULL) {
            return;
        }

        $id_customization = (int) Tools::getValue('id_product_customization');

        $products = $cart->getProducts(true);
        $quantity = null;
        $id_shop = (int) Context::getContext()->shop->id;

        foreach ($products as $product) {
            if ($product['id_product'] == $id_product && $product['id_product_attribute'] == $id_product_attribute) {
                if ($product['id_customization'] == $id_customization) {
                    $quantity = $product['cart_quantity'];
                }
            }
        }

        if ($quantity === NULL) {
            $product = new Product($id_product);
            $quantity = (int) $product->minimal_quantity;
        }

        if ($id_shop === null) {
            return;
        }

        $twoSidedPrinting = (int) Tools::getValue('twoSidedPrinting');
        $express = (int) Tools::getValue('express');
        $sameSides = (int) Tools::getValue('sameSides');
        $percentToCovaregeFirst = (int) Tools::getValue('percentToCovaregeFirst');
        $percentToCovaregeSecond = (int) Tools::getValue('percentToCovaregeSecond');
        $colorsFirst = (int) Tools::getValue('colorsFirst');
        $colorsSecond = (int) Tools::getValue('colorsSecond');
        $price = $this->module->calc(
            $twoSidedPrinting, 
            $express, 
            $sameSides,
            $percentToCovaregeFirst, 
            $percentToCovaregeSecond, 
            $colorsFirst, 
            $colorsSecond,
            $quantity,
            $id_product,
            $id_product_attribute,
            $id_customization
        );

        if ($price === false) {
            echo Tools::jsonEncode(array('msg' => $this->l('Something gone wrong. Please try again letter.')));
            return;
        }

        echo Tools::jsonEncode(array('msg' => Tools::displayPrice($price)));
    }  
}
