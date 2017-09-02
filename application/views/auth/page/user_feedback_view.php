<div id="content">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <div class="account">
  <?php echo $this->load->view('auth/inside/user_menu_view', null, true); ?>

  <div class="account-content">
   <div class="account-feedback">
    <div class="form-title">
     <?php echo $this->lang->line('accp_feedback_title'); ?>
    </div>
    
    <form action="<?php echo anchor_wta(site_url('ajax/form-send/feedback')); ?>" method="post">

     <div class="form-field">
      <div class="field-title">
       <?php echo $this->lang->line('accp_feedback_form_name_title'); ?>
      </div>
      
      <div class="field-input">
       <input type="text" maxlength="255" name="name" value="<?php echo $this->session->userdata('username'); ?>" />
      </div>
      
      <div class="clear"></div>
     </div><!-- end .form-field -->
     
     <div class="form-field">
      <div class="field-title">
       <?php echo $this->lang->line('accp_feedback_form_email_title'); ?>
      </div>
      
      <div class="field-input">
       <input type="text" maxlength="255" name="email" value="<?php echo $this->session->userdata('email'); ?>" />
      </div>
      
      <div class="clear"></div>
     </div><!-- end .form-field -->
     
     <div class="form-field">
      <div class="field-title">
       <?php echo $this->lang->line('accp_feedback_form_text_title'); ?>
      </div>
      
      <div class="field-textarea">
       <textarea name="text" maxlength="5000" cols="30" rows="5"></textarea>
      </div>
      
      <div class="clear"></div>
     </div><!-- end .form-field -->
     
     <div class="form-button">
      <input class="ajax-form" type="button" value="<?php echo $this->lang->line('accp_feedback_form_submit'); ?>" />
     </div>

     <input type="hidden" name="link" value="<?php echo base64_encode(current_url()); ?>" />
     <input type="hidden" name="robot" value="" />
    </form>
    
    <div class="clear"></div>
   </div><!-- end .account-feedback -->
  </div><!-- end .account-content -->

  <div class="clear"></div>
 </div><!-- end .account -->
</div><!-- end #content -->