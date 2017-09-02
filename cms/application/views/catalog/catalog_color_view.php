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
  
  <?php if (isset($menu) && !empty($menu)) : ?>
  
  <script type="text/javascript" language="JavaScript">
   function js_menu() {
    window.location = '<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/'; ?>' + $('#js_select option:selected').val();
   }
  </script>
  
  <?php
    function slimO($children, $menuid, $parmenuid, $RANG) {
      
      foreach ($children as $one) {
          echo "<option value='{$one['id']}'";
          if (($parmenuid == $one['id']) || ($menuid == $one['id'])) echo "selected='selected'";
          echo " style='margin-left: {$RANG}px;'>";
          for ($i = 1; $i < $RANG; ++$i) echo '&nbsp;';
          echo "{$one['name']}</option>";
          
          if (isset($one['children'])) slimO($one['children'], $menuid, $parmenuid, ($RANG + 5));
      }
      
      $RANG -= 5;
      
    }
    ?>
  
  <select id="js_select" onchange="js_menu();">
   <option value="0">Виберіть сторінку</option>
   <?php foreach ($menu as $one) : ?>
   <option <?php if (isset($CATEGORY) && $CATEGORY == $one['id']) echo 'selected'; ?> value="<?php echo $one['id']; ?>"><?php echo $one['name']; ?></option>
   
   <?php if (isset($one['children'])) : ?>
    <?php slimO($one['children'], (isset($CATEGORY) ? $CATEGORY : 0), 0, 5); ?>
   <?php endif; ?>
   
   <?php endforeach; ?>
  </select>
  <?php endif; ?>
  
  <div class="clear"></div>
  <div class="add"><img src="<?php echo base_url(); ?>images/plus.png" alt="+" /><a href="<?php echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE; ?>">Додати</a></div>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
  
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
  
  <ul>
   <?php $i = 0; $count_dd = count($content['data']); foreach ($content['data'] as $one) : ?>
    <li class="item">
      <div class="left-item">
        <span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><?php echo $one['name']; ?></a></span></div>

        <div class="right-item">
            
            <span class="vertical">
                <?php if ($i > 0) : ?><a href="<?php echo base_url(), 'edit/pos/up/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a><?php endif; ?>
                <?php if ($i < $count_dd - 1) : ?><a href="<?php echo base_url(), 'edit/pos/down/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a><?php endif; ?>
            </span>
            <span class="vertical">
             <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
                <a href="javascript:void(0);" title="зробити невидимою" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
             <?php else : ?>
                <a href="javascript:void(0);" title="зробити видимою" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
             <?php endif; ?>
            </span>
            
            <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити колір?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
            
        </div>
    </li>
       <?php ++$i; endforeach; ?>
  </ul>

  <?php endif; ?>

</div><!-- end page list -->

<div class="clear"></div>
      
<div class="pages">
<?php if (isset($ALLPAGE) && isset($COUNTONPAGE) && isset($THISPAGE)) : 
    $count_page = ceil($ALLPAGE/$COUNTONPAGE);
       if ($count_page > 1) :
?>
  <ul class="pages">
      
      <?php if ($THISPAGE > 1) : ?>
      <li>←</li>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', ($THISPAGE - 1), '/', $CATEGORY; ?>">Назад</a></li>
      <?php endif; ?>
      
   <?php
   
   $first = $THISPAGE - 4;
   if ($first < 0) $first = 0;
   
   $last = $THISPAGE + 3;
   if ($last > $count_page) $last = $count_page;
   
   for ($i = $first; $i < $last; ++$i) : ?>
    <?php if (($i + 1) == $THISPAGE) : ?><li><?php echo ($i + 1); ?></li>
    <?php else : ?>
     <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', ($i + 1), '/', $CATEGORY; ?>"><?php echo ($i + 1); ?></a></li>
    <?php endif; ?>
   <?php endfor; ?>
    
    <?php if ($THISPAGE < $count_page) : ?>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', ($THISPAGE + 1), '/', $CATEGORY; ?>">Вперед</a></li>
      <li>→</li>
      <?php endif; ?>
    
  </ul>
<?php endif; endif; ?>

</div><!-- end page list -->

</div><!-- end content -->