<div id="content">

    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
    
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
      Ім'я (ua):<br />
      <input type="text" class="title-field" name="name_ua" maxlength="250" value="<?php if (isset($content['name_ua'])) echo htmlspecialchars($content['name_ua']); ?>" />
      
      <span class="checkbox"><input type="hidden" name="visible" value="0" /><input type="checkbox" name="visible" value="1" <?php if (isset($content['visible']) && $content['visible'] == 1) echo "checked='checked'"; ?> />Видимий на сайті</span>
   </div>
   <div class="field">
      Ім'я (ru):<br />
      <input type="text" class="title-field" name="name_ru" maxlength="250" value="<?php if (isset($content['name_ru'])) echo htmlspecialchars($content['name_ru']); ?>" />

    <span class="checkbox"><input type="hidden" name="in_stock" value="0" /><input type="checkbox" name="in_stock" value="1" <?php if (isset($content['in_stock']) && $content['in_stock'] == 1) echo "checked='checked'"; ?> />В продажі</span>
    
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
    
  <div class="field field-category">
    <span class="text">Матеріал фасаду:</span><br />
    <select name="mat_facadeid">
      <option value="0">Немає</option>
      <?php foreach ($mat_fasade as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if ((isset($content['mat_facadeid']) && $content['mat_facadeid'] == $one['id'])) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
    
    <div class="field field-category">
    <span class="text">Виробник:</span><br />
    <select name="factoryid">
      <?php foreach ($produser as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if ((isset($content['factoryid']) && $content['factoryid'] == $one['id']) || (isset($_SESSION['prod_selected']) && $_SESSION['prod_selected'] == $one['id'])) echo "selected='selected'"; ?>><?php if (empty($one['name'])) echo 'Немає'; else echo $one['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
    
    <div class="field field-category">
    <span class="text">Матеріал корпусу:</span><br />
    <select name="mat_corpsid">
      <option value="0">Немає</option>
      <?php foreach ($mat_corpus as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (isset($content['mat_corpsid']) && $content['mat_corpsid'] == $one['id']) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
    
    <?php if (isset($UKRMEBLI)) : ?>
    <div class="field field-category">
    <span class="text">Акція:</span><br />
    <select name="options">
      <option value="0">Немає</option>
      <?php foreach ($actions as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (isset($content['options']) && $content['options'] == $one['id']) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>
      <?php endforeach; ?>
    </select>
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
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/ui/jquery-ui-1.8.16.custom.min.js'; ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/datepicker.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" />
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>/js/fancy.js"></script>
  
    <div class="price">
      <span class="text">Ціна:</span><br />
      <input type="text" class="field-price" name="price" value="<?php if (isset($content['opt_price'])) echo $content['opt_price']; ?>" />
    </div>
    
    <div class="price">
      <span class="text">Процент:</span><br />
      <input type="text" class="field-price" name="percent" value="<?php if (isset($content['percent'])) echo $content['percent']; ?>" />
    </div>
    
    <div class="price">
      <span class="text">Сума:</span><br />
      <input type="text" class="field-price" name="sum" value="<?php if (isset($content['sum'])) echo $content['sum']; ?>" />
    </div>
    
    <div class="price">
      <span class="text">Знижка:</span><br />
      <input type="text" class="field-price" name="discount" value="<?php if (isset($content['discount'])) echo $content['discount']; ?>" />
    </div>
    
    <div class="price" style="width: 150px;">
      <span class="text">Рейтинг<br />адміністратора:</span><br />
      <select name="admin_rate" style="width: 60px;">
      <?php for ($i = 1; $i <= 20; ++$i) : ?>
       <option <?php if (isset($content['admin_rate']) && $content['admin_rate'] == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
      <?php endfor; ?>
      </select>
    </div>
    
    <div class="price">
      <span class="text">Термін<br />поставки:</span><br />
      <select name="present" style="width: 60px;">
      <?php for ($i = -7; $i <= 40; ++$i) : ?>
       <option <?php if (isset($content['present']) && $content['present'] == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
      <?php endfor; ?>
      </select>
    </div>
    
  <?php if (!isset($SDS)) : ?>
  <div class="price" style="margin-top: 35px; margin-left: -30px;"><div>
    <span class="checkbox"><input type="hidden" name="free_delivery" value="0" /><input type="checkbox" name="free_delivery" value="1" <?php if (isset($content['free_delivery']) && $content['free_delivery'] == 1) echo "checked='checked'"; ?> /><font style="margin-left: -40px;">безплатна доставка</font></span></div></div>
    
    <div class="price" style="margin-top: 35px; margin-left: -30px;"><div>
    <span class="checkbox"><input type="hidden" name="top" value="0" /><input type="checkbox" name="top" value="1" <?php if (isset($content['top']) && $content['top'] == 1) echo "checked='checked'"; ?> /><font style="margin-left: -40px;">в топ</font></span></div></div>
   <?php endif; ?>
    <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>
  </div>

  <div class="clear"></div>
  <div class="line"></div>

  <div class="field2">
    <h2>Параметри:</h2>

    <div class="small-field">
      <div>Висота:</div>
      <input type="text" name="size_height" maxlength="255" value="<?php if (isset($content['size_height'])) echo htmlspecialchars($content['size_height']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Ширина:</div>
      <input type="text" name="size_width" maxlength="255" value="<?php if (isset($content['size_width'])) echo htmlspecialchars($content['size_width']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Глубина:</div>
      <input type="text" name="size_depth" maxlength="255" value="<?php if (isset($content['size_depth'])) echo htmlspecialchars($content['size_depth']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Спальний розмір:</div>
      <input type="text" name="sizer" maxlength="255" value="<?php if (isset($content['sizer'])) echo htmlspecialchars($content['sizer']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Вага:</div>
      <input type="text" name="weight" maxlength="255" value="<?php if (isset($content['weight'])) echo htmlspecialchars($content['weight']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Відео:</div>
      <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="video"><?php if (isset($content['video'])) echo $content['video']; ?></textarea>
    </div>
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Увага (ua):</div>
      <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="alert_ua"><?php if (isset($content['alert_ua'])) echo $content['alert_ua']; ?></textarea>
    </div>
    <div class="clear"></div>
    <div class="small-field">
      <div>Увага (ru):</div>
      <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="alert_ru"><?php if (isset($content['alert_ru'])) echo $content['alert_ru']; ?></textarea>
    </div>
    <div class="clear"></div>
    
    <?php if (isset($SDS)) : ?>
    <div class="small-field">
      <div>Матеріал (ua):</div>
      <input type="text" name="stuff_ua" maxlength="250" value="<?php if (isset($content['stuff_ua'])) echo htmlspecialchars($content['stuff_ua']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Матеріал (ru):</div>
      <input type="text" name="stuff_ru" maxlength="250" value="<?php if (isset($content['stuff_ru'])) echo htmlspecialchars($content['stuff_ru']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Розміри (ua):</div>
      <input type="text" name="size_ua" maxlength="100" value="<?php if (isset($content['size_ua'])) echo htmlspecialchars($content['size_ua']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
      <div>Розміри (ru):</div>
      <input type="text" name="size_ru" maxlength="100" value="<?php if (isset($content['size_ru'])) echo htmlspecialchars($content['size_ru']); ?>" />
    </div>
    
    <div class="clear"></div>
    
    <div class="small-field">
    <div>Заголовок (ua):</div>
    <input type="text" style="margin-bottom: 3px;" name="title_ua" maxlength="250" value="<?php if (isset($content['title_ua'])) echo htmlspecialchars($content['title_ua']); ?>" />
  </div>

  <div class="clear"></div>
  
  <div class="small-field">
    <div>Заголовок (ru):</div>
    <input type="text" style="margin-bottom: 3px;" name="title_ru" maxlength="250" value="<?php if (isset($content['title_ru'])) echo htmlspecialchars($content['title_ru']); ?>" />
  </div>

  <div class="clear"></div>
  
  <div class="small-field">
    <div>Ключові слова (ua):</div>
    <input type="text" style="margin-bottom: 3px;" name="keyword_ua" maxlength="250" value="<?php if (isset($content['keyword_ua'])) echo htmlspecialchars($content['keyword_ua']); ?>" />
  </div>

  <div class="clear"></div>
  
  <div class="small-field">
    <div>Ключові слова (ru):</div>
    <input type="text" style="margin-bottom: 3px;" name="keyword_ru" maxlength="250" value="<?php if (isset($content['keyword_ru'])) echo htmlspecialchars($content['keyword_ru']); ?>" />
  </div>

  <div class="clear"></div>

  <div class="small-field">
    <div>Опис (ua):</div>
    <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="description_ua"><?php if (isset($content['description_ua'])) echo $content['description_ua']; ?></textarea>
  </div>
  
  <div class="clear"></div>
  
  <div class="small-field">
    <div>Опис (ru):</div>
    <textarea cols="35" style="margin-bottom: 3px;" rows="5" class="textarea" name="description_ru"><?php if (isset($content['description_ru'])) echo $content['description_ru']; ?></textarea>
  </div>
  
  <div class="clear"></div>
  <?php endif; ?>
    <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>
    
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
     <span style="color: red; font-weight: bold;">Рекомендований розмір: 660 х 452</span><br /><br />
     <?php if (isset($content['image']) && !empty($content['image'])) : ?>
     Змінити головну картинку:<br /><br />
    <input type="file" size="20" accept="image/*" name="main_image" />
    <?php else : ?>
    Завантажити головну картинку:<br /><br />
    <input type="file" size="20" accept="image/*" name="main_image" />
    <?php endif; ?>
    </div>

    <div class="clear" style="margin-top: 10px;"></div>
     <?php if (isset($images)) : foreach ($images as $one) : ?>
        <div class="product-images" style="text-align: center; width: 67px; height: 75px;">
            <a rel="images" href="<?php if (isset($one['image'])) echo getsiteurl(), 'images/', $ID, '/moreimg/', $one['image']; ?>"><img style="max-height: 62px; max-width: 67px;" src="<?php if (isset($one['image'])) echo getsiteurl(), 'images/', $ID, '/moreimg/', $one['image']; ?>" /></a>
        <br />
        &nbsp;
        <div style="position: absolute; z-index: 2; margin-top: -13px; margin-left: 50px;">
        <a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити картинку?')) { window.location = <?php echo "'", base_url(), 'edit/del/image/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></div>
        </div>
     <?php endforeach; endif; ?>

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
    
    <div class="clear"></div>
    
    <?php else : ?>
    
    <div class="small-field" style="color: red; font-weight: bold;">
        картинки можна додати після збереження об'єкта
    </div>
    
    <?php endif; ?>
    
    <!-- COMPONENTS ZONE -->
    
    <?php if (isset($ID) && is_numeric($ID) && $ID > 0) : $_SESSION['PARENT_'] = $ID; ?>
    
    <div class="clear"></div>
    <div class="line2"></div>
    
    <h2>Компоненти:</h2>
    
    <div class="item">
      <div class="center-item"><span class="vertical"><a  style="margin-left: 50px; font-size: 16px;" href="<?php echo base_url(), 'edit/catalog/object'; ?>">Додати новий компонент</a></span>
      </div>
    </div>

    <?php if (isset($alltovar) && count($alltovar) > 0) : ?>
    
    <script type="text/javascript" language="JavaScript">
     
     function del_comp_ok(objid) {
      
      objid = parseInt(objid);
      
      $.ajax({
       
       type: 'GET',
       url: '<?php echo base_url(), 'edit/del/object/'; ?>' + objid
       
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
                    var img = $("#die_comp option:selected").attr('id');
                    $("#par_comp").append("<div class='item' id='comp" + i_to_t + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='comp[]' value='" + id + "' /><div class='product'><span class='vertical'><img src='" + img + "' width='30' /></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='<?php echo base_url(), 'edit/catalog/object/';?>" + id + "'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { del_comp_ok(" + id + "); $('#comp" + i_to_t + "').remove(); UAH2.splice(UAH2.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
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
        
      <div class="product"><span class="vertical"><img src="<?php echo getsiteurl(), 'images/', $one['id'], '/mainimg/', $one['image']; ?>" width="30" /></span></div>
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
        <option id="<?php echo getsiteurl(), 'images/', $one['id'], '/mainimg/', $one['image']; ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_t; ?>"><?php echo mb_substr($one['name'], 0, 20); ?></option>
        <?php ++$i_to_t; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>
    
    <?php endif; ?>
    
    <?php endif; ?>
    
    <!-- end ----------- -->

  </div><!-- end field2 -->

  <div class="clear"></div>
  <div class="line"></div>
  
  <div class="field2">
      
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

        <input type="hidden" name="items_cat[]" value="<?php echo $one['id']; ?>" />
        
      <div class="product"><span class="vertical"><input type="radio" name="cat_main" value="<?php echo $one['id']; ?>" <?php if (isset($one['main']) && $one['main']) echo 'checked'; ?> /></span></div>
      <div class="center-item"><span class="vertical"><a  style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_cat<?php echo $i_to_cat; ?>').remove(); UAH_CAT.splice(UAH_CAT.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
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
      <?php slimO($one['children'], (isset($content['idcat']) ? $content['idcat'] : 0), (isset($_SESSION['cat_selected']) ? $_SESSION['cat_selected'] : 0), 5, $i_to_cat); ?>
      <?php endif; ?>
      
     <?php ++$i_to_cat; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>
      
  </div>
  
  <div class="clear"></div>
  <div class="line"></div>
  
  
  <div class="field2">
      
      <h2>Колір фасаду:</h2>
      
    <?php $i_to_colf = 0; ?>
    
    <script type="text/javascript" language="JavaScript">
        
        UAH_COLF = ["<?php if (isset($IDIS_ITEM_COLF) && count($IDIS_ITEM_COLF) > 0) echo join("\", \"", $IDIS_ITEM_COLF); ?>"];
        
        function set_gar_opt_colf() {
            
            var id = $("#die_ie_colf option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_COLF.indexOf(id) == -1) {
                    i_to_rec = $("#die_ie_colf option:selected").attr('rel');
                    var name = $("#die_ie_colf option:selected").text();
                    var img = $("#die_ie_colf option:selected").attr('id');
                    $("#par_it_colf").append("<div class='item' id='recit_colf" + i_to_rec + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='items_colf[]' value='" + id + "' /><div class='product'><span class='vertical'><img src='" + img + "' width='20' /></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_colf" + i_to_rec + "').remove(); UAH_COLF.splice(UAH_COLF.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_COLF.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>
    
    <div id="par_it_colf">
    <?php if (isset($ocolors)) : foreach ($ocolors as $one) : ?>
    <div class="item" id="recit_colf<?php echo $i_to_colf; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_colf[]" value="<?php echo $one['id']; ?>" />
        
      <div class="product"><span class="vertical"><img src="<?php echo getsiteurl(), $one['image']; ?>" width="20" /></span></div>
      <div class="center-item"><span class="vertical"><a  style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_colf<?php echo $i_to_colf; ?>').remove(); UAH_COLF.splice(UAH_COLF.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_colf; endforeach; endif; ?>
    </div>

    <?php if (isset($colors) && count($colors) > 0) : ?>
    <select id="die_ie_colf" onchange="set_gar_opt_colf(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($colors as $one) : ?>
        <option id="<?php echo getsiteurl(), $one['image']; ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_colf; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
        <?php ++$i_to_colf; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>
      
  </div>
  
  <div class="clear"></div>
  <div class="line"></div>
  
  
  <div class="field2">
      
    <h2>Колір корпусу:</h2>
      
    <?php $i_to_cor = 0; ?>
    
    <script type="text/javascript" language="JavaScript">
        
        UAH_COR = ["<?php if (isset($IDIS_ITEM_COR) && count($IDIS_ITEM_COR) > 0) echo join("\", \"", $IDIS_ITEM_COR); ?>"];
        
        function set_gar_opt_cor() {
            
            var id = $("#die_ie_cor option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_COR.indexOf(id) == -1) {
                    i_to_cor = $("#die_ie_cor option:selected").attr('rel');
                    var name = $("#die_ie_cor option:selected").text();
                    var img = $("#die_ie_cor option:selected").attr('id');
                    $("#par_it_cor").append("<div class='item' id='recit_cor" + i_to_cor + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='items_cor[]' value='" + id + "' /><div class='product'><span class='vertical'><img src='" + img + "' width='20' /></span></div><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_cor" + i_to_cor + "').remove(); UAH_COR.splice(UAH_COR.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_COR.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>
    
    <div id="par_it_cor">
    <?php if (isset($ocolors_cor)) : foreach ($ocolors_cor as $one) : ?>
    <div class="item" id="recit_cor<?php echo $i_to_cor; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_cor[]" value="<?php echo $one['id']; ?>" />
        
      <div class="product"><span class="vertical"><img src="<?php echo getsiteurl(), $one['image']; ?>" width="20" /></span></div>
      <div class="center-item"><span class="vertical"><a  style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_cor<?php echo $i_to_cor; ?>').remove(); UAH_COR.splice(UAH_COR.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_cor; endforeach; endif; ?>
    </div>

    <?php if (isset($colors) && count($colors) > 0) : ?>
    <select id="die_ie_cor" onchange="set_gar_opt_cor(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($colors as $one) : ?>
        <option id="<?php echo getsiteurl(), $one['image']; ?>" value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_cor; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
        <?php ++$i_to_cor; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>
      
  </div>
  
  <div class="clear"></div>
  <div class="line"></div>
  
  
  <div class="field2">
      
    <h2>Стиль:</h2>
      
    <?php $i_to_sty = 0; ?>
    
    <script type="text/javascript" language="JavaScript">
        
        UAH_STY = ["<?php if (isset($IDIS_ITEM_STY) && count($IDIS_ITEM_STY) > 0) echo join("\", \"", $IDIS_ITEM_STY); ?>"];
        
        function set_gar_opt_sty() {
            
            var id = $("#die_ie_sty option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_STY.indexOf(id) == -1) {
                    i_to_sty = $("#die_ie_sty option:selected").attr('rel');
                    var name = $("#die_ie_sty option:selected").text();
                    var img = $("#die_ie_sty option:selected").attr('id');
                    $("#par_it_sty").append("<div class='item' id='recit_sty" + i_to_sty + "'><div class='left-item'><span class='vertical'><a href='javascript:void(0);'><img src='<?php echo base_url(); ?>images/move.png' alt='#' /></a></span></div><input type='hidden' name='items_sty[]' value='" + id + "' /><div class='center-item'><span class='vertical'><a  style='margin-left: 0px;' href='javascript:void(0);'>" + name + "</a></span></div><div class='right-item'><span class='vertical'><a href='javascript:void(0);' rel='" + id + "' onclick=\"if (confirm('Видалити?')) { $('#recit_sty" + i_to_sty + "').remove(); UAH_STY.splice(UAH_STY.indexOf($(this).attr('rel')), 1); } return false;\"><img src='<?php echo base_url(); ?>images/del.png' alt='x' /></a></span></div></div>");
                    UAH_STY.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>
    
    <div id="par_it_sty">
    <?php if (isset($ocolors_sty)) : foreach ($ocolors_sty as $one) : ?>
    <div class="item" id="recit_sty<?php echo $i_to_sty; ?>">
      <div class="left-item">
        <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

        <input type="hidden" name="items_sty[]" value="<?php echo $one['id']; ?>" />
        
      <div class="center-item"><span class="vertical"><a  style="margin-left: 0px;" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 40); ?></a></span>
      </div>

      <div class="right-item">
          <span class="vertical"><a href="javascript:void(0);" rel="<?php echo $one['id']; ?>" onclick="if (confirm('Видалити?')) { $('#recit_sty<?php echo $i_to_sty; ?>').remove(); UAH_STY.splice(UAH_STY.indexOf($(this).attr('rel')), 1); } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
      </div>
    </div>
    <?php ++$i_to_sty; endforeach; endif; ?>
    </div>

    <?php if (isset($colors_sty) && count($colors_sty) > 0) : ?>
    <select id="die_ie_sty" onchange="set_gar_opt_sty(); return false;">
        <option id="0">Виберіть:</option>
        <?php foreach ($colors_sty as $one) : ?>
        <option value="<?php echo $one['id']; ?>" rel="<?php echo $i_to_sty; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
        <?php ++$i_to_sty; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>
      
  </div>
  
  <div class="clear"></div>
  <div class="line"></div>
  
  <script type="text/javascript" language="JavaScript">
   var $index = 1;
   $('#add_prop1').live('click', function(){
    $('#props1').append("<div style='border-bottom: 1px solid gray; padding-bottom: 5px; margin-bottom: 10px;'><table><tr><td>розмір (ua):&nbsp;<input type='text' name='new_items1[" + $index + "][name_ua]' value='' /></td><td style='width: 30px;'></td><td>значення:&nbsp;<input type='text' name='new_items1[" + $index + "][opt_price]' value='' /></td></tr><tr><td>розмір (ru):&nbsp;&nbsp;<input type='text' name='new_items1[" + $index + "][name_ru]' value='' /></td><td style='width: 30px;'></td><td></td></tr></table></div>");
    ++$index;
   });
   
  </script>
  <div style="width: 100%;">
   <h2>Ціни товару:</h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" name="prices" value="0" /><input type="checkbox" name="prices" <?php if (isset($content['prices']) && $content['prices'] == 1) echo 'checked' ?> value="1" /> - включити табличку цін
   <div id="props1" style="margin-bottom: 20px;">
   <?php if (isset($prices) && is_array($prices) && !empty($prices)) : ?>
    <?php foreach ($prices as $value) : ?>
    <div style="border-bottom: 1px solid gray; padding-bottom: 5px; margin-bottom: 10px;">
     <table>
      <tr>
       <input type="hidden" name="items1[<?php echo $value['id'] ?>][id]" value="<?php if (isset($value['id'])) echo $value['id']; ?>" />
       <td>розмір (ua):&nbsp;<input type="text" name="items1[<?php echo $value['id'] ?>][name_ua]" value="<?php if (isset($value['name_ua'])) echo $value['name_ua']; ?>" /></td>
       <td style="width: 30px;"></td>
       <td>значення:&nbsp;<input type="text" name="items1[<?php echo $value['id'] ?>][opt_price]" value="<?php if (isset($value['opt_price'])) echo $value['opt_price']; ?>" /></td>
      </tr>
      <tr>
       <td>розмір (ru):&nbsp;&nbsp;<input type="text" name="items1[<?php echo $value['id'] ?>][name_ru]" value="<?php if (isset($value['name_ru'])) echo $value['name_ru']; ?>" /></td>
       <td style="width: 30px;"></td>
       <td></td>
      </tr>
      <tr><td></td><td></td><td><a title="видалити" href="<?php echo base_url(), 'edit/del/object_prices/', $value['id']; ?>"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></td></tr>
     </table>
    </div>
    <?php endforeach; ?>
   <?php endif; ?>
   </div>
   <img src="<?php echo base_url(); ?>images/plus.png" alt="#" />&nbsp;&nbsp;<a href="javascript:void(0);" id="add_prop1" style="color: black;">Додати ціну</a>
  </div>
  <div class="clear"></div>
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>
  <div class="clear"></div>
  <div class="line"></div>
  
  
  <h2>Тексти:</h2>

  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
  <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>
  
  <h3>Короткий опис (ua):</h3>
  <div class="editor">
      <textarea class="texts" name="short_desc_ua" cols="113" rows="30"><?php if (isset($content['short_desc_ua'])) echo $content['short_desc_ua']; ?></textarea>
  </div>
  <div class="clear"></div><br />
  
  <h3>Короткий опис (ru):</h3>
  <div class="editor">
      <textarea class="texts" name="short_desc_ru" cols="113" rows="30"><?php if (isset($content['short_desc_ru'])) echo $content['short_desc_ru']; ?></textarea>
  </div>
  <div class="clear"></div><br />
  
  <h3>Опис (ua):</h3>
  <div class="editor">
      <textarea class="texts" name="description_ua" cols="113" rows="30"><?php if (isset($content['description_ua'])) echo $content['description_ua']; ?></textarea>
  </div>
  <div class="clear"></div><br />
  
  <h3>Опис (ru):</h3>
  <div class="editor">
      <textarea class="texts" name="description_ru" cols="113" rows="30"><?php if (isset($content['description_ru'])) echo $content['description_ru']; ?></textarea>
  </div>
  <div class="clear"></div><br />

  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
</div><!-- end creation -->
</div><!-- end content -->