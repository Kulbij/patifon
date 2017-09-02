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
     echo '<ul class="children">';
     foreach ($children as $one) {
        
        echo "<li id='anchor{$one['id']}' class='item' style='margin-left: {$RANG}px;'>
      <div class='left-item'>
        <span class='vertical'>";
        if(isset($one['image']) && !empty($one['image'])){
            echo "<img src='"; echo getsiteurl(), $one['image']; echo "' style='margin-left:20px;' width='25px' alt='#' />";
        }

          echo "<a href='".base_url()."edit/{$MODULE}/{$SUBMODULE}/{$one['id']}'><img src='".base_url()."images/move.png' alt='#' /></a>
        </span>
      </div>

      <div class='center-item'><span class='vertical'><a href='".base_url()."edit/{$MODULE}/{$SUBMODULE}/{$one['id']}'>".preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', mb_substr($one['name'], 0, 35))."</a></span></div>

        <div class='right-item'>";
      
      echo "
            
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
       echo "<a href='javascript:void(0);' title='Убрати з фільтрів' onclick=\"window.location = '".base_url()."edit/unvis/{$SUBMODULE}/{$one['id']}'; return false;\"><img src='".base_url()."images/eye.png' /></a>";
      } else {
       echo "<a href='javascript:void(0);' title='Показати в фільтрах' onclick=\"window.location = '".base_url()."edit/vis/{$SUBMODULE}/{$one['id']}'; return false;\"><img style='opacity: 0.4;' src='".base_url()."images/eye.png' /></a>";
      }

      if (isset($one['filter-vis']) && $one['filter-vis'] == 1) {
       echo "<a href='javascript:void(0);' title='Убрати з характеристик' onclick=\"window.location = '".base_url()."edit/unvis/har/{$one['id']}'; return false;\"><img src='".base_url()."images/eye.png' /></a>";
      } else {
       echo "<a href='javascript:void(0);' title='Показати в характеристиках' onclick=\"window.location = '".base_url()."edit/vis/harvis/{$one['id']}'; return false;\"><img style='opacity: 0.4;' src='".base_url()."images/eye.png' /></a>";
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
  
  <script type="text/javascript" language="JavaScript">      
   $('.slide-f').live('click', function(){
    if ($(this).hasClass('close')) {
     $(this).removeClass('close').addClass('open').attr('title', 'приховати дочірні');
     $(this).find('img').first().attr('src', '/cms/images/slide-up.png');
     $(this).closest('li.item').find('ul.children').show();
    } else {
     $(this).removeClass('open').addClass('close').attr('title', 'показати дочірні');
     $(this).find('img').first().attr('src', '/cms/images/slide-down.png');
     $(this).closest('li.item').find('ul.children').hide();
    }
   });
  </script>

  <ul>
   <?php foreach ($content['data'] as $one) : ?>
    <li id="anchor<?php echo $one['id']; ?>" class="item">
      <div class="left-item">
        <span class="vertical"><a href="<?php 
          echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
          ?>"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a>
          <?php if(isset($one['image']) && !empty($one['image'])) : ?>
            <img src="<?php echo getsiteurl(), $one['image']; ?>" width="25px" alt="#" />
          <?php endif; ?>
        </span>
      </div>

      <?php if (isset($one['children']) && !empty($one['children'])) : ?>
      <div class="left-item">
       <span class="vertical">
        <a href="javascript:void(0);" title="показати дочірні" class="slide-f open">
         <img style="cursor: auto;" src="<?php echo base_url(); ?>images/slide-up.png" alt="#" />
        </a>
       </span>
      </div>
      <?php else : ?>
       <div class="left-item">
        <span class="vertical">
         <img style="cursor: auto; opacity: 0;" src="<?php echo base_url(); ?>images/move.png" alt="#" />
       </span>
      </div>
      <?php endif; ?>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><?php echo preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', mb_substr($one['name'], 0, 35)); ?></a></span></div>

        <div class="right-item" style="position: right;">
            
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
            <a href="javascript:void(0);" title="Убрати з фільтрів" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php else : ?>
            <a href="javascript:void(0);" title="Показувати в фільтрові та характеристикі" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php endif; ?>
        </span>

        <span class="vertical">
         <?php if (isset($one['filter-vis']) && $one['filter-vis'] == 1) : ?>
            <a href="javascript:void(0);" title="Убрати з характеристик" 
            onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/har/'.$one['id'], "'"; ?>;
             return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php else : ?>
            <a href="javascript:void(0);" title="Показувати в характеристиках" 
            onclick="window.location = <?php echo "'", base_url(), 'edit/vis/harvis/', $one['id'], "'";
             ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
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