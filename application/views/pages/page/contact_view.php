<div id="content">
 <?php $this->load->view('inside/bread_view'); ?>

<div class="contacts">
 <?php if (isset($SITE_TOP['address']) && !empty($SITE_TOP['address'])) : ?>
  <div class="contacts-address">
   <h2><?php echo $this->lang->line('cop_title_address'); ?></h2>
   <p id="map_address"><?php echo $SITE_TOP['address']; ?></p>
  </div><!-- end .contacts-address -->
 <?php endif; ?>

 <?php if (isset($SITE_TOP['phones']) && !empty($SITE_TOP['phones'])) : ?>
  <div class="contacts-phone">
   <h2><?php echo $this->lang->line('cop_title_phones'); ?></h2>
   <p>
    <?php foreach ($SITE_TOP['phones'] as $value) : ?>
     <?php echo $value['phone'], '&nbsp; '; ?>
    <?php endforeach; ?>
   </p>
  </div><!-- end .contacts-address -->
 <?php endif; ?>

  <div class="clear"></div>

  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;language=<?php echo SITELANG; ?>" type="text/javascript"></script>
  <script src="<?php echo resource_url('public/js/own.map.js', array('js' => true)); ?>" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" language="JavaScript" charset="utf-8" async defer>
   $(document).ready(function() {
    map_initialize();
   });
  </script>
  <style type="text/css">
   #map_canvas .gmnoprint img {
    max-width: none !important;
   }
  </style>

  <div id="map_canvas" class="contacts-map">
   
  </div>

 <?php if (isset($SITE_CONTENT['pagetext']) && !empty($SITE_CONTENT['pagetext'])) : ?>
  <div class="contacts-description">
   <?php echo $SITE_CONTENT['pagetext']; ?>
  </div><!-- end .contacts-description -->
 <?php endif; ?>
</div><!-- end .contacts -->
</div><!-- end #content -->