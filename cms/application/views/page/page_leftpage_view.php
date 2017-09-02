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

  <div class="clear"></div>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
  
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
  
  <ul>
   <?php $i = 0; $count_dd = count($content['data']); foreach ($content['data'] as $one) : ?>
    <li class="item">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/page/', $SUBMODULE, '/', $one['link']; 
      ?>"><?php echo mb_substr($one['name'], 0, 45); ?></a></span></div>

        <div class="right-item">
            
            <span class="vertical">
            <?php if ((isset($one['visible']) && $one['visible'] == 1)) : ?>
            <a 
                href="
                <?php
                 echo getsite_url(), $one['link'];
                ?>"
                target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a>
            <?php endif; ?>
        </span>
            
            
            <span class="vertical">
                <?php if ($i > 0) : ?><a href="<?php echo base_url(), 'edit/pos/up/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a><?php endif; ?>
                <?php if ($i < $count_dd - 1) : ?><a href="<?php echo base_url(), 'edit/pos/down/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a><?php endif; ?>
            </span>
            <span class="vertical">
             <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
                <a href="javascript:void(0);" title="зробити невидимою" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/leftpage/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
             <?php else : ?>
                <a href="javascript:void(0);" title="зробити видимою" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/leftpage/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
             <?php endif; ?>
            </span>
            
            
      </div>
    </li>
   <?php ++$i; endforeach; ?>
  </ul>

  <?php endif; ?>

</div><!-- end page list -->
</div><!-- end content -->