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
	<div class='col-lg-4'>
		<div class="panel">
			<h3>
				<i class="icon icon-truck"></i> {l s='Koszt nadruku do  40% ' mod='dsdynamicprice'}
				<span class="panel-heading-action">
					<a class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'}&addRange=0">
						<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
							<i class="process-icon-new"></i>
						</span>
					</a>
				</span>
			</h3>
			<table class='table table-bordered'>
				<thead class='thead-default'>
					<tr class='column-headers'>
						<th>{l s='Quantity' mod='dsdynamicprice'}</th>
						<th>{l s='Other price' mod='dsdynamicprice'}</th>
						<th>{l s='Cotton price' mod='dsdynamicprice'}</th>
						<th>{l s='Actions' mod='dsdynamicprice'}</th>
					</tr>
				</thead>
				<tbody>
					{foreach $print_one as $range}
						<tr>
							<td>{$range.main_to}</td>
							<td>{Tools::displayPrice($range.price_a)}</td>
							<td>{Tools::displayPrice($range.price_b)}</td>
							<td>
								<div class="btn-group-action">
									<div class="btn-group pull-right">
										<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&editRange={$range.id_dsdynamicprice}"
										title="{l s='Edit' mod='dsdynamicprice'}" class="details btn btn-default">
											<i class="icon-edit"></i> {l s='Edit' mod='dsdynamicprice'}
										</a>
										<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down"></i>&nbsp;
										</button>										
										<ul class="dropdown-menu">
											<li>
												<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&deleteRange={$range.id_dsdynamicprice}" title="{l s='Delete' mod='dsdynamicprice'}" class="notes">
													<i class="icon-upload"></i> {l s='Delete' mod='dsdynamicprice'}
												</a>
											</li>
										</ul>
									</div>
								</div>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
	<div class='col-lg-4'>
		<div class="panel">
			<h3>
				<i class="icon icon-truck"></i> {l s='Koszt nadruku do 70% ' mod='dsdynamicprice'}
				<span class="panel-heading-action">
					<a class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'}&addRange=1">
						<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
							<i class="process-icon-new"></i>
						</span>
					</a>
				</span>
			</h3>
			<table class='table table-bordered'>
				<thead class='thead-default'>
					<tr class='column-headers'>
						<th>{l s='Quantity' mod='dsdynamicprice'}</th>
						<th>{l s='Other price' mod='dsdynamicprice'}</th>
						<th>{l s='Cotton price' mod='dsdynamicprice'}</th>
						<th>{l s='Actions' mod='dsdynamicprice'}</th>
					</tr>
				</thead>
				<tbody>
					{foreach $print_two as $range}
						<tr>
							<td>{$range.main_to}</td>
							<td>{Tools::displayPrice($range.price_a)}</td>
							<td>{Tools::displayPrice($range.price_b)}</td>
							<td>
								<div class="btn-group-action">
									<div class="btn-group pull-right">
										<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&editRange={$range.id_dsdynamicprice}"
										title="{l s='Edit' mod='dsdynamicprice'}" class="details btn btn-default">
											<i class="icon-edit"></i> {l s='Edit' mod='dsdynamicprice'}
										</a>
										<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down"></i>&nbsp;
										</button>										
										<ul class="dropdown-menu">
											<li>
												<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&deleteRange={$range.id_dsdynamicprice}" title="{l s='Delete' mod='dsdynamicprice'}" class="notes">
													<i class="icon-upload"></i> {l s='Delete' mod='dsdynamicprice'}
												</a>
											</li>
										</ul>
									</div>
								</div>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
	<div class='col-lg-4'>
		<div class="panel">
			<h3>
				<i class="icon icon-truck"></i> {l s='Koszt nadruku apla' mod='dsdynamicprice'}
				<span class="panel-heading-action">
					<a class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'}&addRange=2">
						<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
							<i class="process-icon-new"></i>
						</span>
					</a>
				</span>
			</h3>
			<table class='table table-bordered'>
				<thead class='thead-default'>
					<tr class='column-headers'>
						<th>{l s='Quantity' mod='dsdynamicprice'}</th>
						<th>{l s='Other price' mod='dsdynamicprice'}</th>
						<th>{l s='Cotton price' mod='dsdynamicprice'}</th>
						<th>{l s='Actions' mod='dsdynamicprice'}</th>
					</tr>
				</thead>
				<tbody>
					{foreach $print_three as $range}
						<tr>
							<td>{$range.main_to}</td>
							<td>{Tools::displayPrice($range.price_a)}</td>
							<td>{Tools::displayPrice($range.price_b)}</td>
							<td>
								<div class="btn-group-action">
									<div class="btn-group pull-right">
										<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&editRange={$range.id_dsdynamicprice}"
										title="{l s='Edit' mod='dsdynamicprice'}" class="details btn btn-default">
											<i class="icon-edit"></i> {l s='Edit' mod='dsdynamicprice'}
										</a>
										<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down"></i>&nbsp;
										</button>										
										<ul class="dropdown-menu">
											<li>
												<a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure={$namemodules}&deleteRange={$range.id_dsdynamicprice}" title="{l s='Delete' mod='dsdynamicprice'}" class="notes">
													<i class="icon-upload"></i> {l s='Delete' mod='dsdynamicprice'}
												</a>
											</li>
										</ul>
									</div>
								</div>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class='row'>
	<div class='col-lg-4'>
		<div class='panel'>
			<h3>
				<i class="icon icon-truck"></i> {l s='Główne ustawienia' mod='dsdynamicprice'}
			</h3>
			<form method='POST' id='main-settings'>
				<input type='hidden' name='mainsettings'>
				<input type='hidden' name='token' value='{$token}'>
				<div id='response-settings'>
					<div class='alert alert-success' role='alert' style='display: none'>
					</div>

					<div class='alert alert-warning hidden' role='alert' style='display: none'>
					</div>
				</div>
				<div class='form-group'>
					<label>{l s='Koszt matrycy' mod='dsdynamicprice'}</label>
					<input type='number' step='0.01' class='form-control matrix' required name='matrix' value='{$matrix}'>
				</div>
				<div class='form-group'>
					<label>{l s='Koszt expressu' mod='dsdynamicprice'}</label>
					<input type='number' step='0.01' class='form-control express' required name='express' value='{$express}'>
				</div>
				<button type='submit' class='btn btn-success'>{l s='Save' mod='dsdynamicprice'}</button>
			</form>
		</div>
	</div>
	{* <div class='col-lg-4'>
		<div class='panel'>
			<h3>
				<i class="icon icon-truck"></i> {l s='Lista stautsów' mod='dsdynamicprice'}
			</h3>
			<div class='form-group'>
				<select id='order_state_list' class='form-control' multiple>
					{foreach $order_states as $state}
						<option value='{$state.id_order_state}'>{$state.name}</option>
					{/foreach}
				</select>
			</div>
			<button class='btn btn-success btn-cst' id='add'>{l s='Add' mod='dsdynamicprice'}</button>
		</div>
	</div>
	<div class='col-lg-4'>
		<div class='panel'>
			<h3>
				<i class="icon icon-truck"></i> {l s='Lista statusów do wysyłki maili' mod='dsdynamicprice'}
			</h3>
			<div class='form-group'>
				<select id='order_send_list' class='form-control' multiple>
					{foreach $order_emails as $state}
						<option value='{$state.id_state}'>{$state.name}</option>
					{/foreach}
				</select>
			</div>
			<button class='btn btn-danger btn-cst' id='remove'>{l s='Remove' mod='dsafillate'}</button>
			<button class='btn btn-success btn-cst' id='save' data-token='{$token}'>{l s='Save order status list' mod='dsafillate'}</button>
		</div>
	</div> *}
</div>
<script>
	$().ready(function() {  
		$('#add').click(function() {  
			return !$('#order_state_list option:selected').remove().appendTo('#order_send_list');  
		});  
		$('#remove').click(function() {  
			return !$('#order_send_list option:selected').remove().appendTo('#order_state_list');  
		});
	});

	$('#order_send_list').bind('DOMSubtreeModified', () => {
		var options = $('#order_send_list option');
		values = [0];
		var value = $.map(options, function(option) {
			values.push(option.value)
		});
	})

	$('#save').on('click', (e) => {
		e.preventDefault();
		let token = $('#save').data('token');
		$.ajax({
			type: 'POST',
			url: baseAdminDir+'index.php',
			data: {
				ajax: true,
				controller: 'AdministratorDsdynamicprice',
				action: 'call',
				token: token,
				array: values,
				
			},
			success: function (data) {
				location.reload();
			},
			error: function (data) {
				console.log('An error occurred.');
				console.log(data);
			},
		});
	})

	$('#main-settings').on('submit', function(e) {
		let token = $('#save').data('token');
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: baseAdminDir+'index.php',
			data: {
				ajax: true,
				controller: 'AdministratorDsdynamicprice',
				action: 'configuration',
				token: token,
				matrix: $('.matrix').val(),
				express: $('.express').val()
				
			},
			success: function (data) {
				var obj = JSON.parse(data);

				if (obj.success) {
					$('#response-settings .alert-success').html(obj.success);
					$('#response-settings .alert-success').slideDown('fast');
					setTimeout(function() {
						$('#response-settings .alert-success').slideUp('fast');
					}, 3000);
				}

				if (obj.msg) {
					$('#response-settings .alert-warning').html(obj.msg);
					$('#response-settings .alert-warning').slideDown('fast');
					setTimeout(function() {
						$('#response-settings .alert-warning').slideUp('fast');
					}, 3000);
				}
			},
			error: function (data) {
				console.log('An error occurred.');
				console.log(data);
			},
		});
	})
</script>