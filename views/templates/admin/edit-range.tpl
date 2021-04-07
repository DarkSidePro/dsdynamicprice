{*
*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <DARK SIDE TEAM> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Poul-Henning Kamp
 * ----------------------------------------------------------------------------
 *
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