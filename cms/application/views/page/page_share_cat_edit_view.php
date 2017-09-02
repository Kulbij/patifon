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
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo $content['name'.$value]; ?>" 
      
      <?php if ($value == '_ru') : ?>
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

  <h2>Параметри:</h2>
  
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
     <?php if (isset($content['image']) && !empty($content['image'])) : ?><img src="<?php echo getsite_url(), $content['image']; ?>" alt="" /><?php endif; ?>
  </div>
  <div class="small-field">
      <div style="color: red; font-weight: bold;">Рекомендований розмір: 460 х 286</div>
      <input type="file" name="artical_image" accept="image/*" />
  </div>
  
  <div class="clear"></div>
  <?php endif; ?>
  
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->