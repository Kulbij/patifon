
<?php if (isset($PAGINATION['COUNTPAGE']) && $PAGINATION['COUNTPAGE'] > 1) : ?>

<div class="pager">
 <ul>
  <?php 
   $start_ = $PAGINATION['THISPAGE'] - $PAGINATION['COUNTSHOWPAGE'];
   if ($start_ <= 0) $start_ = 1;
   
   $finish_ = $PAGINATION['THISPAGE'] + $PAGINATION['COUNTSHOWPAGE'];
   if ($finish_ > $PAGINATION['COUNTPAGE']) $finish_ = $PAGINATION['COUNTPAGE'];
  ?>
  
  <?php for ($i = $start_; $i <= $finish_; ++$i) : ?>
   
   <?php if ($PAGINATION['THISPAGE'] == $i) : ?>
    <li class="selected">
     <?php echo $i; ?>
    </li>
   <?php else : ?>
    <li>
     <a href="<?php echo anchor_wta(site_url($this->config->item('auth_user_page_link').'/'.$__LINK.'/page/'.$i)); ?>">
      <?php echo $i; ?>
     </a>
    </li>
   <?php endif; ?>
   
  <?php endfor; ?>
 </ul>
 
 <?php if (isset($PAGINATION['THISPAGE']) && $PAGINATION['THISPAGE'] > 1) : ?>
  <div class="pager-prev">
   <a href="<?php echo anchor_wta(site_url($this->config->item('auth_user_page_link').'/'.$__LINK.'/page/'.($PAGINATION['THISPAGE'] - 1))); ?>">
    <?php echo $this->lang->line('site_page_prev'); ?>
   </a>
  </div>
 <?php else : ?>
  <div class="pager-prev">
   <?php echo $this->lang->line('site_page_prev'); ?>
  </div>
 <?php endif; ?>

 <?php if ($PAGINATION['THISPAGE'] < $PAGINATION['COUNTPAGE']) : ?>
  <div class="pager-next">
   <a href="<?php echo anchor_wta(site_url($this->config->item('auth_user_page_link').'/'.$__LINK.'/page/'.($PAGINATION['THISPAGE'] + 1))); ?>">
    <?php echo $this->lang->line('site_page_next'); ?>
   </a>
  </div>
 <?php else : ?>
  <div class="pager-next">
   <?php echo $this->lang->line('site_page_next'); ?>
  </div>
 <?php endif; ?>

</div><!-- end .pager -->

<?php endif; ?>