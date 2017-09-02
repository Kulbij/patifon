<div id="content">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/ui/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/ui/jquery-ui-1.8.16.custom.min.js'; ?>"></script>

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

      <?php if ($value == $this->config->item('config_default_lang')) : ?>
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

  <h2>Параметри меню:</h2>

  <?php if (isset($SDS)) : ?>
  <div class="small-field">
   <div>Основне меню</div>
   <input type="hidden" name="visible_ontop" value="0" />
   <input type="checkbox" <?php if (isset($content['visible_ontop']) && $content['visible_ontop']) echo "checked='checked'"; ?> name="visible_ontop" value="1" />
  </div><div class="clear"></div>
  <?php endif; ?>

  <?php if (!isset($SDS)) : ?>

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
    <select name="parentid">
        <option value="0">Немає</option>
        <?php foreach ($CATS as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (isset($content['parentid']) && $one['id'] == $content['parentid']) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>

      <?php if (isset($one['children'])) : ?>
       <?php slimO($one['children'], (isset($content['parentid']) ? $content['parentid'] : 0), 0, 5); ?>
      <?php endif; ?>

      <?php endforeach; ?>
    </select>
  </div>

  <div class="clear"></div>


  <div class="small-field">
    <div>Батьківська 2:</div>
    <select name="parentid2">
        <option value="0">Немає</option>
        <?php foreach ($CATS as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (isset($content['parentid2']) && $one['id'] == $content['parentid2']) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>

      <?php if (isset($one['children'])) : ?>
       <?php slimO($one['children'], (isset($content['parentid2']) ? $content['parentid2'] : 0), 0, 5); ?>
      <?php endif; ?>

      <?php endforeach; ?>
    </select>
  </div>

  <div class="clear"></div>
<?php if (isset($SDS)) : ?>
  <div class="small-field">
    <div>Батьківська 3:</div>
    <select name="parentid3">
        <option value="0">Немає</option>
        <?php foreach ($CATS as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (isset($content['parentid3']) && $one['id'] == $content['parentid3']) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>

      <?php if (isset($one['children'])) : ?>
       <?php slimO($one['children'], (isset($content['parentid3']) ? $content['parentid3'] : 0), 0, 5); ?>
      <?php endif; ?>

      <?php endforeach; ?>
    </select>
  </div>
  <?php endif; ?>

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

  <?php if (isset($SDS) && isset($content['parentid']) && $content['parentid'] == 0) : ?>
  <div class="small-field" style="width: 980px;">
   <div>Призначення категорії:</div>
   <div>
    <input style="width: 20px;" type="radio" name="cat_type" value="-1" <?php if (!isset($content['cat_type']) || !in_array($content['cat_type'], array('is_d', 'is_sh', 'is_k'))) echo 'checked'; ?> />Не вибрано<br />
    <input style="width: 20px;" type="radio" name="cat_type" value="is_d" <?php if (isset($content['cat_type']) && $content['cat_type'] == 'is_d') echo 'checked'; ?> />Дивани<br />
    <input style="width: 20px;" type="radio" name="cat_type" value="is_sh" <?php if (isset($content['cat_type']) && $content['cat_type'] == 'is_sh') echo 'checked'; ?> />Шафи<br />
    <input style="width: 20px;" type="radio" name="cat_type" value="is_k" <?php if (isset($content['cat_type']) && $content['cat_type'] == 'is_k') echo 'checked'; ?> />Кухні<br />
   </div>
  </div>
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
  <?php endforeach; ?>
  <div class="clear"></div>

  <div class="small-field" style="width: 980px;">
    <div style="width: 100%; margin: 0 0 10px 0;">Фільтри, які використовуватимуться:</div>

    <?php if (isset($content['parentid']) && $content['parentid'] > 0) : ?>
     <div class="clear"></div>
      <div style="width: 100%; margin-bottom: 30px;">
       <input type="hidden" name="filter_concat" value="0" /><input style="width: 40px;" type="checkbox" name="filter_concat" <?php if (isset($content['filter_concat']) && $content['filter_concat']) echo 'checked'; ?> value="1" /> - приєднати фільтри з батьківської категорії
      </div>
     <div class="clear"></div>
    <?php endif; ?>

    <?php
      if (isset($filters) && !empty($filters)) :
      $array_chunk = array_chunk($filters, ceil(count($filters)/3), true);
      foreach ($array_chunk as $value) :
    ?>
     <div style="width: 200px;">
       <?php foreach ($value as $subvalue) : ?>
         <div style="margin: 0 0 5px 0; width: 200px;">
          <label>
           <input style="width: 40px;" type="checkbox" name="filters[]" <?php if (isset($filters_already[$subvalue['id']])) echo 'checked'; ?> value="<?php echo $subvalue['id']; ?>" /> - <?php echo $subvalue['name']; ?>
          </label>
         </div>
       <?php endforeach; ?>
     </div>
    <?php endforeach; endif; ?>
  </div><div class="clear"></div>

  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>

  <?php if (isset($SDS)) : ?>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>

  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <h2>Текст (<?php echo ltrim($value, '_'); ?>):</h2>

  <div class="editor">
      <textarea class="texts" name="text<?php echo $value; ?>" cols="113" rows="20"><?php if (isset($content['text'.$value])) echo $content['text'.$value]; ?></textarea>
  </div><div class="clear"></div>
  <?php endforeach; ?>

  <?php endif; ?>

  <?php 

  $url = base_url();
  $url = explode('cms', $url);
  $url = $url[0];
  ?>

  <?php if (!isset($SDS)) : ?>
   <div class="small-field">
      <?php if (isset($content['image_big']) && !empty($content['image_big'])) : ?>
        <img style="max-width: 980px;" src="<?php echo $url.$content['image_big']; ?>" alt="photo" />
      <?php endif; ?>
   </div>
   <div class="small-field">
       <div style="color: red; font-weight: bold;">Картинка - 320 x 239</div>
       <input type="file" name="cat_image" accept="image/*" />
   </div><div class="clear"></div>
  <?php endif; ?>

  <div class="clear"></div>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>

</div><!-- end creation -->

</div><!-- end content -->