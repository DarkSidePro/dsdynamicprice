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
<div class='row'>
    <div class='col col-lg-4'>
    </div>
    <div class='col col-lg-4'>
        <div class='panel'>
            <form id='editRangePrice' method='POST'>
                <input type='hidden' name='editRangePrice' value='{$range[0].id_dsdynamicprice}'>
                <div class='form-group'>
                    <label>{l s='Quantity' mod='dsdynamicprice'}</label>
                    <input type='number' min="0.00" step='1.0' class='form-control' required name='quantity' value='{$range[0].main_to}'>
                </div>
                
                <div class='form-group'>
                    <label>{l s='Other price for peace' mod='dsdynamicprice'}</label>
                    <input type="number" min="0.00" step="0.01" class='form-control' required name='price_b' value='{$range[0].price_a}'/>
                </div>
                <div class='form-group'>
                    <label>{l s='Cotton price for peace' mod='dsdynamicprice'}</label>
                    <input type="number" min="0.00" step="0.01" class='form-control' required name='price_b' value='{$range[0].price_a}'/>
                </div>
                <div class='form-group'>
                    <label>{l s='Percentage of painted area' mod='dsdynamicprice'}</label>
                    <select required class='form-control' name='print'>
                        {foreach $prints as $print}
                            <option value='{$print.id_dsdynamicpriceprint}' {if $range[0].id_dsdynamicpriceprint == $print.id_dsdynamicpriceprint}selected{/if}>{$print.print_scale}</option>
                        {/foreach}
                    </select>
                </div>
                <button type='submit' class='btn btn-default'>{l s='Save' mod='dsdynamicprice'}</button>
            </form>
        </div>
    </div>
</div>