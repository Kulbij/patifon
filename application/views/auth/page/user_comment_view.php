<div id="content">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <div class="account">
  <?php echo $this->load->view('auth/inside/user_menu_view', null, true); ?>

  <div class="account-content">
   <div class="account-comments">

    <?php if (isset($SITE_CONTENT['comments']) && !empty($SITE_CONTENT['comments'])) : ?>
     <?php foreach ($SITE_CONTENT['comments'] as $value) : ?>
      <div class="comments-block">
       <div class="block-title">
        <?php if (isset($value['name'])) echo $value['name']; ?>
       </div>

       <?php if (isset($value['comments']) && !empty($value['comments'])) : ?>
        <?php foreach ($value['comments'] as $comment) : ?>
         <div class="block-item">
          <div class="item-date">
           <?php if (isset($comment['datetime'])) echo date('d.m.Y', strtotime($comment['datetime'])); ?>
          </div>

          <div class="item-text">
           <?php if (isset($comment['text'])) echo $comment['text']; ?>
          </div><!-- end .item-text -->

          <div class="item-link">
           <a href="<?php echo anchor_wta(site_url('product/'.$value['link'])); ?>">
            <?php echo $this->lang->line('accp_comment_to_product'); ?>
           </a>
          </div>
         </div><!-- end .block-item -->
        <?php endforeach; ?>
       <?php endif; ?>
      
      </div>
     <?php endforeach; ?>
    <?php endif; ?>

   </div><!-- end .account-comments -->
  </div><!-- end .account-content -->

  <div class="clear"></div>
 </div><!-- end .account -->

 <?php echo $this->load->view('auth/inside/user_page_view', null, true); ?>
</div><!-- end #content -->