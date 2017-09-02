<div class="block-product-comments">
 <div class="block-left">

  <?php if (isset($SITE_CONTENT['comments']) && !empty($SITE_CONTENT['comments'])) : ?>

   <div class="block-comments">
    <div class="comments-title">
     <?php echo $this->lang->line('op_review_title'); ?>
    </div>
    
    <?php foreach ($SITE_CONTENT['comments'] as $value) : ?>
     <div class="comments-item">
      <div class="item-name">
       <?php if (isset($value['name'])) echo $value['name']; ?>
      </div>
      <div class="item-date">
       <?php if (isset($value['datetime'])) echo date('d.m.Y', strtotime($value['datetime'])); ?>
      </div>
      <div class="item-text">
       <?php if (isset($value['text'])) echo $value['text']; ?>
      </div>
     </div><!-- end .comments-item -->
    <?php endforeach; ?>
    
   </div><!-- end .block-comments -->
   
   <?php if (isset($SITE_CONTENT['product_pages']['count_page']) && $SITE_CONTENT['product_pages']['count_page'] > 1) :

    $page_start = $SITE_CONTENT['product_pages']['this_page'] - $SITE_CONTENT['product_pages']['count_show_page'];
    if ($page_start <= 0) $page_start = 1;

    $page_finish = $SITE_CONTENT['product_pages']['this_page'] + $SITE_CONTENT['product_pages']['count_show_page'];
    if ($page_finish > $SITE_CONTENT['product_pages']['count_page']) $page_finish = $SITE_CONTENT['product_pages']['count_page'];

   ?>
    <div class="pager">
     <ul>

      <?php for ($i = $page_start; $i <= $page_finish; ++$i) : ?>

       <?php if ($SITE_CONTENT['product_pages']['this_page'] == $i) : ?>
        <li class="selected">
         <?php echo $i; ?>
        </li>
       <?php else : ?>
        <li>
         <a href="<?php echo anchor_wta(site_url('product/'.$__GEN['obj_link'].'/review/page/'.$i)), '#tabs'; ?>">
          <?php echo $i; ?>
         </a>
        </li>
       <?php endif; ?>

      <?php endfor; ?>

     </ul>
     
     <?php if ($SITE_CONTENT['product_pages']['this_page'] > 1) : ?>
      <div class="pager-prev">
       <a href="<?php echo anchor_wta(site_url('product/'.$__GEN['obj_link'].'/review/page/'.($SITE_CONTENT['product_pages']['this_page'] - 1))), '#tabs'; ?>">
        <?php echo $this->lang->line('site_page_prev'); ?>
       </a>
      </div>
     <?php else : ?>
      <div class="pager-prev">
       <?php echo $this->lang->line('site_page_prev'); ?>
      </div>
     <?php endif; ?>

     <?php if ($SITE_CONTENT['product_pages']['this_page'] < $SITE_CONTENT['product_pages']['count_page']) : ?>
      <div class="pager-next">
       <a href="<?php echo anchor_wta(site_url('product/'.$__GEN['obj_link'].'/review/page/'.($SITE_CONTENT['product_pages']['this_page'] + 1))), '#tabs'; ?>">
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

  <?php else : ?>

   <div class="block-comments">
    <div class="comments-title">
     <?php echo $this->lang->line('op_review_no_title'); ?>
    </div>
   </div><!-- end .block-comments -->

  <?php endif; ?>

 </div><!-- end .block-left -->
 
 <div class="block-right">
  <?php echo $this->load->view('inside/object/subs_review_form_view', null, true); ?>
 </div><!-- end .block-right -->
  
 <div class="clear"></div>
</div><!-- end .block-product-comments -->