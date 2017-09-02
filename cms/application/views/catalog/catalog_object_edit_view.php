<div id="content">
<script src="<?php echo base_url(),'js/jquery-2.1.3.min.js';?>"></script>

<script src="<?php echo base_url(),'js/jquery-migrate-1.2.1.min.js';?>"></script>
<!--<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>-->
<link rel="stylesheet" href="<?php echo base_url(), 'js/datepicker/css/ui-lightness/jquery-ui-1.9.2.custom.min.css';?>"/>
<script src="<?php echo base_url(), 'js/datepicker/js/jquery-ui-1.9.2.custom.min.js';?>"></script>
<link type="text/css" href="<?php echo base_url(), 'js/select2/css/select2.min.css'; ?>" rel="stylesheet"></link>
<script src="<?php echo base_url(), 'js/select2/js/select2.js'; ?>"></script>
<script type="text/javascript" language="JavaScript">
$(window).load(function(){
 $('.button').css('display', 'block');
 $('#datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            monthNamesShort: [ "Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень" ],
            yearRange: "1900:" + new Date().getFullYear()
        });
        $('#sort').sortable({
                        update: function(event, ui) {
                           console.log($('#sort>li>input').serialize());
                           
                           $.ajax({
                              url:  '<?php echo baseurl('edit/ajax/sort');?>',
                              data: $('#sort>li>input').serialize(),
                              type: 'POST'                              
                           });
                        }
                        
                    });
});
$(function(){
     $('#share').select2();
        $('#share').on('select2:unselect', function() {
    if ($(this).val() === null) {
        $(this).val("0").trigger("change");
        $(this).select2('close');
    }
      }).on('select2:select', function() {
    $(this).find(':selected[value=0]').removeAttr('selected').trigger('change');
      });
});

function removeIndexImage(id){

  if (confirm("Видалити картинку?")) {
  $('.index_img_' + id).detach();
}
  }
// create ajax ===========================================
  $(document).ready(function() {
    $('.del_cat').click(function(){
        var text_cat = $(this).parent().parent().parent().find('.center-item span a').text();
            if (confirm("Видалити Категорію " + "«" + text_cat + "» ?")) {
              $(this).parent().parent().parent().detach();

              var id_cat = $(this).parent().parent().parent().find('.id_cat').val();
              var id = <?php if(isset($ID) && !empty($ID) && $ID >= 1) echo $ID; else echo 0; ?>;

              $.ajax({
                      url: '<?php echo baseurl('edit/ajax/cat');?>',
                      data: 'id=' + id_cat + '&id_obj=' + id,
                      type: 'POST',
                      success: function (data) {
                        // end
                      }
                   });
            }
    });
    $('.del_pop').click(function(){
        var text_cat = $(this).parent().parent().parent().find('.center-item span a').text();
            if (confirm("Видалити Категорію " + "«" + text_cat + "» ?")) {
              $(this).parent().parent().parent().detach();

              var id = $(this).parent().parent().parent().find('.id_pop').val();

              $.ajax({
                      url: '<?php echo baseurl('edit/ajax/pop');?>',
                      data: 'id=' + id,
                      type: 'POST'
                   });
            }
    })
    $('.del_color').click(function(){
        var text_cat = $(this).parent().parent().parent().find('.center-item span a').text();
            if (confirm("Видалити Категорію " + "«" + text_cat + "» ?")) {
              $(this).parent().parent().parent().detach();

              var id = $(this).data('id');

              $.ajax({
                      url: '<?php echo baseurl('edit/ajax/color');?>',
                      data: 'id=' + id,
                      type: 'POST'
                   });
            }
    })
  });
  
</script>

<?php if (isset($breadcrumbs) && count($breadcrumbs) > 0) : ?>
<ul class="breadcrumbs">
  <?php foreach ($breadcrumbs as $one) : ?>
   <li><a href="<?php echo base_url(), $one['link']; ?>"><?php echo $one['name']; ?></a></li>
   <li>→</li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<div class="clear"></div>

<div class="creation_product">
<form id="saveform" action="<?php echo base_url().'edit/save/'.$SUBMODULE; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="module" value="<?php if (isset($MODULE)) echo $MODULE; ?>" />
    <input type="hidden" name="submodule" value="<?php if (isset($SUBMODULE)) echo $SUBMODULE; ?>" />
    <?php if (isset($ID) && is_numeric($ID) && $ID > 0) : ?><input type="hidden" name="id" value="<?php echo $ID; ?>" /><?php endif; ?>

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

      <span class="checkbox"><input type="hidden" name="visible" value="0" /><input type="checkbox" name="visible" value="1" <?php if (isset($content['visible']) && $content['visible'] == 1) echo "checked='checked'"; ?> />Видимий на сайті</span>
   </div>


  <?php if (isset($SDS)) : ?>
  <div class="field field-category">
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
    <span class="text">Меню:</span><br />
    <select name="categoryid">
      <option value="0">Немає</option>
      <?php foreach ($cats as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (((isset($content['idcat']) && $content['idcat'] == $one['id']) || (isset($_SESSION['cat_selected']) && $_SESSION['cat_selected'] == $one['id']))) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>

      <?php if (isset($one['children'])) : ?>
       <?php slimO($one['children'], (isset($content['idcat']) ? $content['idcat'] : 0), (isset($_SESSION['cat_selected']) ? $_SESSION['cat_selected'] : 0), 5); ?>
      <?php endif; ?>

      <?php endforeach; ?>
    </select>
  </div>
  <?php endif; ?>

  <?php if (isset($SDS)) : ?>
    <div class="field field-category">
    <span class="text">Батьківський:</span><br />
    <select name="parentid">
      <option value="0">Немає</option>
      <?php foreach ($alltovar as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if ((isset($content['parentid']) && $content['parentid'] == $one['id']) || (isset($PARENT_PARENT) && $PARENT_PARENT == $one['id'])) echo "selected='selected'"; ?>><?php if (empty($one['name'])) echo 'Немає'; else echo $one['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <?php endif; ?>

    <?php if (!isset($SDS)) : ?>
    <div class="field field-category">
    <span class="text">Акції:</span><br />
    <select name="shareid[]" id='share' multiple='multiple'>
        <option value="0" <?php if(empty($content['shareid'])) echo 'selected="selected"';?>>Немає</option>
      <?php foreach ($shares as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (isset($content['shareid']) && in_array($one['id'],$content['shareid'])) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
    <div class="field field-category">
    <span class="text">Подарунок:</span><br />
    <input style="width: 250px;" type="text" name="gift" value="<?php if(isset($content['gift'])) echo $content['gift'];?>"/>
    <br/>
    <br/>
    <input type="text" name="date_gift" id="datepicker" value="<?php if(isset($content['date_gift'])) echo $content['date_gift'];?>" />
  </div>
    <?php endif; ?>

  <div class="clear"></div>
  <div class="line"></div>

  <div class="field">
   <?php if (isset($ID) && is_numeric($ID) && $ID > 0) : ?>
    <div class="price">
      <span class="text">Артикул:</span><br />
      <input type="text" name="id" disabled="disabled" value="<?php if (isset($content['id'])) echo $content['id']; ?>" />
    </div>

      <div class="price">
      <span class="text">К-сть переглядів:</span><br />
      <input type="text" name="countwatch" disabled="disabled" value="<?php if (isset($content['countwatch'])) echo $content['countwatch']; ?>" />
    </div>

   <?php endif; ?>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/ui/jquery-ui-1.8.16.custom.css" />
<!--<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>-->
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/ui/jquery-ui-1.8.16.custom.min.js'; ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/datepicker.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" />
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>/js/fancy.js"></script>

    <div class="price">
      <span class="text">Стара ціна:</span><br />
      <input type="text" class="field-price" name="old_price" value="<?php if (isset($content['old_price'])) echo $content['old_price']; else echo 0; ?>" />
    </div>

    <div class="price">
      <span class="text">Ціна:</span><br />
      <input type="text" class="field-price" name="price" value="<?php if (isset($content['price'])) echo $content['price']; else echo 0; ?>" />
    </div>

  <?php if (!isset($SDS)) : ?>
  <div class="price" style="margin-top: 10px; margin-left: -5px;">
   <input type="hidden" name="in_stock" value="0" /><input type="checkbox" name="in_stock" value="1" <?php if (isset($content['in_stock']) && $content['in_stock']) echo 'checked';  ?> /> - есть в наличии
  </div>
  <?php endif; ?>

  <?php if (isset($SDS)) : ?>
  <div class="price" style="margin-top: 10px; margin-left: 0px;">
   <span class="text">Наработка часов:</span><br />
   <input type="text" class="field-price" name="workhours" value="<?php if (isset($content['workhours'])) echo $content['workhours']; else echo 0; ?>" /> часов
  </div>

  <div class="price" style="margin-top: 10px; margin-left: -5px;">
   <span class="text">Пробег:</span><br />
   <input type="text" class="field-price" name="run" value="<?php if (isset($content['run'])) echo $content['run']; else echo 0; ?>" /> тыс.км.
  </div>
  <?php endif; ?>

  <div class="price" style="margin-top: 10px; margin-left: -5px;">
   <input type="hidden" name="avail" value="0" /><input type="checkbox" name="avail" value="1" <?php if (isset($content['avail']) && $content['avail']) echo 'checked';  ?> /> - знятий з продажу
  </div>

  <?php if (!isset($SDS)) : ?>
  <div class="price" style="margin-top: 10px; margin-left: -5px;">
   <input type="hidden" name="popular" value="0" /><input type="checkbox" name="popular" value="1" <?php if (isset($content['popular']) && $content['popular']) echo 'checked';  ?> /> - показувати на головній
  </div>
  <?php endif; ?>
  <?php if (!isset($SDS)) : ?>
  <div class="price" style="margin-top: 10px; margin-left: -5px;">
   <input type="hidden" name="delivery_3_5" value="0" /><input type="checkbox" name="delivery_3_5" value="1" <?php if (isset($content['delivery_3_5']) && $content['delivery_3_5']) echo 'checked';  ?> /> - ожидание 2-3 дня
  </div>
  <?php endif; ?>

  <div class="price" style="margin-top: 10px; margin-left: -5px;">
   <input type="hidden" name="show_cart" value="0" /><input type="checkbox" name="show_cart" value="1" <?php if (isset($content['show_cart']) && $content['show_cart'] == 1) echo 'checked';  ?> /> - Показувати в корзині
  </div>


   <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>
  </div>

  <div class="clear"></div>
  <div class="line"></div>

  <div class="field2">
    <h2>Параметри:</h2>

    <div class="small-field">
    <div>Посилання буде введенне вручну:</div>
    <input type="hidden" name="manual" value="0" /><input id="checker" type="checkbox" name="manual" onclick="if ($(this).is(':checked')) { $(this).val(1); $('#elink').attr('readonly', false); } else { $(this).val(0); $('#elink').attr('readonly', true); } " value="<?php if (isset($content['manual'])) echo $content['manual']; else echo 0; ?>" <?php if (isset($content['manual']) && $content['manual'] == 1) echo 'checked'; ?> />
    </div>

    <div class="clear"></div>

    <div class="small-field">
     <div>Посилання:</div>
     <input id="elink" type="text" name="link" <?php if (!isset($content['manual']) || $content['manual'] == 0) echo 'readonly'; ?> value="<?php if (isset($content['link'])) echo $content['link']; ?>" />
     </div><div class="clear"></div>

     <?php if (isset($SDS)) : ?>

     <?php
    function slim_pp($children, $menuid, $parmenuid, $RANG) {

      foreach ($children as $one) {
          echo "<option value='{$one['id']}'";
          if (($parmenuid == $one['id']) || ($menuid == $one['id'])) echo "selected='selected'";
          echo " style='margin-left: {$RANG}px;'>";
          for ($i = 1; $i < $RANG; ++$i) echo '&nbsp;';
          echo "{$one['name']}</option>";

          if (isset($one['children'])) slim_pp($one['children'], $menuid, $parmenuid, ($RANG + 5));
      }

      $RANG -= 5;

    }
    ?>
     <div class="small-field">
      <div>Сторінка інструкцій:</div>
      <select name="pageid" style="width: auto;">
       <option value="0">Немає</option>
       <?php if (isset($pages) && !empty($pages)) : ?>
        <?php foreach ($pages as $value) : ?>
         <option <?php if (isset($content['pageid']) && $content['pageid'] == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>

         <?php if (isset($value['children'])) : ?>
          <?php slim_pp($value['children'], (isset($content['pageid']) ? $content['pageid'] : 0), 0, 5); ?>
         <?php endif; ?>

        <?php endforeach; ?>
       <?php endif; ?>
      </select>
     </div><div class="clear"></div>

    <?php endif; ?>

    <?php foreach ($this->config->item('config_languages') as $value) : ?>
    <div class="clear"></div>
    <div class="line" style="width: 432px;"></div>
    <div class="clear"></div>

    <div class="small-field">
     <div>Заголовок (<?php echo ltrim($value, '_'); ?>):</div>
     <input type="text" style="margin-bottom: 3px;" name="title<?php echo $value ?>" maxlength="250" value="<?php if (isset($content['title'.$value])) echo htmlspecialchars($content['title'.$value]); ?>" />
    </div><div class="clear"></div>

    <div class="small-field">
     <div>Ключові слова (<?php echo ltrim($value, '_'); ?>):</div>
     <input type="text" style="margin-bottom: 3px;" name="keyword<?php echo $value ?>" maxlength="250" value="<?php if (isset($content['keyword'.$value])) echo htmlspecialchars($content['keyword'.$value]); ?>" />
    </div><div class="clear"></div>

    <div class="small-field">
     <div>Опис (<?php echo ltrim($value, '_'); ?>):</div>
     <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="description<?php echo $value ?>"><?php if (isset($content['description'.$value])) echo $content['description'.$value]; ?></textarea>
    </div><div class="clear"></div>
    <?php endforeach; ?>

    <!--  -->

    <!-- <div class="small-field">
     <div>Відео:</div>
     <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="video"><?php if (isset($content['video'])) echo $content['video']; ?></textarea>
    </div><div class="clear"></div> -->

    <div class="title_video">Відео:</div>
    <?php if(empty($video)) : ?>
    <div class="video_element">
     <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="old_video[]"><?php if (isset($video['text'])) echo $video['text']; ?></textarea>
    </div><div class="clear"></div>
    <?php endif; ?>

    <?php if(isset($video) && !empty($video)) foreach($video as $video) : ?>

    <div class="video_element">
     <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="old_video[]"><?php if (isset($video['text'])) echo $video['text']; ?></textarea>
    </div><div class="clear"></div>

    <?php endforeach; ?>

    <style type="text/css">
    .add_video {
      float: right;
      border: 1px solid #000;
      padding: 5px;
      text-decoration: none;
      font-weight: bold;
    }
    .new_video textarea {
      float: right;
    }
    .video_element textarea {
      width: 100%;
    }
    .title_video {
      font-weight: bold;
      padding-bottom: 10px;
    }
    </style>
    
    
    <script type="text/javascript">
    $(document).ready(function() {
      $('.add_video').click(function() {
        var video = '<div class="new_video video_element"><textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="video_new[]"></textarea></div><div class="clear"></div>';
      var last_el = $('.video_element').next().last();
      last_el.append(video);
      });
    });
    </script>
    <div class="clear"></div>
    <a href="javascript:void(0);" class="add_video">Додати відео</a>
    <div class="clear"></div>

    <?php if (isset($SDS)) : ?>

    <div class="small-field" style="width: 445px;">
     <div>Ширина:</div>
     <input type="text" style="margin-bottom: 3px;" name="width" maxlength="250" value="<?php if (isset($content['width'])) echo htmlspecialchars($content['width']); ?>" />&nbsp;см
    </div><div class="clear"></div>

    <div class="small-field" style="width: 445px;">
     <div>Висота:</div>
     <input type="text" style="margin-bottom: 3px;" name="height" maxlength="250" value="<?php if (isset($content['height'])) echo htmlspecialchars($content['height']); ?>" />&nbsp;см
    </div><div class="clear"></div>

    <div class="small-field" style="width: 445px;">
     <div>Глибина:</div>
     <input type="text" style="margin-bottom: 3px;" name="depth" maxlength="250" value="<?php if (isset($content['depth'])) echo htmlspecialchars($content['depth']); ?>" />&nbsp;см
    </div><div class="clear"></div>

    <?php endif; ?>

    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </div><!-- end field2 -->

  <div class="field2">
    <h2>Картинки:</h2>

    <?php if (isset($ID) && is_numeric($ID) && $ID > 0) : ?>

    <div class="product-images" style="width: 100px; height: 68px;">
       <?php if (isset($content['image']) && !empty($content['image']) && isset($content['image']) && !empty($content['image'])) : ?>
        <a rel="images" href="<?php if (isset($content['image'])) echo getsiteurl(), 'images/', $ID, '/mainimg/', $content['image']; ?>"><img id="photo_this" style="max-width: 100px; max-height: 68px;" src="<?php if (isset($content['image'])) echo getsiteurl(), 'images/', $ID, '/mainimg/', $content['image']; ?>" /></a>
        <?php endif; ?>
    </div>
    <div style="padding-left: 160px; margin-top: 0px;">
     <?php if (!isset($SDS)) : ?>
     <span style="color: red; font-weight: bold;">Рекомендований розмір: 580 х 580</span><br /><br /><?php endif; ?>
     <?php if (isset($content['image']) && !empty($content['image'])) : ?>
     Змінити головну картинку:<br /><br />
    <input type="file" size="20" accept="image/*" name="main_image" />
    <?php else : ?>
    Завантажити головну картинку:<br /><br />
    <input type="file" size="20" accept="image/*" name="main_image" />
    <?php endif; ?>
    </div>

   <?php if (isset($SDS)) : ?>

    <div class="clear"></div>
    <div class="line" style="width: 440px;"></div>
    <div class="clear"></div>

    <div class="product-images" style="width: 100px; height: 68px;">
       <?php if (isset($content['image_hover']) && !empty($content['image_hover']) && isset($content['image_hover']) && !empty($content['image_hover'])) : ?>
        <a rel="images" href="<?php if (isset($content['image_hover'])) echo getsiteurl(), 'images/', $ID, '/mainimg/', $content['image_hover']; ?>"><img id="photo_this" style="max-width: 100px; max-height: 68px;" src="<?php if (isset($content['image_hover'])) echo getsiteurl(), 'images/', $ID, '/mainimg/', $content['image_hover']; ?>" /></a>
        <?php endif; ?>
    </div>
    <div style="padding-left: 160px; margin-top: 0px;">
     <?php if (!isset($SDS)) : ?>
     <span style="color: red; font-weight: bold;">Рекомендований розмір: 220 х 165</span><br /><br /><?php endif; ?>
     Картинка при наведені:<br /><br />
     <input type="file" size="20" accept="image/*" name="hover_image" />
    </div>
    <?php endif; ?>

    <?php if (!isset($SDS)) : ?>
    <?php $count_images = count($images); ?>
    <div class="clear" style="margin-top: 10px;"></div>
    <ul id='sort'>        
     <?php $index_img = 0; if (isset($images)) : $counter=1; foreach ($images as $one) : ?>
        <li style="height: 82px; float: left;" class="index_img_<?php echo $index_img;?>">
            <input type="hidden" name="el[]" value="<?php echo $one['id'];?>"/>
            <div class="product-images" style="text-align: center; width: 67px; height: 75px;">
            <a rel="images" href="<?php if (isset($one['image'])) echo getsiteurl(), 'images/', $ID, '/moreimg/', $one['image']; ?>"><img style="max-height: 62px; max-width: 67px;" src="<?php if (isset($one['image'])) echo getsiteurl(), 'images/', $ID, '/moreimg/', $one['image']; ?>" /></a>
            <br />
            &nbsp;
            <div style="position: absolute; z-index: 2; margin-top: -13px; margin-left: 50px;">
            <?php if($count_images <= 1) : ?>
            <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити картинку?')) { window.location = <?php echo "'", base_url(), 'edit/del/image/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></div>
            <?php else : ?>
            <a class="del_index_img" title="видалити" href="javascript:void(0);" onclick="removeIndexImage(<?php echo $index_img; ?>); return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></div>
            <?php endif; ?>
            </div>
        </li>
     <?php $index_img++; endforeach; endif; ?>
    </ul>
    <div class="clear"></div>


    <link href="<?php echo base_url(); ?>js/upload/uploadify.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url(); ?>js/upload/swfobject.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/upload/jquery.uploadify.v2.1.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#file_upload_').uploadify({
        'uploader'  : '<?php echo base_url(); ?>js/upload/uploadify.swf',
        'script'    : '<?php echo base_url(); ?>js/upload/uploadify.php',
        'cancelImg' : '<?php echo base_url(); ?>js/upload/cancel.png',
        'folder'    : '/images/<?php echo $ID; ?>',
        'scriptData'  : {
         'test_add': '<?php echo $this->config->item('test_add'); ?>'
        },
        'auto' : true,
        'multi' : true,
        'buttonText' : 'Select photo',
        'QueueSizeLimit' : 30,
        'fileDesc'   : 'jpg; gif; png; jpeg;',
        'fileExt'   : '*.jpg;*.gif;*.png;*.jpeg;',
        'onComplete' : function(event, ID, fileObj, response, data) { $("#upimgs").val($("#upimgs").val() + "," + response); }
      });
    });
    </script>
    <br /><input id="upimgs" type="hidden" name="upimgs" value="" /><br />
    <div style="margin-left: 10px;"><div id="file_upload_" name="file_upload_"></div></div>
    <?php endif; ?>
    <div class="clear"></div>

    <?php else : ?>

    <div class="small-field" style="color: red; font-weight: bold;">
        картинки можна додати після збереження об'єкта
    </div>

    <?php endif; ?>

    <!-- COMPONENTS ZONE -->

    <?php if (isset($SDS) && isset($ID) && is_numeric($ID) && $ID > 0 && isset($content['parentid']) && $content['parentid'] == 0) : ?>

    <div class="clear"></div>
    <div class="line2"></div>

    <h2>Компоненти:</h2>

    <div class="item">
      <div class="center-item"><span class="vertical"><a  style="margin-left: 50px; font-size: 16px;" href="<?php echo base_url(), 'edit/catalog/object/0/', $ID; ?>">Додати новий компонент</a></span>
      </div>
    </div>

    <?php if (isset($alltovar) && count($alltovar) > 0) : ?>

    <script type="text/javascript" language="JavaScript">

     function del_comp_ok(objid) {

      objid = parseInt(objid);

      $.ajax({

       type: 'GET',
       url: '<?php echo base_url(), 'edit/del/object_component/'; ?>' + objid

      });

     }

    </script>

    <?php $i_to_t = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH2 = ["<?php if (isset($comp_idis) && count($comp_idis) > 0) echo join("\", \"", $comp_idis); ?>"];

        function set_comp() {

            var id = $("#die_comp option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH2.indexOf(id) == -1) {
                    i_to_t = $("#die_comp option:selected").attr('rel');
                    var name = $("#die_comp option:selected").text();
                    var img = ''; //$("#die_comp option:selected").attr('id');
                    $("#par_comp").append("<div class='item' id='comp" + i_to_t + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='comp[]' value='" + id + "' /><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='<?php echo base_url(), 'edit/catalog/object/';?>" + id + "'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { del_comp_ok(" + id + "); $('#comp" + i_to_t + "').remove(); UAH2.splice(UAH2.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH2.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>

    <div id="par_comp">
    <?php if (isset($components)) : foreach ($components as $one) : ?>
    <div class="item" id="comp<?php echo $i_to_t; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="comp[]" value="<?php echo $one['id']; ?>" />

      <div class="product"><span class="vertical"></span></div>
      <div class="center-item"><span class="vertical"><a  style="margin-left: 0px;" href="<?php echo base_url(), 'edit/catalog/object/', $one['id']; ?>"><?php echo mb_substr($one['name'], 0, 20); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { del_comp_ok(<?php echo $one['id']; ?>); $('#comp<?php echo $i_to_t; ?>').remove(); UAH2.splice(UAH2.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_t; endforeach; endif; ?>
    </div>

    <?php if (isset($alltovar) && count($alltovar) > 0) : ?>
    <select id="die_comp" onchange="set_comp(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($alltovar as $one) : ?>
        <option id="<?php echo getsiteurl(), 'images/', $one['id'], '/mainimg/', $one['image']; ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_t; ?>"><?php echo $one['id'], ' ', mb_substr($one['name'], 0, 30); if (isset($one['parentname'])) echo ' ', mb_substr($one['parentname'], 0, 30); ?></option>
        <?php ++$i_to_t; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

    <?php endif; ?>

    <?php endif; ?>

    <!-- end ----------- -->
  </div><!-- end field2 -->

  <div class="clear"></div>
  <div class="line"></div>

  <div class="field2" style="float: left;">

      <h2>Категорії:</h2>

    <?php $i_to_cat = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_CAT = ["<?php if (isset($cats_oid) && count($cats_oid) > 0) echo join("\", \"", $cats_oid); ?>"];

        function set_gar_opt_cat() {

            var id = $("#die_ie_cat option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_CAT.indexOf(id) == -1) {
                    i_to_cat = $("#die_ie_cat option:selected").attr('rel');
                    var name = $("#die_ie_cat option:selected").text();
                    $("#par_it_cat").append("<div class='item' id='recit_cat" + i_to_cat + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='items_cat[]' value='" + id + "' /><div class='product'><span class='vertical'><input type='radio' name='cat_main' value='" + id + "' /></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_cat" + i_to_cat + "').remove(); UAH_CAT.splice(UAH_CAT.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_CAT.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }

    </script>
    

    <div id="par_it_cat">
    <?php if (isset($cats_o)) : foreach ($cats_o as $one) : ?>
    <div class="item" id="recit_cat<?php echo $i_to_cat; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_cat[]" class="id_cat" value="<?php echo $one['id']; ?>" />

      <div class="product"><span class="vertical"><input type="radio" name="cat_main" value="<?php echo $one['id']; ?>" <?php if (isset($one['main']) && $one['main']) echo 'checked'; ?> /></span></div>
      <div class="center-item"><span class="vertical"><a  style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" class="del_cat" rel="<?php echo $one['id']; ?>"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_cat; endforeach; endif; ?>
    </div>

    <?php if (isset($cats) && count($cats) > 0) : ?>
    <?php
    function slimO($children, $menuid, $parmenuid, $RANG, $i_to) {

      foreach ($children as $one) {
          echo "<option value='{$one['id']}' rel='{$i_to}'";
          if (($parmenuid == $one['id']) || ($menuid == $one['id'])) echo "selected='selected'";
          echo " style='margin-left: {$RANG}px;'>";
          for ($i = 1; $i < $RANG; ++$i) echo '&nbsp;';
          echo "{$one['name']}</option>";

          if (isset($one['children'])) {
           ++$i_to;
           slimO($one['children'], $menuid, $parmenuid, ($RANG + 5), $i_to);
          }
          ++$i_to;
      }

      $RANG -= 5;

    }
    ?>
    <select id="die_ie_cat" onchange="set_gar_opt_cat(); return false;">
     <option id="0">Виберіть:</option>
     <?php foreach ($cats as $one) : ?>
     <option value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_cat; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>

      <?php if (isset($one['children'])) : ++$i_to_cat; ?>
      <?php slimO($one['children'], (isset($content['idcat']) ? $content['idcat'] : 0), 0, 5, $i_to_cat); ?>
      <?php endif; ?>

     <?php ++$i_to_cat; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </div>


  <?php if (!isset($SDS)) : ?>
  <div class="field2" style="float: left;">

      <h2>Рекомендовані товари:</h2>

    <?php $i_to_colf = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_CAT = ["<?php if (isset($cats_oid) && count($cats_oid) > 0) echo join("\", \"", $cats_oid); ?>"];

        function set_gar_opt_colf() {

            var id = $("#die_ie_colf option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_CAT.indexOf(id) == -1) {
                    i_to_colf = $("#die_ie_colf option:selected").attr('rel');
                    var name = $("#die_ie_colf option:selected").text();
                    $("#par_it_colf").append("<div class='item' id='recit_colf" + i_to_colf + "'><input type='hidden' name='items_colf[]' value='" + id + "' /><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_colf" + i_to_colf + "').remove(); UAH_CAT.splice(UAH_CAT.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_CAT.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>

    <div id="par_it_colf">
    <?php if (isset($colf_o)) : foreach ($colf_o as $one) : ?>
    <div class="item" id="recit_colf<?php echo $i_to_colf; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_colf[]" class="id_pop" value="<?php echo $one['id']; ?>" />

      <div class="center-item"><span class="vertical"><a  style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" class="del_pop"
            
            ><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_colf; endforeach; endif; ?>
    </div>

    <?php if (isset($colf) && count($cats) > 0) : ?>
    <?php
    function slimColf($children, $menuid, $parmenuid, $RANG, $i_to) {

      foreach ($children as $one) {
          echo "<option value='{$one['id']}' rel='{$i_to}'";
          if (($parmenuid == $one['id']) || ($menuid == $one['id'])) echo "selected='selected'";
          echo " style='margin-left: {$RANG}px;'>";
          for ($i = 1; $i < $RANG; ++$i) echo '&nbsp;';
          echo "{$one['name_ru']}</option>";

          if (isset($one['children'])) {
           ++$i_to;
           slimColf($one['children'], $menuid, $parmenuid, ($RANG + 5), $i_to);
          }
          ++$i_to;
      }

      $RANG -= 5;

    }
    ?>
    <select id="die_ie_colf" onchange="set_gar_opt_colf(); return false;">
     <option id="0">Виберіть:</option>
     <?php foreach ($colf as $one) : ?>
     <option value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_colf; ?>"><?php echo mb_substr($one['name_ru'], 0, 40); ?></option>

      <?php if (isset($one['children'])) : ++$i_to_colf; ?>
      <?php slimColf($one['children'], (isset($content['idcat']) ? $content['idcat'] : 0), 0, 5, $i_to_colf); ?>
      <?php endif; ?>

     <?php ++$i_to_colf; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </div>
  <?php endif; ?>

  <div class="clear"></div>
  <div class="line"></div>

  <?php if (!isset($SDS)) : ?>
  <div class="field2" style="float: left;">

      <h2>Аксессуари:</h2>

    <?php $i_to_acc = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_CAT = ["<?php if (isset($acc_old) && count($acc_old) > 0) echo join("\", \"", $acc_old); ?>"];

        function set_gar_opt_acc() {

            var id = $("#die_ie_acc option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_CAT.indexOf(id) == -1) {
                    i_to_acc = $("#die_ie_acc option:selected").attr('rel');
                    var name = $("#die_ie_acc option:selected").text();
                    $("#par_it_acc").append("<div class='item' id='recit_acc" + i_to_acc + "'><input type='hidden' name='items_acc[]' value='" + id + "' /><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_acc" + i_to_acc + "').remove(); UAH_CAT.splice(UAH_CAT.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_CAT.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
        $(document).ready(function () {

          $('.delete').click(function(){
            var text_acc = $(this).parent().parent().find('.center-item span a').text();
            if (confirm("Видалити Аксессуар " + "«" + text_acc + "» ?")) {
              $(this).parent().parent().detach();

              var id_acc = $(this).parent().parent().find('.id_acc').val();

              $.ajax({
                      url: '<?php echo baseurl('edit/ajax/acc');?>',
                      data: 'id=' + id_acc,
                      type: 'POST'
                   });
            }
          });

        });
    </script>

    <div id="par_it_acc">
    <?php if (isset($acc_o)) : foreach ($acc_o as $one) : ?>
    <div class="item" id="recit_acc<?php echo $i_to_acc; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_acc[]" class="id_acc" value="<?php echo $one['id']; ?>" />

      <div class="center-item">
        <span class="vertical"><a  style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name_ru'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical delete"><a href="javascript:void(0);" 
            
            ><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_acc; endforeach; endif; ?>
    </div>

    <?php if (isset($acc) && count($cats) > 0) : ?>
    <?php
    function slimAcc($children, $menuid, $parmenuid, $RANG, $i_to) {

      foreach ($children as $one) {
          echo "<option value='{$one['id']}' rel='{$i_to}'";
          if (($parmenuid == $one['id']) || ($menuid == $one['id'])) echo "selected='selected'";
          echo " style='margin-left: {$RANG}px;'>";
          for ($i = 1; $i < $RANG; ++$i) echo '&nbsp;';
          echo "{$one['name_ru']}</option>";

          if (isset($one['children'])) {
           ++$i_to;
           slimAcc($one['children'], $menuid, $parmenuid, ($RANG + 5), $i_to);
          }
          ++$i_to;
      }

      $RANG -= 5;

    }
    ?>
    <select id="die_ie_acc" onchange="set_gar_opt_acc(); return false;">
     <option id="0">Виберіть:</option>
     <?php foreach ($acc as $one) : ?>
     <option><?php echo mb_substr($one['name'], 0, 40); ?></option>

      <?php if(isset($one['children']) && !empty($one['children'])) : ?>
        <?php foreach ($one['children'] as $two) : ?>
          <option value="<?php echo $two['id']; ?>" rel="<?php echo $i_to_acc; ?>">&nbsp;&nbsp;&nbsp;<?php echo mb_substr($two['name'], 0, 40); ?></option>
        <?php endforeach; ?>
      <?php endif; ?>

     <?php ++$i_to_acc; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </div>
  <?php endif; ?>

  <?php if (!isset($SDS)) : ?>
  <div class="field2" style="float: left;">

      <h2>Зв'язані товари:</h2>

    <span style="margin-left:15px;"><?php if(isset($content['name_ru']) && !empty($content['name_ru'])) echo $content['name_ru']; ?></span>
    <select name="items_obj_color[<?php if(!empty($content['id'])) echo $content['id'] ?>]" style="width: 150px;">
      <option value="0">Виберіть колір</option>
      <?php foreach ($colors as $color_) : ?>
       <option <?php if (!empty($content['color']) && $content['color'] == $color_['id']) echo 'selected'; ?> value="<?php echo $color_['id']; ?>"><?php echo mb_substr($color_['name'], 0, 40); ?></option>
      <?php endforeach; ?>
     </select>

    <?php $i_to_obj = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_CAT1 = ["<?php if (isset($color_old) && count($color_old) > 0) echo join("\", \"", $color_old); ?>"];

        function set_gar_opt_obj() {

            var id = $("#die_ie_obj option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_CAT1.indexOf(id) == -1) {
                    i_to_obj = $("#die_ie_obj option:selected").attr('rel');
                    var name = $("#die_ie_obj option:selected").text();
                    $("#par_it_obj").append("<div class='item' id='recit_colf_color" + id + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a><select name='items_obj_new[" + id + "]' style='width: 150px;'><option value='0'>Виберіть колір</option><?php foreach ($colors as $color_) : ?><option value='<?php echo $color_['id']; ?>'><?php echo mb_substr($color_['name'], 0, 40); ?></option><?php endforeach; ?></select></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_colf_color" + id + "').remove(); UAH_COLF_color.splice(UAH_COLF_color.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_CAT1.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>

    <div id="par_it_obj">
    <?php if (isset($obj_o)) : foreach ($obj_o as $one) : ?>

    <div class="item" id="recit_obj<?php echo $i_to_obj; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>


      <div class="product"><span class="vertical"></span></div>
      <div class="center-item">
       <span class="vertical">
        <a style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a>


       <select name="items_obj[<?php echo $one['id'] ?>]" style="width: 150px;">
        <option value="0">Виберіть колір</option>
        <?php foreach ($colors as $color_) : ?>
         <option <?php if ($one['colorid'] == $color_['id']) echo 'selected'; ?> value="<?php echo $color_['id']; ?>"><?php echo mb_substr($color_['name'], 0, 40); ?></option>
        <?php endforeach; ?>
       </select>
       </span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" class="del_color" data-id="<?php echo $one['id']; ?>">
          <img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_obj; endforeach; endif; ?>
    </div>

    <?php if (isset($obj) && count($cats) > 0) : ?>
    <?php
    function slimObj($children, $menuid, $parmenuid, $RANG, $i_to) {

      foreach ($children as $one) {
          echo "<option value='{$one['id']}' rel='{$i_to}'";
          if (($parmenuid == $one['id']) || ($menuid == $one['id'])) echo "selected='selected'";
          echo " style='margin-left: {$RANG}px;'>";
          for ($i = 1; $i < $RANG; ++$i) echo '&nbsp;';
          echo "{$one['name_ru']}</option>";

          if (isset($one['children'])) {
           ++$i_to;
           slimObj($one['children'], $menuid, $parmenuid, ($RANG + 5), $i_to);
          }
          ++$i_to;
      }

      $RANG -= 5;

    }
    ?>
    <select id="die_ie_obj" onchange="set_gar_opt_obj(); return false;">
     <option id="0">Виберіть:</option>
     <?php foreach ($obj as $one) : ?>
     <option value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_obj; ?>"><?php echo mb_substr($one['name_ru'], 0, 40); ?></option>

      <?php if (isset($one['children'])) : ++$i_to_obj; ?>
      <?php slimObj($one['children'], (isset($content['idcat']) ? $content['idcat'] : 0), 0, 5, $i_to_obj); ?>
      <?php endif; ?>

     <?php ++$i_to_obj; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </div>
  <?php endif; ?>

  <div class="clear"></div>
  <div class="line"></div>

  <?php if (isset($SDS)) : ?>
  <div class="field2">

      <h2>Стилі:</h2>

    <?php $i_to_colf_ = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_COLF_ = ["<?php if (isset($IDIS_ITEM_STY) && count($IDIS_ITEM_STY) > 0) echo join("\", \"", $IDIS_ITEM_STY); ?>"];

        function set_gar_opt_colf() {

            var id = $("#die_ie_colf_ option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_COLF_.indexOf(id) == -1) {
                    i_to_rec_ = $("#die_ie_colf_ option:selected").attr('rel');
                    var name = $("#die_ie_colf_ option:selected").text();
                    //var img = $("#die_ie_colf option:selected").attr('id');
                    $("#par_it_colf_").append("<div class='item' id='recit_colf_" + i_to_rec_ + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='items_colf_sty[]' value='" + id + "' /><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_colf_" + i_to_rec_ + "').remove(); UAH_COLF_.splice(UAH_COLF_.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_COLF_.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>

    <div id="par_it_colf_">
    <?php if (isset($ocolors_sty)) : foreach ($ocolors_sty as $one) : ?>
    <div class="item" id="recit_colf_<?php echo $i_to_colf_; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_colf_sty[]" value="<?php echo $one['id']; ?>" />

      <div class="product"><span class="vertical"></span></div>
      <div class="center-item"><span class="vertical"><a style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_colf_<?php echo $i_to_colf_; ?>').remove(); UAH_COLF_.splice(UAH_COLF_.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_colf_; endforeach; endif; ?>
    </div>

    <?php if (isset($colors_sty) && count($colors_sty) > 0) : ?>
    <select id="die_ie_colf_" onchange="set_gar_opt_colf(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($colors_sty as $one) : ?>
        <option id="<?php #echo getsiteurl(), $one['image']; ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_colf_; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
        <?php ++$i_to_colf_; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </div>

  <div class="clear"></div>
  <div class="line"></div>
  <?php endif; ?>

  <?php if (isset($SDS)) : ?>
  <div class="field2">

      <h2>Кольори:</h2>

    <?php $i_to_colors = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_COLORS = ["<?php if (isset($IDIS_ITEM) && count($IDIS_ITEM) > 0) echo join("\", \"", $IDIS_ITEM); ?>"];

        function set_gar_opt_colors() {

            var id = $("#die_ie_colors option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_COLORS.indexOf(id) == -1) {
                    i_to_colors_ = $("#die_ie_colors option:selected").attr('rel');
                    var name = $("#die_ie_colors option:selected").text();
                    //var img = $("#die_ie_colf option:selected").attr('id');
                    $("#par_it_colors").append("<div class='item' id='recit_colors_" + i_to_colors_ + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='items_colors[]' value='" + id + "' /><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_colors_" + i_to_colors_ + "').remove(); UAH_COLORS.splice(UAH_COLORS.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_COLORS.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>

    <div id="par_it_colors">
    <?php if (isset($ocolors)) : foreach ($ocolors as $one) : ?>
    <div class="item" id="recit_colors_<?php echo $i_to_colors; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_colors[]" value="<?php echo $one['id']; ?>" />

      <div class="product"><span class="vertical"></span></div>
      <div class="center-item"><span class="vertical"><a style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_colors_<?php echo $i_to_colors; ?>').remove(); UAH_COLORS.splice(UAH_COLORS.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_colors; endforeach; endif; ?>
    </div>

    <?php if (isset($colors) && count($colors) > 0) : ?>
    <select id="die_ie_colors" onchange="set_gar_opt_colors(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($colors as $one) : ?>
        <option id="<?php #echo getsiteurl(), $one['image']; ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_colors; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
        <?php ++$i_to_colors; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </div>

  <?php endif; ?>

  <?php if (isset($SDS)) : ?>

  <div class="field2" style="float: right;">

      <h2>Кольори корпусу:</h2>

    <?php $i_to_colors_c = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_COLORS_C = ["<?php if (isset($IDIS_ITEM_COLORS_C) && count($IDIS_ITEM_COLORS_C) > 0) echo join("\", \"", $IDIS_ITEM_COLORS_C); ?>"];

        function set_gar_opt_colors_c() {

            var id = $("#die_ie_colors_c option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_COLORS_C.indexOf(id) == -1) {
                    i_to_colors_c_ = $("#die_ie_colors_c option:selected").attr('rel');
                    var name = $("#die_ie_colors_c option:selected").text();
                    //var img = $("#die_ie_colf option:selected").attr('id');
                    $("#par_it_colors_c").append("<div class='item' id='recit_colors_c_" + i_to_colors_c_ + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='items_colors_c[]' value='" + id + "' /><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_colors_c_" + i_to_colors_c_ + "').remove(); UAH_COLORS_C.splice(UAH_COLORS_C.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_COLORS_C.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>

    <div id="par_it_colors_c">
    <?php if (isset($ocolors_colors_c)) : foreach ($ocolors_colors_c as $one) : ?>
    <div class="item" id="recit_colors_c_<?php echo $i_to_colors_c; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_colors_c[]" value="<?php echo $one['id']; ?>" />

      <div class="product"><span class="vertical"></span></div>
      <div class="center-item"><span class="vertical"><a style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_colors_c_<?php echo $i_to_colors_c; ?>').remove(); UAH_COLORS_C.splice(UAH_COLORS_C.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_colors_c; endforeach; endif; ?>
    </div>

    <?php if (isset($colors_colors_c) && count($colors_colors_c) > 0) : ?>
    <select id="die_ie_colors_c" onchange="set_gar_opt_colors_c(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($colors_colors_c as $one) : ?>
        <option id="<?php #echo getsiteurl(), $one['image']; ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_colors_c; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
        <?php ++$i_to_colors_c; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </div>

  <?php endif; ?>

  <div class="clear"></div>

  <?php if (isset($SDS)) : ?>
  <div class="line"></div>

  <div class="field2">

      <h2>Категорії тканин:</h2>

    <?php $i_to_colors_tt = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_COLORS_TT = ["<?php if (isset($IDIS_ITEM_COLORS_TT) && count($IDIS_ITEM_COLORS_TT) > 0) echo join("\", \"", $IDIS_ITEM_COLORS_TT); ?>"];

        function set_gar_opt_colors_tt() {

            var id = $("#die_ie_colors_tt option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_COLORS_TT.indexOf(id) == -1) {
                    i_to_colors_tt_ = $("#die_ie_colors_tt option:selected").attr('rel');
                    var name = $("#die_ie_colors_tt option:selected").text();
                    //var img = $("#die_ie_colf option:selected").attr('id');
                    $("#par_it_colors_tt").append("<div class='item' id='recit_colors_tt_" + i_to_colors_tt_ + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a>&nbsp;&nbsp;<input type='text' name='items_colors_tt[" + id + "]' value='0.00' style='width: 50px;' /> грн.</span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_colors_tt_" + i_to_colors_tt_ + "').remove(); UAH_COLORS_TT.splice(UAH_COLORS_TT.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_COLORS_TT.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }

        
    </script>

    <div id="par_it_colors_tt">
    <?php if (isset($ocolors_colors_tt)) : foreach ($ocolors_colors_tt as $one) : ?>
    <div class="item" id="recit_colors_tt_<?php echo $i_to_colors_tt; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

      <div class="product"><span class="vertical"></span></div>
      <div class="center-item"><span class="vertical"><a style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a>
       &nbsp;&nbsp;

        <input style="width: 50px;" type="text" name="items_colors_tt[<?php echo $one['id']; ?>]" value="<?php echo $one['price']; ?>" /> грн.
       </span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" class="del_cat" data-id="<?php echo $one['id']; ?>" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_colors_tt_<?php echo $i_to_colors_tt; ?>').remove(); UAH_COLORS_TT.splice(UAH_COLORS_TT.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_colors_tt; endforeach; endif; ?>
    </div>

    <?php if (isset($colors_colors_tt) && count($colors_colors_tt) > 0) : ?>
    <select id="die_ie_colors_tt" onchange="set_gar_opt_colors_tt(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($colors_colors_tt as $one) : ?>
        <option id="<?php #echo getsiteurl(), $one['image']; ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_colors_tt; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
        <?php ++$i_to_colors_tt; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </div>

  <div class="clear"></div>
  <div class="line"></div>
  <?php endif; ?>

  <?php if (isset($SDS)) : ?>
  <div class="field2">

      <h2>Менеджери:</h2>

    <?php $i_to_man = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_MAN = ["<?php if (isset($IDIS_ITEM_MAN) && count($IDIS_ITEM_MAN) > 0) echo join("\", \"", $IDIS_ITEM_MAN); ?>"];

        function set_gar_opt_man() {

            var id = $("#die_ie_man option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_MAN.indexOf(id) == -1) {
                    i_to_man = $("#die_ie_man option:selected").attr('rel');
                    var name = $("#die_ie_man option:selected").text();
                    //var img = $("#die_ie_man option:selected").attr('id');
                    $("#par_it_man").append("<div class='item' id='recit_man" + i_to_man + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='items_man[]' value='" + id + "' /><div class='product'><span class='vertical'></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_man" + i_to_man + "').remove(); UAH_MAN.splice(UAH_MAN.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_MAN.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>

    <div id="par_it_man">
    <?php if (isset($omanagers)) : foreach ($omanagers as $one) : ?>
    <div class="item" id="recit_man<?php echo $i_to_man; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_man[]" value="<?php echo $one['id']; ?>" />

      <div class="product"><span class="vertical"></span></div>
      <div class="center-item"><span class="vertical"><a  style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_man<?php echo $i_to_man; ?>').remove(); UAH_MAN.splice(UAH_MAN.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_man; endforeach; endif; ?>
    </div>

    <?php if (isset($managers) && count($managers) > 0) : ?>
    <select id="die_ie_man" onchange="set_gar_opt_man(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($managers as $one) : ?>
        <option id="<?php  ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_man; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
        <?php ++$i_to_man; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

  </div>

  <div class="clear"></div>
  <div class="line"></div>
  <?php endif; ?>

  <div class="clear"></div>

  <script type="text/javascript" language="JavaScript">
   var $index = 1;
   $('#add_prop1').live('click', function(){
    $('#props1').append("<div style='border-bottom: 1px solid gray; padding-bottom: 5px; margin-bottom: 10px;'><table><tr><td>ім'я (ru):&nbsp;<input type='text' name='new_items1[" + $index + "][name_ru]' value='' /></td><td style='width: 30px;'></td><td>значення (ru):&nbsp;<input type='text' name='new_items1[" + $index + "][value_ru]' value='' /></td></tr></table></div>");
    ++$index;
   });
  </script>
  <div style="width: 100%;">
   <h2>Властивості товару:</h2>

   <?php if (isset($SDS)) : ?>
   <div class="field2">
   <?php foreach ($this->config->item('config_languages') as $value) : ?>
   <div class="small-field">
    <div>Заголовок для властивостей:</div>
    <input type="text" style="margin-bottom: 3px;" name="features_text<?php echo $value ?>" maxlength="255" value="<?php if (isset($content['features_text'.$value])) echo htmlspecialchars($content['features_text'.$value]); ?>" />
   </div><div class="clear"></div>
   <?php endforeach; ?>
   </div>
   <div class="clear"></div><br />
   <?php endif; ?>

   <div id="props1" style="margin-bottom: 20px;">
   <?php if (isset($colors1) && is_array($colors1) && !empty($colors1)) : ?>
    <?php foreach ($colors1 as $value) : ?>
    <div style="border-bottom: 1px solid gray; padding-bottom: 5px; margin-bottom: 10px;">
     <table>
      <tr>
       <input type="hidden" name="items1[<?php echo $value['id'] ?>][id]" value="<?php if (isset($value['id'])) echo $value['id']; ?>" />
       <td>ім'я (ua):&nbsp;<input type="text" name="items1[<?php echo $value['id'] ?>][name_ru]" value="<?php if (isset($value['name_ru'])) echo $value['name_ru']; ?>" /></td>
       <td style="width: 30px;"></td>
       <td>значення (ua):&nbsp;<input type="text" name="items1[<?php echo $value['id'] ?>][value_ru]" value="<?php if (isset($value['value_ru'])) echo $value['value_ru']; ?>" /></td>
      </tr>
      <tr><td></td><td></td><td><a title="видалити" href="<?php echo base_url(), 'edit/del/object_item1/', $value['id']; ?>"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></td></tr>
     </table>
    </div>
    <?php endforeach; ?>
   <?php endif; ?>
   </div>
   <img src="<?php echo base_url(); ?>images/plus.png" alt="#" />&nbsp;&nbsp;<a href="javascript:void(0);" id="add_prop1" style="color: black;">Додати властивість товару</a>
  </div>

  <div class="clear"></div><div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>


  <?php if (isset($SDS) && isset($ID) && is_numeric($ID) && $ID > 0) : ?>
  <div style="width: 100%;">

    <div>
     <img src="<?php echo base_url(); ?>images/plus.png" alt="#" />&nbsp;&nbsp;<a href="javascript:void(0);" style="color: black;" onclick="$('#data').show(); $('#data [name=use_size]').val(1); $(this).parent().remove();">Змінити розміри</a>
    </div>

    <div id="data" style="display: none;">
     <input type="hidden" name="use_size" value="0" />
     <table>
      <thead>
          <tr>
            <th>Английские размеры (UK)&nbsp;&nbsp;</th>
            <th>Европейские размеры (EU)</th>
            <th>Длина стопы (см)</th>
          </tr>
       </thead>
      <tbody>
      <?php if (isset($size_table[0]['data']) && !empty($size_table[0]['data'])) : ?>
       <?php foreach ($size_table[0]['data'] as $value) : ?>
        <tr>
          <td>
            <input type="text" maxlength="255" disabled value="<?php if (isset($value['eur'])) echo $value['eur']; ?>" />
          </td>
          <td>
            <input type="text" maxlength="255" disabled value="<?php if (isset($value['uk'])) echo $value['uk']; ?>" />
          </td>
          <td>
            <input type="text" maxlength="255" name="cm[<?php echo $value['id']; ?>]" value="<?php if (isset($size_object[$value['id']])) echo $size_object[$value['id']]; elseif (isset($value['cm'])) echo $value['cm']; ?>" />
          </td>
        </tr>
       <?php endforeach; ?>
      <?php endif; ?>
      </tbody>
      </table>
    </div>

  </div>

  <div class="clear"></div><div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>
  <?php endif; ?>

  <h3>Категорія товара :</h3>
  </br>
  <div> Смартфоны : 
    <input type="radio" name="radio-vis-obj" value="1" <?php if($content['product-visible'] == '1') echo 'checked'; ?> />
  </div>
  <div> Аксессуары : 
    <input type="radio" name="radio-vis-obj" value="0" <?php if($content['product-visible'] == '0') echo 'checked'; ?> />
  </div>
  </br>
  <div class="clear"></div>

  <?php if(isset($cat_paket) && !empty($cat_paket)) : ?>

  <h3>Настройка :</h3>
  </br>
  <div class="small-field">
    <?php $counter = 1; foreach ($cat_paket as $value) : ?>
     <div style="width: 33%; float:left; margin: 0 0 5px 0;">
       <span style="max-width: 200px; font-weight: bold;"><?php if (isset($value['name'])) echo $value['name']; ?></span><br />
       <?php $i = 0; if (isset($value['children']) && !empty($value['children'])) : foreach ($value['children'] as $subvalue) : ?>
          <label>
           <input style="width: 40px;" type="checkbox" name="option[<?php echo $subvalue['id']; ?>][id]" <?php if(isset($idis_option) && !empty($idis_option) && in_array($subvalue['mainid'], $idis_option)) echo 'checked'; ?> value="<?php echo $subvalue['id']; ?>" /> - <?php echo $subvalue['name']; ?>
           <input type="hidden" name="option[<?php echo $subvalue['id']; ?>][catalogid]" value="<?php echo $subvalue['catalogid'];?>" />
          </label><br />
       <?php $i++; endforeach; endif; ?>
     </div>
    <?php if($counter%3==0):?>
    <div class="clear"></div>
    <?php endif;?>
    <?php $counter++; endforeach; ?>
  </div>

  <div class="line"></div>
  <div class="clear"></div>
  </br>

  <?php endif; ?>

  <?php if (isset($filters) && !empty($filters)) : ?>
  <div class="small-field">
    <div style="width: 100%; margin: 0 0 10px 0;">Фільтри, які використовуватимуться:</div>
    <?php $counter = 1; foreach ($filters as $value) : ?>
     <div style="width: 33%; float:left; margin: 0 0 5px 0;">
       <span style="max-width: 200px; font-weight: bold;"><?php if (isset($value['name'])) echo $value['name']; ?></span><br />
       <?php if (isset($value['children']) && !empty($value['children'])) : foreach ($value['children'] as $subvalue) : ?>
          <label>
           <input style="width: 40px;" type="checkbox" name="filters[]" <?php if (isset($filters_already[$subvalue['id']])) echo 'checked'; ?> value="<?php echo $subvalue['id']; ?>" /> - <?php echo $subvalue['name']; ?>
          </label><br />
       <?php endforeach; endif; ?>
     </div>
    <?php if($counter%3==0):?>
    <div class="clear"></div>
    <?php endif;?>
    <?php $counter++; endforeach; ?>

  </div>

  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>
  <?php endif; ?>

  <h2>Тексти:</h2>

  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>

  <?php foreach ($this->config->item('config_languages') as $value) : ?>

  <?php if (isset($SDS)) : ?>
   <h3>Короткий опис (<?php echo ltrim($value, '_'); ?>):</h3>
   <div class="editor">
     <textarea class="texts" name="shorttext<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['shorttext'.$value])) echo $content['shorttext'.$value]; ?></textarea>
   </div>
   <div class="clear"></div>
   <div class="line"></div>
   <div class="clear"></div>
   <br />
  <?php endif; ?>

  <h3>Таблиця характеристик (<?php echo ltrim($value, '_'); ?>):</h3>
  <div class="editor">
   <textarea class="texts" name="features<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['features'.$value])) echo $content['features'.$value]; ?></textarea>
  </div>
  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>
  <br />

  <h3>Опис (<?php echo ltrim($value, '_'); ?>):</h3>
  <div class="editor">
   <textarea class="texts" name="text<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['text'.$value])) echo $content['text'.$value]; ?></textarea>
  </div>
  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>
  <br />

  <?php endforeach; ?>

  <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
</div><!-- end creation -->
</div><!-- end content -->