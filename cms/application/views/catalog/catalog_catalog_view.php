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
    <div class="add" style="position: fixed; left: 1050px;"><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/catalog/', $SUBMODULE; ?>">Додати меню</a></div>

<div class="clear"></div>

<div class="category-list">

 <?php
 function slim($children, $MODULE, $SUBMODULE, $RANG) {
    $RANG = 0;
     $i = 0;
     $count_bb = count($children);
     echo '<ul>';
     foreach ($children as $one) {
        
        echo "<li id='anchor{$one['id']}' class='item' style='margin-left: {$RANG}px;'>
      <div class='left-item'>
        <span class='vertical'><a href='".base_url()."edit/{$MODULE}/{$SUBMODULE}/{$one['id']}'><img src='".base_url()."images/move.png' alt='#' /></a></span>
      </div>

      <div class='center-item'><span class='vertical'><a href='".base_url()."edit/{$MODULE}/{$SUBMODULE}/{$one['id']}'>".preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', mb_substr($one['name'], 0, 35))."</a></span></div>

        <div class='right-item'>
        
        <span class='vertical'>";
      
      if (isset($one['visible']) && $one['visible'] == 1) {
        echo "<a href='".getsite_url()."catalog/{$one['link']}.html' target='_blank'><img src='".base_url()."images/zoom.png' alt='#' /></a>";
      }
      
      echo "</span>
            
        <span class='vertical'>";
      
      if ($i > 0) {
      echo "<a href='".base_url()."edit/pos/up/{$SUBMODULE}/{$one['id']}'><img src='".base_url()."images/arrow-up.png' /></a>";
        }
        
      if ($i < $count_bb - 1) {
      echo "<a href='".base_url()."edit/pos/down/{$SUBMODULE}/{$one['id']}'><img src='".base_url()."images/arrow-down.png' /></a>";
        }
      
      echo "</span>";
      
      if (isset($SDS)) {
       echo "<span class='vertical'>";
       
       echo '<a href="javascript:void(0);" ';
       
       if ($one['visible_ontop'] == 1) {
        echo 'title="зняти з основного меню" onclick="window.location = \''.base_url().'edit/uncheck/'.$SUBMODULE.'/'.$one['id'].'\'; return false;"><img src="'.base_url().'images/check.png"';
       } else {
        echo 'title="поставити на основне меню" onclick="window.location = \''.base_url().'edit/check/'.$SUBMODULE.'/'.$one['id'].'\'; return false;"><img src="'.base_url().'images/uncheck.png"';
       }
       
       echo ' alt="#" /></a></span>';
      }
      
      echo '<span class="vertical">';
      
      if (isset($one['visible']) && $one['visible'] == 1) {
       echo "<a href='javascript:void(0);' title='зробити невидимою' onclick=\"window.location = '".base_url()."edit/unvis/{$SUBMODULE}/{$one['id']}'; return false;\"><img src='".base_url()."images/eye.png' /></a>";
      } else {
       echo "<a href='javascript:void(0);' title='зробити видимою' onclick=\"window.location = '".base_url()."edit/vis/{$SUBMODULE}/{$one['id']}'; return false;\"><img style='opacity: 0.4;' src='".base_url()."images/eye.png' /></a>";
      }
      
      echo "</span>
      
        <span class='vertical'>
            <a title='видалити' href='javascript:void(0);' onclick=\"if (confirm('Видалити меню?')) { window.location = '".base_url()."edit/del/{$SUBMODULE}/{$one['id']}'; } return false;\"><img src='".base_url()."images/del.png' alt='X' /></a>
        </span>
            
      </div>";
        
        if (isset($one['children'])) slim($one['children'], $MODULE, $SUBMODULE, ($RANG + 7));
        
        ++$i;
       
       echo '</li>';
        
     }
     echo '</ul>';
     $RANG -= 7;
     
 }
 ?>
    
  <div class="clear"></div>

  <?php $i = 0; $count_bb = count($content['data']); if (isset($content['data']) && count($content['data']) > 0) : ?>
  
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
      ?>"><?php echo preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', mb_substr($one['name'], 0, 35)); ?></a></span></div>

        <div class="right-item" style="position: right;">
        
        <span class="vertical">
            <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
            <a href="<?php echo getsite_url(), 'catalog/', $one['link'], '.html'; ?>" target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a>
            <?php endif; ?>
        </span>
            
        <span class="vertical">
            <?php if ($i > 0) : ?><a href="<?php echo base_url(), 'edit/pos/up/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a><?php endif; ?>
            <?php if ($i < $count_bb - 1) : ?><a href="<?php echo base_url(), 'edit/pos/down/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a><?php endif; ?>
        </span>
        
        <?php if (isset($SDS)) : ?>
         <span class="vertical"><a href="javascript:void(0);" 
         <?php if ($one['visible_ontop'] == 1) : ?>
           title="зняти з основного меню" onclick="window.location = <?php echo "'", base_url(), 'edit/uncheck/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/check.png'; ?>"
         <?php else : ?>
           title="поставити на основне меню" onclick="window.location = <?php echo "'", base_url(), 'edit/check/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/uncheck.png'; ?>"
         <?php endif; ?>
          alt="#" /></a></span>
        <?php endif; ?>
        
        <span class="vertical">
         <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
            <a href="javascript:void(0);" title="зробити невидимою" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php else : ?>
            <a href="javascript:void(0);" title="зробити видимою" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php endif; ?>
        </span>
        
        <span class="vertical">
            <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити меню?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
        </span>
            
      </div>
        
        <?php if (isset($one['children'])) : ?>
        <?php slim($one['children'], $MODULE, $SUBMODULE, 7); ?>
        <?php endif; ?>
        
    </li>
    
   <?php ++$i; endforeach; ?>
  </ul>

  <?php endif; ?>

</div><!-- end page list -->
</div><!-- end content -->