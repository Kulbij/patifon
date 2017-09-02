
<?php if ($this->ion_auth->logged_in() && $this->session->userdata('user_subscribe') === 0) : ?>

 <div class="subscribe-title">
  <?php echo $this->lang->line('accp_subscribe_text'); ?>
 </div>

 <?php if ($this->session->userdata('user_share_50') === 1) : ?>
  <div class="subscribe-text">
   <?php echo $this->lang->line('accp_subscribe_have_text_1'); ?>
  </div>
  <div class="subscribe-info">
   <?php echo $this->lang->line('accp_subscribe_have_text_2'); ?>
  </div>
 <?php endif; ?>

 <div class="subscribe-field">

  <form action="<?php echo anchor_wta(site_url('ajax/data/subscribe')); ?>" method="post">

   <div class="field-input">
    <input class="subscribe-field-input" name="email" type="text" maxlength="255" placeholder="<?php echo $this->lang->line('f_subs_form_email_title'); ?>" value="<?php echo $this->session->userdata('email'); ?>" />
   </div>
   
   <div class="field-button">
    <input type="hidden" name="on" value="1" />
    <input class="subscribe-form" type="button" value="<?php echo $this->lang->line('f_subs_form_button_title'); ?>" />
   </div>

  </form>

 </div><!-- end .subscribe-field -->

<?php else : ?>

 <div class="subscribe-title">
  <?php echo $this->lang->line('f_subs_text'); ?>
 </div>
 <div class="subscribe-text">
  <?php printf($this->lang->line('f_subs_text2'), $this->config->item('auth_user_discount')); ?>
 </div>
 <div class="subscribe-info">
  <?php printf($this->lang->line('f_subs_text3'), $this->config->item('auth_user_discount_min_limit')); ?>
 </div>

 <div class="subscribe-field">

  <form action="<?php echo anchor_wta(site_url('ajax/data/subscribe')); ?>" method="post">

   <div class="field-input">
    <input class="subscribe-field-input" name="email" type="text" maxlength="255" placeholder="<?php echo $this->lang->line('f_subs_form_email_title'); ?>" value="<?php echo $this->session->userdata('email'); ?>" />
   </div>
   
   <div class="field-button">
    <input type="hidden" name="on" value="1" />
    <input class="subscribe-form" type="button" value="<?php echo $this->lang->line('f_subs_form_button_title'); ?>" />
   </div>

  </form>

 </div><!-- end .subscribe-field -->

<?php endif; ?>