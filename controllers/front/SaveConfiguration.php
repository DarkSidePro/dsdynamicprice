<?php
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <DARK SIDE TEAM> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Poul-Henning Kamp
 * ----------------------------------------------------------------------------
 */

class DsdynamicpriceSaveConfigurationModuleFrontController extends ModuleFrontController
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
        
        if ($cart->id === NULL) {
            echo Tools::jsonEncode(array('error' => $this->l('Empty cart.')));
            return;
        }
        
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
            echo Tools::jsonEncode(array('error' => $this->l('This product is not in the cart.')));
            return;
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
        
        if (!isset($_FILES['fileToPrintFirst'])) {
            return;
        }

        $fileToPrintFirst = $_FILES['fileToPrintFirst'];

        if (!isset($_FILES['fileToPrintSecond'])) {
            return;
        }

        $fileToPrintSecond = $_FILES['fileToPrintSecond'];
        
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
            echo Tools::jsonEncode(array('msg' => $this->l('Something gone wrong.')));
            return;
        }
        
        $fileToPrintFirstName = $this->moveFile($fileToPrintFirst);

        if ($fileToPrintFirstName === 10001) {
            echo Tools::jsonEncode(array('msg' => $this->l('Plik jest pusty.')));
            return;
        }

        if ($fileToPrintFirstName === 10002) {
            echo Tools::jsonEncode(array('msg' => $this->l('Plik jest za duży.')));
            return;
        }
        
        $fileToPrintSecondName = $this->moveFile($fileToPrintSecond);

        if ($twoSidedPrinting == 1) {
            if ($sameSides == 0) {
                if ($fileToPrintSecondName === 10001) {
                    echo Tools::jsonEncode(array('msg' => $this->l('Drugi plik jest pusty.')));
                    return;
                }
        
                if ($fileToPrintSecondName === 10002) {
                    echo Tools::jsonEncode(array('msg' => $this->l('Drugi plik jest za duży.')));
                    return;
                }
            }
        }

        $id_specific_price = $this->module->newSpecificPrice(
                $cart->id, 
                $id_product,
                $id_product_attribute, 
                $price, 
                $quantity, 
                $id_shop, 
                $id_currency,
                $cart
            );

        $isCreated = $this->module->isCreated( 
                $cart->id,
                $id_product, 
                $id_product_attribute, 
                $id_shop, 
                $id_currency,
            );

        if (!empty($isCreated)) {            
            $this->deleteConfiguration($cart->id, $id_product, $id_product_attribute);
        } 

        $configuration = $this->module->saveConfiguration(
            $id_specific_price,
            $cart->id,
            $id_product,
            $id_product_attribute,
            $twoSidedPrinting, 
            $express, 
            $sameSides,
            $percentToCovaregeFirst, 
            $percentToCovaregeSecond, 
            $colorsFirst, 
            $colorsSecond,
            $fileToPrintFirstName, 
            $fileToPrintSecondName
        );

        if ($configuration === false) {
            echo Tools::jsonEncode(array('msg' => $this->l('Coś poszło nie tak. Prosimy spróbuj ponownie później.')));
            return;
        } else {
            echo Tools::jsonEncode(array('success' => $this->l('Konfiguracja druku została zapisana.')));
            return;
        }
    }

    protected function moveFile($file)
    {
        if ($file['size'] == 0) {
           return 10001;
        }

        if ($file['size'] > 2097152) {
            return 10002;
        }

        $temp = explode(".", $file["name"]);
        $newfilename = md5(time()) . '.' . end($temp);
        move_uploaded_file($file["tmp_name"], _PS_UPLOAD_DIR_.$newfilename);

        return $newfilename;
    }

    protected function deleteConfiguration($id_cart, $id_product, $id_product_attribute)
    {
        if (!Validate::isInt($id_cart)) {
            exit();
        }

        if (!Validate::isInt($id_product)) {
            exit();
        }
        
        if (!Validate::isInt($id_product_attribute)) {
            exit();
        }

        $sql = new DbQuery();
        $sql->select('dsp.id_configuration, dsc.id_specific_price, dsc.file_to_print_first, dsc.file_to_print_second')
            ->from('dsdynamicprice_products', 'dsp')
            ->leftJoin('dsdynamicprice_configuration', 'dsc', 'dsp.id_configuration = dsc.id')
            ->where('dsp.id_cart = '.$id_cart.' AND dsp.id_product = '.$id_product.' AND dsp.id_product_attribute = '.$id_product_attribute);
        $data = Db::getInstance()->executeS($sql);

        if (empty($data)) {
            exit();
        }

        $id_configuration = $data[0]['id_configuration'];
        $id_specific_price = $data[0]['id_specific_price'];
        $fileToPrintFirstName = $data[0]['file_to_print_first'];
        $fileToPrintSecondName = $data[0]['file_to_print_second'];

        $sql = 'DELETE FROM '._DB_PREFIX_.'dsdynamicprice_products WHERE id_configuration ='.$id_configuration;
        Db::getInstance()->execute($sql);

        $sql = 'DELETE FROM '._DB_PREFIX_.'dsdynamicprice_configuration WHERE id ='.$id_configuration;
        Db::getInstance()->execute($sql);

        $this->module->deleteSpecificPrice($id_specific_price);
        $this->deleteFile($fileToPrintFirstName);
        $this->deleteFile($fileToPrintSecondName);
    }

    protected function deleteFile($fileName)
    {
        if (file_exists(_PS_UPLOAD_DIR_.$fileName)) {
            unlink(_PS_UPLOAD_DIR_.$fileName);
        }
    }
}
