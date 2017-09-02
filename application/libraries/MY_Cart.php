<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Cart extends CI_Cart {

    public $CI;

    public function __construct() {
	parent::__construct();
	$this->CI = &get_instance();
    }

    //----------------------------------------------------------------------

    /**
     * Get Cart Element
     * 
     * Get cart element by rowid
     * 
     * @access  public
     * @return  array
     */
    function getElement($rowid = '') {
	return (isset($this->_cart_contents["{$rowid}"])) ? $this->_cart_contents["{$rowid}"] : array();
    }

    //----------------------------------------------------------------------

    /**
     * Get Cart Element
     * 
     * Get cart element by rowid
     * 
     * @access  public
     * @return  array, bool
     */
    function getElementByID($id) {
	foreach ($this->_cart_contents as $one) {
	    if ($one['id'] == $id)
		return $one;
	}

	return false;
    }

    //----------------------------------------------------------------------

    /**
     * Find element in Cart
     * 
     * Find element in Cart by id
     * 
     * @access  public
     * @return  bool
     */
    function isElement($id = '', $prices = 0) {
	foreach ($this->_cart_contents as $one) {
	    if (isset($one['id']) && $one['id'] == $id && isset($one['options']['prices']) && $one['options']['prices'] == $prices)
		return true;
	}
	return false;
    }

    //----------------------------------------------------------------------

    /**
     * update total price in Cart
     * 
     * update total price in Cart
     * 
     * @access  public
     * @return  bool
     */
    public function updateTotalPrice() {
	return true;
    }

    function _save_cart() {
	// Unset these so our total can be calculated correctly below
	unset($this->_cart_contents['total_items']);
	unset($this->_cart_contents['cart_total']);

	// Lets add up the individual prices and set the cart sub-total
	$total = 0;
	$items = 0;		

	foreach ($this->_cart_contents as $key => $val) {
	    // We make sure the array contains the proper indexes
	    if (!is_array($val) OR ! isset($val['price']) OR ! isset($val['qty'])) {
		continue;
	    }
	    
	    $val['price'] += $this->_cart_contents[$key]['options']['warranty_price'];	    
	    $total += ($val['price'] * $val['qty']);
	    $items += $val['qty'];
	    // Set the subtotal
	    $this->_cart_contents[$key]['subtotal'] = ($val['price'] * $val['qty']);
	}

	// Set the cart total and total items.
	$this->_cart_contents['total_items'] = $items;
	$this->_cart_contents['cart_total'] = $total;

	// Is our cart empty?  If so we delete it from the session
	if (count($this->_cart_contents) <= 2) {
	    $this->CI->session->unset_userdata('cart_contents');

	    // Nothing more to do... coffee time!
	    return FALSE;
	}

	// If we made it this far it means that our cart has data.
	// Let's pass it to the Session class so it can be stored
	$this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));

	// Woot!
	return TRUE;
    }

}
