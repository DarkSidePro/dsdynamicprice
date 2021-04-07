{*
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
*}
<div id='calculator-form' class=''>
    <h2>Konfigurator do druku</h2>
    <form method='POST' enctype='multipart/form-data' id='dsdynamicprice'>
        <input type='hidden' name='dsdynamicprice'>
        <input type='hidden' name='id_product' value='{$product.id}' required>
        <input type='hidden' name='id_product_customization' value="{$product.id_customization}" id="product_customization_id" required>
        <input type='hidden' name='id_product_attribute' value='' id='id_product_attribute'>
        <div class='form-group' id='twoSidedPrintingDiv'>
            <label>{l s='Czy druk drustronny?' mod='dsdynamicprice'}</label>
            <select id='twoSidedPrinting' class='form-control' name='twoSidedPrinting'>
                <option value='0'>{l s='Nie' mod='dsdynamicprice'}</option>
                <option value='1'>{l s='Tak' mod='dsdynamicprice'}</option>
            </select>
        </div>
        <div class='form-group hidden' id='sameSidesDiv'>
            <label>{l s='Czy na obudwóch stronach to samo?' mod='dsdynamicprice'}</label>
            <select class='form-control' name='sameSides' id='sameSides'>
                <option value='0'>{l s='Nie' mod='dsdynamicprice'}</option>
                <option value='1'>{l s='Tak' mod='dsdynamicprice'}</option>
            </select>
        </div>
        <div class='form-group' id='percentToCovaregeFirstDiv'>
            <label id='percentToCovaregeFirstLabelOne'>{l s='Procent pokrycia strony' mod='dsdynamicprice'}</label>
            <label id='percentToCovaregeFirstLabelDouble'>{l s='Procent pokrycia stron' mod='dsdynamicprice'}</label>
            <label id='percentToCovaregeFirstLabelTwo'>{l s='Procent pokrycia pierwszej strony' mod='dsdynamicprice'}</label>
            <select class='form-control' name='percentToCovaregeFirst' id='percentToCovaregeFirst'>
                {foreach $prints as $print}
                    <option value='{$print.id_dsdynamicpriceprint}'>{$print.print_scale}</option>
                {/foreach}
            </select>
        </div>
        <div class='form-group' id='percentToCovaregeSecondDiv'>
            <label id='percentToCovaregeSecondLabelTwo'>{l s='Procent pokrycia drugiej strony' mod='dsdynamicprice'}</label>
            <select class='form-control' name='percentToCovaregeSecond' id='percentToCovaregeSecond'>
                {foreach $prints as $print}
                    <option value='{$print.id_dsdynamicpriceprint}'>{$print.print_scale}</option>
                {/foreach}
            </select>
        </div>
        <div class='form-group' id='selectColorsFirstDiv'>
            <label id='selectColorsFirstLabelOne'>{l s='Kolory na stronie' mod='dsdynamicprice'}</label>
            <label id='selectColorsFirstLabelTwo'>{l s='Kolory na pierwszej stronie' mod='dsdynamicprice'}</label>
            <label id='selectColorsFirstLabelDouble'>{l s='Kolory na stronach' mod='dsdynamicprice'}</label>
            <select class='form-control' id='selectColorsFirst' name='colorsFirst'>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
            </select>
        </div>
        <div class='form-group' id='selectColorsSecondDiv'>
            <label>{l s='Kolory na drugiej stronie' mod='dsdynamicprice'}</label>
            <select class='form-control' id='selectColorsSecond' name='colorsSecond'>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
            </select>
        </div>
        <div class='form-group' id='fileToPrintFirstDiv'>
            <label id='fileToPrintFirstLabelOne'>{l s='Plik z projektem strony' mod='dsdynamicprice'}</label>
            <label id='fileToPrintFirstLabelTwo'>{l s='Plik z projektem na pierwszą stronę' mod='dsdynamicprice'}</label>
            <label id='fileToPrintFirstLabelDouble'>{l s='Plik z projektem stron' mod='dsdynamicprice'}</label>
            <input type='file' class='form-control' name='fileToPrintFirst' id='fileToPrintFirst'>
        </div>
        <div class='form-group' id='fileToPrintSecondDiv'>
            <label>{l s='Plik z projektem na drugą stronę' mod='dsdynamicprice'}</label>
            <input type='file' class='form-control' name='fileToPrintSecond' id='fileToPrintSecond'>
        </div>
        <div class='form-group'>
            <label>{l s='Czy express?' mod='dsdynamicprice'}</label>
            <select id='express' class='form-control' name='express'>
                <option value='0'>{l s='Nie' mod='dsdynamicprice'}</option>
                <option value='1'>{l s='Tak' mod='dsdynamicprice'}</option>
            </select>
        </div>
        <div class='form-group' id='ds-price-response'>
            {l s='Cena:' mod='dsdynamicprice'} <span></span>
        </div>
        <div class='form-group hidden' id='ds-other-response' role='alert'>
            {l s='Kliknij dodaj do koszyka aby zapisać konifugrację.' mod='dsdynamicprice'}
            <button class='btn btn-primary offer-cart'>{l s='Dodaj do koszyka' mod='dsdynamicprice'}</button>
        </div>
        <div class='form-group alert alert-danger hidden' id='ds-alert-response' role='alert'>
        </div>
        <div class='form-group alert alert-success hidden' id='ds-success-response' role='alert'>
        </div>

        <div class='form-group'>
            <button type='submit' class='btn btn-success'>{l s='Save configuration' mod='dsdynamicprice'}</button>
        </div>
    </form>
</div>