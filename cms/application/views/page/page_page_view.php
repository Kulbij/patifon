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

<div class="clear"></div>
    <div class="add"><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE; ?>">Додати</a></div>
          
    <div class="clear"></div>

<?php
 function recursive($children = array(), $MODULE, $SUBMODULE) {
  if (isset($children) && is_array($children) && !empty($children)) {
   echo '<ul>';
   $i = 1; $count_dd = count($children);
   foreach ($children as $two) {
    echo '<li class="item">
      <div class="left-item">
        <span class="vertical"><a href="'.base_url().'edit/page/'.$SUBMODULE.'/'.$two['id'].'"><img src="'.base_url().'images/move.png" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="'.base_url().'edit/page/'.$SUBMODULE.'/'.$two['id'].'">'.mb_substr($two['name'], 0, 45).'</a></span></div>

        <div class="right-item">
            
            <span class="vertical">';
            
          if ((isset($two['visible']) && $two['visible'] == 1) || $two['link'] == 'main') {
            echo '<a 
                href="';
                
                if ($two['link'] == 'index') echo getsite_url();
                else echo getsite_url(), $two['link'], '.html';
                
                echo '
                "
                target="_blank"><img src="'.base_url().'images/zoom.png" alt="#" /></a>';
          }
        
        echo '</span>';
            
            echo '<span class="vertical">';
             if ($i > 1) { echo '<a href="'.base_url().'edit/pos/up/'.$SUBMODULE.'/'.$two['id'].'"><img src="'.base_url().'images/arrow-up.png" /></a>';
             }
             if ($i < $count_dd) {
             echo '<a href="'.base_url().'edit/pos/down/'.$SUBMODULE.'/'.$two['id'].'"><img src="'.base_url().'images/arrow-down.png" /></a>';
             }
             echo '
            </span>
            <span class="vertical">';
             if (isset($two['visible']) && $two['visible'] == 1) {
                echo '<a href="javascript:void(0);" title="сделать невидимой" onclick="window.location = '."'".base_url().'edit/unvis/page/'.$two['id']."'".'; return false;"><img src="'.base_url().'images/eye.png" /></a>';
             } else {
                echo '<a href="javascript:void(0);" title="сделать видимой" onclick="window.location = '."'".base_url().'edit/vis/page/'.$two['id']."'".'; return false;"><img style="opacity: 0.4;" src="'.base_url().'images/eye.png" /></a>';
             }
             
            echo '</span>';
            
       
         echo '<span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm(\'Видалити?\')) { window.location = \''.base_url().'edit/del/'.$SUBMODULE.'/'.$two['id'].'\'; } return false;"><img src="'.base_url().'images/del.png" alt="X" /></a></span>';
        
            
    echo '   
      </div>';
      
      if (isset($two['children']) && is_array($two['children']) && !empty($two['children'])) {
       recursive($two['children'], $MODULE, $SUBMODULE);
      }
      
      echo '</li>';
      
      ++$i;
   }
   echo '</ul>';
  }
 }
?>

<div class="page-list">

  <div class="clear"></div>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
  
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
  
  <ul>
   <?php $i = 0; $count_dd = count($content['data']); foreach ($content['data'] as $one) : ?>
    <li class="item">
      <div class="left-item">
        <span class="vertical"><a href="<?php 
      echo base_url(), 'edit/page/', $SUBMODULE, '/', $one['id']; 
      ?>"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/page/', $SUBMODULE, '/', $one['id']; 
      ?>"><?php echo mb_substr($one['name'], 0, 45); ?></a></span></div>

        <div class="right-item">
            
            <span class="vertical">
            <?php if ((isset($one['visible']) && $one['visible'] == 1) || $one['link'] == 'index') : ?>
            <a 
                href="
                <?php
                 if ($one['link'] == 'index') echo getsite_url();
                 else echo getsite_url(), $one['link'], '.html';
                ?>"
                target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a>
            <?php endif; ?>
        </span>
            
            <?php if ($one['link'] != 'index') : ?>
            <span class="vertical">
                <?php if ($i > 1) : ?><a href="<?php echo base_url(), 'edit/pos/up/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a><?php endif; ?>
                <?php if ($i < $count_dd - 1) : ?><a href="<?php echo base_url(), 'edit/pos/down/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a><?php endif; ?>
            </span>
            <span class="vertical">
             <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
                <a href="javascript:void(0);" title="зробити невидимою" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/page/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
             <?php else : ?>
                <a href="javascript:void(0);" title="зробити видимою" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/page/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
             <?php endif; ?>
            </span>
            <?php endif; ?>
        
        <?php if ($one['link'] != 'index') : ?>
        <span class="vertical">
         <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
        </span>
        <?php endif; ?>
            
      </div>
      
      <?php if (isset($one['children']) && is_array($one['children']) && !empty($one['children'])) : ?>
       <?php recursive($one['children'], $MODULE, $SUBMODULE); ?>
      <?php endif; ?>
      
    </li>
   <?php ++$i; endforeach; ?>
  </ul>

  <?php endif; ?>

</div><!-- end page list -->
</div><!-- end content -->