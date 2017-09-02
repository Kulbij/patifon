<div class="tabbx">
 <?php if (isset($SITE_CONTENT['accesories']) && $SITE_CONTENT['accesories']) : ?>
  <div class="ct">
   <div class="cttt sm"><?php echo $this->lang->line('op_in_title_accessories'); ?></div>

   <div class="cttl">

    <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['accesories']), true); ?>

    <div class="clr"></div>
   </div>

  </div>
 <?php endif; ?>
</div>