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
  <form id="saveform" action="<?php echo base_url().'edit/save/leftpage'; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <input type="hidden" name="link" value="<?php echo $LINK; ?>" />
      
  <div class="field">
      <input type="text" class="title-field" name="name" maxlength="250" value="<?php if (isset($content['name'])) echo $content['name']; ?>" />
      
      <?php if (!empty($LINK)) : ?>
      <span><input type="hidden" name="visible" value="0" /><input type="checkbox" <?php if (isset($content['visible']) && $content['visible']) echo "checked='checked'"; ?> name="visible" value="1" />Відображати на сайті</span>
      <?php endif; ?>
      
  </div>

  <div class="line"></div>

  <h2>Параметри сторінки:</h2>
  
  <div class="small-field">
    <div>Заголовок:</div>
    <input type="text" style="margin-bottom: 3px;" name="title" maxlength="250" value="<?php if (isset($content['title'])) echo $content['title']; ?>" />
  </div>

  <div class="clear"></div>
  
  <div class="small-field">
    <div>Ключові слова:</div>
    <input type="text" style="margin-bottom: 3px;" name="keyword" maxlength="250" value="<?php if (isset($content['keyword'])) echo $content['keyword']; ?>" />
  </div>

  <div class="clear"></div>

  <div class="small-field">
    <div>Опис:</div>
    <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="description"><?php if (isset($content['description'])) echo $content['description']; ?></textarea>
  </div>
  
  <div class="clear"></div>

  <div class="line"></div>

 <?php if (!empty($LINK) && $LINK != 'bestproposition') : ?>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny.js'; ?>"></script>
  
  <h2>Текст сторінки:</h2>

  <div class="editor">
      <textarea id="text_form" name="text" cols="113" rows="30"><?php if (isset($content['text'])) echo $content['text']; ?></textarea>
  </div>
 <?php endif; ?>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->