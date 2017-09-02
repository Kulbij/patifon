<?php if (isset($img) && isset($img['id']) && isset($img['image']) && isset($img['image_big'])) : ?>
<div class="photos" style="width: 180px; height: 212px;">
           <div class="foto" style="width: 180px; height: 182px;"><span class="vertical-foto"  style="width: 180px; height: 182px;"><img style="max-width: 180px; max-height: 182px;" src="<?php echo getsite_url(), $img['image_big']; ?>" alt="#"/></span></div>
 <div class="menu-foto">
   <span class="vertical"><a rel="images" href="<?php echo getsite_url(), $img['image_big']; ?>"><img title="подивитись картинку" src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a></span>

     <span class="vertical">
         <a href="<?php echo base_url(), 'edit/pos/up/gallery/', $img['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a>
     </span><span class="vertical">
         <a href="<?php echo base_url(), 'edit/pos/down/gallery/', $img['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a>
     </span>

     <span class="vertical"><a href="javascript:void(0);" 
     <?php if (isset($img['visible']) && $img['visible'] == 1) : ?>
       title="зробити невидимою" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/gallery/', $img['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>"
     <?php else : ?>
       title="зробити видимою" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/gallery/', $img['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>"
     <?php endif; ?>
      alt="#" /></a></span>

     <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/gallery/', $img['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
 </div>
</div>
<?php endif; ?>