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
  <form id="saveform" action="<?php echo base_url().'edit/save/page'; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <input type="hidden" name="id" value="<?php echo $LINK; ?>" />
      
  <div class="field">
      
      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я (<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>"
      
      <?php if ((!isset($LINK) || $LINK != 0) && $value == $this->config->item('config_default_lang')) : ?>
      id="ethis"
      
      onkeypress="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeyup="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeydown="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      <?php endif; ?>
      
      />
      <?php endforeach; ?>
      
      <?php if (!empty($LINK) && $LINK != 'index') : ?>
      <span><input type="hidden" name="visible" value="0" /><input type="checkbox" <?php if (isset($content['visible']) && $content['visible']) echo "checked='checked'"; ?> name="visible" value="1" />Відображати на сайті</span>
      <?php endif; ?>
      
  </div>

  <div class="line"></div>

  <h2>Параметри сторінки:</h2>
  
  <?php if (isset($LINK) && $LINK == 'price') : ?>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/ui/jquery-ui-1.8.16.custom.css" />
   <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
   <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/ui/jquery-ui-1.8.16.custom.min.js'; ?>"></script>
   <script type="text/javascript" language="JavaScript" src="<?php echo baseurl(), 'js/datepicker.js'; ?>"></script>
   <div class="small-field">
    <div style="width: 196px;">Дата актуальності прайс-листу:</div>
    <input id="datepicker" type="text" name="price_date" value="<?php if (isset($content['_price']['date'])) echo $content['_price']['date']; else echo date('Y-m-d'); ?>" />
   </div><div class="clear"></div>
   
   <div class="small-field">
    <div>Прайс-лист:</div>
    <input type="file" name="file_price" />
   </div><div class="clear"></div>
  
   <?php if (isset($content['_price']) && !empty($content['_price'])) : ?>
    <div class="small-field">
     <div style="color: red; font-weight: bold;">&nbsp;&nbsp;&nbsp;<?php echo $content['_price']['file'], ' - ', $content['_price']['weight']; ?></div>
    </div><div class="clear"></div>
   <?php endif; ?>
   <div class="line"></div><div class="clear"></div>
  
  <?php elseif (isset($SDS) && isset($_LINK) && $LINK == 'index') : ?>
  
  <div class="small-field">
    <div>Посилання на банер:</div>
    <input type="text" style="margin-bottom: 3px;" name="banner_link" maxlength="250" value="<?php if (isset($content['banner_link'])) echo htmlspecialchars($content['banner_link']); ?>" />
  </div><div class="clear"></div>
  
  <div class="small-field">
   <?php if (isset($content['banner']) && !empty($content['banner'])) : ?><img src="<?php echo getsite_url(), $content['banner']; ?>" alt="" /><?php endif; ?>
  </div>
  <div class="small-field">
   <div style="color: red; font-weight: bold;">Рекомендований розмір: 220 х 400</div>
   <input type="file" name="main_image" accept="image/*" />
  </div><div class="clear"></div><div class="line"></div><div class="clear"></div>
  
  <?php endif; ?>
  
  
  <?php if ((!isset($LINK) || $LINK != 0)) : ?>
  <?php if (isset($SDS)) : ?>
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
   <div>Батьківська сторінка</div>
   <select name="parentid">
    
    <?php if (!isset($SDS)) : ?><option value="0">Немає</option><?php endif; ?>
    
    <?php if (isset($CATS) && !empty($CATS)) : ?>
     <?php foreach ($CATS as $value) : ?>
      <option <?php if (isset($content['parentid']) && $content['parentid'] == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
      
      <?php if (isset($value['children'])) : ?>
       <?php slimO($value['children'], (isset($content['parentid']) ? $content['parentid'] : 0), 0, 5); ?>
      <?php endif; ?>
      
     <?php endforeach; ?>
    <?php endif; ?>
   </select>
  </div><div class="clear"></div>
  
  <?php else : ?><input type="hidden" name="parentid" value="0" />
  <?php endif; ?>
  
  <div class="clear"></div>
  
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
  
  <?php if (isset($SDS)) : ?>
  <div class="small-field">
  <div>Сторінка з файлами:</div>
  <input type="hidden" name="isdoc" value="0" /><input id="checker" type="checkbox" name="isdoc" value="1" <?php if (isset($content['isdoc']) && $content['isdoc'] == 1) echo 'checked'; ?> />
  </div>
  <?php else : ?><input type="hidden" name="isdoc" value="0" />
  <?php endif; ?>
  
  <div class="clear"></div>
  
  <?php endif; ?>
  
  
  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <div class="small-field">
    <div>Заголовок (<?php echo ltrim($value, '_'); ?>):</div>
    <input type="text" style="margin-bottom: 3px;" name="title<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['title'.$value])) echo htmlspecialchars($content['title'.$value]); ?>" />
  </div><div class="clear"></div>
  
  <div class="small-field">
    <div>Ключові слова (<?php echo ltrim($value, '_'); ?>):</div>
    <input type="text" style="margin-bottom: 3px;" name="keyword<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['keyword'.$value])) echo htmlspecialchars($content['keyword'.$value]); ?>" />
  </div><div class="clear"></div>

  <div class="small-field">
    <div>Опис (<?php echo ltrim($value, '_'); ?>):</div>
    <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="description<?php echo $value; ?>"><?php if (isset($content['description'.$value])) echo $content['description'.$value]; ?></textarea>
  </div><div class="clear"></div>
  
  <div class="line"></div>
  <div class="clear"></div>
  <?php endforeach; ?>
  
  <?php if (isset($LINK) && $LINK == 'history') : ?>
  <div class="small-field">
   <div>Посилання на відео:</div>
   <input type="text" name="text2_ua" value="<?php if (isset($content['text2_ua'])) echo $content['text2_ua']; ?>" />
  </div><div class="clear"></div>
  <?php endif; ?>
  
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

   <?php if (isset($content['link']) && $content['link'] == 'contact') : ?>
    <h2>Адреса магазину (<?php echo ltrim($value, '_'); ?>):</h2>

    <div class="editor">
     <textarea class="texts" name="text2<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['text2'.$value])) echo $content['text2'.$value]; ?></textarea>
    </div><div class="clear"></div>
    <div class="line"></div>
    <div class="clear"></div>
   <?php endif; ?>

  <?php endforeach; ?>
  
 <?php if (isset($SDS) && $LINK == 4) : ?>
  
  <?php if (isset($SDS)) : ?>
  
  <div class="line"></div>
  <div class="clear"></div>
  
  <?php foreach ($content['cts'] as $subvalue) : ?>
   <?php foreach ($this->config->item('config_languages') as $value) : ?>
   <h2>Текст №<?php echo $subvalue['id']; ?> (<?php echo ltrim($value, '_'); ?>):</h2>
   <div class="editor">
    <textarea class="texts" name="cts[<?php echo $subvalue['id']; ?>][text<?php echo $value; ?>]" cols="113" rows="5"><?php if (isset($subvalue['text'.$value])) echo $subvalue['text'.$value]; ?></textarea>
   </div><div class="clear"></div>
   <?php endforeach; ?>
   <div class="line"></div><div class="clear"></div>
  <?php endforeach; ?>
  <?php endif; ?>
  
  <div class="clear"></div>
  
  <div class="small-field">
    <div>E-mail:</div>
    <input type="text" style="margin-bottom: 3px;" name="email" maxlength="250" value="<?php if (isset($content['email'])) echo htmlspecialchars($content['email']); ?>" />
  </div><div class="clear"></div>
  
  <?php if (isset($SDS)) : foreach ($this->config->item('config_languages') as $value) : ?>
  <div class="small-field">
    <div>Постачальник (<?php echo ltrim($value, '_'); ?>):</div>
    <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="dir<?php echo $value; ?>"><?php if (isset($content['dir'.$value])) echo $content['dir'.$value]; ?></textarea>
  </div><div class="clear"></div>
  <?php endforeach; endif; ?>
  
  <div class="line"></div>
  
  <?php if (isset($SDS) && isset($content['graph']) && is_array($content['graph']) && !empty($content['graph'])) : foreach ($content['graph'] as $th) : ?>
  <h3><?php if (isset($th['days'])) echo $th['days']; ?></h3>
  <input type="hidden" name="graph[<?php echo $th['id']; ?>][id]" value="<?php echo $th['id']; ?>" />
  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <div class="small-field">
      <div>Дні:</div>
      <input type="text" maxlength="250" name="graph[<?php echo $th['id']; ?>][days<?php echo $value; ?>]" value="<?php echo $th['days'.$value]; ?>" />
  </div>
  <?php endforeach; ?>
  <div class="small-field">
      <div>З:</div>
      <input type="text" maxlength="250" name="graph[<?php echo $th['id']; ?>][from]" value="<?php echo $th['from']; ?>" />
  </div>
  <div class="small-field">
      <div>По:</div>
      <input type="text" maxlength="250" name="graph[<?php echo $th['id']; ?>][to]" value="<?php echo $th['to']; ?>" />
  </div>
  <div class="small-field">
   <div>Вихідний:</div>
   <input type="hidden" name="graph[<?php echo $th['id']; ?>][holiday]" value="0" /><input type="checkbox" name="graph[<?php echo $th['id']; ?>][holiday]" <?php if (isset($th['holiday']) && $th['holiday'] == 1) echo 'checked'; ?> value="1" />
  </div>
  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>
  <?php endforeach; endif; ?>
  
 <?php endif; ?>
  
  
  
  <?php if (isset($LINK) && $LINK == 'payment_and_delivery') : ?>
  
  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <h2>Оплата та доставка:</h2>
  <div class="editor">
   <textarea class="texts" name="text2<?php echo $value; ?>" cols="113" rows="20"><?php if (isset($content['text2'.$value])) echo $content['text2'.$value]; ?></textarea>
  </div><div class="clear"></div>
  <?php endforeach; ?>
  
  <?php endif; ?>
  
  <?php if (isset($SDS) && isset($LINK) && $LINK != 0 && $LINK != 2 && $LINK != 5) : ?>
   
   <div class="small-field">
    <?php if (isset($content['image_big']) && !empty($content['image_big'])) : ?><img style="max-width: 980px;" src="<?php echo getsite_url(), $content['image_big']; ?>" alt="" /><?php endif; ?>
   </div>
   <div class="small-field">
    <div style="color: red; font-weight: bold;">Картинка - 1088 x 328</div>
    <input type="file" name="image" accept="image/*" />
   </div>
   
   <?php if (isset($content['image_big']) && !empty($content['image_big'])) : ?>
   <div class="vertical">
    <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/page_image_1/', $LINK, "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
   </div>
   <?php endif; ?>
   
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
    <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/page_image_2/', $LINK, "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a>
   </div>
   <?php endif; ?>
   
   <div class="clear"></div>
   <div class="line"></div>
   <div class="clear"></div>
  <?php endif; ?>
  
  
  
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->