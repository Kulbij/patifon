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

<div class="category-list">
  
  <form action="" method="post">
   <input type="text" name="username" value="" />&nbsp;<input type="submit" value="Пошук" />&nbsp;
   <a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE; ?>">весь список</a>
  </form>

  <div class="clear" style="height: 20px;"></div>

  <?php $i = 0; $count_bb = count($content['data']); ?>
  
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
  
  <ul>
   <?php foreach ($content['data'] as $one) : ?>
    <li id="anchor<?php echo $one['id']; ?>" class="item">
      <div class="left-item">
        <span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><?php echo preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', mb_substr($one['identity'].' '.$one['username'], 0, 35)); ?></a></span></div>

        <div class="right-item" style="position: right;">
        
        <span class="vertical">
         <?php if (isset($one['active']) && $one['active'] == 1) : ?>
            <a href="javascript:void(0);" title="забанити" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php else : ?>
            <a href="javascript:void(0);" title="розбанити" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php endif; ?>
        </span>
        
        <?php if (isset($SDS)) : ?>
         <span class="vertical">
          <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити меню?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
         </span>
        <?php endif; ?>
            
      </div>
        
    </li>
    
   <?php ++$i; endforeach; ?>
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
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/', ($THISPAGE - 1); ?>">Назад</a></li>
      <?php endif; ?>
      
   <?php
   
   $first = $THISPAGE - 4;
   if ($first < 0) $first = 0;
   
   $last = $THISPAGE + 3;
   if ($last > $count_page) $last = $count_page;
   
   for ($i = $first; $i < $last; ++$i) : ?>
    <?php if (($i + 1) == $THISPAGE) : ?><li><?php echo ($i + 1); ?></li>
    <?php else : ?>
     <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/', ($i + 1); ?>"><?php echo ($i + 1); ?></a></li>
    <?php endif; ?>
   <?php endfor; ?>
    
    <?php if ($THISPAGE < $count_page) : ?>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/', ($THISPAGE + 1); ?>">Вперед</a></li>
      <li>→</li>
      <?php endif; ?>
    
  </ul>
<?php endif; endif; ?>
</div>

</div><!-- end page list -->
</div><!-- end content -->