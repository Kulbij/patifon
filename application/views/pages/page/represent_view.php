<div id="content">

<?php $this->load->view('inside/bread_view'); ?>

<?php $this->load->view('inside/leftside/leftside_view'); ?>

<div class="content">
<div class="represent">

<?php if (isset($SITE_CONTENT['represents']) && !empty($SITE_CONTENT['represents'])) : ?>
<div class="map">
 <div id="map">
  <div class="mapup">
   
   <?php foreach ($SITE_CONTENT['represents'] as $value) : ?>
   <a href="<?php echo anchor_wta(site_url('representation/'.$value['link'])); ?>" id="<?php if (isset($value['class'])) echo $value['class']; ?>" class="town"><span class="disc"><?php
    if (isset($value['name'])) {
     if (isset($value['id']) && $value['id'] == 9) echo $value['name'];
     else echo '<span class="name">', $value['name'], '</span>';
    } ?></span></a>
   <?php endforeach; ?>
   
  </div><!-- end .mapup -->

  <img src="<?php echo baseurl('public/images/elt/content/represent/map.png'); ?>" usemap="#map-image" class="map-image" alt="#" />

  <map name="map-image">
   
   <?php foreach ($SITE_CONTENT['represents'] as $value) : ?>
   <area title="<?php if (isset($value['state'])) echo $value['state']; ?>" class="<?php if (isset($value['state'])) echo $value['state']; ?>" href="<?php echo anchor_wta(site_url('representation/'.$value['link'])); ?>" shape="poly" coords="<?php if (isset($value['coords'])) echo $value['coords']; ?>" alt="#" />
   <?php endforeach; ?>
   
  </map>
 </div><!-- end #map -->
</div><!-- end .map -->
<?php endif; ?>

</div><!-- end .represent -->
</div><!-- end .content -->

<div class="clear"></div>
</div><!-- end #content -->