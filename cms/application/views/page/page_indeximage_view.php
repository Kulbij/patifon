<div id="content">
<h1><?php if (isset($content['modulename'])) echo $content['modulename']; ?></h1>

<?php if (isset($content['subs']) && count($content['subs'])) : ?>
<ul class="additional-menu">
 <?php foreach ($content['subs'] as $one) : ?>
  <?php if ($one['link'] == $SUBMODULE) : ?>
   <li class="active"><div class="left"></div><?php echo $one['name']; ?><div class="right"></div></li>
  <?php else : ?>
   <li><a href="<?php echo base_url(), $MODULE, '/', $one['link']; ?>"><?php echo $one['name']; ?></a></li>
  <?php endif; ?>
 <?php endforeach; ?>
</ul>
<?php endif; ?>

<div class="clear"></div>

<div class="photos-list">
  <div class="add">

    <img src="<?php echo base_url(); ?>images/plus.png" alt="додати фото" /><a href="<?php echo base_url(), 'edit/page/', $SUBMODULE; ?>">Додати баннер</a>

  </div>

  <div class="clear"></div>

<?php if (isset($content['data']) && count($content['data']) > 0) : ?>

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" />
  <script type='text/javascript' language="JavaScript" src='<?php echo base_url(); ?>js/jquery.js'></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>/js/fancy.js"></script>

 <?php $i = 0; $count_bb = count($content['data']); foreach ($content['data'] as $one) : ?>
  <div class="photos">
      <div class="foto"><span class="vertical-foto"><img style="height: 64px;" src="<?php echo getsite_url(), $one['image']; ?>" alt="#"/></span></div>
    <div class="menu-foto">

      <span class="vertical"><a href="<?php echo base_url(), 'edit/page/', $SUBMODULE, '/', $one['id']; ?>"><img title="редагувати картинку" src="<?php echo base_url(); ?>images/pencil.png" alt="#" /></a></span>
      <?php if($one['visible'] == 1):?>
      <span class="vertical"><a href="<?php echo base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id']; ?>"><img title="зробити невидимим" src="<?php echo base_url(); ?>images/eye.png" alt="#" /></a></span>
      <?php else:?>
      <span class="vertical"><a href="<?php echo base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id']; ?>"><img title="зробити видимим" src="<?php echo base_url(); ?>images/eye.png" alt="#" style="opacity: .6;"/></a></span>
      <?php endif;?>
      <span class="vertical"><a rel="images" href="<?php echo getsite_url(), $one['image']; ?>"><img title="подивитись картинку" src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a></span>

      <span class="vertical">
         <?php if ($i > 0) : ?><a href="<?php echo base_url(), 'edit/pos/up/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a><?php endif; ?>
      </span>
      <span class="vertical">
                <?php if ($i < $count_bb - 1) : ?><a href="<?php echo base_url(), 'edit/pos/down/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a><?php endif; ?>
      </span>

      <span class="vertical"><a title="видалити фото" href="javascript:void(0);" onclick="if (confirm('Видалити фотографію?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
    </div>
  </div>
 <?php ++$i; endforeach; ?>

  <div class="clear"></div>

<?php endif; ?>

  <div class="clear"></div>

</div><!-- end catalog list -->
</div><!-- end content -->