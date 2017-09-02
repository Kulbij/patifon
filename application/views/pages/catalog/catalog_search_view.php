<div id="cnt">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <?php echo $this->load->view('inside/leftside/leftside_view', null, true); ?>

  <div class="cnt">
    <!-- catalog -->
    <div class="ct">

     <?php if (isset($SITE_CONTENT['catalog']) && !empty($SITE_CONTENT['catalog'])) : ?>
      <div class="cttl">

       <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['catalog']), true); ?>

       <div class="clr"></div>
      </div>
     <?php endif; ?>

    </div>
    <!-- end catalog -->

  <?php if (isset($PAGINATION['COUNTPAGE']) && $PAGINATION['COUNTPAGE'] > 1) : ?>
   <div class="pg">

    <ul class="pgls">

     <?php
      $start_ = $PAGINATION['THISPAGE'] - $PAGINATION['COUNTSHOWPAGE'];
      if ($start_ <= 0) $start_ = 1;

      $finish_ = $PAGINATION['THISPAGE'] + $PAGINATION['COUNTSHOWPAGE'];
      if ($finish_ > $PAGINATION['COUNTPAGE']) $finish_ = $PAGINATION['COUNTPAGE'];
     ?>

     <?php for ($i = $start_; $i <= $finish_; ++$i) : ?>

      <?php if ($PAGINATION['THISPAGE'] == $i) : ?>
       <li class="lsit ac"><?php echo $i; ?></li>
      <?php else : ?>
       <li class="lsit">
        <a href="<?php echo anchor_wta(site_url('catalog/search/page/'.$i)), '?search=', $this->input->get('search'); ?>" class="itlk">
         <?php echo $i; ?>
        </a>
       </li>
      <?php endif; ?>

     <?php endfor; ?>

    </ul>

    <?php if (!isset($SDS)) : ?>
     <?php if ($PAGINATION['THISPAGE'] > 1) : ?>
      <a href="<?php echo anchor_wta(site_url('catalog/search/page/'.($PAGINATION['THISPAGE'] - 1))), '?search=', $this->input->get('search'); ?>" class="pgpr">
       <i class="pgar"></i><?php echo $this->lang->line('site_page_prev'); ?>
      </a>
     <?php else : ?>
      <a href="javascript:void(0);" class="pgpr db">
       <i class="pgar"></i><?php echo $this->lang->line('site_page_prev'); ?>
      </a>
     <?php endif; ?>
    <?php endif; ?>

    <?php if (!isset($SDS)) : ?>
     <?php if ($PAGINATION['THISPAGE'] < $PAGINATION['COUNTPAGE']) : ?>
      <a href="<?php echo anchor_wta(site_url('catalog/search/page/'.($PAGINATION['THISPAGE'] + 1))), '?search=', $this->input->get('search'); ?>" class="pgnx">
       <?php echo $this->lang->line('site_page_next'); ?><i class="pgar"></i>
      </a>
     <?php else : ?>
      <a href="javascript:void(0);" class="pgnx db">
       <?php echo $this->lang->line('site_page_next'); ?><i class="pgar"></i>
      </a>
     <?php endif; ?>
    <?php endif; ?>

   </div>
  <?php endif; ?>

  </div>

 <div class="clr"></div>
</div>