<div id="content">

<?php if (isset($breadcrumbs) && count($breadcrumbs) > 0) : ?>
<ul class="breadcrumbs">
  <?php foreach ($breadcrumbs as $one) : ?>
   <li><a href="<?php echo base_url(), $one['link']; ?>"><?php echo $one['name']; ?></a></li>
   <li>→</li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/ui/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/ui/jquery-ui-1.8.16.custom.min.js'; ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/datepicker.js'; ?>"></script>

<div class="clear"></div>

<div class="creation_page">
  <form id="saveform" action="<?php echo base_url().'edit/save/'.$SUBMODULE; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <?php if (isset($LINK) && is_numeric($LINK) && $LINK > 0) : ?><input type="hidden" name="id" value="<?php echo $LINK; ?>" /><?php endif; ?>
  
  <?php if ($this->session->userdata('product_date_error') !== false) : ?>
   <div class="field" style="border: solid red 1px; padding: 5px; font-size: 16px;">
    Не можна поставити дати <strong><?php echo $this->session->userdata('product_date_error') ?></strong> - на цю акцію, бо цей час занятий іншою акцією.
   </div>
  <?php $this->session->unset_userdata('product_date_error'); endif; ?>

  <div class="field">

      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я (<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>"
      
      <?php if ($value == $this->config->item('config_default_lang')) : ?>
      id="ethis"
      
      onkeypress="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeyup="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeydown="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      <?php endif; ?>
      
      />

      <br /><br />
      Коротка назва (<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="shortname<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['shortname'.$value])) echo htmlspecialchars($content['shortname'.$value]); ?>" />
      <?php endforeach; ?>
      
      <span><input type="hidden" name="visible" value="0" /><input type="checkbox" <?php if (isset($content['visible']) && $content['visible']) echo "checked='checked'"; ?> name="visible" value="1" />Відображати на сайті</span>
      
  </div>

  <div class="line"></div>

  <div class="clear"></div>
  
  <?php if (!isset($SDS)) : ?>
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
   <?php endif; ?>
   
   <div class="small-field">
   <div>Тип:</div>
    <select name="class">
      <?php
       $_type = array(
         'discount' => 'Скидка',
         'gift' => 'Товар в подарок',
         'sale' => 'Распродажа'
        );
       foreach ($_type as $key => $value) : 
      ?>
       <option <?php if (isset($content['class']) && $content['class'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
      <?php endforeach; ?>
    </select>
   </div><div class="clear"></div>

<div class="small-field">
    <div>Дата початку:</div>
    <input id="datepicker" type="text" style="margin-bottom: 3px;" name="date_start" readonly="readonly" maxlength="250" value="<?php if (isset($content['date_start'])) {
        echo date('Y-m-d', strtotime($content['date_start']));
    } else echo date("Y-m-d");
    ?>" />
  </div><div class="clear"></div>

  <div class="small-field">
    <div>Дата закінчення:</div>
    <input id="datepicker2" type="text" style="margin-bottom: 3px;" name="date_end" readonly="readonly" maxlength="250" value="<?php if (isset($content['date_end'])) {
        echo date('Y-m-d', strtotime($content['date_end']));
    } else echo date("Y-m-d");
    ?>" />
  </div><div class="clear"></div>

  <div class="small-field" style="width: 100%;">
   <div>Знижка:</div>
   <input type="text" name="discount" value="<?php if (isset($content['discount'])) echo $content['discount']; else echo '0.00'; ?>" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="hidden" name="is_uah" value="0" /><input style="width: 20px; margin-left: 50px;" type="checkbox" name="is_uah" value="1" <?php if (isset($content['is_uah']) && $content['is_uah']) echo 'checked'; ?> /> - відмітити якщо знижка не у відсотках а гривнях
   </div>
   <div class="clear"></div>

   <div class="small-field" style="width: 100%;">
   <div>Товар в подарунок:</div>
    <select name="dis_product_id">
      <option value="0">Немає</option>
      <?php foreach ($ALLT as $value) : ?>
       <option <?php if (isset($content['dis_product_id']) && $content['dis_product_id'] == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>">
        <?php echo $value['name']; ?>
       </option>
      <?php endforeach; ?>
    </select>
   </div>
   <div class="clear"></div>

   <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>

 <h2>Прив'язки</h2>

 <div class="small-field">
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
    <div>Батьківська:</div>
    <select name="rel_category_id">
        <option value="0">Немає</option>
        <?php foreach ($ALLC as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (isset($content['rel_category_id']) && $one['id'] == $content['rel_category_id']) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>
      
      <?php if (isset($one['children'])) : ?>
       <?php slimO($one['children'], (isset($content['rel_category_id']) ? $content['rel_category_id'] : 0), 0, 5); ?>
      <?php endif; ?>
      
      <?php endforeach; ?>
    </select>
  </div>

   <div class="small-field" style="width: 100%;">
   <div>Бренд:</div>
    <select name="rel_brand_id">
      <option value="0">Немає</option>
      <?php foreach ($ALLB as $value) : ?>
       <option <?php if (isset($content['rel_brand_id']) && $content['rel_brand_id'] == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>">
        <?php echo $value['name']; ?>
       </option>
      <?php endforeach; ?>
    </select>
   </div>
   <div class="clear"></div>

   <div class="small-field" style="width: 100%;">
   <div>Товар:</div>
    <select name="rel_object_id">
      <option value="0">Немає</option>
      <?php foreach ($ALLT as $value) : ?>
       <option <?php if (isset($content['rel_object_id']) && $content['rel_object_id'] == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>">
        <?php echo $value['name']; ?>
       </option>
      <?php endforeach; ?>
    </select>
   </div>
   <div class="clear"></div>

  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>

  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <div class="small-field">
    <div>Заголовок (<?php echo ltrim($value, '_'); ?>):</div>
    <input type="text" style="margin-bottom: 3px;" name="title<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['title'.$value])) echo $content['title'.$value]; ?>" />
  </div><div class="clear"></div>
  
  <div class="small-field">
    <div>Ключові слова (<?php echo ltrim($value, '_'); ?>):</div>
    <input type="text" style="margin-bottom: 3px;" name="keyword<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['keyword'.$value])) echo $content['keyword'.$value]; ?>" />
  </div><div class="clear"></div>

  <div class="small-field">
    <div>Опис (<?php echo ltrim($value, '_'); ?>):</div>
    <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="description<?php echo $value; ?>"><?php if (isset($content['description'.$value])) echo $content['description'.$value]; ?></textarea>
  </div><div class="clear"></div>

  <div class="small-field">
    <div>Опис по наведеню (<?php echo ltrim($value, '_'); ?>):</div>
    <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="text_hover<?php echo $value; ?>"><?php if (isset($content['text_hover'.$value])) echo $content['text_hover'.$value]; ?></textarea>
  </div><div class="clear"></div>
  
  <div class="line"></div>
  <div class="clear"></div>
  <?php endforeach; ?>

  <?php if (!isset($SDS)) : ?>
  <div class="small-field">
     <?php if (isset($content['image_hd']) && !empty($content['image_hd'])) : ?><img src="<?php echo getsiteurl(), $content['image_hd']; ?>" alt="image" /><?php endif; ?>
  </div>
  <div class="small-field">
      <div style="color: red; font-weight: bold;">Картинка 460 x 250</div>
      <input type="file" name="image" accept="image/*" />
  </div>
  <div class="clear"></div>
  <?php endif; ?>

  <div class="line"></div>
  <div class="clear"></div>

  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>
  
  <?php foreach ($this->config->item('config_languages') as $value) : ?>

   <h2>Короткий опис (<?php echo ltrim($value, '_'); ?>):</h2>
   <div class="editor">
       <textarea class="texts" name="shorttext<?php echo $value; ?>" cols="113" rows="10"><?php if (isset($content['shorttext'.$value])) echo $content['shorttext'.$value]; ?></textarea>
   </div>
   <div class="clear"></div>
   <div class="line"></div>
   <div class="clear"></div>
   <br />

   <h2>Повний опис (<?php echo ltrim($value, '_'); ?>):</h2>

   <div class="editor">
       <textarea class="texts" name="text<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['text'.$value])) echo $content['text'.$value]; ?></textarea>
   </div><div class="clear"></div>
   <div class="line"></div>
   <div class="clear"></div>

  <?php endforeach; ?>
  
  
  
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->