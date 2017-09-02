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
 
 <div class="line"></div>
 
 <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
 <script type="text/javascript" language="JavaScript">
  function setObject($factory, $category) {
   if ($factory > 0 && $category > 0) {
    $('select[name=object] option[value!=0]').each(function(index){
     if ($(this).attr('data-factory') == $factory && $.inArray($category, $.makeArray($(this).attr('data-category'))) !== -1) $(this).attr('disabled', false);
     else $(this).attr('disabled', true);
    });
   } else if ($factory > 0 && $category <= 0) {
    $('select[name=object] option[value!=0][data-factory!=' + $factory + ']').attr('disabled', true);
    $('select[name=object] option[data-factory=' + $factory + ']').attr('disabled', false);
   } else if ($factory <= 0 && $category > 0) {
    $('select[name=object] option[value!=0]').each(function($index){
     if ($.inArray($category, $.makeArray($(this).attr('data-category').split(','))) !== -1) $(this).attr('disabled', false);
     else $(this).attr('disabled', true);
    });
   } else $('select[name=object] option').attr('disabled', false);
  }
  
  $(document).ready(function(){
   $('select[name=factory]').live('change', function(){
    var $factory = $(this).find(':selected').val();
    var $category = $('select[name=category] option:selected').val();
    setObject($factory, $category);
    $('input[name=in_factory]').val($factory);
    $('input[name=in_category]').val($category);
   });
   
   $('select[name=category]').live('change', function(){
    var $category = $(this).find(':selected').val();
    var $factory = $('select[name=factory] option:selected').val();
    setObject($factory, $category);
    $('input[name=in_factory]').val($factory);
    $('input[name=in_category]').val($category);
   });
   
   $('select[name=object]').live('change', function(){
    $('input[name=in_object]').val($(this).find(':selected').val());
   });
  });
 </script>
 
 <h2>Вибірка основних даних</h2>
 
 <div class="small-field">
  <div>Виробник:</div>
  <select name="factory">
   <option value="0">Всі</option>
   <?php foreach ($factory as $one) : ?>
   <option value="<?php echo $one['id']; ?>"><?php echo $one['name']; ?></option>
   <?php endforeach; ?>
  </select>
 </div><div class="clear"></div>
 
 <?php
 function slimO($children, $RANG) {
  foreach ($children as $one) {
   echo "<option value='{$one['id']}'";
   echo " style='margin-left: {$RANG}px;'>";
   for ($i = 1; $i < $RANG; ++$i) echo '&nbsp;';
   echo "{$one['name']}</option>";
   
   if (isset($one['children'])) slimO($one['children'], ($RANG + 5));
  }
  $RANG -= 5;
 }
 ?>
 <div class="small-field">
  <div>Категорія:</div>
  <select name="category">
   <option value="0">Всі</option>
   <?php foreach ($category as $one) : ?>
   <option value="<?php echo $one['id']; ?>"><?php echo $one['name']; ?></option>
   <?php if (isset($one['children'])) : ?>
   <?php slimO($one['children'], 5); ?>
   <?php endif; ?>
   <?php endforeach; ?>
  </select>
 </div><div class="clear"></div>
 
 <div class="small-field" style="width: 980px;">
  <div>Об'єкт:</div>
  <select name="object">
   <option value="0">Всі</option>
   <?php foreach ($object as $one) : ?>
   <option data-factory="<?php echo $one['factoryid']; ?>" data-category="<?php foreach ($one['category'] as $two) { echo $two['id']; if (end($one['category']) != $two) echo ','; } ?>" value="<?php echo $one['id']; ?>"><?php echo $one['name'], ' ', $one['id']; ?></option>
   <?php endforeach; ?>
  </select>
 </div><div class="clear"></div>
 
 <div class="line"></div>
 <div class="clear"></div>
  
  <!-- auto change price -->
  
  <form id="auto_price" action="<?php echo base_url().'edit/save/auto_price'; ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="in_factory" value="0" />
  <input type="hidden" name="in_category" value="0" />
  <input type="hidden" name="in_object" value="0" />
  
  <h2>Автоматична зміна цін:</h2>
  
  <style type="text/css">
   td {
    padding: 5px;
   }
  </style>
  <table style="padding: 5px;">
   <tr style="font-weight: bold; text-align: center;">
    <td width="width: 120px;">Ціна</td>
    <td width="width: 50px;">*</td>
    <td width="width: 50px;">+</td>
    <td width="width: 50px;">-</td>
    <td width="width: 50px;">Round</td>
    <td>Змінити</td>
    <td>До попереднього</td>
   </tr>
   <tr>
    <td>до ОПТу</td>
    <td><input type="text" name="opt[percent]" size="5" value="1" /></td>
    <td><input type="text" name="opt[sum]" size="5" value="0" /></td>
    <td><input type="text" name="opt[discount]" size="5" value="0" /></td>
    <td><input type="text" name="opt[round]" size="5" value="2" /></td>
    <td><input type="hidden" name="opt[change]" value="0" /><input type="checkbox" name="opt[change]" value="1" /></td>
    <td>-</td>
   </tr>
   <tr>
    <td>dybok</td>
    <td><input type="text" name="dybok[percent]" size="5" value="1" /></td>
    <td><input type="text" name="dybok[sum]" size="5" value="0" /></td>
    <td><input type="text" name="dybok[discount]" size="5" value="0" /></td>
    <td></td>
    <td><input type="hidden" name="dybok[change]" value="0" /><input type="checkbox" name="dybok[change]" value="1" /></td>
    <td><input type="hidden" name="dybok[prev]" value="0" /><input type="checkbox" name="dybok[prev]" value="1" /></td>
   </tr>
   <tr>
    <td>термін поставки</td>
    <td>
      <select name="present" style="width: 60px;">
      <?php for ($i = -7; $i <= 40; ++$i) : ?>
       <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
      <?php endfor; ?>
      </select></td>
    <td></td>
    <td></td>
    <td></td>
    <td><input type="hidden" name="present_change" value="0" /><input type="checkbox" name="present_change" value="1" /></td>
    <td></td>
   </tr>
  </table>
  
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('auto_price').submit(); return false;">Зберегти</a></div>

  </form>
  
  <div class="line"></div>
  <div class="clear"></div>
  
  <!-- auto change material -->
  
  <form id="auto_material" action="<?php echo base_url().'edit/save/auto_material'; ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="in_factory" value="0" />
  <input type="hidden" name="in_category" value="0" />
  <input type="hidden" name="in_object" value="0" />
  
  <h2>Автоматична зміна матеріалів:</h2>
  
  <div class="small-field">
  <div>Матеріал корпусу:</div>
  <select name="mat_corpsid">
   <option value="0">Немає</option>
   <?php foreach ($corpus as $one) : ?>
   <option value="<?php echo $one['id']; ?>"><?php echo $one['name']; ?></option>
   <?php endforeach; ?>
  </select>
  </div><div class="clear"></div>
  
  <div class="small-field">
  <div>Матеріал фасаду:</div>
  <select name="mat_facadeid">
   <option value="0">Немає</option>
   <?php foreach ($facade as $one) : ?>
   <option value="<?php echo $one['id']; ?>"><?php echo $one['name']; ?></option>
   <?php endforeach; ?>
  </select>
 </div><div class="clear"></div>
  
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('auto_material').submit(); return false;">Зберегти</a></div>

  </form>
  
  <div class="line"></div>
  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>
  
  <!-- complect region -->
  
  <script type="text/javascript" language="JavaScript">
  var clicker = false;
  $('#a_complect').live('click', function(){
   if (!clicker) { clicker = true;
    $.ajax({
     type: 'POST',
     url: '<?php echo site_url('edit/ajax/auto_complect'); ?>',
     data: 'data=data',
     success: function($data) {
      if ($data) {
       alert('Комплекти перераховані!');
       clicker = false;
      } else {
       alert('При операції виникла помилка!');
       clicker = false;
      }
     },
     error: function() { clicker = false; }
    });
   }
  });
  </script>
  
  <a id="a_complect" href="javascript:void(0);" style="font-size: 24px; margin-left: 10px; color: black;">Перерахувати комплекти</a>
  
  <div class="line"></div>
  <div class="clear"></div>
    
</div><!-- end creation -->

</div><!-- end content -->