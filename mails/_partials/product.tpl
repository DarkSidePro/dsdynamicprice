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
<tr>
    <td style="border:1px solid #D6D4D4;text-align:center;color:#777;padding:7px 0">{$product.reference}</td>
    <td style="border:1px solid #D6D4D4;text-align:center;color:#777;padding:7px 0"><a href='{$link->getProductLink($product.id_product)|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}'>{$product.name}</a></td>
    <td style="border:1px solid #D6D4D4;text-align:center;color:#777;padding:7px 0">{$product.unit_price}</td>
    <td style="border:1px solid #D6D4D4;text-align:center;color:#777;padding:7px 0">{$product.quantity}</td>
    <td style="border:1px solid #D6D4D4;text-align:center;color:#777;padding:7px 0">{$product.price}</td>
</tr>