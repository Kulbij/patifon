
<script type="text/javascript">
 $(document).ready(function(){
  $('input[type="checkbox"]').uniform();
 });
</script>

<div id="content">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <div class="account">
  <?php echo $this->load->view('auth/inside/user_menu_view', null, true); ?>

  <div class="account-content">
   <div class="account-form">
    <div class="form-block">
     <div class="block-title">
      <?php echo $this->lang->line('accp_sp_title'); ?>
     </div>
    
     <form action="<?php echo anchor_wta(site_url('user/ajax/form-send/my-info-form')); ?>" method="post">
    
      <div class="block-success form-success" style="display: none;"></div>

      <div class="block-error form-error" style="display: none;"></div>
      <div class="block-error form-error2" style="display: none;"></div>

      <div class="block-field">
       <div class="field-name">
        <div class="vertical"><?php echo $this->lang->line('accp_info_name_title'); ?></div>
       </div>
       <div class="field-input">
        <input type="text" maxlength="255" name="name" value="<?php if (isset($SITE_CONTENT['user']['username'])) echo $SITE_CONTENT['user']['username']; ?>" />
       </div>

       <div class="clear"></div>
      </div><!-- end .block-field -->

      <div class="block-field">
       <div class="field-name">
        <div class="vertical"><?php echo $this->lang->line('accp_info_email_title'); ?></div>
       </div>
       <div class="field-input">
        <input type="text" maxlength="255" name="email" value="<?php if (isset($SITE_CONTENT['user']['email'])) echo $SITE_CONTENT['user']['email']; ?>" />
       </div>

       <div class="clear"></div>
      </div><!-- end .block-field -->

      <div class="block-field">
       <div class="field-link">
        <a href="javascript:void(0);" class="user-add-phone">
         <?php echo $this->lang->line('accp_info_link_add_phone'); ?>
        </a>
       </div>
      </div><!-- end .block-field -->

      <div class="phone-container">
       <?php if (isset($SITE_CONTENT['user-phones']) && !empty($SITE_CONTENT['user-phones'])) : ?>

        <script type="text/javascript" language="JavaScript">
         $(document).ready(function(){
          $('.new-phone').mask('+38 (999) 999-99-99');
         });
        </script>

        <?php foreach ($SITE_CONTENT['user-phones'] as $value) : ?>
         <?php echo $this->load->view('auth/inside/user_edit_info_phone_field_view', array(
          'id' => $value['id'],
          'value' => $value['phone']
         ), true); ?>
        <?php endforeach; ?>

       <?php endif; ?>
      </div>

      <div class="block-field">
       <div class="field-name">
        <div class="vertical"><?php echo $this->lang->line('accp_info_password_old_title'); ?></div>
       </div>
       <div class="field-input">
        <input type="password" maxlength="255" name="password_old" value="" />
       </div>

       <div class="clear"></div>
      </div><!-- end .block-field -->

      <div class="block-field">
       <div class="field-name">
        <div class="vertical"><?php echo $this->lang->line('accp_info_password_new_title'); ?></div>
       </div>
       <div class="field-input">
        <input type="password" maxlength="255" name="password_new" value="" />
       </div>

       <div class="clear"></div>
      </div><!-- end .block-field -->

      <div class="block-field">
       <div class="field-name">
        <div class="vertical"><?php echo $this->lang->line('accp_info_password_confirm_title'); ?></div>
       </div>
       <div class="field-input">
        <input type="password" maxlength="255" name="password_confirm" value="" />
       </div>

       <div class="clear"></div>
      </div><!-- end .block-field -->

      <div class="block-button">
       <input class="ajax-form" type="button" value="<?php echo $this->lang->line('accp_info_submit'); ?>" />
      </div>
      <?php if (isset($SDS)) : ?>
       <div class="block-reset">
        <input type="reset" value="<?php echo $this->lang->line('accp_info_reset'); ?>" />
       </div>
      <?php endif; ?>

      <input type="hidden" name="robot" value="" />
     </form>

     <div class="clear"></div>
    </div><!-- end .form-block -->
   </div><!-- end .account-form -->
    
   <div class="user-subscribe-container">
    <?php echo $this->load->view('auth/inside/user_subscribe_view', null, true); ?>
   </div>

   <div class="clear"></div>
  </div><!-- end .account-content -->

  <div class="clear"></div>
 </div><!-- end .account -->
</div><!-- end #content -->