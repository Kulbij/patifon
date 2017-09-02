<div id="content">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <div class="account">
  <?php echo $this->load->view('auth/inside/user_menu_view', null, true); ?>

  <div class="account-content">
   <div class="account-order">

    <?php if (isset($SITE_CONTENT['orders']) && !empty($SITE_CONTENT['orders'])) : ?>

     <?php foreach ($SITE_CONTENT['orders'] as $value) : ?>
      <div class="order-item">
       <div class="item-info">
        <div class="info-title">
         <a href="<?php if (isset($value['id'])) echo anchor_wta(site_url($this->config->item('auth_user_page_link').'/order/'.$value['id'])); ?>">
          <?php echo $this->lang->line('accp_orders_order_title'); ?> #<?php if (isset($value['id'])) echo $value['id']; ?> <?php echo $this->lang->line('accp_orders_order_title_from'); ?> <?php if (isset($value['datetime'])) echo date('d.m.y', strtotime($value['datetime'])); ?>
         </a>
        </div>
        <div class="info-text">
         <?php if (isset($value['quantity']) && isset($value['sum'])) : ?>
          <?php echo $value['quantity'], ' ', $this->input->pl_form($value['quantity'], $this->lang->line('site_p_form1'), $this->lang->line('site_p_form2'), $this->lang->line('site_p_form5')), ' ', $this->lang->line('accp_orders_order_sum'), ' ', $this->input->price_format($value['sum'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')), ' ', $this->lang->line('site_valuta'); ?>
         <?php endif; ?>
        </div>
       </div><!-- end .item-info -->

      <?php if (isset($value['canceled']) && $value['canceled']) : ?>
       <div class="item-status cancel">
        <?php echo $this->lang->line('accp_orders_order_is_canceled'); ?>
       </div>
      <?php elseif (isset($value['check']) && !$value['check']) : ?>
       <div class="item-status wait">
        <?php echo $this->lang->line('accp_orders_order_is_waiting'); ?>
       </div>
      <?php else : ?>
       <div class="item-status ok">
        <?php echo $this->lang->line('accp_orders_order_is_okey'); ?>
       </div>
      <?php endif; ?>

       <div class="clear"></div>
      </div><!-- end .order-item -->
     <?php endforeach; ?>

    <?php else : ?>
     
     <div class="order-text">
      <?php echo $this->lang->line('accp_orders_empty'); ?>
     </div>

    <?php endif; ?>

   </div><!-- end .account-order -->
  </div><!-- end .account-content -->

  <div class="clear"></div>
 </div><!-- end .account -->
</div><!-- end #content -->