<div id="cnt">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <?php
  if (isset($SITE_CONTENT['content']) && !empty($SITE_CONTENT['content'])) :

   $last_articles = array();
   if ($PAGINATION['THISPAGE'] == 1) {

    $last_articles = array_slice($SITE_CONTENT['content'], 0, 3);
    $SITE_CONTENT['content'] = array_slice($SITE_CONTENT['content'], 3, count($SITE_CONTENT['content']) - 3);

   }

 ?>

  <div class="ar">

   <?php if (isset($last_articles) && !empty($last_articles)) : ?>

    <?php foreach ($last_articles as $key => $value) : ?>

     <?php if ($key == 0) : ?>

      <div class="arbgit">
        <a class="itim" href="<?php echo anchor_wta(site_url('articles/detail/'.$value['link'])); ?>">
         <span class="imvral">
          <img class="imim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>">
         </span>
        </a>

        <div class="ittt">
         <a class="ttlk" href="<?php echo anchor_wta(site_url('articles/detail/'.$value['link'])); ?>">
          <?php echo $value['name']; ?>
         </a>
        </div>

        <div class="ittx">
         <p><?php echo $value['shorttext']; ?></p>
        </div>
      </div>

     <?php else : ?>

      <a class="arslit" href="<?php echo anchor_wta(site_url('articles/detail/'.$value['link'])); ?>">
        <span class="itvral">
         <img class="itim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>">
        </span>

        <span class="ithv"></span>
        <span class="ittt"><?php echo $value['name']; ?></span>
      </a>

     <?php endif; ?>

    <?php endforeach; ?>

    <div class="clr"></div>

   <?php endif; ?>


   <?php if (isset($SITE_CONTENT['content']) && !empty($SITE_CONTENT['content'])) : ?>
    <div class="arcnt">

     <?php foreach ($SITE_CONTENT['content'] as $value) : ?>

      <div class="arit">
       <a class="itim" href="<?php echo anchor_wta(site_url('articles/detail/'.$value['link'])); ?>">
        <span class="imvral">
         <img class="imim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>">
        </span>
       </a>

       <div class="ittt">
        <div class="ttvral">
         <a class="ttlk" href="<?php echo anchor_wta(site_url('articles/detail/'.$value['link'])); ?>">
          <?php echo $value['name']; ?>
         </a>
        </div>
       </div>
      </div>

     <?php endforeach; ?>

     <div class="clr"></div>
    </div>
   <?php endif; ?>

  </div>


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
        <li class="lsit"><?php echo anchor(site_url('articles/page/'.$i), $i, array('class' => 'itlk')); ?></li>
       <?php endif; ?>

      <?php endfor; ?>

     </ul>

     <a
      <?php if ($PAGINATION['THISPAGE'] > 1) : ?>
       href="<?php echo anchor_wta(site_url('articles/page/'.($PAGINATION['THISPAGE'] - 1))); ?>" class="pgpr"
      <?php else : ?>
       href="javascript:void(0);" class="pgpr db"
      <?php endif; ?>
     >
      <i class="pgar"></i><?php echo $this->lang->line('site_page_prev'); ?>
     </a>

     <a
      <?php if ($PAGINATION['THISPAGE'] < $PAGINATION['COUNTPAGE']) : ?>
       href="<?php echo anchor_wta(site_url('articles/page/'.($PAGINATION['THISPAGE'] + 1))); ?>" class="pgnx"
      <?php else : ?>
       href="javascript:void(0);" class="pgnx db"
      <?php endif; ?>
     >
      <?php echo $this->lang->line('site_page_next'); ?><i class="pgar"></i>
     </a>

   </div>
  <?php endif; ?>


 <?php endif; #end articles ?>

</div>