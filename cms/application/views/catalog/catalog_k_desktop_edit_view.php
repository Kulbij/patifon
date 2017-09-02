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
      <?php if (isset($LINK) && is_numeric($LINK) && $LINK > 0) : ?><input type="hidden" name="id" value="<?php echo $LINK; ?>" /><?php endif; ?>

  <div class="field">

      <?php foreach ($this->config->item('config_languages') as $value) : ?>
      <br />Ім'я:<br />
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'.$value])) echo htmlspecialchars($content['name'.$value]); ?>" />
      <?php endforeach; ?>
      <br/>
      <br/>
      Ціна (грн): <br/>
      <input type="text" class="title-field" name="price" value="<?php if(isset($content['price'])) echo $content['price']; else echo 0;?>"/>
  </div>

  <div class="line"></div>
  <div class="clear"></div>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>

</div><!-- end creation -->

</div><!-- end content -->