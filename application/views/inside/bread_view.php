<div class="bdcb">
 <?php if (isset($SITE_BREAD['breadcrumbs']) && is_array($SITE_BREAD['breadcrumbs']) && !empty($SITE_BREAD['breadcrumbs'])) : ?>
  <ul class="bdcbls">
   <?php foreach ($SITE_BREAD['breadcrumbs'] as $value) : ?>
    <li class="lsit">
     <?php if ($value['link'] == 'cart') : ?>
      <a class="itlk" href="javascript:void(0);" onclick="cart_show(); return false;"><?php echo $value['name']; ?></a> /
     <?php else : ?>
      <?php echo anchor($value['link'], preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', $value['name']), array('class' => 'itlk')); ?> /
     <?php endif; ?>
    </li>
   <?php endforeach; ?>
  </ul>
 <?php endif; ?>

 <div class="clr"></div>

 <?php if (isset($SITE_BREAD['breadname']) && !empty($SITE_BREAD['breadname'])) : ?>
  <h1 class="bdcbtt"><?php echo preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', $SITE_BREAD['breadname']); ?></h1>

  <?php if (isset($__GEN['obj_id']) && $__GEN['obj_id'] > 0) : ?>
   <div class="bdcbcd">(<?php echo $this->lang->line('op_bread_code'); ?> <?php echo $__GEN['obj_id']; ?>)</div>
  <?php endif; ?>

  <div class="clr"></div>
 <?php endif; ?>

</div>