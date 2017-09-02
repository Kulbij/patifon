<div id="content">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <div class="account">
  <?php echo $this->load->view('auth/inside/user_menu_view', null, true); ?>

  <div class="account-content">
   <div class="account-cart">

    <?php $discount = 0; $total = 0; if (isset($SITE_CONTENT['order']) && !empty($SITE_CONTENT['order'])) : ?>
     <?php foreach ($SITE_CONTENT['order'] as $value) :
      if (!$discount && isset($value['order_discount']) && $value['order_discount']) {
       $discount = $this->config->item('auth_user_discount');
      }
      ?>
      <div class="cart-item">
       <div class="item-image">
        <a href="<?php echo anchor_wta(site_url('product/'.$value['link'])); ?>">
         <img src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>" />
        </a>
       </div>
     
       <div class="item-info">
        <div class="info-title">
         <a href="<?php echo anchor_wta(site_url('product/'.$value['link'])); ?>">
          <?php echo $value['name']; ?>
         </a>
        </div>

        <?php if (isset($value['color']) && isset($value['color_name'])) : ?>
         <div class="info-color" style="background: #<?php echo $value['color']; ?>;"></div>
         <div class="info-text">
          <?php echo $value['color_name']; ?>
         </div>
        <?php endif; ?>

        <div class="clear"></div>

        <div class="info-price">
         <?php echo $this->input->price_format($value['sum'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> 
         <?php echo $this->lang->line('site_valuta'); ?>
        </div>
        <div class="info-amount">x<?php echo $value['quantity']; ?></div>
        <div class="info-total">
         <?php if (isset($value['sum']) && isset($value['quantity'])) {
          $total += $value['sum'] * $value['quantity'];
          echo $this->input->price_format($value['sum'] * $value['quantity'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <?php echo $this->lang->line('site_valuta');
         } ?>
        </div>

        <div class="clear"></div>
       </div><!-- end .item-info -->

       <div class="clear"></div>
      </div><!-- end .cart-item -->
     <?php endforeach; ?>
    <?php endif; ?>

     <div class="cart-info">
      <div class="info-price">
       <?php echo $this->lang->line('ap_c_sum'); ?>: <?php echo $this->input->price_format($total - $discount, $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?>  <?php echo $this->lang->line('site_valuta'); ?>
      </div>
     </div><!-- end .cart-info -->
   </div><!-- end .account-cart -->
  </div><!-- end .account-content -->

  <div class="clear"></div>
 </div><!-- end .account -->
</div><!-- end #content -->