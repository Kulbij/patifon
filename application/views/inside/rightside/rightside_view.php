<div class="sdbr">
 <?php if (isset($_PRINT_LINK) && !empty($_PRINT_LINK)) : ?>
  <div class="pn">
   <i class="icpn"></i>
   <a class="pnlk" href="<?php echo anchor_wta(site_url($_PRINT_LINK.'/print')); ?>">
    <?php echo $this->lang->line('site_print'); ?>
   </a>
  </div>
 <?php endif; ?>

 <div class="sdbrfdbc">
  <div class="fdbctx"><?php echo $this->lang->line('tp_question_phone'); ?></div>

  <form action="<?php echo anchor_wta(site_url('ajax/form-send/callbackphone')); ?>" method="post">
   <input class="fdbcnm" type="text" name="phone" maxlength="255" placeholder="+38 (___) ___–__–__" value="+38 (___) ___–__–__" />
   <input class="ajax-form fdbcbt" type="submit" value="<?php echo $this->lang->line('tp_submit_form'); ?>" />
   <input type="hidden" name="link" value="<?php echo base64_encode(current_url()); ?>" />
   <input type="hidden" name="robot" value="" />
  </form>

 </div>
</div>