
<?php

unset($_SESSION['PARENT_']);

?>

<div id="content">
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), '/js/jquery.js'; ?>"></script>
<h1><?php if (isset($content['modulename'])) echo $content['modulename']; ?></h1>

<?php if (isset($content['subs']) && count($content['subs']) > 0) : ?>
<ul class="additional-menu">
 <?php foreach ($content['subs'] as $one) : ?>
  <?php if ($one['link'] == $SUBMODULE) : ?>
   <li class="active"><div class="left"></div><?php echo $one['name']; ?><div class="right"></div></li>
  <?php else : ?>
   <li><a href="<?php echo base_url(), $MODULE, '/', $one['link']; ?>"><?php echo $one['name']; ?></a></li>
  <?php endif; ?>
 <?php endforeach; ?>
</ul>
<?php endif; ?>

<div class="clear"></div>

<div class="catalog-list">

  <div class="clear"></div>
    <div class="add"><span>Кількість об'єктів: <span class="big"><?php echo $COUNTPRO; ?></span></span><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/catalog/object'; ?>">Додати об'єкт</a></div>
          
    <div class="clear"></div>

    <script type="text/javascript" language="JavaScript">
    $(document).ready(function(){
     $('select[name=main__s]').live('change', function(){
      var $link = '<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/$oop/', $THISPAGE, '/', $CATTHIS, '/', $BRANDTHIS; ?>';
      var $new_link = $link.replace('$oop', $(this).find('option:selected').val());
      window.location = $new_link;
     });
    });
    </script>
    
    <select name="main__s">
     <option value="0">Виберіть товар</otpion>
     <?php foreach ($content['data_main'] as $value) : ?>
     <option <?php if (isset($OBJECT_THIS) && $OBJECT_THIS == $value['id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php  echo $value['name'];?></option>
     <?php endforeach; ?>
    </select>
    
    <br /><br />
    
  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
  <ul>
      <form id="form_order" method="post" action="<?php echo base_url(), 'edit/actions/object'; ?>">
   <?php $i = 0; foreach ($content['data'] as $one) : ?>
    
    <li class="item" style="width: 910px;">
      <div class="check"><span class="vertical"><input type="hidden" name="chord[<?php echo $i; ?>]" value="0" /><input id="tov_wow<?php echo $i; ?>" class="check__" type="checkbox" name="chord[<?php echo $i; ?>]" value="1" /><input type="hidden" name="idis[<?php echo $i; ?>]" value="<?php echo $one['id']; ?>" /></span></div>
      <div class="product"><span class="vertical"><img src="<?php echo getsiteurl(), 'images/', $one['id'], '/mainimg/', $one['image']; ?>" width="35px" alt="#" /></span></div>
      <div class="center-item" style="width: 209px;"><span class="vertical"><a href="<?php echo base_url(), 'edit/catalog/object/', $one['id']; ?>"><?php echo mb_substr($one['name'], 0, 35); ?></a></span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 40px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="width[<?php echo $i; ?>]" size="1" maxlength="10" value="<?php echo $one['size_width']; ?>" /></span>&nbsp;ш</span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 40px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="height[<?php echo $i; ?>]" size="1" maxlength="10" value="<?php echo $one['size_height']; ?>" /></span>&nbsp;в</span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 40px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="depth[<?php echo $i; ?>]" size="1" maxlength="10" value="<?php echo $one['size_depth']; ?>" /></span>&nbsp;д</span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 50px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="weight[<?php echo $i; ?>]" size="2" maxlength="10" value="<?php echo $one['weight']; ?>" /></span>&nbsp;вага</span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 40px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="admin_rate[<?php echo $i; ?>]" size="1" maxlength="10" value="<?php echo $one['admin_rate']; ?>" /></span>&nbsp;рейтинг</span>
      </div>
      
      <div class="price">
        <span class="vertical"><span class="number" style="text-align: left;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="price[<?php echo $i; ?>]" size="6" maxlength="10" value="<?php echo $one['opt_price']; ?>" /></span>&nbsp;грн.</span>
      </div>

      <div class="right-item">
        <?php if ($one['visible'] == 1) : ?>
        <span class="vertical"><a title="подивитись на сайті" href="<?php echo getsite_url(), 'product/detail/', $one['id']; ?>" target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a></span>
        <?php endif; ?>
        
        <span class="vertical"><a href="javascript:void(0);" 
        <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
          title="зробити невидимим" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/object/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>"
        <?php else : ?>
          title="зробити видимим" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/object/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>
         
         <span class="vertical"><a href="javascript:void(0);" 
        <?php if (isset($one['in_stock']) && $one['in_stock'] == 1) : ?>
          title="зняти з продажу" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/object_stock/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/z_in_stock.png'; ?>"
        <?php else : ?>
          title="добавити в продаж" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/object_stock/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/z_un_stock.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>
        
        <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/object/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
      </div>
      
    </li>
    
     <?php if (isset($one['children']) && is_array($one['children']) && !empty($one['children'])) : ?>
      <ul style="margin-left: 25px;">
       <?php ++$i; foreach ($one['children'] as $subone) : ?>
        <li class="item" style="width: 910px;">
      <div class="check"><span class="vertical"><input type="hidden" name="chord[<?php echo $i; ?>]" value="0" /><input id="tov_wow<?php echo $i; ?>" class="check__" type="checkbox" name="chord[<?php echo $i; ?>]" value="1" /><input type="hidden" name="idis[<?php echo $i; ?>]" value="<?php echo $subone['id']; ?>" /></span></div>
      <div class="product"><span class="vertical"><img src="<?php echo getsiteurl(), 'images/', $subone['id'], '/mainimg/', $subone['image']; ?>" width="35px" alt="#" /></span></div>
      <div class="center-item" style="width: 209px;"><span class="vertical"><a href="<?php echo base_url(), 'edit/catalog/object/', $subone['id']; ?>"><?php echo mb_substr($subone['name'], 0, 35); ?></a></span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 40px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="width[<?php echo $i; ?>]" size="1" maxlength="10" value="<?php echo $subone['size_width']; ?>" /></span>&nbsp;ш</span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 40px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="height[<?php echo $i; ?>]" size="1" maxlength="10" value="<?php echo $subone['size_height']; ?>" /></span>&nbsp;в</span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 40px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="depth[<?php echo $i; ?>]" size="1" maxlength="10" value="<?php echo $subone['size_depth']; ?>" /></span>&nbsp;д</span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 50px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="weight[<?php echo $i; ?>]" size="2" maxlength="10" value="<?php echo $subone['weight']; ?>" /></span>&nbsp;вага</span>
      </div>
      
      <div class="price" style="margin-right: 5px;">
        <span class="vertical"><span class="number" style="text-align: left; width: 40px;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="admin_rate[<?php echo $i; ?>]" size="1" maxlength="10" value="<?php echo $subone['admin_rate']; ?>" /></span>&nbsp;рейтинг</span>
      </div>
      
      <div class="price">
        <span class="vertical"><span class="number" style="text-align: left;"><input onfocus="$('#tov_wow<?php echo $i; ?>').attr('checked', 'checked');" type="text" name="price[<?php echo $i; ?>]" size="6" maxlength="10" value="<?php echo $subone['opt_price']; ?>" /></span>&nbsp;грн.</span>
      </div>

      <div class="right-item">
        <?php if ($subone['visible'] == 1) : ?>
        <span class="vertical"><a title="подивитись на сайті" href="<?php echo getsite_url(), 'product/detail/', $subone['id']; ?>" target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a></span>
        <?php endif; ?>
        
        <span class="vertical"><a href="javascript:void(0);" 
        <?php if (isset($subone['visible']) && $subone['visible'] == 1) : ?>
          title="зробити невидимим" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/object/', $subone['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>"
        <?php else : ?>
          title="зробити видимим" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/object/', $subone['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>
         
         <span class="vertical"><a href="javascript:void(0);" 
        <?php if (isset($subone['in_stock']) && $subone['in_stock'] == 1) : ?>
          title="зняти з продажу" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/object_stock/', $subone['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/z_in_stock.png'; ?>"
        <?php else : ?>
          title="добавити в продаж" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/object_stock/', $subone['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/z_un_stock.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>
        
        <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/object/', $subone['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
      </div></li>
       <?php ++$i; endforeach; ?>
       </ul>
      <?php endif; ?>
    
   <?php ++$i; endforeach; ?>
  </ul>
  
  <script type="text/javascript" language="JavaScript">
      function check_uncheck_all() {
          if ($("#ch_un_a").val() == 0) {
              $('.check__').attr('checked', 'checked');
              $("#chek_un_all").html('Зняти виділення');
              $("#ch_un_a").val(1);
          } else {
              $('.check__').removeAttr('checked');
              $("#chek_un_all").html('Вибрати всі');
              $("#ch_un_a").val(0);
          }
      }
  </script>
  
  <div class="value">
    <input id="ch_un_a" type="hidden" name="ch_un_a" value="0" />
    <a id="chek_un_all" href="javascript:void(0);" onclick="check_uncheck_all();">Вибрати всі</a>
    
    <script type="text/javascript" language="JavaScript">
        
        function option_change() {
            
            if ($('select#select_option__ option:selected').val() == 'move') {
                
                $('select#where_id').show();
                
            } else {
                
                $('select#where_id').hide();
                
            }
            
        }
        
    </script>
    
    <select id="select_option__" name="option_" onchange="option_change();">
        <option value="vis">Зробити видимими</option>
        <option value="unvis">Зробити невидимими</option>
      <?php if (isset($SDS)) : ?><option value="move">Перемістити в каталог</option><?php endif; ?>
      <option value="up_stock">Поставити на продаж</option>
      <option value="down_stock">Зняти з продажу</option>
      <option value="price">Змінити ціни</option>
      <option value="admin_rate">Змінити рейтинг</option>
      <option value="sizer_weight">Змінити розміри і вагу</option>
      <option value="del">Видалити</option>
    </select>
    
    <?php if (isset($SDS)) : ?>
    <select style="display:none;" id="where_id" name="where_">
       <?php foreach ($cats as $one) : ?>
        <option <?php if (isset($one['children']) && count($one['children']) > 0) echo "disabled='disabled'"; ?> value="<?php echo $one['id']; ?>"><?php echo $one['name']; ?></option>
        
        <?php if (isset($one['children']) && count($one['children']) > 0) : ?>
         <?php foreach ($one['children'] as $two) : ?>
          <option value="<?php echo $two['id']; ?>"><?php echo '&nbsp;&nbsp;&nbsp;', $two['name']; ?></option>
         <?php endforeach; ?>
        <?php endif; ?>
        
       <?php endforeach; ?>
    </select>
    <?php endif; ?>
  </div>

  <div class="button"><a href="javascript:void(0);" onclick="$('#form_order').submit();">Зберегти</a></div>
</form>

<div class="clear"></div>
      
<div class="pages">
<?php if (isset($ALLPAGE) && isset($COUNTONPAGE) && isset($THISPAGE)) : 
    $count_page = ceil($ALLPAGE/$COUNTONPAGE);
       if ($count_page > 1) :
?>
  <ul class="pages">
      
      <?php if ($THISPAGE > 1) : ?>
      <li>←</li>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/', ($THISPAGE - 1), '/', $CATTHIS, '/', $BRANDTHIS; ?>">Назад</a></li>
      <?php endif; ?>
      
   <?php
   
   $first = $THISPAGE - 4;
   if ($first < 0) $first = 0;
   
   $last = $THISPAGE + 3;
   if ($last > $count_page) $last = $count_page;
   
   for ($i = $first; $i < $last; ++$i) : ?>
    <?php if (($i + 1) == $THISPAGE) : ?><li><?php echo ($i + 1); ?></li>
    <?php else : ?>
     <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/', ($i + 1), '/', $CATTHIS, '/', $BRANDTHIS; ?>"><?php echo ($i + 1); ?></a></li>
    <?php endif; ?>
   <?php endfor; ?>
    
    <?php if ($THISPAGE < $count_page) : ?>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/', ($THISPAGE + 1), '/', $CATTHIS, '/', $BRANDTHIS; ?>">Вперед</a></li>
      <li>→</li>
      <?php endif; ?>
    
  </ul>
<?php endif; endif; ?>
</div>
      
  <?php endif; ?>

</div><!-- end page list -->

<div class="right-sidebar" style="left: 250px;">

<?php if (isset($cats) && count($cats) > 0) : ?>
<ul class="right-sidebar-menu">

<?php if ($CATTHIS == 0) : ?>
<li class="list-header"><div class="left"></div>Всі<div class="right"></div></li>
<li class="clear"></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/0/', $BRANDTHIS; ?>">Всі</a></li>
<?php endif; ?>

<?php foreach ($cats as $one) : ?>

<?php if ($one['id'] == $CATTHIS) : ?>
<li class="list-header"><div class="left"></div><?php echo $one['name']; ?><div class="right"></div></li>
<li class="clear"></li>
<?php else : ?>

<?php if (isset($one['children']) && count($one['children']) > 0) : ?>
<li><?php echo $one['name']; ?></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $one['id'], '/', $BRANDTHIS; ?>"><?php echo $one['name']; ?></a></li>
<?php endif; ?>

<?php endif; ?>

<?php if (isset($one['children']) && count($one['children']) > 0) : ?>
 <?php foreach ($one['children'] as $two) : ?>
    <?php if ($two['id'] == $CATTHIS) : ?>
    <li class="list-header">&nbsp;&nbsp;&nbsp;<div class="left"></div><?php echo $two['name']; ?><div class="right"></div></li>
    <li class="clear"></li>
    <?php else : ?>
    <li>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $two['id'], '/', $BRANDTHIS; ?>"><?php echo $two['name']; ?></a></li>
    <?php endif; ?>
    
    <?php if (isset($two['children']) && count($two['children']) > 0) : ?>
     <?php foreach ($two['children'] as $three) : ?>
        <?php if ($three['id'] == $CATTHIS) : ?>
        <li class="list-header">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="left"></div><?php echo $three['name']; ?><div class="right"></div></li>
        <li class="clear"></li>
        <?php else : ?>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $three['id'], '/', $BRANDTHIS; ?>"><?php echo $three['name']; ?></a></li>
        <?php endif; ?>
     <?php endforeach; ?>
    <?php endif; ?>
    
    
 <?php endforeach; ?>
<?php endif; ?>

<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if (isset($sorts) && count($sorts) > 0) : ?>
<ul class="right-sidebar-menu">
    
<?php if ($BRANDTHIS == 0) : ?>
<li class="list-header"><div class="left"></div>Всі<div class="right"></div></li>
<li class="clear"></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $CATTHIS, '/0'; ?>">Всі</a></li>
<?php endif; ?>

<?php foreach ($sorts as $one) : ?>
<?php if ($one['id'] == $BRANDTHIS) : ?>
<li class="list-header"><div class="left"></div><?php echo $one['name']; ?><div class="right"></div></li>
<li class="clear"></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $CATTHIS, '/', $one['id']; ?>"><?php echo $one['name']; ?></a></li>
<?php endif; ?>
<?php endforeach; ?>

</ul>
<?php endif; ?>
    
</div><!-- end right sidebar -->

</div><!-- end content -->