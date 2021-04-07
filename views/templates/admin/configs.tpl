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
    <div class='col-lg-12'>
        <div class='card mt-2'>
            <div class='card-header'>
                {l s='Konfiguracja druku' mod='dsdynamicprint'}
            </div>
            <div class='card-body'>
                <div class='table-responsive'>
                    <table class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>{l s='Product' mod='dsdynamicprint'}</th>
                                <th>{l s='Two side' mod='dsdynamicprint'}</th>
                                <th>{l s='Same side' mod='dsdynamicprint'}</th>
                                <th>{l s='Covarege first' mod='dsdynamicprint'}</th>
                                <th>{l s='Coverage second' mod='dsdynamicprint'}</th>
                                <th>{l s='Colors first' mod='dsdynamicprint'}</th>
                                <th>{l s='Colors second' mod='dsdynamicprint'}</th>
                                <th>{l s='Express' mod='dsdynamicprint'}</th>
                                <th>{l s='File first' mod='dsdynamicprint'}</th>
                                <th>{l s='FIle second' mod='dsdynamicprint'}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $configs as $config}
                                <tr>
                                    <th>
                                        <a href='{$link->getAdminLink('AdminProducts', true, ['id_product' => $config['id_product']])}'>{$config['product_name']}</a>
                                    </th>
                                    <td>
                                        {if $config['two_side_printing'] == 0}
                                            {l s='No' mod='dsdynamicprint'}
                                        {else}
                                            {l s='Yes' mod='dsdynamicprint'}
                                        {/if}
                                    </td>
                                    <td>
                                        {if $config['same_sides'] == 0}
                                            {l s='No' mod='dsdynamicprint'}
                                        {else}
                                            {l s='Yes' mod='dsdynamicprint'}
                                        {/if}
                                    </td>
                                    <td>{$config['first_print_scale']}</td>
                                    <td>{$config['second_print_scale']}</td>
                                    <td>{$config['colors_first']}</td>
                                    <td>{$config['colors_second']}</td>
                                    <td>
                                        {if $conif['express'] == 0}
                                            {l s='No' mod='dsdynamicprint'}
                                        {else}
                                            {l s='Yes' mod='dsdynamicprint'}
                                        {/if}
                                    </td>
                                    <td>
                                        {if $config['file_to_print_first'] != 10001}
                                            <a href='{$link->getBaseLink()}upload/{$config['file_to_print_first']}' download>{l s='Downlaod' mod='dsdynamicprint'}</a>
                                        {/if}
                                    </td>
                                    <td>
                                        {if $config['file_to_print_second'] != 10001}
                                            <a href='{$link->getBaseLink()}upload/{$config['file_to_print_second']}' download>{l s='Downlaod' mod='dsdynamicprint'}</a>
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>