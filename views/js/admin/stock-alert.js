/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    Axelweb <contact@axelweb.fr>
 * @copyright 2007-2024 Axelweb
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

$(document).ready(function() {
  let searchTimeout;
  
  // Product search with autocomplete
  $('#product-search').on('input', function() {
    clearTimeout(searchTimeout);
    const query = $(this).val().trim();
    
    if (query.length < 2) {
      $('#product-results').hide();
      return;
    }
    
    searchTimeout = setTimeout(function() {
      // TODO: Ajax call to search products
      console.log('Search for:', query);
      // For now, show placeholder
      $('#product-results .dropdown-menu').html('<a class="dropdown-item disabled" href="#">Searching...</a>');
      $('#product-results').show();
    }, 300);
  });
  

  // Remove selected product
  $('#remove-selected-product').on('click', function() {
    $('#selected-product').hide();
    $('#selected-product-id').val('');
    $('#product-search').val('');
    $('#check-orders-btn').prop('disabled', true);
  });
  
  // Enable/disable submit button
  $('#selected-product-id').on('change', function() {
    $('#check-orders-btn').prop('disabled', !$(this).val());
  });
});
