<div id="cnt">

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
   <?php if($SITE_CONTENT['selectcat'][0]['parentid2'] == 0) : ?>
    <li class="lsit">
      <a class="itlk" href="<?php echo anchor_wta(site_url('pidcatalog/'.$SITE_CONTENT['prevcat'][0]['link'])); ?>"><?php echo $SITE_CONTENT['prevcat'][0]['name_ru']; ?></a> /
    </li>
  <?php endif; ?>

  </ul>
 <?php endif; ?>

 <div class="clr"></div>
  <h1 class="bdcbtt"><?php echo $SITE_CONTENT['thiscat'][0]['name_ru']; ?></h1>

  <div class="clr"></div>

</div>

<div class="category">
<?php if($SITE_CONTENT['id'] == 1) : ?>
<?php foreach($SITE_CONTENT['selectcat'] as $value) : ?>
  <?php if($value['id'] != '6') : ?>
  <div class="item">
    <div class="image"><a href="<?php echo anchor_wta(site_url('pidcatalog/'.$value['link'])); ?>" class="link"><span class="vertical"><img src="<?php echo baseurl($value['image_big']); ?>" alt="<?php echo $value['name_ru']; ?>"></span></a></div>
    <div class="name"><a href="<?php echo anchor_wta(site_url('pidcatalog/'.$value['link'])); ?>" class="link"><?php echo $value['name_ru']; ?></a></div>
  </div>
  <?php endif; ?>
<?php endforeach; ?>
<?php else : ?>
  <?php foreach($SITE_CONTENT['selectcat'] as $value) : ?>
  <div class="item">
    <div class="image"><a href="<?php echo anchor_wta(site_url('catalog/'.$SITE_CONTENT['urlcat'].'/'.$value['link'])); ?>" class="link"><span class="vertical"><img src="<?php echo baseurl($value['image_big']); ?>" alt="<?php echo $value['name_ru']; ?>"></span></a></div>
    <div class="name"><a href="<?php echo anchor_wta(site_url('catalog/'.$SITE_CONTENT['urlcat'].'/'.$value['link'])); ?>" class="link"><?php echo $value['name_ru']; ?></a></div>
  </div>
<?php endforeach; ?>
<?php endif;?>

<div class="clr"></div>

</div>


</div>