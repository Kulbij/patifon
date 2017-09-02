<div class="account-menu">
 <?php if (isset($SITE_CONTENT['page_list']) && !empty($SITE_CONTENT['page_list'])) : ?>
  <ul>
   <?php foreach ($SITE_CONTENT['page_list'] as $value) : ?>

    <?php if (isset($__LINK) && isset($value['link']) && $__LINK == $value['link']) : ?>
     <li class="selected">
      <?php if (isset($value['name'])) echo $value['name']; ?>
     </li>
    <?php else : ?>
     <li>
      <a href="<?php echo anchor_wta(site_url($this->config->item('auth_user_page_link').'/'.$value['link'])); ?>">
       <?php if (isset($value['name'])) echo $value['name']; ?>
      </a>
     </li>
    <?php endif; ?>
    
   <?php endforeach; ?>
  </ul>
 <?php endif; ?>
</div><!-- end .account-menu -->