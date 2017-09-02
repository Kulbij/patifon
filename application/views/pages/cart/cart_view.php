<div id="content">
 <?php $this->load->view('inside/bread_view'); ?>

 <div class="step">
   <div class="step-item selected">
     <div class="item-number">1</div>
     <div class="item-text"><?php echo $this->lang->line('cpp_step_title_first'); ?></div>

     <div class="clear"></div>
   </div><!-- end .step-item -->

   <div class="step-item">
     <div class="item-number">2</div>
     <div class="item-text"><?php echo $this->lang->line('cpp_step_title_second'); ?></div>

     <div class="clear"></div>
   </div><!-- end .step-item -->

   <div class="step-item">
     <div class="item-number">3</div>
     <div class="item-text"><?php echo $this->lang->line('cpp_step_title_third'); ?></div>

     <div class="clear"></div>
   </div><!-- end .step-item -->

   <div class="clear"></div>
 </div><!-- end .step -->

 <div id="cart_inside_page">
  <?php echo $this->load->view('ajax/ownbox/owb_cart_inside_view', array('move_to_shopping' => false), true); ?>
 </div>
</div><!-- end #content -->