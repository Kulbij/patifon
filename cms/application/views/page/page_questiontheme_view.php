<div id="content">
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

<div class="page-list">

    <div class="add"><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/page/', $SUBMODULE; ?>">Додати</a></div>
    
  <div class="clear"></div>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
  
  <ul>
   <?php foreach ($content['data'] as $one) : ?>
    <li class="item">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><?php if (isset($one['name'])) echo $one['name']; ?></a></span></div>
        
      <div class="right-item">
        <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
      </div>

    </li>
   <?php endforeach; ?>
  </ul>

  <?php endif; ?>

</div><!-- end page list -->
</div><!-- end content -->