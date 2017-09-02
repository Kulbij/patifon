<div class="ownbox-content fmfdbc">
 <div class="fmtt">
  <?php echo $this->lang->line('ap_fb_title'); ?>
 </div>
 <a class="fmex ownbox-close" href="javascript:void(0);"></a>

 <form action="<?php echo site_url('ajax/form-send/feedback'); ?>" method="post">

  <div class="fmfld">
   <div class="fldtt"><?php echo $this->lang->line('ap_fb_field_title_name'); ?></div>
   <input class="fldtx" type="text" name="name" maxlength="255" />
  </div>

  <div class="fmfld">
   <div class="fldtt"><?php echo $this->lang->line('ap_fb_field_title_email'); ?></div>
   <input class="fldtx" type="text" name="email" maxlength="255" />
  </div>

  <div class="fmfld">
   <div class="fldtt"><?php echo $this->lang->line('ap_fb_field_title_text'); ?></div>
   <textarea class="fldtxar" rows="5" cols="30" name="text" maxlength="2000"></textarea>
  </div>

  <input class="ajax-form fmbt" type="submit" value="<?php echo $this->lang->line('ap_fb_button_submit'); ?>" />
  <input type="hidden" name="link" value="<?php echo base64_encode($this->input->get_referer($this->config->item('base_url'))); ?>" />
  <input type="hidden" name="robot" value="" />
 </form>

</div>