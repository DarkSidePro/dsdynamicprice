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