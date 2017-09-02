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
    
    <div class="add" style="left: -200px;"><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE; ?>">Додати</a></div>

<div class="clear"></div>

<div class="category-list">
    
  <div class="clear"></div>

  <?php $i = 0; $count_bb = count($content['data']); if (isset($content['data']) && count($content['data']) > 0) : ?>
  
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
  
  <ul>
   <?php foreach ($content['data'] as $one) : ?>
    <li id="anchor<?php echo $one['id']; ?>" class="item">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><?php echo mb_substr($one['name'], 0, 35); ?></a></span></div>

        <div class="right-item" style="position: right;">
        
        <span class="vertical">
            <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
            <a href="<?php echo getsite_url(), 'photogallery/', $one['id']; ?>" target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a>
            <?php endif; ?>
        </span>
        
        <span class="vertical">
            <?php if ($i > 0) : ?><a href="<?php echo base_url(), 'edit/pos/up/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a><?php endif; ?>
            <?php if ($i < $count_bb - 1) : ?><a href="<?php echo base_url(), 'edit/pos/down/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a><?php endif; ?>
        </span>
        
        <span class="vertical">
         <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
            <a href="javascript:void(0);" title="зробити невидимою в галереї" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php else : ?>
            <a href="javascript:void(0);" title="зробити видимою в галереї" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php endif; ?>
        </span>
        
        <span class="vertical">
            <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
        </span>
        
      </div>
      
      <?php if (isset($one['children']) && !empty($one['children'])) : ?>
      <ul>
       <?php $j = 0; $count_bb_ch = count($one['children']); foreach ($one['children'] as $two) : ?>
       <li id="anchor<?php echo $two['id']; ?>" class="item">
         <div class="left-item">
           <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
         </div>

         <div class="center-item"><span class="vertical"><a href="<?php 
         echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $two['id']; 
         ?>"><?php echo mb_substr($two['name'], 0, 35); ?></a></span></div>

           <div class="right-item" style="position: right;">
           
           <span class="vertical">
               <?php if (isset($two['visible']) && $two['visible'] == 1) : ?>
               <a href="<?php echo getsite_url(), 'photogallery/', $two['id']; ?>" target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a>
               <?php endif; ?>
           </span>
           
           <span class="vertical">
               <?php if ($j > 0) : ?><a href="<?php echo base_url(), 'edit/pos/up/', $SUBMODULE, '/', $two['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a><?php endif; ?>
               <?php if ($j < $count_bb_ch - 1) : ?><a href="<?php echo base_url(), 'edit/pos/down/', $SUBMODULE, '/', $two['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a><?php endif; ?>
           </span>
           
           <span class="vertical">
            <?php if (isset($two['visible']) && $two['visible'] == 1) : ?>
               <a href="javascript:void(0);" title="зробити невидимою в галереї" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $two['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
            <?php else : ?>
               <a href="javascript:void(0);" title="зробити видимою в галереї" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $two['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
            <?php endif; ?>
           </span>
           
           <span class="vertical">
               <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $two['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
           </span>
           
         </div>
           
       </li>
       <?php ++$j; endforeach; ?>
      </ul>
      <?php endif; ?>
      
    </li>
    
   <?php ++$i; endforeach; ?>
  </ul>

  <?php endif; ?>

</div><!-- end page list -->
</div><!-- end content -->