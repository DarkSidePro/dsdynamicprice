/**
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
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */
$(function() {
    $('#sameSidesDiv').hide();
    $('#percentToCovaregeFirstLabelTwo').hide();
    $('#percentToCovaregeFirstLabelDouble').hide();
    $('#percentToCovaregeSecondDiv').hide();
    $('#selectColorsFirstLabelTwo').hide();
    $('#selectColorsFirstLabelDouble').hide();
    $('#selectColorsSecondDiv').hide();
    $('#fileToPrintFirstLabelTwo').hide();
    $('#fileToPrintFirstLabelDouble').hide();
    $('#fileToPrintSecondDiv').hide();
});

var value = $('#product-details').data('product').id_product_attribute;
$('#id_product_attribute').val(value);

$('body').on('change', '#twoSidedPrinting, #express, #sameSides, #percentToCovaregeFirst, #percentToCovaregeSecond, #selectColorsFirst, #selectcolorsSecond, #fileToPrintFirst, #fileToPrintSecond', function() {
    if ($('#twoSidedPrinting').val() == 0) {
        $('#sameSidesDiv').slideUp('fast');
        $('#percentToCovaregeSecondDiv').slideUp('fast');
        $('#percentToCovaregeFirstLabelOne').show();
        $('#percentToCovaregeFirstLabelTwo').hide();
        $('#percentToCovaregeFirstLabelDouble').hide();
        $('#selectColorsSecondDiv').slideUp('fast');
        $('#selectColorsFirstLabelOne').show();
        $('#selectColorsFirstLabelTwo').hide();
        $('#selectColorsFirstLabelDouble').hide();
        $('#fileToPrintSecondDiv').slideUp('fast');
        $('#fileToPrintFirstLabelOne').show();
        $('#fileToPrintFirstLabelTwo').hide();
        $('#fileToPrintFirstLabelDouble').hide();
    } else {
        $('#sameSidesDiv').slideDown('fast');
        if ($('#sameSides').val() == 0) {
            $('#percentToCovaregeSecondDiv').slideDown('fast');
            $('#percentToCovaregeFirstLabelOne').hide();
            $('#percentToCovaregeFirstLabelTwo').show();
            $('#percentToCovaregeFirstLabelDouble').hide();
            $('#selectColorsSecondDiv').slideDown('fast');
            $('#selectColorsFirstLabelOne').hide();
            $('#selectColorsFirstLabelTwo').show();
            $('#selectColorsFirstLabelDouble').hide();
            $('#fileToPrintSecondDiv').slideDown('fast');
            $('#fileToPrintFirstLabelOne').hide();
            $('#fileToPrintFirstLabelTwo').show();
            $('#fileToPrintFirstLabelDouble').hide();
        } else {
            $('#percentToCovaregeSecondDiv').slideUp('fast');
            $('#percentToCovaregeFirstLabelOne').hide();
            $('#percentToCovaregeFirstLabelTwo').hide();
            $('#percentToCovaregeFirstLabelDouble').show();
            $('#selectColorsSecondDiv').slideUp('fast');
            $('#selectColorsFirstLabelOne').hide();
            $('#selectColorsFirstLabelTwo').hide();
            $('#selectColorsFirstLabelDouble').show();
            $('#fileToPrintSecondDiv').slideUp('fast');
            $('#fileToPrintFirstLabelOne').hide();
            $('#fileToPrintFirstLabelTwo').hide();
            $('#fileToPrintFirstLabelDouble').show();
        }
    }

    $('#id_product_attribute').val($('#product-details').data('product').id_product_attribute);

    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/module/dsdynamicprice/GetPrice",
        contentType: false,
        cache: false,
        processData: false,
        data: new FormData(document.getElementById('dsdynamicprice')),
        success: function(data) {
            var obj = JSON.parse(data);
            $('#ds-price-response span').html(obj.msg);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(xhr.responseText);
            console.log(thrownError);
        }
    });
});

$('#dsdynamicprice button.btn-success').on('click', function(e) {
    e.preventDefault();
    var value = $('#product-details').data('product').id_product_attribute;
    $('#id_product_attribute').val(value);

    $.ajax({
        type: "POST",
        url: window.location.protocol + "//" + window.location.host + "/module/dsdynamicprice/SaveConfiguration",
        contentType: false,
        cache: false,
        processData: false,
        data: new FormData(document.getElementById('dsdynamicprice')),
        success: function(data) {
            var obj = JSON.parse(data);

            if (obj.error) {
                $('#ds-other-response').slideDown('fast');
                setTimeout(function() {
                    $('#ds-other-response').slideUp('fast');
                }, 10000);
            }

            if (obj.msg) {
                $('#ds-alert-response').html(obj.msg);
                $('#ds-alert-response').slideDown('fast');
                setTimeout(function() {
                    $('#ds-alert-response').slideUp('fast');
                }, 3000);
            }

            if (obj.success) {
                $('#ds-success-response').html(obj.success);
                $('#ds-success-response').slideDown('fast');
                setTimeout(function() {
                    $('#ds-success-response').slideUp('fast');
                }, 3000);
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(xhr.responseText);
            console.log(thrownError);
        }
    });
})

$.ajax({
    type: "POST",
    url: window.location.protocol + "//" + window.location.host + "/module/dsdynamicprice/GetPrice",
    contentType: false,
    cache: false,
    processData: false,
    data: new FormData(document.getElementById('dsdynamicprice')),
    success: function(data) {
        var obj = JSON.parse(data);
        $('#ds-price-response span').html(obj.msg);
    },
    error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr.status);
        console.log(xhr.responseText);
        console.log(thrownError);
    }
});

$('#dsdynamicprice').submit(function(e) {
    e.preventDefault();
})

$('#calculator-link').on('click', function() {
    $('#calculator-form').slideDown('fast');
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#calculator-form").offset().top - 150
    }, 2000);
});

$('.offer-cart').on('click', function() {
    $('#ds-other-response').slideUp('fast');
    $('form#add-to-cart-or-refresh .btn.btn-primary.add-to-cart').trigger('click');
    setTimeout(function() {
        $("#dsdynamicprice button.btn-success").trigger('click');
    }, 500);
})