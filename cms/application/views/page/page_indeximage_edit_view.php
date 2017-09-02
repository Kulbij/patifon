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
  <form id="saveform" action="<?php echo base_url().'edit/save/indeximg'; ?>" method="post" enctype="multipart/form-data">

      <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
      <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
      <?php if (isset($LINK) && is_numeric($LINK) && $LINK > 0) : ?><input type="hidden" name="id" value="<?php echo $LINK; ?>" /><?php endif; ?>

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" />
  <script type='text/javascript' language="JavaScript" src='<?php echo base_url(); ?>js/jquery.js'></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>/js/fancy.js"></script>
  <div class="small-field" style="width: 900px;">
      <div>
          <?php if (isset($content['image'])) : ?>
          <a rel="images" href="<?php echo getsite_url(), $content['image']; ?>"><img src="<?php echo getsite_url(), $content['image']; ?>" /></a><br />
          <?php endif; ?>
          <span style="color: red; font-weight: bold;">рекомендований розмір 1280 x 372</span>&nbsp;<input type="file" size="32" accept="image/*" name="main_image" /></div>
      </div>

  <div class="clear"></div><br />

  <?php if (isset($SDS)) : ?>
  <div class="small-field">
   <input type="radio" name="isleft" value="1" <?php if (isset($content['isleft']) && $content['isleft'] == 1) echo 'checked'; ?> checked style="width: 25px;" /> - банер зліва<br />
   <input type="radio" name="isleft" value="0" <?php if (isset($content['isleft']) && $content['isleft'] == 0) echo 'checked'; ?> style="width: 25px;" /> - банер праворуч
  </div>

  <div class="clear"></div><br />
  <?php endif; ?>

  <div class="small-field">
   <div>Посилання:</div>
   <input type="text" maxlength="250" name="link" value="<?php if (isset($content['link'])) echo $content['link']; ?>" />
  </div>
  <br/>
  <div class="small-field">
   <div>Товар:</div>
   <select name="obj_id">
       <option value="0">Не вибрано</option>
       <?php foreach($content['objects'] as $one):?>
       <option value="<?php echo $one['id'];?>" <?php if(isset($content['obj_id']) && $one['id'] == $content['obj_id']) echo "selected='selected'";?>><?php echo $one['name'];?></option>
       <?php endforeach;?>
   </select>
  </div>

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </form>

</div><!-- end creation -->

</div><!-- end content -->