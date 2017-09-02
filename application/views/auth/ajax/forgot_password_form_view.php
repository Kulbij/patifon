
<link rel="stylesheet" type="text/css" href="<?php echo baseurl('public/style/form.css'); ?>" />
<script type="text/javascript" language="JavaScript">
 $(document).ready(function(){
  $('input[name=identity]').mask('+38 (999) 999-99-99');
 });
</script>

<div class="ownbox-content form">
 <div class="form-top"></div>

 <form action="<?php echo anchor_wta(site_url('user/ajax/form-send/forgot-password-form')); ?>" method="post">
  <div class="form-content">
   <div class="form-exit">
    <a href="javascript:void(0);" class="ownbox-close"></a>
   </div>
   <div class="form-title">
    <h2>
     <?php echo $this->lang->line('ap_fp_title'); ?>
    </h2>
   </div>

   <div class="form-error" style="display: none;"></div>

   <div class="form-field">
     <div class="field-name">
      <?php echo $this->lang->line('ap_fp_field_identity'); ?>
     </div>
     <div class="field-input">
      <input type="text" name="identity" maxlength="255" placeholder="+38 (___) ___-__-__" value="" />
     </div>

     <div class="clear"></div>
   </div><!-- end .form-field -->
   
   <div class="form-recover-button">
    <input class="ajax-form" type="button" value="<?php echo $this->lang->line('ap_fp_field_button'); ?>" />
   </div>

   <div class="clear"></div>
  </div><!-- end .form-content -->

  <input type="hidden" name="robot" value="" />
 </form>

 <div class="form-bottom"></div>
</div><!-- end .form -->