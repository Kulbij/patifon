
<?php if (isset($SITE_TOP['primary_menu']['menu']) && !empty($SITE_TOP['primary_menu']['menu'])) : ?>
<div class="primary-menu">
 <ul class="menu">
  <?php foreach ($SITE_TOP['primary_menu']['menu'] as $value) : ?>
   <li class="menu-li">
    <a class="menu-a" href="<?php if (isset($value['link'])) echo anchor_wta(site_url($value['link'])); ?>">
     <?php if (isset($value['name'])) echo $value['name']; ?>
    </a>
   </li>
  <?php endforeach; ?>
  
  <?php if (isset($SITE_TOP['primary_menu']['more']) && !empty($SITE_TOP['primary_menu']['more'])) : ?>
  <li class="menu-li more">
   <div class="more-block">
    <a class="menu-a" href="javascript:void(0);">
     <span class="a-left">&nbsp;</span>
      <?php echo $this->lang->line('pm_more'); ?>
     <span class="a-right">&nbsp;</span>
    </a>
   
    <div class="more-drop">
     <div class="drop-top"></div>
     
     <div class="drop-content">
      <ul class="submenu">
       <?php foreach ($SITE_TOP['primary_menu']['more'] as $value) : ?>
       <li class="submenu-li">
        <a class="submenu-a" href="<?php if (isset($value['link'])) echo anchor_wta(site_url($value['link'])); ?>">
         <?php if (isset($value['name'])) echo $value['name']; ?>
        </a>
       </li>
       <?php endforeach; ?>
      </ul>
     </div><!-- end .drop-content -->
     
     <div class="drop-bottom"></div>
    </div><!-- end .more-drop -->
   </div><!-- end .more-block -->
  </li>
  <?php endif; ?>
  
 </ul>
</div><!-- end .primary-menu -->
<?php endif; ?>