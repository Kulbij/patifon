
<div class="<?php if ($this->session->userdata('user_subscribe')) echo 'account-form-subscribe'; else echo 'account-subscribe'; ?>">
 
 <?php if ($this->session->userdata('user_subscribe')) : ?>

  <script type="text/javascript">
   $(document).ready(function(){
    $('input[type="checkbox"]').uniform();
   });
  </script>

  <div class="subscribe-field">

   <form action="<?php echo anchor_wta(site_url('ajax/data/subscribe')); ?>" method="post">

    <div class="field-input">
     <input type="hidden" name="on" value="0" />
     <input class="subscribe-form" type="checkbox" checked="checked" />
    </div>

    <div class="field-text">
     <?php echo $this->lang->line('accp_subscribe_text'); ?>
    </div>

   </form>

   <div class="clear"></div>
  </div><!-- end .subscribe-menu -->

 <?php else : ?>
  
  <div class="subscribe-field">
   
   <form action="<?php echo anchor_wta(site_url('ajax/data/subscribe')); ?>" method="post">

    <div class="field-input">
     <input class="subscribe-field-input" type="text" name="email" maxlength="255" placeholder="<?php echo $this->lang->line('f_subs_form_email_title'); ?>" value="<?php echo $this->session->userdata('email'); ?>" />
    </div>
    
    <div class="field-button">
     <input type="hidden" name="on" value="1" />
     <input class="subscribe-form" type="button" value="" />
    </div>

   </form>

  </div><!-- end .subscribe-field -->

 <?php endif; ?>

 <?php if (!$this->session->userdata('user_subscribe')) : ?>
  <div class="subscribe-title subscribe-result-text">
   <?php echo $this->lang->line('accp_subscribe_not_text'); ?>
  </div>
 <?php endif; ?>
  
 <?php if ($this->session->userdata('user_subscribe') && !$this->session->userdata('user_share_50')) : ?>
  <div class="subscribe-text">
   <?php printf($this->lang->line('accp_subscribe_have_text_1'), $this->config->item('auth_user_discount')); ?>
  </div>
  <div class="subscribe-info">
   <?php printf($this->lang->line('accp_subscribe_have_text_2'), $this->config->item('auth_user_discount_min_limit')); ?>
  </div>
 <?php endif; ?>

</div><!-- end .account-form-subscribe -->