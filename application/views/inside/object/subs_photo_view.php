<div class="tabbx">

 <?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
  <div class="bxpt">
   <div class="pttt"><?php echo $this->lang->line('op_in_title_photo'); ?></div>

   <?php $index = 1; foreach ($SITE_CONTENT['images'] as $value) : ?>
    <!--noindex-->
     <a class="ptit ownbox-form" href="<?php echo anchor_wta(site_url('ajax/form/product')); ?>" data-post="object=<?php echo $OBJECT_ID; ?>&image=<?php echo $index; ?>">
      <span class="itvral">
          <img class="itim" src="<?php if (isset($value['image_big'])) echo baseurl($value['image_big']); ?>" alt="<?php if (isset($SITE_CONTENT['object']['name'])) echo $SITE_CONTENT['object']['name']; ?>" title="<?php if (isset($value['name'])) echo $value['name']; ?>">
      </span>
     </a>
    <!--/noindex-->
   <?php ++$index; endforeach; ?>

   <div class="clr"></div>
  </div>
 <?php endif; ?>

</div>