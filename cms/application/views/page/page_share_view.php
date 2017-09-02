<div id="content" style="width: 1200px;">
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), '/js/jquery.js'; ?>"></script>
<h1><?php if (isset($content['modulename'])) echo $content['modulename']; ?></h1>

<?php if (isset($content['subs']) && count($content['subs']) > 0) : ?>
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

<div class="catalog-list">

  <div class="clear"></div>
    <div class="add"><span>Кількість акцій: <span class="big"><?php echo $COUNTPRO; ?></span></span><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/page/share'; ?>">Додати акцію</a></div>

    <div class="clear"></div>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
  <ul>

   <?php foreach ($content['data'] as $one) : ?>

    <li class="item">
      <div class="check"><span class="vertical"></span></div>
      <div class="product"></div>
      <div class="center-item"><span class="vertical"><a href="<?php echo base_url(), 'edit/page/', $SUBMODULE, '/', $one['id']; ?>"><?php echo mb_substr($one['name'], 0, 35); ?></a></span></div>

      <div class="price">
        <span class="vertical"><?php if (isset($one['date'])) echo date('d.m.Y', strtotime($one['date'])); ?></span>
      </div>

      <div class="right-item">
        <?php if ($one['visible'] == 1) : ?>
        <span class="vertical"><a title="подивитись на сайті" href="<?php echo getsite_url(), 'promotions/detail/', $one['link']; ?>" target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a></span>
        <?php endif; ?>

        <span class="vertical"><a href="javascript:void(0);"
        <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
          title="зробити невидимою" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/share/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>"
        <?php else : ?>
          title="зробити видимою" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/share/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>

        <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/share/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
      </div>
    </li>

   <?php endforeach; ?>
  </ul>

      <div class="clear"></div>

<div class="pages">
<?php if (isset($ALLPAGE) && isset($COUNTONPAGE) && isset($THISPAGE)) :
    $count_page = ceil($ALLPAGE/$COUNTONPAGE);
       if ($count_page > 1) :
?>
  <ul class="pages">

      <?php if ($THISPAGE > 1) : ?>
      <li>←</li>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $CATTHIS, '/', ($THISPAGE - 1); ?>">Назад</a></li>
      <?php endif; ?>

   <?php

   $first = $THISPAGE - 4;
   if ($first < 0) $first = 0;

   $last = $THISPAGE + 3;
   if ($last > $count_page) $last = $count_page;

   for ($i = $first; $i < $last; ++$i) : ?>
    <?php if (($i + 1) == $THISPAGE) : ?><li><?php echo ($i + 1); ?></li>
    <?php else : ?>
     <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $CATTHIS, '/', ($i + 1); ?>"><?php echo ($i + 1); ?></a></li>
    <?php endif; ?>
   <?php endfor; ?>

    <?php if ($THISPAGE < $count_page) : ?>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $CATTHIS, '/', ($THISPAGE + 1); ?>">Вперед</a></li>
      <li>→</li>
      <?php endif; ?>

  </ul>
<?php endif; endif; ?>
</div>

  <?php endif; ?>

</div><!-- end page list -->

<div class="right-sidebar" style="width: 500px; top: 0px;">

<?php if (isset($cats) && count($cats) > 0) : ?>
<ul class="right-sidebar-menu">

<?php if ($CATTHIS == 'all') : ?>
<li class="list-header"><div class="left"></div>Всі<div class="right"></div></li>
<li class="clear"></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0'; ?>">Всі</a></li>
<?php endif; ?>

<?php foreach ($cats as $one) : ?>

<?php if ($one['id'] == $CATTHIS) : ?>
<li class="list-header"><div class="left"></div><?php echo $one['name']; ?><div class="right"></div></li>
<li class="clear"></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $one['id']; ?>"><?php echo $one['name']; ?></a></li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>

</div><!-- end right sidebar -->

</div><!-- end content -->