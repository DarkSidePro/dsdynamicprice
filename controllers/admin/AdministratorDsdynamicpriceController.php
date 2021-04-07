<?php
/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <DARK SIDE TEAM> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Poul-Henning Kamp
 * ----------------------------------------------------------------------------
 */

class AdministratorDsdynamicpriceController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();

        if (!Tools::isSubmit('array') && !Tools::isSubmit('matrix')) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules').'&configure=dsdynamicprice');
        }
    }

    public function ajaxProcessCall()
    {
        $ids_state = Tools::getValue('array');
        $this->addState($ids_state);
    }

    public function ajaxProcessConfiguration()
    {
        $matrix = Configuration::updateValue('DSDYNAMICPRICE_MATRIX', Tools::getValue('matrix'));
        $express = Configuration::updateValue('DSDYNAMICPRICE_EXPRESS', Tools::getValue('express'));

        if ($matrix === false || $express === false) {
            echo Tools::jsonEncode(array('msg' => $this->l('Something gone wrong. Please try again.')));
            return;
        }

        echo Tools::jsonEncode(array('success' => $this->l('Save success.')));
        return;
    }

    protected function addState($array)
    {
        $this->deleteStates();
        $db = \Db::getInstance();
        foreach ($array as $id_state) {
            $sql = "INSERT INTO `" . _DB_PREFIX_ . "dsdynamicprice_state` (`id_state`) VALUES ($id_state)";
            $db->execute($sql);
        }
    }

    protected function deleteStates()
    {
        $db = \Db::getInstance();
        $sql = "DELETE FROM "._DB_PREFIX_."dsdynamicprice_state";

        return DB::getInstance()->execute($sql);
    }
}
