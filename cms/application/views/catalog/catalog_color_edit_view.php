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
  <form id="saveform" action="<?php echo base_url().'edit/save/', $SUBMODULE; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <?php if (isset($LINK) && is_numeric($LINK) && $LINK > 0) : ?><input type="hidden" name="id" value="<?php echo $LINK; ?>" /><?php endif; ?>
      
      <?php if (isset($LINK) && is_numeric($LINK) && $LINK > 0) : ?>
      <h2>Файл №<?php echo $LINK; ?></h2>
      <?php endif; ?>
      
  <div class="field">
      
      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я:<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>" />
      <?php endforeach; ?>
      
  </div>

  <div class="line"></div>
  <div class="clear"></div>
  
  <?php
    function slimO($children, $menuid, $parmenuid, $RANG) {
      
      foreach ($children as $one) {
          echo "<option value='{$one['id']}'";
          if (($parmenuid == $one['id']) || ($menuid == $one['id'])) echo "selected='selected'";
          echo " style='margin-left: {$RANG}px;'>";
          for ($i = 1; $i < $RANG; ++$i) echo '&nbsp;';
          echo "{$one['name']}</option>";
          
          if (isset($one['children'])) slimO($one['children'], $menuid, $parmenuid, ($RANG + 5));
      }
      
      $RANG -= 5;
      
    }
    ?>
  
  <div class="small-field">
   <div>Сторінка</div>
   <select name="pageid">
    
    <?php if (isset($FID) && !empty($FID)) : ?>
     <?php foreach ($FID as $value) : ?>
      <option <?php if (isset($content['pageid']) && $content['pageid'] == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
      
      <?php if (isset($value['children'])) : ?>
       <?php slimO($value['children'], (isset($content['pageid']) ? $content['pageid'] : 0), 0, 5); ?>
      <?php endif; ?>
      
     <?php endforeach; ?>
    <?php endif; ?>
   </select>
  </div><div class="clear"></div>
  
  <div class="small-field" style="width: 980px;">
   <div><?php if (isset($content['file'])) : ?><a target="_blank" href="<?php echo getsite_url(), 'public/files/', $content['file']; ?>"><?php echo $content['name_ru']; ?></a><?php endif; ?></div>
   <input type="file" name="file" />
  </div>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->