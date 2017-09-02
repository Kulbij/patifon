<div id="content">

<?php if (isset($breadcrumbs) && count($breadcrumbs) > 0) : ?>
<ul class="breadcrumbs">
  <?php foreach ($breadcrumbs as $one) : ?>
   <li><a href="<?php echo base_url(), $one['link']; ?>"><?php echo $one['name']; ?></a></li>
   <li>→</li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<div class="clear"></div>

<div class="creation_page">
  <form id="saveform" action="<?php echo base_url().'edit/save/page_footer'; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <input type="hidden" name="id" value="<?php echo $LINK; ?>" />
      
  <div class="field">
      <h2><?php if (isset($content['id'])) echo 'Частина ', $content['id']; ?></h2>
  </div>
  
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>
  
  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <h2>Текст (<?php echo ltrim($value, '_'); ?>):</h2>

  <div class="editor">
      <textarea class="texts" name="footer<?php echo $value; ?>" cols="113" rows="10"><?php if (isset($content['footer'.$value])) echo $content['footer'.$value]; ?></textarea>
  </div><div class="clear"></div>
  <?php endforeach; ?>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->