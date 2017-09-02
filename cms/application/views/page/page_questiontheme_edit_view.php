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
      <input type="hidden" name="id" value="<?php echo $LINK; ?>" />
      
  <div class="field">
      <h2><?php if (isset($content['id'])) echo 'Адресат №', $content['id']; else echo 'Новий адресат'; ?></h2>
  </div>
  
  <div class="small-field">
    <div>Ім'я (ua):</div>
    <input type="text" style="margin-bottom: 3px;" name="name_ua" maxlength="250" value="<?php if (isset($content['name_ua'])) echo $content['name_ua']; ?>" />
  </div><div class="clear"></div>
  
  <div class="small-field">
    <div>Ім'я (ru):</div>
    <input type="text" style="margin-bottom: 3px;" name="name_ru" maxlength="250" value="<?php if (isset($content['name_ru'])) echo $content['name_ru']; ?>" />
  </div><div class="clear"></div>
  
  <div class="small-field">
    <div>Ім'я (en):</div>
    <input type="text" style="margin-bottom: 3px;" name="name_en" maxlength="250" value="<?php if (isset($content['name_en'])) echo $content['name_en']; ?>" />
  </div><div class="clear"></div>
  
  <div class="small-field">
    <div>Ім'я (pl):</div>
    <input type="text" style="margin-bottom: 3px;" name="name_pl" maxlength="250" value="<?php if (isset($content['name_pl'])) echo $content['name_pl']; ?>" />
  </div><div class="clear"></div>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->