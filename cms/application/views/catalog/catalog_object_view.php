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

<!-- ------------------------------------ script -->
<script src="<?php echo base_url().'js/sortable/jquery-ui.js'; ?>"></script>

    <script>
  $(document).ready(function() {
                    $('#sort').sortable({
                        update: function(event, ui) {
                           console.log('moved');
                           $('#sort li.item').each(function(){
                               console.log($('#sort li.item').index($(this)));
                               $(this).find('.sorted').first().val($('#sort li.item').index($(this)));
                           });
                           
                           $.ajax({
                              url: '<?php echo baseurl('edit/ajax/sorting');?>',
                              data: $('#form_order').serialize(),
                              type: 'POST'              
                           });
                        }
                        
                    });
                    $('a.yes, a.no, a.wait').live('click', function(){
                      var element = $(this);
                      var id_object = $(this).parent().find('.id_obj').val();
                      
                      if (element.hasClass('yes')) {
                        var div = '<a href="javascript:void(0);" class="no" style="position: relative; display: block; float: left; margin: 12px 0 0;" title="Нет в наличии"><span class="icav no"></span></a>';
                        var id = 'avail';
                      } if (element.hasClass('no')) {
                        var div = '<a href="javascript:void(0);" class="wait" style="position: relative; display: block; float: left; margin: 12px 0 0;" title="Ожидание 2-3 дня"><span class="icav wait"></span></a>';
                        var id = 'delivery_3_5';
                      } if (element.hasClass('wait')) {
                        var div = '<a href="javascript:void(0);" class="yes" style="position: relative; display: block; float: left; margin: 12px 0 0;" title="Есть в наличии"><span class="icav"></span></a>';
                        var id = 'in_stock';
                      }
                      element.replaceWith(div)

                      $.ajax({
                              url: '<?php echo baseurl('edit/ajax/save_status_object');?>',
                              data: 'id=' + id_object + '&status=' + id,
                              type: 'POST'

                            });
                    });
                });

  </script>

<!--  -------------------------------- end Script -->
<div class="catalog-list">

  <div class="clear"></div>

  <div class="button"><a href="javascript:void(0);" onclick="$('#form_order').submit();">Зберегти</a></div>
  <div class="add" style="margin-right:-100px;"><span>Кількість об'єктів: <span class="big"><?php echo $COUNTPRO; ?></span></span><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/catalog/object'; ?>">Додати об'єкт</a></div>

<div class="value">
  <a id="chek_un_all" href="javascript:void(0);" onclick="check_uncheck_all();">Вибрати всі</a>
</div>

    <div class="clear"></div>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>

      <form id="form_order" method="post" action="<?php echo base_url(), 'edit/actions/object'; ?>">
        <ul id="sort">
   <?php $i = 1; foreach ($content['data'] as $one) : ?>

    <li class="item">
      <input class="id_obj" type="hidden" name="ids" value="<?php echo $one['id'];?>" />
      <input type="hidden" name="sort[<?php echo $one['id'];?>]" class="sorted" value="<?php echo $one['position'];?>" /> 
      <div class="check"><span class="vertical"><input type="hidden" name="chord[<?php echo $i; ?>]" value="0" /><input id="tov_wow<?php echo $i; ?>" class="check__" type="checkbox" name="chord[<?php echo $i; ?>]" value="1" /><input type="hidden" name="idis[<?php echo $i; ?>]" value="<?php echo $one['id']; ?>" /></span></div>
      <div class="product"><span class="vertical"><a href="<?php echo base_url(), 'edit/catalog/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo getsiteurl(), 'images/', $one['id'], '/mainimg/', $one['image']; ?>" width="35px" alt="#" /></a></span></div>
      <div class="center-item" style="width: 209px;"><span class="vertical"><a href="<?php echo base_url(), 'edit/catalog/', $SUBMODULE, '/', $one['id']; ?>"><?php echo mb_substr($one['name'], 0, 35); ?></a></span>
      </div>

      <?php if (!isset($SDS)) : ?>
      <div class="price" style="width:200px; margin: 0 0 0 20px;">
          <span class="vertical">
              <input type="text" class="price_ajax" name="price[<?php echo $i;?>]" value="<?php echo $one['price'];?>" style="width: 75px;"/>
          </span>
      </div>

      <?php endif; ?>
      <?php if($one['in_stock'] == '0' && $one['avail'] == '0') : ?>
        <a href="javascript:void(0);" class="no" title="Нет в наличии" style="position: relative; display: block; float: left; margin: 12px 0 0;"><span class="icav no"></span></a>
      <?php else : ?>
        <?php if($one['in_stock'] == '0' || $one['avail'] == '1') : ?>
          <a href="javascript:void(0);" class="no" title="Нет в наличии" style="position: relative; display: block; float: left; margin: 12px 0 0;"><span class="icav no"></span></a>
        <?php else : ?>
          <?php if(isset($one['delivery_3_5']) && $one['delivery_3_5'] == '1') : ?>
            <a href="javascript:void(0);" class="wait" title="Ожидание 2-3 дня" style="position: relative; display: block; float: left; margin: 12px 0 0;"><span class="icav wait"></span></a>
          <?php else : ?>
            <a href="javascript:void(0);" class="yes" title="Есть в наличии" style="position: relative; display: block; float: left; margin: 12px 0 0;"><span class="icav"></span></a>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>

      <div class="right-item">
      <span class="vertical"><a title="Копіювати товар" href="<?php echo base_url(), 'edit/copy/object/', $one['id']; ?>"><img src="<?php echo base_url(); ?>images/copy.png" alt="#" /></a></span>
        <?php if ($one['visible'] == 1) : ?>
        <span class="vertical"><a title="подивитись на сайті" href="<?php echo getsite_url(), 'product/', $one['link'], '.html'; ?>" target="_blank"><img src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a></span>
        <?php endif; ?>

        <span class="vertical"><a href="javascript:void(0);"
        <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
          title="зробити невидимим" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/object/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>"
        <?php else : ?>
          title="зробити видимим" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/object/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>

        <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/object/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
      </div>
    </li>

   <?php ++$i; endforeach; ?>

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

  <script type="text/javascript">

      $('input.price_ajax').keyup(function(){
        var price = $(this).val();
        var id = $(this).parent().parent().parent().find('.id_obj').val();
        
        $.ajax({
            url: '<?php echo baseurl('edit/ajax/remove_price');?>',
            data: 'id=' + id + '&price=' + price,
            type: 'POST',
            DataType: 'json',
            success: function(data) {
              // end
            }
         });
      });

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
        <option value="price">Змінити ціни</option>
        <option value="vis">Зробити видимими</option>
        <option value="unvis">Зробити невидимими</option>
      <?php if (isset($SDS)) : ?><option value="price">Змінити ціни</option><?php endif; ?>
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
  </ul>
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

<div class="right-sidebar" style="top: -4px;">

<?php if (isset($cats) && count($cats) > 0) : ?>
<ul class="right-sidebar-menu">

<?php if ($CATTHIS == 0) : ?>
<li><div class="selected"><strong>Всі товари</strong></div></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/0/', $BRANDTHIS; ?>"><strong>Всі товари</strong></a></li>
<?php endif; ?>

<div style="margin-top: 5px"></div>


<?php foreach ($cats as $one) : ?>

<?php if ($one['id'] == $CATTHIS) : ?>
<li><div class="selected"><strong><?php echo strip_tags($one['name']); ?></strong></div></li>
<?php else : ?>

<?php if (isset($one['children']) && count($one['children']) > 0) : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $one['id'], '/', $BRANDTHIS; ?>"><strong><?php echo $one['name']; ?></strong></a></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $one['id'], '/', $BRANDTHIS; ?>"><strong><?php echo strip_tags($one['name']); ?></strong></a></li>
<?php endif; ?>

<?php endif; ?>

<?php if (isset($one['children']) && count($one['children']) > 0) : ?>
 <?php foreach ($one['children'] as $two) : ?>
    <?php if ($two['id'] == $CATTHIS) : ?>
    <li class="subitem"><div class="selected"><?php echo strip_tags($two['name']); ?></div></li>
    <?php else : ?>
    <li class="subitem"><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $two['id'], '/', $BRANDTHIS; ?>"><?php echo strip_tags($two['name']); ?></a></li>
    <?php endif; ?>

    <?php if (isset($two['children']) && count($two['children']) > 0) : ?>
     <?php foreach ($two['children'] as $three) : ?>
        <?php if ($three['id'] == $CATTHIS) : ?>
        <li class="sub_subitem"><div class="selected"><?php echo strip_tags($three['name']); ?></div></li>
        <?php else : ?>
        <li class="sub_subitem"><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $three['id'], '/', $BRANDTHIS; ?>"><?php echo strip_tags($three['name']); ?></a></li>
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
<li><div class="selected">Всі</div></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $CATTHIS, '/0'; ?>">Всі</a></li>
<?php endif; ?>

<?php foreach ($sorts as $one) : ?>
<?php if ($one['id'] == $BRANDTHIS) : ?>
<li><div class="selected"><?php echo $one['name']; ?></div></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0/1/', $CATTHIS, '/', $one['id']; ?>"><?php echo $one['name']; ?></a></li>
<?php endif; ?>
<?php endforeach; ?>

</ul>
<?php endif; ?>

</div><!-- end right sidebar -->

</div><!-- end content -->

