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
  <form id="saveform" action="<?php echo base_url().'edit/save/otherpage'; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <input type="hidden" name="link" value="<?php echo $LINK; ?>" />
      
  <div class="field">
      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я (<?php echo ltrim($value, '_'); ?>):<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>" />
      <?php endforeach; ?>
      
  </div>

  <div class="line"></div>

  <h2>Параметри сторінки:</h2>
  
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

 <?php if (isset($LINK) && $LINK == 'invoice') : ?>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>
  
  <?php foreach ($this->config->item('config_languages') as $value) : ?>

   <h2>Постачальник (<?php echo ltrim($value, '_'); ?>):</h2>

   <div class="editor">
    <textarea class="texts" name="pp<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['pp']['text'.$value])) echo $content['pp']['text'.$value]; ?></textarea>
   </div>
  <?php endforeach; ?>

 <?php endif; ?>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->