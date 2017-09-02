<div id="content">

<?php $this->load->view('inside/bread_view'); ?>

<?php if (isset($SITE_CONTENT['lookbooks']) && !empty($SITE_CONTENT['lookbooks'])) $this->load->view('inside/leftside/leftside_view'); ?>

<div class="gallery">
 
 <?php if (isset($SITE_CONTENT['lookbooks']) && !empty($SITE_CONTENT['lookbooks'])) : ?>
 <div class="content">
  <?php if (isset($SITE_CONTENT['lookbooks']['last']) && !empty($SITE_CONTENT['lookbooks']['last'])) : ?>
   <div class="main-category">
    <a href="<?php echo anchor_wta(site_url('lookbook/'.$SITE_CONTENT['lookbooks']['last']['link'])); ?>">
     <img src="<?php echo baseurl($SITE_CONTENT['lookbooks']['last']['image_big']); ?>" alt="<?php echo $SITE_CONTENT['lookbooks']['last']['name']; ?>" />
    </a>
   </div>
  <?php endif; ?>
  
  <?php if (isset($SITE_CONTENT['lookbooks']['other']) && !empty($SITE_CONTENT['lookbooks']['other'])) : ?>
  <div class="more-category">
   <?php foreach ($SITE_CONTENT['lookbooks']['other'] as $value) : ?>
    <div class="category-item">
     <a href="<?php echo anchor_wta(site_url('lookbook/'.$value['link'])); ?>">
      <img src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>" />
     </a>
    </div>
   <?php endforeach; ?>
  </div><!-- end .more-category -->
  <?php endif; ?>
 </div><!-- end .content -->
 
 <?php elseif (isset($SITE_CONTENT['in_lookbook']) && !empty($SITE_CONTENT['in_lookbook'])) : ?>
  
  <div class="category-inner">
   <?php foreach ($SITE_CONTENT['in_lookbook'] as $value) : ?>
   <div class="category-item">
    <div class="item-image">
     <?php if (isset($value['image']) && !empty($value['image']) && isset($value['image2']) && !empty($value['image2'])) : ?>
      <img src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>" />
      <img src="<?php echo baseurl($value['image2']); ?>" alt="<?php echo $value['name2']; ?>" />
     <?php elseif (isset($value['image_big']) && !empty($value['image_big'])) : ?>
      <img src="<?php echo baseurl($value['image_big']); ?>" alt="<?php echo $value['name']; ?>" />
     <?php elseif (isset($value['image2_big']) && !empty($value['image2_big'])) : ?>
      <img src="<?php echo baseurl($value['image2_big']); ?>" alt="<?php echo $value['name2']; ?>" />
     <?php endif; ?>
    </div><!-- end .item-image -->
    
    <div class="item-title">
     <?php if (isset($value['image']) && !empty($value['image']) && isset($value['image2']) && !empty($value['image2'])) : ?>
      
      <?php if (!empty($value['object_1'])) : ?><a href="<?php echo anchor_wta(site_url('product/'.$value['object_1'])); ?>"><?php echo $value['name']; ?></a><?php elseif (!empty($value['name'])) : ?><?php echo $value['name']; ?><?php endif; ?><?php if (!empty($value['object_2'])) : ?>\<a href="<?php echo anchor_wta(site_url('product/'.$value['object_2'])); ?>"><?php echo $value['name2']; ?></a><?php elseif (!empty($value['name2'])) : ?>\<?php echo $value['name2']; ?><?php endif; ?>
      
     <?php elseif (isset($value['image_big']) && !empty($value['image_big'])) : ?>
      
      <?php if (!empty($value['object_1'])) : ?>
       <a href="<?php echo anchor_wta(site_url('product/'.$value['object_1'])); ?>"><?php echo $value['name']; ?></a>
      <?php elseif (!empty($value['name'])) : ?>
       <?php echo $value['name']; ?>
      <?php endif; ?>
      
     <?php elseif (isset($value['image2_big']) && !empty($value['image2_big'])) : ?>
      
      <?php if (!empty($value['object_2'])) : ?>
       <a href="<?php echo anchor_wta(site_url('product/'.$value['object_2'])); ?>"><?php echo $value['name2']; ?></a>
      <?php elseif (!empty($value['name2'])) : ?>
       <?php echo $value['name2']; ?>
      <?php endif; ?>
      
     <?php endif; ?>
    </div>
   </div><!-- end .category-item -->
   <?php endforeach; ?>
  </div><!-- end .category-inner -->
 
 <?php endif; ?>
 
</div><!-- end .gallery -->

<div class="clear"></div>
</div><!-- end #content -->