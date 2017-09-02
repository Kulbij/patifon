<div id="content">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <div class="account">
  <?php echo $this->load->view('auth/inside/user_menu_view', null, true); ?>

  <div class="account-content">
   <div class="account-contacts">
    <div class="contacts-block">
     <div class="block-title">
      <?php echo $this->lang->line('accp_info_contact_title'); ?>
     </div>
     <div class="block-edit">
      <a href="<?php echo anchor_wta(site_url($this->config->item('auth_user_page_link').'/edit-info')); ?>">
       <?php echo $this->lang->line('accp_info_edit_title'); ?>
      </a>
     </div>

     <div class="clear"></div>
    
    <?php if (isset($SITE_CONTENT['user']['username']) && !empty($SITE_CONTENT['user']['username'])) : ?>
     <div class="block-string">
       <div class="string-name">
        <?php echo $this->lang->line('accp_info_name_title'); ?>
       </div>
       <div class="string-value">
        <?php echo $SITE_CONTENT['user']['username']; ?>
       </div>

       <div class="clear"></div>
     </div><!-- end .block-string -->
    <?php endif; ?>

    <?php if (isset($SITE_CONTENT['user']['email']) && !empty($SITE_CONTENT['user']['email'])) : ?>
     <div class="block-string">
       <div class="string-name">
        <?php echo $this->lang->line('accp_info_email_title'); ?>
       </div>
       <div class="string-value">
        <?php echo $SITE_CONTENT['user']['email']; ?>
       </div>

       <div class="clear"></div>
     </div><!-- end .block-string -->
    <?php endif; ?>

    <?php if (isset($SITE_CONTENT['user']['identity']) && !empty($SITE_CONTENT['user']['identity'])) : ?>
     <div class="block-string">
       <div class="string-name">
        <?php echo $this->lang->line('accp_info_phone_title'); ?>
       </div>
       <div class="string-value">
        <?php echo $SITE_CONTENT['user']['identity']; ?>
       </div>

       <div class="clear"></div>
     </div><!-- end .block-string -->
    <?php endif; ?>

     <div class="block-string">
       <div class="string-name"><?php echo $this->lang->line('accp_info_password_title'); ?></div>
       <div class="string-value">
        <a href="<?php echo anchor_wta(site_url($this->config->item('auth_user_page_link').'/edit-info')); ?>">
         <?php echo $this->lang->line('accp_info_password_change_link'); ?>
        </a>
       </div>

       <div class="clear"></div>
     </div><!-- end .block-string -->
    </div><!-- end .contacts-block -->

   </div><!-- end .account-contacts -->

   <div class="user-subscribe-container">
    <?php echo $this->load->view('auth/inside/user_subscribe_view', null, true); ?>
   </div>

   <div class="clear"></div>
  </div><!-- end .account-content -->
 
  <div class="clear"></div>
 </div><!-- end .account -->
</div><!-- end #content -->