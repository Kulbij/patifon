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
  <form id="saveform" action="<?php echo base_url().'edit/save/topphones'; ?>" method="post"  enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <input type="hidden" name="id" value="<?php echo $LINK; ?>" />

  <div class="field">
      <h2><?php if (isset($content['operator'])) echo $content['operator']; ?></h2>
  </div>

  <?php if (isset($SDS)) : foreach ($this->config->item('config_languages') as $value) : ?>
  <div class="small-field">
    <div>Ім'я менеджера (<?php echo ltrim($value, '_'); ?>):</div>
    <input type="text" style="margin-bottom: 3px;" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>" />
  </div><div class="clear"></div>
  <?php endforeach; endif; ?>

  <div class="small-field">
    <div>Номер:</div>
    <input typr="text" name="phone" value="<?php if (isset($content['phone'])) echo $content['phone']; ?>" />
  </div>

  <div class="clear"></div>

  <div class="small-field">
    <div>Пакет телефона:</div>
    <select name="phones_packet">
      <option <?php if($content['paket'] == 0) echo 'selected'; ?> value="0">Виберите пакет</option>
      <option <?php if($content['paket'] == 1) echo 'selected'; ?> value="1">МТС</option>
      <option <?php if($content['paket'] == 2) echo 'selected'; ?> value="2">Киевстар</option>
      <option <?php if($content['paket'] == 3) echo 'selected'; ?> value="3">Life:)</option>
    </select>
  </div>

  <?php if (isset($SDS)) : ?>

  <div class="small-field">
   <?php if (isset($content['image']) && !empty($content['image'])) : ?><img style="max-width: 980px;" src="<?php echo getsite_url(), $content['image']; ?>" alt="" /><?php endif; ?>
  </div>
  <div class="small-field">
   <div style="color: red; font-weight: bold;">Картинка - 16 x 16</div>
   <input type="file" name="image" accept="image/*" />
  </div>


  <div class="small-field">
    <div style="width: 175px;">Видимий зверху на сайті:</div>
    <input type="hidden" name="visible_onhead" value="0" /><input type="checkbox" style="margin-bottom: 3px;" name="visible_onhead" value="1" <?php if (isset($content['visible_onhead']) && $content['visible_onhead']) echo 'checked'; ?> />
  </div><div class="clear"></div>


  <div class="small-field">
    <div style="width: 175px;">Видимий в шапці сайту:</div>
    <input type="hidden" name="visible_ontop" value="0" /><input type="checkbox" style="margin-bottom: 3px;" name="visible_ontop" value="1" <?php if (isset($content['visible_ontop']) && $content['visible_ontop']) echo 'checked'; ?> />
  </div>

  <div class="clear"></div>

  <div class="small-field">
    <div style="width: 175px;">Видимий в підвалі:</div>
    <input type="hidden" name="visible_onfoot" value="0" /><input type="checkbox" style="margin-bottom: 3px;" name="visible_onfoot" value="1" <?php if (isset($content['visible_onfoot']) && $content['visible_onfoot']) echo 'checked'; ?> />
  </div>

  <div class="clear"></div>

  <div class="small-field">
    <div style="width: 175px;">Мобільний:</div>
    <input type="hidden" name="mobile" value="0" /><input type="checkbox" style="margin-bottom: 3px;" name="mobile" value="1" <?php if (isset($content['mobile']) && $content['mobile']) echo 'checked'; ?> />
  </div>
  <?php endif; ?>
  <div class="clear"></div>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>

</div><!-- end creation -->

</div><!-- end content -->