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
  <form id="saveform" action="<?php echo base_url().'edit/save/artical'; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <?php if (isset($LINK) && is_numeric($LINK) && $LINK > 0) : ?><input type="hidden" name="id" value="<?php echo $LINK; ?>" /><?php endif; ?>

  <div class="field">

      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я (<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo $content['name'.$value]; ?>"

      <?php if ($value == $this->config->item('config_default_lang')) : ?>
      id="ethis"

      onkeypress="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeyup="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeydown="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      <?php endif; ?>

      />
      <?php endforeach; ?>

      <?php if (!empty($LINK) && $LINK != 'main') : ?>
      <span><input type="hidden" name="visible" value="0" /><input type="checkbox" <?php if (isset($content['visible']) && $content['visible']) echo "checked='checked'"; ?> name="visible" value="1" />Відображати на сайті</span>
      <?php endif; ?>

  </div>

<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/datepicker.js'; ?>"></script>

  <div class="line"></div>

  <h2>Параметри статті:</h2>

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

  <div class="small-field">
    <div>К-сть переглядів:</div>
    <input type="text" disabled="disabled" value="<?php if (isset($content['countwatch'])) echo $content['countwatch']; else echo 0; ?>" />
  </div>

  <div class="clear"></div>

  <?php if (isset($SDS)) : ?>
  <div class="small-field">
    <div>Каталог:</div>
    <select name="catid">
        <option value="0">Все</option>
        <?php foreach ($CATS as $one) : ?>
        <option value="<?php echo $one['id']; ?>" <?php if (isset($content['catid']) && $one['id'] == $content['catid']) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>
        <?php endforeach; ?>
    </select>
  </div>
  <?php endif; ?>
  <div class="clear"></div>

  <div class="small-field">
    <div>Дата:</div>
    <input id="datepicker" type="text" style="margin-bottom: 3px;" name="date" readonly="readonly" maxlength="250" value="<?php if (isset($content['date'])) {
        echo date('Y-m-d', strtotime($content['date']));
    } else echo date("Y-m-d");
    ?>" />
  </div>

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
  <div class="line"></div>
  <div class="clear"></div>
  <?php endforeach; ?>

  <?php if (!isset($SDS)) : ?>
   <div class="small-field">
    <?php if (isset($content['image']) && !empty($content['image'])) : ?><img src="<?php echo getsite_url(), $content['image']; ?>" alt="" /><?php endif; ?>
   </div>
   <div class="small-field">
    <div style="color: red; font-weight: bold;">Рекомендований розмір: 540 х 280</div>
    <input type="file" name="artical_image" accept="image/*" />
   </div>

   <div class="clear"></div>
   <div class="line"></div>
  <?php endif; ?>

  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>

  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <h2>Скорочений текст (<?php echo ltrim($value, '_'); ?>):</h2>

  <div class="editor">
      <textarea class="texts" name="shorttext<?php echo $value; ?>" cols="113" rows="10"><?php if (isset($content['shorttext'.$value])) echo $content['shorttext'.$value]; ?></textarea>
  </div>
  <?php endforeach; ?>

  <div class="clear"></div>
  <div class="line"></div>

  <?php foreach ($this->config->item('config_languages') as $value) : ?>
  <h2>Повний текст (<?php echo ltrim($value, '_'); ?>):</h2>

  <div class="editor">
      <textarea class="texts" name="text<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['text'.$value])) echo $content['text'.$value]; ?></textarea>
  </div>
  <?php endforeach; ?>


  <?php if (isset($SDS)) : ?>

  <div class="small-field">
   <?php if (isset($content['top_image_big']) && !empty($content['top_image_big'])) : ?><img style="max-width: 980px;" src="<?php echo getsite_url(), $content['top_image_big']; ?>" alt="" /><?php endif; ?>
  </div>
  <div class="small-field">
   <div style="color: red; font-weight: bold;">Верхня картинка - 1088 x 328</div>
   <input type="file" name="image" accept="image/*" />
  </div>

  <div class="clear"></div>
  <div class="clear"></div>

  <div class="small-field">
   <?php if (isset($content['top_image2_big']) && !empty($content['top_image2_big'])) : ?><img style="max-width: 980px;" src="<?php echo getsite_url(), $content['top_image2_big']; ?>" alt="" /><?php endif; ?>
  </div>
  <div class="small-field">
   <div style="color: red; font-weight: bold;">Верхня картинка 2 - 1088 x 328</div>
   <input type="file" name="image2" accept="image/*" />
  </div>

  <?php endif; ?>

  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>



  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>

</div><!-- end creation -->

</div><!-- end content -->