
<link rel="stylesheet" type="text/css" href="<?php echo baseurl('public/style/form.css'); ?>" />
<script type="text/javascript">
 $(document).ready(function(){
   $('input[type="checkbox"]').uniform();
   $('input[name=identity]').mask('+38 (999) 999-99-99');
 });
</script>

<div class="form ownbox-content">
 <div class="form-top"></div>

 <div class="form-content">
  <div class="form-exit">
   <a href="javascript:void(0);" class="ownbox-close"></a>
  </div>
  <div class="form-title">
   <h2>
    <?php echo $this->lang->line('ap_l_title'); ?>
   </h2>
  </div>
 
  <form action="<?php echo anchor_wta(site_url('user/ajax/form-send/login-form')); ?>" method="post" autocomplete="off">

   <div class="form-error" style="display: none;"></div>

   <div class="form-field">
    <div class="field-name">
     <?php echo $this->lang->line('ap_l_field_login'); ?>
    </div>
    <div class="field-input">
     <input type="text" maxlength="255" name="identity" placeholder="+38 (___) ___-__-__" value="" />
    </div>

    <div class="clear"></div>
   </div><!-- end .form-field -->

   <div class="form-field">
    <div class="field-name">
     <?php echo $this->lang->line('ap_l_field_password'); ?>
    </div>
    <div class="field-input">
     <input type="password" maxlength="255" name="password" value="" />
    </div>

    <div class="clear"></div>
   </div><!-- end .form-field -->

   <div class="form-checkbox">
    <label>
     <span class="checkbox-input">
      <input type="checkbox" name="remember" value="1" />
     </span>
     <span class="checkbox-text">
      <?php echo $this->lang->line('ap_l_field_remember'); ?>
     </span>
    </label>
    
    <div class="clear"></div>
   </div><!-- end .form-checkbox -->

   <div class="form-recover">
    <!--noindex-->
     <a href="<?php echo anchor_wta(site_url('user/ajax/form/forgot-password-form')); ?>" class="ownbox-form">
      <?php echo $this->lang->line('ap_l_field_forgot'); ?>
     </a>
    <!--/noindex-->
   </div>

   <div class="form-entry">
    <input class="ajax-form" type="button" value="<?php echo $this->lang->line('ap_l_field_enter'); ?>" />
   </div>

   <input type="hidden" name="robot" value="" />
  </form>

  <div class="clear"></div>

  <?php if (isset($SDS)) : ?>
   <div class="form-soc">
    <div class="soc-title">
     Войти через соц. сети
    </div>
    <div class="soc-fb">
     <a href="#">
      Facebook
     </a>
    </div>
    <div class="soc-vk">
     <a href="#">
      Vkontakte
     </a>
    </div>

    <div class="clear"></div>
   </div><!-- end .form-soc -->
  <?php endif; ?>
 </div><!-- end .form-content -->

 <div class="form-bottom"></div>
</div><!-- end .form -->