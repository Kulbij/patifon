<div class="ownbox-content form form-cart">
	<div class="title"><?php if (isset($pagename)) echo $pagename; ?></div>
	<a class="close ownbox-close" href="javascript:void(0);"></a>

	 	<div class="cart-box" id="cart_inside">
	  		<?php echo $this->load->view('ajax/ownbox/owb_cart_inside_view', null, true); ?>
	 	</div><!-- end .ownbox-content -->

</div><!-- end #box -->