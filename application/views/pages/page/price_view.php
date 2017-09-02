<div id="content">

<?php $this->load->view('inside/bread_view'); ?>

<div class="price">
 <div class="page-title"><h1><?php if (isset($SITE_BREAD['breadname'])) echo preg_replace("/<[\/\!]*?[^<>]*?>/si", ' ', $SITE_BREAD['breadname']); ?></h1></div>
 
 <div class="clear"></div>
 
 <?php if (isset($SITE_CONTENT['_price']) && !empty($SITE_CONTENT['_price'])) : ?>
 <div class="price-download">
  <div class="download-title">
   <a href="<?php if (isset($SITE_CONTENT['_price']['file'])) echo baseurl('public/files/'.$SITE_CONTENT['_price']['file']); ?>">
    <?php echo $this->lang->line('z_load_price');
    if (isset($SITE_CONTENT['_price']['date'])) echo '<br />', date('d.m.Y', strtotime($SITE_CONTENT['_price']['date'])); 
    if (isset($SITE_CONTENT['_price']['file'])) {
     $ext = end(explode('.', $SITE_CONTENT['_price']['file']));
     if (!empty($ext)) { echo ' (.', $ext, ')'; }
    }
    ?>
   </a>
  </div>
  <div class="download-size"><?php if (isset($SITE_CONTENT['_price']['weight'])) echo $SITE_CONTENT['_price']['weight']; ?></diV>
 </div><!-- end .price-download --->
 <?php endif; ?>
 
 <?php if (isset($SITE_CONTENT['phones']) && !empty($SITE_CONTENT['phones'])) : ?>
 <div class="phone-manager">
  <div class="phone-top"></div>
  
  <div class="phone-content">
   <div class="phone-title"><?php echo $this->lang->line('p_p_phones'); ?></div>
   
   <?php foreach ($SITE_CONTENT['phones'] as $value) : ?>
   <div class="phone-item">
    <div class="item-name"><?php echo $value['name']; ?></div>
    <div class="item-phone"><?php echo $value['phone']; ?></div>
   </div><!-- end .phone-item -->
   <?php endforeach; ?>
   
  </div><!-- end .phone-content -->
  
  <div class="phone-bottom"></div>
 </div><!-- end .phone-manager -->
 <?php endif; ?>
 
 <div class="clear"></div>
</div><!-- end .price -->

<?php if (isset($SITE_TOP['last_catalog']) && !empty($SITE_TOP['last_catalog'])) : ?>
<div class="new-product">
 <div class="product-title"><?php echo $this->lang->line('p_i_last'); ?></div>
 
 <?php foreach ($SITE_TOP['last_catalog'] as $value) : ?>
 <div class="product-item">
  <div class="item-image">
   <a href="<?php echo anchor_wta(site_url('product/'.$value['link'])); ?>">
    <span class="vertical">
     <img src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>" />
    </span>
   </a>
  </div>
  <div class="item-title">
   <a href="<?php echo anchor_wta(site_url('product/'.$value['link'])); ?>">
    <?php echo $value['name']; ?>
   </a>
  </div>
 </div><!-- end .product-item -->
 <?php endforeach; ?>

 <div class="clear"></div>
</div><!-- end .new-product -->
<?php endif; ?>

</div><!-- end #content -->