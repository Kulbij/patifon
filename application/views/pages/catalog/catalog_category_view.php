<div id="content">
 <?php $this->load->view('inside/bread_view'); ?>

 <?php if (isset($SITE_CONTENT['category']) && !empty($SITE_CONTENT['category'])) : ?>
  <div class="category">

   <?php $index = 1; foreach ($SITE_CONTENT['category'] as $value) : ?>
    <div class="category-item">
     <div class="item-image">
      <a href="<?php if (isset($value['link'])) echo anchor_wta(site_url('catalog/'.$value['link'])); ?>">
       <img src="<?php if (isset($value['image_big'])) echo baseurl($value['image_big']); ?>" alt="<?php if (isset($value['name'])) echo $value['name']; ?>" />
      </a>
     </div><!-- end .item-image -->

     <div class="item-title">
      <a href="<?php if (isset($value['link'])) echo anchor_wta(site_url('catalog/'.$value['link'])); ?>">
       <?php if (isset($value['name'])) echo $value['name']; ?>
      </a>
     </div><!-- end .item-title -->
    </div><!-- end .category-item -->

    <?php if ($index % 3 == 0) : ?><div class="clear"></div><?php endif; ?>
   <?php ++$index; endforeach; ?>

   <div class="clear"></div>
  </div><!-- end .category -->
 <?php endif; ?>

 <?php if (isset($SITE_CONTENT['articles']) && !empty($SITE_CONTENT['articles'])) : ?>
  <div class="main-articles">
   <div class="articles-title">
    <?php echo $this->lang->line('cat_cat_articles_title'); ?>
   </div>

   <?php foreach ($SITE_CONTENT['articles'] as $value) : ?>
    <div class="articles-item">
     <div class="item-title">
      <a href="<?php if (isset($value['link'])) echo anchor_wta(site_url('articles/detail/'.$value['link'])); ?>">
       <?php if (isset($value['name'])) echo $value['name']; ?>
      </a>
     </div>

     <div class="item-text">
      <p><?php if (isset($value['shorttext'])) echo $value['shorttext']; ?></p>
     </div><!-- end .item-text -->

     <div class="item-more">
      <a href="<?php if (isset($value['link'])) echo anchor_wta(site_url('articles/detail/'.$value['link'])); ?>">
       <?php echo $this->lang->line('cat_cat_articles_detail'); ?>
      </a>
     </div>
    </div><!-- end .articles-item -->
   <?php endforeach; ?>

   <div class="clear"></div>
  </div><!-- end .main-articles -->
 <?php endif; ?>

</div><!-- end #content -->