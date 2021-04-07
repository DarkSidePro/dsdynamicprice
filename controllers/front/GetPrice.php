<?php
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <DARK SIDE TEAM> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Poul-Henning Kamp
 * ----------------------------------------------------------------------------
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
