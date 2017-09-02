<div class="block-comments-form">
 <div class="form-title">
  <?php echo $this->lang->line('op_review_form_title'); ?>
 </div>
 
 <form action="<?php echo anchor_wta(site_url('ajax/form-send/review')); ?>" method="post">

  <div class="form-field">
   <div class="field-title">
    <?php echo $this->lang->line('op_review_form_name'); ?>
   </div>
   <div class="field-input">
    <input type="text" name="name" maxlength="255" value="<?php echo $this->session->userdata('username'); ?>" />
   </div>
   <div class="clear"></div>
  </div><!-- end .form-field -->
  
  <div class="form-field">
   <div class="field-title">
    <?php echo $this->lang->line('op_review_form_email'); ?>
   </div>
   <div class="field-input">
    <input type="text" name="email" maxlength="255" value="<?php echo $this->session->userdata('email'); ?>" />
   </div>
   <div class="clear"></div>
  </div><!-- end .form-field -->
  
  <div class="form-field">
   <div class="field-title">
    <?php echo $this->lang->line('op_review_form_text'); ?>
   </div>
   <div class="field-textarea">
    <textarea cols="30" rows="5" name="text"></textarea>
   </div>
   <div class="clear"></div>
  </div><!-- end .form-field -->
  
  <div class="form-button">
   <input class="ajax-form" type="button" value="<?php echo $this->lang->line('op_review_form_button'); ?>" />
  </div>

  <input type="hidden" name="object" value="<?php if (isset($SITE_CONTENT['object']['id'])) echo $SITE_CONTENT['object']['id']; else echo 0; ?>" />

  <input type="hidden" name="link" value="<?php echo base64_encode(current_url()); ?>" />
  <input type="hidden" name="robot" value="" />

 </form>
 
 <div class="clear"></div>
</div><!-- end .block-comments-form -->