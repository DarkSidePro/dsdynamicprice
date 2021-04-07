<?php
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <DARK SIDE TEAM> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Poul-Henning Kamp
 * ----------------------------------------------------------------------------
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Dsdynamicprice extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dsdynamicprice';
        $this->tab = 'merchandizing';
        $this->version = '1.0.0';
        $this->author = 'Dark-Side.pro';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DS: Dynamic Price');
        $this->description = $this->l('Module DS: Dynamic Price');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DSDYNAMICPRICE_LIVE_MODE', false);
        $this->createTab();
        include dirname(__FILE__).'/sql/install.php';
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayCalculator') && 
            $this->registerHook('displayReassurance') && 
            $this->registerHook('ModuleRoutes') &&
            $this->registerHook('displayAdminOrder') && 
            $this->registerHook('actionBeforeCartUpdateQty');
    }

    public function uninstall()
    {
        Configuration::deleteByName('DSDYNAMICPRICE_LIVE_MODE');
        include dirname(__FILE__).'/sql/uninstall.php';
        $this->tabRem();

        return parent::uninstall();
    }

    private function createTab()
    {
        $response = true;
        $parentTabID = Tab::getIdFromClassName('AdminDarkSideMenu');
        if ($parentTabID) {
            $parentTab = new Tab($parentTabID);
        } else {
            $parentTab = new Tab();
            $parentTab->active = 1;
            $parentTab->name = array();
            $parentTab->class_name = 'AdminDarkSideMenu';
            foreach (Language::getLanguages() as $lang) {
                $parentTab->name[$lang['id_lang']] = 'Dark-Side.pro';
            }
            $parentTab->id_parent = 0;
            $parentTab->module = '';
            $response &= $parentTab->add();
        }
        $parentTab_2ID = Tab::getIdFromClassName('AdminDarkSideMenuSecond');
        if ($parentTab_2ID) {
            $parentTab_2 = new Tab($parentTab_2ID);
        } else {
            $parentTab_2 = new Tab();
            $parentTab_2->active = 1;
            $parentTab_2->name = array();
            $parentTab_2->class_name = 'AdminDarkSideMenuSecond';
            foreach (Language::getLanguages() as $lang) {
                $parentTab_2->name[$lang['id_lang']] = 'Dark-Side Config';
            }
            $parentTab_2->id_parent = $parentTab->id;
            $parentTab_2->module = '';
            $response &= $parentTab_2->add();
        }
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdministratorDsdynamicprice';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = 'DS: Dynamic Price';
        }
        $tab->id_parent = $parentTab_2->id;
        $tab->module = $this->name;
        $response &= $tab->add();

        return $response;
    }

    private function tabRem()
    {
        $id_tab = Tab::getIdFromClassName('AdministratorDsdynamicprice');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            $tab->delete();
        }
        $parentTab_2ID = Tab::getIdFromClassName('AdminDarkSideMenuSecond');
        if ($parentTab_2ID) {
            $tabCount_2 = Tab::getNbTabs($parentTab_2ID);
            if ($tabCount_2 == 0) {
                $parentTab_2 = new Tab($parentTab_2ID);
                $parentTab_2->delete();
            }
        }
        $parentTabID = Tab::getIdFromClassName('AdminDarkSideMenu');
        if ($parentTabID) {
            $tabCount = Tab::getNbTabs($parentTabID);
            if ($tabCount == 0) {
                $parentTab = new Tab($parentTabID);
                $parentTab->delete();
            }
        }

        return true;
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $msg = null;

        if ((bool) Tools::isSubmit('addRangePrice') == true) {
            $msg = (new Dsdynamicprice())->displayConfirmation("Save success");
        }

        if ((bool) Tools::isSubmit('editRangePrice') == true) {
            $msg = (new Dsdynamicprice())->displayConfirmation("Save success");
        }
    
        $this->context->smarty->assign('module_dir', $this->_path);
        $this->context->smarty->assign('link', $this->context->link);
        $this->context->smarty->assign('namemodules', $this->name);

        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitDsdynamicpriceModule')) == true) {
            $this->postProcess();
        }

        if (Tools::isSubmit('deleteRange') == true) {
            $rangeID = Tools::getValue('deleteRange');
            $this->deleteRangePrice($rangeID);
        }

        if (Tools::isSubmit('addRangePrice')) {
            $main_to = Tools::getValue('quantity');
            $id_dsdynamicpriceprint = Tools::getValue('addRangePrice');
            $price_a = Tools::getValue('price_a');
            $price_b = Tools::getValue('price_b');

            $this->createRange($main_to, $id_dsdynamicpriceprint, $price_a, $price_b);
        }

        if (Tools::isSubmit('editRangePrice')) {
            $main_to = Tools::getValue('quantity');
            $price_a = Tools::getValue('price_a');
            $price_b = Tools::getValue('price_b');
            $id_dsdynamicpriceprint = Tools::getValue('print');
            $rangeID = Tools::getValue('editRange');

            $this->updateRange($price_a, $price_b, $main_to, $id_dsdynamicpriceprint, $rangeID);
        }
        
        $token = Tools::getAdminTokenLite('AdministratorDsdynamicprice');
        
        $this->context->smarty->assign('print_one', $this->getRangePrices(0));
        $this->context->smarty->assign('print_two', $this->getRangePrices(1));
        $this->context->smarty->assign('print_three', $this->getRangePrices(2));
        $this->context->smarty->assign('order_states', $this->getOrderStates((int) Configuration::get('PS_LANG_DEFAULT')));
        $this->context->smarty->assign('order_emails', $this->getStates((int) Configuration::get('PS_LANG_DEFAULT')));
        $this->context->smarty->assign('token', $token);
        $this->context->smarty->assign('matrix', Configuration::get('DSDYNAMICPRICE_MATRIX'));
        $this->context->smarty->assign('express', Configuration::get('DSDYNAMICPRICE_EXPRESS'));

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        if ((bool) Tools::isSubmit('addRangePrice') == true) {
            return $msg.$output;
        }

        if (Tools::isSubmit('addRange') == true) {
            $id_dsdynamicpriceprint = Tools::getValue('addRange');

            $this->context->smarty->assign('id_dsdynamicpriceprint', $id_dsdynamicpriceprint);

            $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/add-range.tpl');
        }

        if (Tools::isSubmit('editRange') == true) {
            $rangeID = Tools::getValue('editRange');
            $range = $this->getRangePrice($rangeID);
            $prints = $this->getPrints();

            $this->context->smarty->assign('range', $range);
            $this->context->smarty->assign('prints', $prints);

            $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/edit-range.tpl');
        }

        return $msg.$output;
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    protected function getRangePrices($id_dsdynamicpriceprint)
    {
        $sql = new DbQuery();
        $sql->select('*')
            ->from('dsdynamicprice')
            ->where('id_dsdynamicpriceprint ='.$id_dsdynamicpriceprint);
        $result = Db::getInstance()->ExecuteS($sql);
        return $result;
    }

    protected function getRangePrice($rangeID)
    {
        $sql = new DbQuery();
        $sql->select('*')
            ->from('dsdynamicprice')
            ->where('id_dsdynamicprice ='.$rangeID);
        $result = Db::getInstance()->ExecuteS($sql);

        return $result;
    }

    protected function deleteRangePrice($rangeID)
    {
        $sql = 'DELETE FROM '._DB_PREFIX_.'dsdynamicprice WHERE id_dsdynamicprice ='.$rangeID;
        return Db::getInstance()->execute($sql);
    }

    protected function createRange($main_to, $id_dsdynamicpriceprint, $price_a, $price_b)
    {
        $db = \Db::getInstance();
        $result = $db->insert('dsdynamicprice', array(
            'main_to' => (int) $main_to,
            'id_dsdynamicpriceprint' => $id_dsdynamicpriceprint,
            'price_a' => $price_a,
            'price_b' => $price_b,
        ));
    }

    public function updateRange($price_a, $price_b, $main_to, $id_dsdynamicpriceprint, $rangeID)
    {
        $rangeID = (int) $rangeID;
        $sql = 'UPDATE '._DB_PREFIX_.'dsdynamicprice SET main_to = '.$main_to.' WHERE id_dsdynamicprice = '.$rangeID;
        DB::getInstance()->execute($sql);
        $sql = 'UPDATE '._DB_PREFIX_.'dsdynamicprice SET id_dsdynamicpriceprint = '.$id_dsdynamicpriceprint.' WHERE id_dsdynamicprice = '.$rangeID;
        DB::getInstance()->execute($sql);
        $sql = 'UPDATE '._DB_PREFIX_.'dsdynamicprice SET price_a = '.$price_a.' WHERE id_dsdynamicprice = '.$rangeID;
        DB::getInstance()->execute($sql);
        $sql = 'UPDATE '._DB_PREFIX_.'dsdynamicprice SET price_b = '.$price_b.' WHERE id_dsdynamicprice = '.$rangeID;
        DB::getInstance()->execute($sql);
    }

    public function getPrints()
    {
        $sql = new DbQuery();
        $sql->select('*')
            ->from('dsdynamicpriceprint');
        
        $result = Db::getInstance()->ExecuteS($sql);

        return $result;  
    }

    public function hookModuleRoutes()
    {
        return array(
            'module-dsdynamicprice-getprice' => array(
                'controller' => 'GetPrice',
                'rule' => 'get-price',
                'keywords' => array(),
                'params' => array(
                    'module' => 'dsdynamicprice',
                    'fc' => 'module',
                )
            )
        );
    }

    public function hookDisplayCalculator()
    {
        $prints = $this->getPrints();
        $this->context->smarty->assign('prints', $prints);
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/hook/calculator.tpl');

        return $output;
    }

    public function hookdisplayReassurance()
    {
        if (Context::getContext()->controller->php_self == 'product') {
            return Hook::exec('displayCalculator');
        }

        return;
    }

    protected function getSpecificPrice($rangePrint, $rangeTo, $material)
    {
        $sql = new DbQuery();
        $sql->select('*')
            ->from('dsdynamicprice')
            ->where('id_dsdynamicpriceprint ='.$rangePrint)
            ->where('main_to >='.$rangeTo)
            ->orderBy('main_to')
            ->limit(1);
        $result = Db::getInstance()->ExecuteS($sql);

        if($material == 0) {
            return $result[0]["price_a"];
        } else {
            return $result[0]["price_b"];            
        }        
    }

    public static function calc(
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
        )   
    {
        if (!Validate::isInt($twoSidedPrinting)) {
            return false;
        }

        if (!Validate::isInt($express)) {
            return false;
        }

        if (!Validate::isInt($sameSides)) {
            return false;
        }

        if (!Validate::isInt($percentToCovaregeFirst)) {
            return false;
        }

        if (!Validate::isInt($percentToCovaregeSecond)) {
            return false;
        }

        if (!Validate::isInt($colorsFirst)) {
            return false;
        }

        if (!Validate::isInt($colorsSecond)) {
            return false;
        }

        if (!Validate::isInt($quantity)) {
            return false;
        }

        if (!Validate::isInt($id_product)) {
            return false;
        }

        if (!Validate::isInt($id_product_attribute)) {
            return false;
        }
 
        //Cena podstawowa - do wrzucenia do bazy przez Patryczka i do obsłużenia na zapleczu
        $matrix = Configuration::get('DSDYNAMICPRICE_MATRIX');
        //Expres podstawowy - do wrzucenia do bazy przez Patryczka i do obsłużenia na zapleczu
        $expressValue = Configuration::get('DSDYNAMICPRICE_EXPRESS');
        $specific_price_output = null; //zostawiłem, bo po coś to pewnie chciałeś ;)
        $priceOriginal = Product::getPriceStatic(
                $id_product, 
                false, 
                $id_product_attribute, 
                2, 
                null, 
                false, 
                true, 
                1, 
                false, 
                null, 
                null, 
                null, 
                $specific_price_output, 
                true, 
                true, 
                null, 
                true,
                $id_customization
            );
        $product = new Product($id_product);
        $product_features = $product->getFeatures();
        $featureID = 6;
        $cottonIds = [19, 641, 642, 643, 644, 645];
        $material = null;

        foreach ($product_features as $feature)
        {
            if ($feature['id_feature'] == 6) {
                if (in_array($feature['id_feature_value'], $cottonIds)) {
                    $material = 1;
                }
            }
        }

        if ($material != 1) {
            $material = 0;
        }


        if ($twoSidedPrinting == 0) {
            $price = ($matrix/$quantity+Dsdynamicprice::getSpecificPrice($percentToCovaregeFirst, $quantity, $material))*$colorsFirst+$priceOriginal;
        } else {
            if ($sameSides == 1) {
                $price = ($matrix/$quantity+Dsdynamicprice::getSpecificPrice($percentToCovaregeFirst, $quantity, $material)*2)*$colorsFirst+$priceOriginal;
            } else {
                $price = ($matrix/$quantity+Dsdynamicprice::getSpecificPrice($percentToCovaregeFirst, $quantity, $material))*2*$colorsFirst+$priceOriginal;
            }
        }

        if ($express == 1) {
            $price = $price * $expressValue;
        } 

        return $price;
    }

    protected function getConfigs($id_cart, $id_lang)
    {
        $sql = new DbQuery();
        $sql->select('dsp.*, dsc.*, pl.name as product_name, dp.print_scale as first_print_scale, dpp.print_scale as second_print_scale')
            ->from('dsdynamicprice_products', 'dsp')
            ->leftJoin('dsdynamicprice_configuration', 'dsc', 'dsc.id = dsp.id_configuration')
            ->leftJoin('dsdynamicpriceprint', 'dp', 'dp.id_dsdynamicpriceprint = dsc.percent_covarege_first')
            ->leftJoin('dsdynamicpriceprint', 'dpp', 'dpp.id_dsdynamicpriceprint = dsc.percent_covarege_second')
            ->leftJoin('product_lang', 'pl', 'pl.id_product = dsp.id_product')
            ->where('dsp.id_cart = '.$id_cart.' AND pl.id_lang = '.$id_lang);
        
        return Db::getInstance()->executeS($sql);
    }

    protected function getOrderStates($id_lang)
    {
        $sql = 'SELECT os.id_order_state, os.name 
        FROM ' . _DB_PREFIX_ . 'order_state_lang os
        WHERE NOT EXISTS (
            SELECT * FROM ' . _DB_PREFIX_ . 'dsdynamicprice_state dss WHERE dss.id_state = os.id_order_state) 
        AND os.id_lang ='.$id_lang;
        
        
        return Db::getInstance()->executeS($sql); 
    }

    protected function getStates($id_lang)
    {
        $sql = new DbQuery();
        $sql->select('os.name, dss.id_state')
            ->from('dsdynamicprice_state', 'dss')
            ->leftJoin('order_state_lang', 'os', 'os.id_order_state = dss.id_state')
            ->where('os.id_lang = '.$id_lang);
        
        return Db::getInstance()->executeS($sql); 
    }

    public function dupaMail($message)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <test@new.torbowo.pl>' . "\r\n";
        $to = 'rekrutacjatchorzewski@gmail.com';
        $subject = 'Vardump'.time();

        ob_start();
        print_r($message);
        $dupa = ob_get_clean();


        return mail($to, $subject, $dupa, $headers);
    }

    public function newSpecificPrice(
            $id_cart, 
            $id_product, 
            $id_product_attribute, 
            $price, 
            $quantity, 
            $id_shop, 
            $id_currency,
            $cart
        )
    {
        if (!Validate::isInt($id_cart)) {
            exit();
        }

        if (!Validate::isInt($id_product)) {
            exit();
        }

        if (!Validate::isPrice($price)) {
            exit();
        }

        if (!Validate::isInt($id_shop)) {
            exit();
        }

        if (!Validate::isInt($id_currency)) {
            exit();
        }

        $specific_price = new SpecificPrice();
        $specific_price->id_product = $id_product; // choosen product id
        $specific_price->id_product_attribute = $id_product_attribute; // optional or set to 0
        $specific_price->id_cart = $id_cart;
        $specific_price->from_quantity = $quantity;
        $specific_price->price = $price;
        $specific_price->reduction_type = 'amount';
        $specific_price->reduction_tax = 1;
        $specific_price->reduction = 0;
        $specific_price->from = date("0000-00-00 00:00:00");
        $specific_price->to = date("Y-m-d H:i:s", strtotime('+1 year')); // or set date x days from now
        $specific_price->id_shop = $id_shop;
        $specific_price->id_currency  = $id_currency;
        $specific_price->id_country = 0;
        $specific_price->id_group = 0;
        $specific_price->id_customer = 0;
        $specific_price->add();

        return $specific_price->id;
    }

    public function saveConfiguration(
            $id_specific_price,
            $id_cart,
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
        )
    {
        $sql = Db::getInstance()->insert('dsdynamicprice_configuration', array(
            'id_specific_price' => (int) $id_specific_price,
            'two_side_printing' => (int) $twoSidedPrinting,
            'express' => (int) $express,
            'same_sides' => (int) $sameSides,
            'percent_covarege_first' => (int) $percentToCovaregeFirst,
            'percent_covarege_second' => (int) $percentToCovaregeSecond,
            'colors_first' => (int) $colorsFirst,
            'colors_second' => (int) $colorsSecond,
            'file_to_print_first' => pSQL($fileToPrintFirstName),
            'file_to_print_second' => pSQL($fileToPrintSecondName)
        ));

        $id = Db::getInstance()->Insert_ID();

        if ($sql === false) {
            echo Tools::jsonEncode(array('msg' => 'Something gone wrong.'));
            return;
        }

        $sql = Db::getInstance()->insert('dsdynamicprice_products', array(
            'id_configuration' => (int) $id,
            'id_cart' => (int) $id_cart,
            'id_product' => (int) $id_product,
            'id_product_attribute' => (int) $id_product_attribute,
        ));

        if ($sql === false) {
            echo Tools::jsonEncode(array('msg' => 'Something gone wrong.'));
            return;
        }
    }

    public function isCreated(
            $id_cart, 
            $id_product, 
            $id_product_attribute, 
            $id_shop, 
            $id_currency
        )
    {
        if (!Validate::isInt($id_cart)) {
            exit();
        }

        if (!Validate::isInt($id_product)) {
            exit();
        }

        if(!Validate::isInt($id_product)) {
            exit();
        }

        if (!Validate::isInt($id_shop)) {
            exit();
        }

        if (!Validate::isInt($id_currency)) {
            exit();
        }

        $sql = new DbQuery();
        $sql->select('ds.*')
            ->from('dsdynamicprice_configuration', 'ds')
            ->leftJoin('specific_price', 'sp', 'sp.id_specific_price = ds.id_specific_price')
            ->where('sp.id_cart = '.$id_cart.' AND 
                sp.id_product = '.$id_product.' AND 
                sp.id_product_attribute = '.$id_product_attribute.' AND 
                sp.id_shop = '.$id_shop.' AND 
                sp.id_currency = '.$id_currency.''
            );

        return Db::getInstance()->executeS($sql);
    }

    public function deleteSpecificPrice($id_specific_price)
    {
        if (!Validate::isInt($id_specific_price)) {
            exit();
        }

        $specific_price = new SpecificPrice();
        $specific_price->id = $id_specific_price;
        
        return $specific_price->delete();
    }

    public function hookActionBeforeCartUpdateQty()
    {
        $cart = Context::getContext()->cart;
        $id_cart = $cart->id;
        $products = $cart->getProducts(true);
        $id_currency =  $cart->id_currency;
        $id_shop = (int) Context::getContext()->shop->id;
        $id_product = null;
        $id_customization = null;
        $id_product_attribute = null;
        $quantity = null;        

        foreach ($products as $product) {
            $id_product = $product['id_product'];
            $id_product_attribute = $product['id_product_attribute'];
            $id_customization = $product['id_customization'];
            $quantity = $product['cart_quantity'];

            $isCreated = $this->isCreated( 
                $id_cart,
                $id_product, 
                $id_product_attribute, 
                $id_shop, 
                $id_currency
            );

            if (!empty($isCreated)) {
                $id_specific_price = $isCreated[0]['id_specific_price'];
                $twoSidedPrinting = $isCreated[0]['two_side_printing'];
                $express = $isCreated[0]['express'];
                $sameSides = $isCreated[0]['same_sides'];
                $percentToCovaregeFirst = $isCreated[0]['percent_covarege_first'];
                $percentToCovaregeSecond = $isCreated[0]['percent_covarege_second'];
                $colorsFirst = $isCreated[0]['colors_first'];
                $colorsSecond = $isCreated[0]['colors_second'];

                $price = $this->calc(
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

                $this->updateSpecificPrice(
                    $id_specific_price, 
                    $price, 
                    $id_cart,
                    $id_product, 
                    $id_product_attribute, 
                    $quantity, 
                    $id_shop, 
                    $id_currency
                );
            }
        }
    }

    protected function updateSpecificPrice(
            $id, 
            $price, 
            $id_cart,
            $id_product, 
            $id_product_attribute, 
            $quantity, 
            $id_shop, 
            $id_currency
        )
    {
        $specific_price = new SpecificPrice($id);
        $specific_price->from_quantity = (int) $quantity;
        $specific_price->price = $price;
        $specific_price->update();
    }

    /**
     * @hook displayAdminOrder
     */
    public function hookDisplayAdminOrder($params)
    {
        $id_order = $params['id_order'];
        $order = new Order($id_order);
        $id_cart = $order->id_cart;
        $configs = $this->getConfigs($id_cart, (int)(Configuration::get('PS_LANG_DEFAULT')));

        $this->context->smarty->assign('link', $this->context->link);
        $this->context->smarty->assign('configs', $configs);
        
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configs.tpl');

        return $output;
    }

    public function hookBackOfficeHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/back.css');
    }
}
