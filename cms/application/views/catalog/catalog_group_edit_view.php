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
      
  <div class="field">
      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я першої картинки(<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>"
      
      <?php if ($value == $this->config->item('config_default_lang')) : ?>
      id="ethis"
      
      onkeypress="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeyup="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeydown="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      <?php endif; ?>
      
      />
      
      <br />Ім'я другої картинки(<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="name2<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name2'.$value])) echo htmlspecialchars($content['name2'.$value]); ?>" />
      <?php endforeach; ?>
      
      <span><input type="hidden" name="visible" value="0" /><input type="checkbox" <?php if (isset($content['visible']) && $content['visible']) echo "checked='checked'"; ?> name="visible" value="1" />Відображати на сайті</span>
  </div>
  
  <div class="small-field">
    <div>Категорія:</div>
    <select name="catid">
     <?php foreach ($CATS as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (isset($content['catid']) && $one['id'] == $content['catid']) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>
     <?php endforeach; ?>
    </select>
  </div><div class="clear"></div>
  
  <div class="small-field">
    <?php if (isset($content['image_big']) && !empty($content['image_big'])) : ?><img style="max-width: 980px;" src="<?php echo getsite_url(), $content['image_big']; ?>" alt="" /><?php endif; ?>
   </div>
   <div class="small-field">
    <div style="color: red; font-weight: bold;">Картинка - 1088 x 328</div>
    <input type="file" name="image" accept="image/*" />
   </div>
   
   <?php if (isset($content['image_big']) && !empty($content['image_big'])) : ?>
   <div class="vertical">
    <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/lb_image_1/', $LINK, "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
   </div>
   <?php endif; ?>
   
   <div class="clear"></div>
   
   <div class="small-field">
    <div>Прикріплений товар:</div>
    <select name="object_1">
     <option value="0">Немає</option>
     
     <?php foreach ($allt as $value) : ?>
      <option <?php if (isset($content['object_1']) && $content['object_1'] == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
     <?php endforeach; ?>
     
    </select>
   </div>
   
   <div class="clear"></div>
   <div class="line"></div>
   <div class="clear"></div>
   
   <div class="small-field">
    <?php if (isset($content['image2_big']) && !empty($content['image2_big'])) : ?><img style="max-width: 980px;" src="<?php echo getsite_url(), $content['image2_big']; ?>" alt="" /><?php endif; ?>
   </div>
   <div class="small-field">
    <div style="color: red; font-weight: bold;">Картинка 2 - 1088 x 328</div>
    <input type="file" name="image2" accept="image/*" />
   </div>
   
   <?php if (isset($content['image2_big']) && !empty($content['image2_big'])) : ?>
   <div class="vertical">
    <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/lb_image_2/', $LINK, "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
   </div>
   <?php endif; ?>
   
   <div class="clear"></div>
   
   <div class="small-field">
    <div>Прикріплений товар:</div>
    <select name="object_2">
     <option value="0">Немає</option>
     
     <?php foreach ($allt as $value) : ?>
      <option <?php if (isset($content['object_2']) && $content['object_2'] == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
     <?php endforeach; ?>
     
    </select>
   </div>
   
   <div class="clear"></div>
   <div class="line"></div>
   <div class="clear"></div>
  
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->