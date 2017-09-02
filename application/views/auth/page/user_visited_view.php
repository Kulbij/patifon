<div id="content">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

<div class="account">
 <?php echo $this->load->view('auth/inside/user_menu_view', null, true); ?>

 <div class="account-content">
  <div class="catalog">
  
   <?php if (isset($SITE_CONTENT['catalog']) && !empty($SITE_CONTENT['catalog'])) {

    echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['catalog']), true);

   } ?>
  
  </div><!-- end .catalog -->
 </div><!-- end .account-content -->

 <div class="clear"></div>
</div><!-- end .account -->

 <?php echo $this->load->view('auth/inside/user_page_view', null, true); ?>
</div><!-- end #content -->