<div id="content">

<?php $this->load->view('inside/bread_view'); ?>

<div class="scheme">
 <div class="page-title"><h1><?php if (isset($SITE_BREAD['breadname'])) echo preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', $SITE_BREAD['breadname']); ?></h1></div>
 
 <div class="clear"></div>
 
 <?php if (isset($SITE_CONTENT['sitemap']) && !empty($SITE_CONTENT['sitemap'])) : ?>
  
  <?php if (isset($SITE_CONTENT['sitemap']['pages']) && !empty($SITE_CONTENT['sitemap']['pages'])) : ?>
  <div class="scheme-block">
   <ul>
    <?php foreach ($SITE_CONTENT['sitemap']['pages'] as $first) : ?>
    <li>
     <a href="<?php echo anchor_wta(site_url($first['link'])); ?>"><?php echo $first['name']; ?></a>
     
     <?php if (isset($first['children']) && !empty($first['children'])) : ?>
     <ul>
      
      <?php foreach ($first['children'] as $second) : ?>
      <li>
       <a href="<?php echo anchor_wta(site_url($second['link'])); ?>"><?php echo $second['name']; ?></a>
       
       <?php if (isset($second['children']) && !empty($second['children'])) : ?>
       <ul>
        
        <?php foreach ($second['children'] as $third) : ?>
        <li>
         <a href="<?php echo anchor_wta(site_url($third['link'])); ?>"><?php echo $third['name']; ?></a>
        </li>
        <?php endforeach; ?>
        
       </ul>
       <?php endif; ?>
      </li>
      <?php endforeach; ?>
      
     </ul>
     <?php endif; ?>
    </li>
    <?php endforeach; ?>
   </ul>
  </div><!-- end scheme-block -->
  <?php endif; ?>
  
  
  
  <?php if (isset($SITE_CONTENT['sitemap']['cats']) && !empty($SITE_CONTENT['sitemap']['cats'])) : ?>
  <div class="scheme-block">
   <ul>
    <?php foreach ($SITE_CONTENT['sitemap']['cats'] as $first) : ?>
    <li>
     <a href="<?php echo anchor_wta(site_url($first['link'])); ?>"><?php echo $first['name']; ?></a>
     
     <?php if (isset($first['children']) && !empty($first['children'])) : ?>
     <ul>
      
      <?php foreach ($first['children'] as $second) : ?>
      <li>
       <a href="<?php echo anchor_wta(site_url($second['link'])); ?>"><?php echo $second['name']; ?></a>
       
       <?php if (isset($second['children']) && !empty($second['children'])) : ?>
       <ul>
        
        <?php foreach ($second['children'] as $third) : ?>
        <li>
         <a href="<?php echo anchor_wta(site_url($third['link'])); ?>"><?php echo $third['name']; ?></a>
        </li>
        <?php endforeach; ?>
        
       </ul>
       <?php endif; ?>
      </li>
      <?php endforeach; ?>
      
     </ul>
     <?php endif; ?>
    </li>
    <?php endforeach; ?>
   </ul>
  </div><!-- end scheme-block -->
  <?php endif; ?>
  
 <?php endif; ?>
 
 <div class="clear"></div>
</div><!-- end .scheme -->
</div><!-- end #content -->