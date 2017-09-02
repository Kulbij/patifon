
function cart_buy($object, $show) {    
 if (typeof $object == 'undefined' ||
     typeof $object.id == 'undefined' ||
     typeof $object.color == 'undefined' ||
     typeof $object.quantity == 'undefined') return false;

  if( typeof $object.id_product == 'undefined') $object.id_product = 1;

 $.ajax({
  url: CI_ROOT_LANG + 'cart/show-cart',
  type: 'POST',
  async: false,
  data: 'id=' + $object.id + '&quantity=' + $object.quantity + '&color=' + $object.color + '&show=' + $show + '&id_product=' + $object.id_product,
  success: function() {
   if ($show) {
    cart_update_query_view();
    cart_show();
   }
  }
 });

}

function cart_buy_component() {
 var object = {};
 object.id = '';
 object.color = '';
 object.quantity = '';

 $('.component-quantity').each(function(){

  if (parseInt($(this).val(), 10) > 0) {
   object.id += '&id[]=' + $(this).data('object');
   object.quantity += '&quantity[' + $(this).data('object') + ']=' + parseInt($(this).val(), 10);
  }

 });

 cart_buy(object, true);
}

function cart_quantity($cart) {
 if (typeof $cart == 'undefined' || $cart === null) return false;
 if (typeof $cart.row == 'undefined') return false;
 if (typeof $cart.quantity == 'undefined') return false;

 $.ajax({
  url: CI_ROOT_LANG + 'cart/change-quantity',
  type: 'POST',
  data: 'row=' + $cart.row + '&quantity=' + $cart.quantity,
  success: function($data) {
   cart_update_query_view();
   cart_update();
  }
 });

}

var quantity_tm;
function cart_quantity_update(elem, time) {

 time = typeof time !== 'undefined' ? time : 1000;

 clearTimeout(quantity_tm);

 var $row = $(elem).attr('name');
 var $count = $(elem).val();

 if ($count < 1) {
  $count = 1;

  elem
   .closest('.qty-parent-amount')
    .find('.cart-plus').removeClass('db')
   .end()
    .find('.cart-minus').addClass('db')
  ;

 } else if ($count > 99) {
  $count = 99;

  elem
   .closest('.qty-parent-amount')
    .find('.cart-plus').addClass('db')
   .end()
    .find('.cart-minus').removeClass('db')
  ;

 }

 var $cart = {};
 $cart.row = $row;
 $cart.quantity = $count;

 quantity_tm = setTimeout(function(){
  cart_quantity($cart);
 }, time);

}

function cart_remove($cart) {
 if (typeof $cart == 'undefined' || $cart === null) return false;
 if ($cart.row == 'undefined') return false;

 $.ajax({
  url: CI_ROOT_LANG + 'cart/remove-catalog',
  type: 'POST',
  async: true,
  data: 'row=' + $cart.row,
  success: function($data) {
   cart_update_query_view();
   cart_update();
  }
 });

}

function cart_update_query_view() {

 $.ajax({
  url: CI_ROOT_LANG + 'cart/cart-data',
  type: 'POST',
  success: function(data) {
   try { data = $.parseJSON(data); } catch (e) { data = undefined; }
   if (typeof data != 'undefined') {

    if (typeof data === 'undefined' || data === null) return false;
    if (typeof data.cart === 'undefined' || data.cart === null) return false;
    if (typeof data.cart.catalogtotalsum === 'undefined') return false;
    if (typeof data.cart.catalogcount === 'undefined') return false;
    if (typeof data.cart.catalogform === 'undefined') return false;

    if (data.cart.catalogtotalsum <= 0) {
     window.location.reload(true);
    } else {
     if (!$('.cart_box a').length) {
      $('.cart_box').html('<a href="javascript:void(0);" class="cart cart_full" onclick="cart_show(); return false;"><span class="cart_total_summ" id="main_c_total">' + data.cart.catalogtotalsum + ' <i>&nbsp;грн.  </i></span><span class="cart__count" id="main_c_count">' + data.cart.catalogcount + '</span></a>');

      $('.cart').show();

     }

     $('#main_c_count').html(data.cart.catalogcount);
     $('#main_c_form').html(data.cart.catalogform);
     $('#main_c_total').html(data.cart.catalogtotalsum + '<i>&nbsp;грн.  </i>');

    }

   }

  }
 });

}

function cart_show() {
 own_box_show(CI_ROOT_LANG + 'cart/load-view');
}

function cart_update() {

 $.ajax({
  url: CI_ROOT_LANG + 'cart/load-content',
  type: 'POST',
  success: function(data){
   try { data = $.parseJSON(data); } catch (e) { data = undefined; }

   if (typeof data != 'undefined' && data !== null) {

    if ('cart' in data && typeof data.cart !== 'undefined') {
     if ($('#cart_inside').length) $('#cart_inside').html(data.cart);
    }

    if ('cart_page' in data && typeof data.cart_page !== 'undefined') {
     if ($('#cart_inside_page').length) $('#cart_inside_page').html(data.cart_page);
    }

    if ('cart_order' in data && typeof data.cart_order !== 'undefined') {
     if ($('#cart_order').length) $('#cart_order').html(data.cart_order);
    }

   }

  }
 });

}

function component_quantity_input(elem) {
 var count = $(elem).val();

 if (count <= 0) {
  $(elem).closest('.component-amount-block').find('.component-minus').addClass('disabled');
  $(elem).closest('.component-amount-block').find('.component-plus').removeClass('disabled');
  count = 0;
 } else if (count >= 99) {
  $(elem).closest('.component-amount-block').find('.component-plus').addClass('disabled');
  $(elem).closest('.component-amount-block').find('.component-minus').removeClass('disabled');
  count = 99;
 } else {
  $(elem).closest('.component-amount-block').find('.component-plus').removeClass('disabled');
  $(elem).closest('.component-amount-block').find('.component-minus').removeClass('disabled');
 }

 $(elem).val(count);

 var comp_price = false;
 $('.component-quantity').each(function(){

  if (parseInt($(this).val(), 10) > 0) {
   comp_price += parseFloat(parseFloat($(this).data('price')) * parseInt($(this).val(), 10));
  }

 });

 if (parseFloat(comp_price) > 0) {
  $('.product-main-price').text(number_format(comp_price, 0, ',', ' '));
  $('.product-component-button-buy').attr('onclick', 'cart_buy_component();');
 } else {
  $('.product-main-price').text('0');
  $('.product-component-button-buy').attr('onclick', "global_goto('#component_container', 50);");
 }

 return true;
}

$(document).ready(function(){

 $('.global-qty-input').keydown(function(event) {
    // Allow: backspace, delete, tab, escape, and enter
   if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||

         // Allow: Ctrl+A
      (event.keyCode == 65 && event.ctrlKey === true) ||
         // Allow: home, end, left, right
      (event.keyCode >= 35 && event.keyCode <= 39)) {
             // let it happen, don't do anything
        return;
    } else {
        // Ensure that it is a number and stop the keypress
       if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
        event.preventDefault();
       }
    }

    if ($(this).val().length > 2) $(this).val($(this).val().substr(0, 2));
  });

 $('.cart-minus').live('click', function() {
  var $elem_input = $(this).closest('.qty-parent-amount').find('input');
  var $row = $(this).attr('rel');
  var $count = parseInt($elem_input.val(), 10);

  $count = parseInt($count, 10) - 1;

  if ($count < 1) {
   $(this).addClass('db');
   return false;
  }

  $(this).removeClass('db');
  $(this).closest('.qty-parent-amount').find('.cart-plus').removeClass('db');

  $elem_input.val($count);

  cart_quantity_update($elem_input);

 });

 $('.cart-plus').live('click', function() {
  var $elem_input = $(this).closest('.qty-parent-amount').find('input');
  var $row = $(this).attr('rel');
  var $count = parseInt($elem_input.val(), 10);

  $count = parseInt(parseInt($count, 10) + 1, 10);

  if ($count > 99) {
   $(this).addClass('db');
   return false;
  }

  $(this).removeClass('db');
  $(this).closest('.qty-parent-amount').find('.cart-minus').removeClass('db');

  $elem_input.val($count);

  cart_quantity_update($elem_input);

 });

 $('.quantity-input').live('keyup', function(e){

  if (e.keyCode == 13) {
   cart_quantity_update(this, 10);
  }

 }).live('blur', function(){
  cart_quantity_update(this, 10);
 });

 $('.cart-remove').live('click', function(){
  var $row = $(this).attr('rel');

  var $cart = {};
  $cart.row = $row;
  cart_remove($cart);
 });

 //components

 $('.component-quantity').live('keyup', function(e){

  if (e.keyCode == 13) {
   component_quantity_input($(this));
  }

 }).live('blur', function(){

  component_quantity_input($(this));

 });

 $('.component-plus').live('click', function(e){
  e.preventDefault();
  if ($(this).hasClass('disabled')) return false;

  var elem_input = $(this).closest('.component-amount-block').find('.component-quantity').first();
  var count = parseInt(elem_input.val(), 10);

  if (count >= 99) return false;

  elem_input.val(parseInt(parseInt(count, 10) + 1, 10));
  component_quantity_input(elem_input);
 });

 $('.component-minus').live('click', function(e){
  e.preventDefault();
  if ($(this).hasClass('disabled')) return false;

  var elem_input = $(this).closest('.component-amount-block').find('.component-quantity').first();
  var count = parseInt(elem_input.val(), 10);

  if (count <= 0) return false;

  elem_input.val(parseInt(parseInt(count, 10) - 1, 10));
  component_quantity_input(elem_input);
 });

 //this is the end... */

});