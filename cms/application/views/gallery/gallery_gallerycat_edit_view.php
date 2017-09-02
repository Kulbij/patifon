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
  <form id="saveform" action="<?php echo base_url().'edit/save/'.$SUBMODULE; ?>" method="post" enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <?php if (isset($ID) && is_numeric($ID) && $ID > 0) : ?><input type="hidden" name="id" value="<?php echo $ID; ?>" /><?php endif; ?>
      
  <div class="field" style="width: 920px;">
      
      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я (<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>" />
      <?php endforeach; ?>
      
      <?php if (!empty($ID) && $ID > 0) : ?>
      <span><input type="hidden" name="visible" value="0" /><input type="checkbox" <?php if (isset($content['visible']) && $content['visible']) echo "checked='checked'"; ?> name="visible" value="1" />Відображати в галереї</span>
      <?php endif; ?>
      
  </div>
  
  <div class="clear"></div>
  <div class="line"></div>
  
  <h2>Параметры</h2>
  
  <input type="hidden" name="parentid" value="0" />
  <?php if (isset($SDS)) : ?>
  <div class="small-field">
   <div>Батьківська:</div>
   <select name="parentid">
    <option value="0">Немає</option>
    <?php if (isset($CATS) && !empty($CATS)) : ?>
     <?php foreach ($CATS as $value) : ?>
      <option value="<?php echo $value['id']; ?>" <?php if (isset($content['parentid']) && $content['parentid'] == $value['id']) echo 'selected'; ?>><?php echo $value['name']; ?></option>
     <?php endforeach; ?>
    <?php endif; ?>
   </select>
  </div><div class="clear"></div>
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
  
  <div class="clear"></div>
  <div class="line"></div>
  <div class="small-field">
     <?php if (isset($content['image']) && !empty($content['image'])) : ?><img width="270" height="180" src="<?php echo getsite_url(), $content['image']; ?>" alt="" /><?php endif; ?>
  </div>
  <div class="small-field">
      <div style="color: red; font-weight: bold;">Рекомендований розмір: 470 x 324</div>
      <input type="file" name="gcat_image" accept="image/*" />
  </div>
  
  <div class="clear"></div>
  <div class="small-field">
  </div>
  <br /><br />
  <div class="clear"></div>
  <?php if (isset($SDS)) : ?>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>
  
  <h2>Текст (ua):</h2>
  <div class="editor">
      <textarea class="texts" name="text_ua" cols="113" rows="20"><?php if (isset($content['text_ua'])) echo $content['text_ua']; ?></textarea>
  </div>
  <div class="clear"></div>
  
  <h2>Текст (ru):</h2>
  <div class="editor">
      <textarea class="texts" name="text_ru" cols="113" rows="20"><?php if (isset($content['text_ru'])) echo $content['text_ru']; ?></textarea>
  </div>
  <div class="clear"></div>

  <h2>Текст (en):</h2>
  <div class="editor">
      <textarea class="texts" name="text_en" cols="113" rows="20"><?php if (isset($content['text_en'])) echo $content['text_en']; ?></textarea>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
  <div class="line"></div>
  
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->