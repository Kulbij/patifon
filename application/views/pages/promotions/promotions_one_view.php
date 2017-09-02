<div id="cnt">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

 <div class="cnt">
  <div class="tx"><?php if (isset($SITE_CONTENT['content']['text'])) echo $SITE_CONTENT['content']['text']; ?></div>
 </div>

 <?php echo $this->load->view('inside/rightside/rightside_view', null, true); ?>

 <div class="clr"></div>
</div>