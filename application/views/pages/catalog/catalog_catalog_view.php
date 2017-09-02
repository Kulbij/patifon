  <div id="cnt">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <?php echo $this->load->view('inside/leftside/leftside_view', null, true); ?>

  <div class="cnt">
    <!-- catalog -->
    <div class="ct">

      <!-- catalog top -->
      <div class="cttop">

       <?php if (
        (isset($SITE_LEFTPANEL['SORT']['children']) && !empty($SITE_LEFTPANEL['SORT']['children']))
       ) : ?>
        <div class="ctst">
         <?php echo $this->lang->line('cat_sort_title'); ?>

         <div class="stsl">
          <?php foreach ($SITE_LEFTPANEL['SORT']['children'] as $value) : ?>
           <?php if (isset($value['link']) && isset($SITE_CONTENT['FILTER']['sort'][0]) && $SITE_CONTENT['FILTER']['sort'][0] == $value['link']) : ?>
            <a class="slmain" href="javascript:void(0);">
             <i class="icsl"></i>
             <?php echo $value['name']; ?>
            </a>
           <?php break; endif; ?>
          <?php endforeach; ?>

          <div class="sldr">
           <div class="drln"></div>

           <?php foreach ($SITE_LEFTPANEL['SORT']['children'] as $value) : ?>
           <?php if(!empty($PARENTCATEGORYLINK)):?>
            <a class="drlk" href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/filter/'.$value['linker'])); ?>">
                <?php else:?>
            <a class="drlk" href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/filter/'.$value['linker'])); ?>">
                <?php endif;?>
             <?php echo $value['name']; ?>
            </a>
           <?php endforeach; ?>

          </div>
         </div>
        </div>
       <?php endif; ?>

       <?php if (
        (isset($SITE_LEFTPANEL['VIEW']['children']) && !empty($SITE_LEFTPANEL['VIEW']['children']))
       ) : ?>
        <div class="cttp">
         <?php foreach ($SITE_LEFTPANEL['VIEW']['children'] as $value) : ?>
            <?php if(!empty($PARENTCATEGORYLINK)):?>
          <a class="tpit <?php echo $value['field']; ?> <?php if (isset($value['link']) && isset($SITE_CONTENT['FILTER']['view'][0]) && $SITE_CONTENT['FILTER']['view'][0] == $value['link']) echo 'ac'; ?>" href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/filter/'.$value['linker'])); ?>"></a>
          <?php else:?>
          <a class="tpit <?php echo $value['field']; ?> <?php if (isset($value['link']) && isset($SITE_CONTENT['FILTER']['view'][0]) && $SITE_CONTENT['FILTER']['view'][0] == $value['link']) echo 'ac'; ?>" href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/filter/'.$value['linker'])); ?>"></a>
          <?php endif;?>
         <?php endforeach; ?>
        </div>
       <?php endif; ?>

      </div>
      <!-- end catalog top -->
      <input type="hidden" class="product_count_all" value="<?php echo $SITE_CONTENT['catalog']['count_copy']; ?>" />
     <?php
      if (isset($SITE_CONTENT['catalog']) && !empty($SITE_CONTENT['catalog'])) :
       $_list = false;
     ?>
      <div class="<?php if (isset($SITE_CONTENT['FILTER']['view'][0]) && $SITE_CONTENT['FILTER']['view'][0] == 'list') { $_list = true; echo 'ctls'; } else echo 'cttl'; ?> col-3">

       <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['catalog'], '_list' => $_list), true); ?>

       <div id="div_catalog_more"></div>

       <div class="clr"></div>
      </div>
     <?php endif; ?>

    </div>
    <!-- end catalog -->

  <?php if (isset($PAGINATION['PAGES']) && is_array($PAGINATION['PAGES']) && !empty($PAGINATION['PAGES'])) : ?>
   <div class="pg">

    <?php if (isset($PAGINATION['COUNT_TO_THIS_PAGE']) && $PAGINATION['COUNT_TO_THIS_PAGE'] < $PAGINATION['COUNTALL']) : ?>

     <div id="div-catalog-more-button">
      <input type="hidden" name="catalog_more_category" value="<?php if (isset($CATEGORYLINK)) echo $CATEGORYLINK; ?>" />
      <input type="hidden" name="catalog_more_parametter" value="<?php if (isset($PAGINATION['PAGE_NEXT_LINK'])) echo htmlspecialchars($PAGINATION['PAGE_NEXT_LINK']).$this->config->item('url_suffix'); ?>" />
      <input type="hidden" name="catalog_more_parametter_page" value="<?php if (isset($PAGINATION['THISPAGE'])) echo (int)$PAGINATION['THISPAGE']; ?>" />
      <input type="hidden" name="catalog_more_parametter_page_last" value="<?php if (isset($PAGINATION['COUNTPAGE'])) echo (int)$PAGINATION['COUNTPAGE']; ?>" />
     </div>

     <button class="pgmr catalog-more">
      <i class="icmr"></i>
      <span class="mrtx"><?php echo $this->lang->line('cat_button_more'); ?></span>
     </button>
    <?php endif; ?>

    <ul class="pgls">

     <?php foreach ($PAGINATION['PAGES'] as $value) : ?>

      <?php if (isset($value['selected']) && $value['selected']) : ?>
       <li class="lsit ac"><?php echo $value['name']; ?></li>
      <?php else : ?>
       <li class="lsit" data-page="<?php echo $value['name']; ?>">
           <?php if(!empty($PARENTCATEGORYLINK)):?>
        <?php echo anchor(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/filter/'.$value['linker']), $value['name'], array('class' => 'itlk')); ?>
           <?php else:?>
        <?php echo anchor(site_url('catalog/'.$CATEGORYLINK.'/filter/'.$value['linker']), $value['name'], array('class' => 'itlk')); ?>
           <?php endif;?>
       </li>
      <?php endif; ?>

     <?php endforeach; ?>

    </ul>

    <?php if (!isset($SDS)) : ?>
     <?php if ($PAGINATION['THISPAGE'] > 1) : ?>
        <?php if(!empty($PARENTCATEGORYLINK)):?>
      <a href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/filter/'.$PAGINATION['prev_page'])); ?>" class="pgpr">
          <?php else:?>
      <a href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/filter/'.$PAGINATION['prev_page'])); ?>" class="pgpr">
          <?php endif;?>
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
          <?php if(!empty($PARENTCATEGORYLINK)):?>
      <a href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/filter/'.$PAGINATION['next_page'])); ?>" class="pgnx">
          <?php elsE:?>
      <a href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/filter/'.$PAGINATION['next_page'])); ?>" class="pgnx">
          <?php endif;?>
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

<?php if (isset($SDS)) : ?>

<div id="content">

<?php $this->load->view('inside/bread_view'); ?>

<?php if (
 (isset($SITE_LEFTPANEL['SORT']['children']) && !empty($SITE_LEFTPANEL['SORT']['children']))
) : ?>
<div class="sort">
 <div class="sort-info">
  <div class="info-view">
   <?php if (isset($PAGINATION['COUNTALL']) && $PAGINATION['COUNTALL'] > 0) echo sprintf($this->lang->line('cat_showed_counter'), (isset($PAGINATION['COUNTSHOWNOW']) ? $PAGINATION['COUNTSHOWNOW'] : 0), $PAGINATION['COUNTALL']); ?>
  </div>

  <div class="info-sort">
    <p><?php echo $this->lang->line('cat_sort_title'); ?>:</p>

    <ul>
     <?php foreach ($SITE_LEFTPANEL['SORT']['children'] as $value) : ?>

      <?php if (isset($value['link']) && isset($SITE_CONTENT['FILTER']['sort'][0]) && $SITE_CONTENT['FILTER']['sort'][0] == $value['link']) : ?>
       <li class="selected">
        <?php echo $value['name']; ?>
       </li>
      <?php else : ?>
       <li>
        <?php if (isset($value['linker'])) echo anchor(site_url('catalog/'.$CATEGORYLINK.'/'.$value['linker']), $value['name'], array()); ?>
       </li>
      <?php endif; ?>

     <?php endforeach; ?>
    </ul>

    <div class="clear"></div>
  </div><!-- end .info-sort -->
 </div><!-- end .sort-info -->

 <?php if (isset($SITE_LEFTPANEL['RESET_BUTTON']) && $SITE_LEFTPANEL['RESET_BUTTON'] !== false) : ?>
  <div class="sort-selected">

   <div class="selected-block">
    <div class="selected-reset">
     <a href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/'.$SITE_LEFTPANEL['RESET_BUTTON'])); ?>"><?php echo $this->lang->line('cat_reset_button'); ?><img src="<?php echo baseurl('public/images/content/icon/reset.png'); ?>" alt="R" /></a>
    </div>
   </div><!-- end .selected-block -->

   <div class="clear"></div>
  </div><!-- end .sort-selected -->
 <?php endif; ?>

</div><!-- end .sort -->
<?php endif; ?>

<?php $this->load->view('inside/leftside/leftside_view'); ?>

<div class="content">

 <?php if (isset($SITE_CONTENT['cattext']) && !empty($SITE_CONTENT['cattext'])) : ?>
  <div class="content-text">
   <?php echo $SITE_CONTENT['cattext']; ?>
  </div>
 <?php endif; ?>

 <?php if (isset($SITE_CONTENT['catalog']) && !empty($SITE_CONTENT['catalog'])) : ?>
  <div class="catalog">

   <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['catalog']), true); ?>

   <div id="div_catalog_more"></div>

   <div class="clear"></div>
  </div><!-- end .catalog -->
 <?php endif; ?>

</div><!-- end .content -->

<div class="clear"></div>

<?php if (isset($PAGINATION['COUNT_TO_THIS_PAGE']) && $PAGINATION['COUNT_TO_THIS_PAGE'] < $PAGINATION['COUNTALL']) : ?>
 <div id="div_catalog_more_button">
  <input type="hidden" name="catalog_more_category" value="<?php if (isset($CATEGORYLINK)) echo $CATEGORYLINK; ?>" />
  <input type="hidden" name="catalog_more_parametter" value="<?php if (isset($PAGINATION['PAGE_NEXT_LINK'])) echo htmlspecialchars($PAGINATION['PAGE_NEXT_LINK']).$this->config->item('url_suffix'); ?>" />
  <input type="hidden" name="catalog_more_parametter_page" value="<?php if (isset($PAGINATION['THISPAGE'])) echo (int)$PAGINATION['THISPAGE']; ?>" />
  <input type="hidden" name="catalog_more_parametter_page_last" value="<?php if (isset($PAGINATION['COUNTPAGE'])) echo (int)$PAGINATION['COUNTPAGE']; ?>" />

  <div class="more-button">
   
  </div>
 </div>
<?php endif; ?>

<?php if (isset($PAGINATION['PAGES']) && is_array($PAGINATION['PAGES']) && !empty($PAGINATION['PAGES'])) :  ?>
<div class="pager">

 <ul>

  <?php foreach ($PAGINATION['PAGES'] as $value) : ?>

   <?php if (isset($value['selected']) && $value['selected']) : ?>
    <li class="selected"><?php echo $value['name'] ?></li>
   <?php else : ?>
    <li class="pager-num" data-page="<?php echo $value['name']; ?>">
     <?php echo anchor(site_url('catalog/'.$CATEGORYLINK.'/'.$value['linker']), $value['name'], array()); ?>
    </li>
   <?php endif; ?>

  <?php endforeach; ?>

 </ul>

 <?php if (isset($SDS)) : ?>
  <?php if ($PAGINATION['THISPAGE'] > 1) : ?>
   <div class="pager-prev">
    <a href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/'.$PAGINATION['prev_page'])); ?>">
     <?php echo $this->lang->line('site_page_prev'); ?>
    </a>
   </div>
  <?php else : ?>
   <div class="pager-prev">
    <?php echo $this->lang->line('site_page_prev'); ?>
   </div>
  <?php endif; ?>
 <?php endif; ?>

 <?php if (isset($SDS)) : ?>
  <?php if ($PAGINATION['THISPAGE'] < $PAGINATION['COUNTPAGE']) : ?>
   <div class="pager-next">
    <a href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/'.$PAGINATION['next_page'])); ?>">
     <?php echo $this->lang->line('site_page_next'); ?>
    </a>
   </div>
  <?php else : ?>
   <div class="pager-next">
    <?php echo $this->lang->line('site_page_next'); ?>
   </div>
  <?php endif; ?>
 <?php endif; ?>

</div><!-- end .pager -->
<?php endif; ?>

 <div class="clear"></div>
</div><!-- end #content -->


<?php endif; ?>