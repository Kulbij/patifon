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
  <form id="saveform" action="<?php echo base_url().'edit/save/setting_scripts'; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <?php if (!is_null($ID)) : ?><input type="hidden" name="id" value="<?php echo $ID; ?>" /><?php endif; ?>
      
  <div class="field">
      <h2><?php if (isset($content['id'])) echo '№', $content['id']; ?></h2>
  </div>
  
  <div class="small-field">
    <div>Текст:</div>
    <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="option"><?php if (isset($content['option'])) echo $content['option']; ?></textarea>
  </div>
  
  <div class="clear"></div>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->