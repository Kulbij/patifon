<div class="tabbx">

 <?php if (isset($SITE_CONTENT['object']['video']) && !empty($SITE_CONTENT['object']['video'])) : ?>
  <div class="bxvd">
   <div class="vdtt"><?php echo $this->lang->line('op_in_title_video'); ?></div>

   <div class="vdbx" style="width: 780px; height: 465px;">
    <?php echo $SITE_CONTENT['object']['video']; ?>
   </div>
  </div>
 <?php endif; ?>

</div>