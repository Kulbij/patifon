<div id="content">

<?php $this->load->view('inside/bread_view'); ?>

<?php $this->load->view('inside/leftside/leftside_view'); ?>

<div class="content">

<?php if ($this->input->value($SITE_CONTENT, 'docs')) : ?>
<div class="document">
 <?php foreach ($this->input->value($SITE_CONTENT, 'docs') as $value) : ?>
 <div class="document-item">
  <div class="item-image">
   <a href="<?php echo baseurl(), 'public/files/', $value['file']; ?>">
    <span class="vertical">
     <img src="<?php echo baseurl(), 'public/images/elt/content/document/passport.png'; ?>" alt="<?php echo $value['name']; ?>" />
    </span>
   </a>
  </div>
  <div class="item-title">
   <a href="<?php echo baseurl(), 'public/files/', $value['file']; ?>">
    <?php echo $value['name']; ?>
   </a>
  </div>
 </div><!-- end .document-item -->
 <?php endforeach; ?>

<div class="clear"></div>
</div><!-- end .document -->
<?php endif;  ?>

</div><!-- end .content -->

<div class="clear"></div>
</div><!-- end #content -->