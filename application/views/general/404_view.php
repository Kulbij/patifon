<?php echo doctype('xhtml11'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <base href="<?php echo baseurl(); ?>" />
 <?php echo meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>
 <?php if (isset($SITE_HEADER['meta_tkd'])) echo meta($SITE_HEADER['meta_tkd']); ?>
 <title><?php if (isset($SITE_HEADER['title'])) echo $SITE_HEADER['title']; ?></title>
 <?php echo link_tag('favicon.ico', 'shortcut icon', 'image/x-icon'); ?>

 <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=cyrillic" />

 <?php if (isset($SITE_HEADER['style']) && is_array($SITE_HEADER['style']) && !empty($SITE_HEADER['style'])) : ?>
  <?php foreach ($SITE_HEADER['style'] as $one) : ?>
   <link rel="<?php echo $one['rel']; ?>" type="<?php echo $one['type']; ?>" href="<?php echo resource_url($one['href'], array('css' => true)); ?>" />
  <?php endforeach; ?>
 <?php endif; ?>

</head>
<body>

<div id="main">

 <div id="cnt">

   <div class="er">
    <div class="lg">
     <a class="lglk" href="<?php echo site_url(); ?>">
      <img src="<?php echo baseurl('public/images/error/logo.png'); ?>" alt="<?php if (isset($SITE_HEADER['title'])) echo $SITE_HEADER['title']; ?>">
     </a>
    </div>

    <div class="im"><img src="<?php echo baseurl('public/images/error/404.png'); ?>" alt="#"></div>

    <div class="tx">
     <div class="txtt"><?php echo $this->lang->line('p404_title'); ?></div>
     <div class="txbx"><?php echo $this->lang->line('p404_text'); ?></div>
    </div>

    <?php if (isset($SITE_TOP['menu']) && !empty($SITE_TOP['menu'])) : ?>
     <div class="mn">
      <?php foreach ($SITE_TOP['menu'] as $value) : ?>
       <a class="mnlk" href="<?php echo anchor_wta(site_url('catalog/'.$value['link'])); ?>">
        <?php echo $value['name']; ?>
       </a>
      <?php endforeach; ?>

      <div class="clr"></div>
     </div>
    <?php endif; ?>

   </div>

 </div>

</div>

</body>
</html>