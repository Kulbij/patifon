<div id="content">

 <?php $this->load->view('inside/leftside/leftside_view'); ?>

<div class="content">
 
 <?php $this->load->view('inside/primary_menu_view'); ?>
 
 <?php $this->load->view('inside/slider_view'); ?>
 
 <?php $this->load->view('inside/bread_view'); ?>
 
 <?php if (isset($SITE_CONTENT['content']) && !empty($SITE_CONTENT['content'])) : ?>
 <div class="article">
  
  <?php foreach ($SITE_CONTENT['content'] as $value) : ?>
  <div class="article-item">
   <div class="item-image">
    <a href="<?php if (isset($value['link'])) echo anchor_wta(site_url($__LINK.'/detail/'.$value['link'])); ?>">
     <span class="vertical">
      <img src="<?php if (isset($value['image'])) echo baseurl($value['image']); ?>" alt="<?php if (isset($value['name'])) echo $value['name']; ?>" />
     </span>
    </a>
   </div><!-- end .item-image -->
   
   <div class="item-info">
    <div class="info-title">
     <a href="<?php if (isset($value['link'])) echo anchor_wta(site_url($__LINK.'/detail/'.$value['link'])); ?>">
      <?php if (isset($value['name'])) echo $value['name']; ?>
     </a>
    </div>
    <div class="info-text">
     <?php if (isset($value['shorttext'])) echo $value['shorttext']; ?>
    </div>
   </div><!-- end .item-info -->
   
   <div class="clear"></div>
  </div><!-- end .article-item -->
  <?php endforeach; ?>
  
  <?php if (isset($PAGINATION['COUNTPAGE']) && $PAGINATION['COUNTPAGE'] > 1) : ?>
  <div class="pager">
    
    <ul>
     
     <?php if ($PAGINATION['THISPAGE'] > 1) : ?>
      <li class="pager-prev">
       <a href="<?php echo anchor_wta(site_url($__LINK.'/'.$CATEGORYLINK.'/page/'.($PAGINATION['THISPAGE'] - 1))); ?>">
        <?php echo $this->lang->line('promo_page_prev'); ?>
       </a>
      </li>
     <?php endif; ?>
     
     <?php 
      $start_ = $PAGINATION['THISPAGE'] - $PAGINATION['COUNTSHOWPAGE'];
      if ($start_ <= 0) $start_ = 1;
      
      $finish_ = $PAGINATION['THISPAGE'] + $PAGINATION['COUNTSHOWPAGE'];
      if ($finish_ > $PAGINATION['COUNTPAGE']) $finish_ = $PAGINATION['COUNTPAGE'];
     ?>
     
     <?php for ($i = $start_; $i <= $finish_; ++$i) : ?>
      
      <?php if ($PAGINATION['THISPAGE'] == $i) : ?>
      <li class="selected"><?php echo $i; ?></li>
      <?php else : ?>
      <li class="pager-num"><?php echo anchor(site_url($__LINK.'/'.$CATEGORYLINK.'/page/'.$i), $i, array()); ?></li>
      <?php endif; ?>
      
     <?php endfor; ?>
     
     <?php if ($PAGINATION['THISPAGE'] < $PAGINATION['COUNTPAGE']) : ?>
      <li class="pager-next">
       <a href="<?php echo anchor_wta(site_url($__LINK.'/'.$CATEGORYLINK.'/page/'.($PAGINATION['THISPAGE'] + 1))); ?>">
        <?php echo $this->lang->line('promo_page_next'); ?>
       </a>
      </li>
     <?php endif; ?>
     
    </ul>
    
  </div><!-- end .pager -->
  <?php endif; ?>
  
 </div><!-- end .article -->
 <?php endif; ?>
 
 <?php if (isset($SITE_CONTENT['cats']) && !empty($SITE_CONTENT['cats'])) : ?>
 <div class="article-category">
  <div class="category-title"><?php echo $this->lang->line('promo_cat'); ?></div>
  
  <ul>
     
    <?php if (isset($__GEN['cat_id']) && $__GEN['cat_id'] == 0) : ?>
     <li class="selected"><?php echo $this->lang->line('site_all'); ?></li>
    <?php else : ?>
     <li>
      <a href="<?php echo anchor_wta(site_url('promotions')); ?>">
       <?php echo $this->lang->line('site_all'); ?>
      </a>
     </li>
    <?php endif; ?>
     
   <?php foreach ($SITE_CONTENT['cats'] as $value) : ?>
    <?php if (isset($__GEN['cat_id']) && $__GEN['cat_id'] == $value['id']) : ?>
     <li class="selected"><?php if (isset($value['name'])) echo $value['name']; ?></li>
    <?php else : ?>
     <li>
      <a href="<?php if (isset($value['link'])) echo anchor_wta(site_url('promotions/'.$value['link'])); ?>">
       <?php if (isset($value['name'])) echo $value['name']; ?>
      </a>
     </li>
    <?php endif; ?>
   <?php endforeach; ?>
  </ul>
 </div><!-- end .article-category -->
 <?php endif; ?>

 <div class="clear"></div>
 </div><!-- end .content -->

 <div class="clear"></div>
 </div><!-- end #content -->