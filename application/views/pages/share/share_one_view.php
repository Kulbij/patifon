<div id="content">

<?php $this->load->view('inside/leftside/leftside_view'); ?>

<div class="content">
 
 <?php $this->load->view('inside/primary_menu_view'); ?>
 
 <?php $this->load->view('inside/slider_view'); ?>
 
 <?php $this->load->view('inside/bread_view'); ?>

 <div class="text">
   <?php if (isset($SITE_CONTENT['content']['text'])) echo $SITE_CONTENT['content']['text']; ?>
 </div><!-- end .text -->
</div><!-- end .content -->

<div class="clear"></div>
</div><!-- end #content -->