<script type="text/javascript" language="JavaScript">
 $(document).ready(function(){
   $('input[name=phone]').mask('+38 (999) 999–99–99');
 });
</script>

<div class="ownbox-content form form-feedback">
  <div class="title"><?php echo $this->lang->line('ap_cb_title'); ?></div>
  <a class="close ownbox-close" href="javascript:void(0);"></a>
  
<form action="<?php echo anchor_wta(site_url('ajax/form-send/callback')); ?>" method="post">
  <div class="field">
    <div class="name"><?php echo $this->lang->line('ap_cb_field_title_name'); ?></div>
    <input type="text" class="input-text" name="name" maxlength="255" />
  </div><!-- end .field -->

  <div class="field">
    <div class="name"><?php echo $this->lang->line('ap_cb_field_title_phone'); ?></div>
    <input class="input-text" type="text" name="phone" maxlength="255" placeholder="+38 (___) ___–__–__" value="+38 (___) ___–__–__" />
  </div><!-- end .field -->

  <div class="field">
    <div class="name"><?php echo $this->lang->line('ap_cb_field_title_text'); ?></div>
    <textarea cols="30" rows="10" class="textarea" name="text" maxlength="2000"></textarea>
  </div><!-- end .field -->

  <input type="submit" class="input-button ajax-form" value="<?php echo $this->lang->line('ap_cb_button_submit'); ?>">
  <input type="hidden" name="link" value="<?php echo base64_encode($this->input->get_referer($this->config->item('base_url'))); ?>" />
  <input type="hidden" name="robot" value="" />
  </form>
</div><!-- end .ownbox-content -->