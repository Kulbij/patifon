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
  <form id="saveform" action="<?php echo base_url().'edit/save/'.$SUBMODULE; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <?php if (isset($LINK) && is_numeric($LINK) && $LINK > 0) : ?><input type="hidden" name="id" value="<?php echo $LINK; ?>" /><?php endif; ?>
      
  <div class="field">
      
      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я (<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>"
      
      <?php if (isset($SDS) && $value == $this->config->item('config_default_lang')) : ?>
      id="ethis"
      
      onkeypress="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeyup="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeydown="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      <?php endif; ?>
      
      />
      <?php endforeach; ?>
      
      <div>
       <br/><br/>
      <span><input type="hidden" name="visible" value="0" /><input type="checkbox" <?php if (isset($content['visible']) && $content['visible']) echo "checked='checked'"; ?> name="visible" value="1" />Відображати на сайті</span>
     &nbsp;&nbsp;&nbsp;
      <span><input type="hidden" name="is_samo" value="0" /><input type="checkbox" <?php if (isset($content['is_samo']) && $content['is_samo']) echo "checked='checked'"; ?> name="is_samo" value="1" />Самовивіз</span>
      </div>

  </div>

  <div class="line"></div>

  <div class="clear"></div>
  
  <?php if (isset($SDS)) : ?>
  <div class="small-field">
  <div>Посилання буде введенне вручну:</div>
   <input type="hidden" name="manual" value="0" /><input id="checker" type="checkbox" name="manual" onclick="if ($(this).is(':checked')) { $(this).val(1); $('#elink').attr('readonly', false); } else { $(this).val(0); $('#elink').attr('readonly', true); } " value="<?php if (isset($content['manual'])) echo $content['manual']; else echo 0; ?>" <?php if (isset($content['manual']) && $content['manual'] == 1) echo 'checked'; ?> />
   </div>
   
   <div class="clear"></div>
   
   <div class="small-field">
   <div>Посилання:</div>
   <input id="elink" type="text" name="link" <?php if (!isset($content['manual']) || $content['manual'] == 0) echo 'readonly'; ?> value="<?php if (isset($content['link'])) echo $content['link']; ?>" />
   </div>
   <div class="clear"></div>
   
  
  <div class="small-field">
   <div>Ціна:</div>
   <input type="text" name="price" value="<?php if (isset($content['price'])) echo $content['price']; else echo '0.00'; ?>" />
   </div>
   <div class="clear"></div>
  
  <?php if (!isset($SDS)) : ?>
  <div class="small-field">
     <?php if (isset($content['image']) && !empty($content['image'])) : ?><img src="<?php echo getsiteurl(), $content['image']; ?>" alt="image" /><?php endif; ?>
  </div>
  <div class="small-field">
      <div style="color: red; font-weight: bold;">Картинка 220 x 578</div>
      <input type="file" name="image" accept="image/*" />
  </div>
  <div class="clear"></div>
  <?php endif; ?>
  
  <?php if (isset($SDS)) : ?>
  
  <div class="small-field">
   <div>Скільки тканин можна вибрати:</div>
   <input type="text" name="textile_count" maxlength="1" value="<?php if (isset($content['price'])) echo $content['textile_count']; else echo 1; ?>" />
  </div><div class="clear"></div>
  
  <div class="small-field">
   <div>В наявності:</div>
   <input type="hidden" name="in_stock" value="0" /><input type="checkbox" name="in_stock" value="1" <?php if (isset($content['in_stock']) && $content['in_stock']) echo 'checked'; ?> />
  </div><div class="clear"></div>
  
  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <div class="small-field">
    <div>Область (<?php echo ltrim($value, '_'); ?>):</div>
    <input type="text" style="margin-bottom: 3px;" name="state<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['state'.$value])) echo htmlspecialchars($content['state'.$value]); ?>" />
  </div><div class="clear"></div>
  
  <div class="line"></div>
  <div class="clear"></div>
  <?php endforeach; ?>
  
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>
  
  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <h2>Текст сторінки (<?php echo ltrim($value, '_'); ?>):</h2>

  <div class="editor">
      <textarea class="texts" name="text<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['text'.$value])) echo $content['text'.$value]; ?></textarea>
  </div><div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>
  <?php endforeach; ?>
  
  <?php endif; ?>
  
  <?php endif; ?>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->