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
      $('.del_paket').live('click', function(){
        $(this).parent().parent().parent().parent().detach();
      });
});
</script>

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
                              url: '<?php echo baseurl('edit/ajax/sor_pakets');?>',
                              data: $('#saveform').serialize(),
                              type: 'POST',
                              success: function (data) {
                                // alert(data);
                              }
                           });
                        }
                        
                    });
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
    <input type="hidden" name="id" value="<?php if (isset($content['id'])) echo $content['id']; ?>" />
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
   </div>


  <?php if (isset($SDS)) : ?>
  <div class="field field-category">

    <span class="text">Меню:</span><br />
    <select name="categoryid">
      <option value="0">Немає</option>
      <?php foreach ($cats as $one) : ?>
      <option value="<?php echo $one['id']; ?>" <?php if (((isset($content['idcat']) && $content['idcat'] == $one['id']) || (isset($_SESSION['cat_selected']) && $_SESSION['cat_selected'] == $one['id']))) echo "selected='selected'"; ?>><?php echo $one['name']; ?></option>

      <?php endforeach; ?>
    </select>
  </div>
  <?php endif; ?>

  

  <div class="field">

    <div class="price">
      <span class="text">Ціна:</span><br />
      <input type="text" class="field-price" name="price" value="<?php if (isset($content['price'])) echo $content['price']; else echo 0; ?>" />
    </div>

  </div><!-- end field2 -->


  <div class="clear"></div>
  <div class="line"></div>

  <div class="field2" >

      <h2>Налаштування:</h2>

    <?php $i_to_cat = 0; ?>

    <script type="text/javascript" language="JavaScript">

        UAH_CAT = ["<?php if (isset($option_oid) && count($option_oid) > 0) echo join("\", \"", $option_oid); ?>"];

        function set_gar_opt_cat() {

            var id = $("#die_ie_cat_option option:selected").attr('value');
            if (parseInt(id) > 0) {
                if (UAH_CAT.indexOf(id) == -1) {
                  var count = $('ul#sort li').size() + Number(1);

                    i_to_cat = $("#die_ie_cat_option option:selected").attr('rel');
                    var name = $("#die_ie_cat_option option:selected").text();
                    var image = $("#die_ie_cat_option option:selected").data('image');
                    $("#sort").append('<li class="item"><div class="" id="recit_cat"><div class="left-item"><span class="vertical"><a href="javascript:void(0);"><img src="' + image + '" alt="#" /></a></span></div><input class="id_obj" type="hidden" name="ids" value="' + id + '" /><input type="hidden" name="option[]" value="' + id + '" /><input type="hidden" name="sort[' + id + ']" class="sorted" value="' + count + '" /><a  style="margin-left: 0px;" class="text_paket" href="javascript:void(0);">' + name + '</a><div class="right-item"><span class="vertical"><a class="del_paket" href="javascript:void(0);" rel="' + id + '"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span></div></div></li>');
                    UAH_CAT.push(id);
                } else {
                    alert('Вже використовується!');
                }
            }
        }
    </script>

    <style type="text/css">
    #sort li {
      margin: 10px;
      width: 280px;
      float: left;
    }
    .field2 {
      min-width: 100%;
    }
    .left-item {
      padding-right: 10px;
    }
    .text_paket {
      text-decoration: none;
      color: #000;
    }
    #sort .right-item{
      position: absolute;
      margin-left: 270px;
      margin-top: -20px;
    }
    </style>

    <div class="pakets">
      <ul id="sort">
      <?php if (isset($show_option) && !empty($show_option)) : foreach ($show_option as $one) : ?>
        <li class="item">
            <div class="" id="recit_cat<?php echo $i_to_cat; ?>">
              <div class="left-item">
                <span class="vertical"><a href="javascript:void(0);"><img src="<?php echo getsiteurl(), $one['image']; ?>" alt="#" /></a></span>
              </div>

              <input class="id_obj" type="hidden" name="ids" value="<?php echo $one['id'];?>" />
              <input type="hidden" name="option[]" value="<?php echo $one['id']; ?>" />
              <input type="hidden" name="sort[<?php echo $one['id'];?>]" class="sorted" value="<?php echo $one['position'];?>" />
              
                
              <a  style="margin-left: 0px;" class="text_paket" href="javascript:void(0);"><?php echo mb_substr($one['name'], 0, 100); ?></a>
                
              <div class="right-item">
                <span class="vertical"><a class="del_paket" href="javascript:void(0);" rel="<?php echo $one['id']; ?>"><img src="<?php echo base_url(); ?>images/del.png" alt="x" /></a></span>
            </div>

            </div>
        </li>
      <?php ++$i_to_cat; endforeach; endif; ?>
      </ul>
    </div>

    <div class="clear"></div>

    <?php if (isset($option) && count($option) > 0) : ?>
   
    <select id="die_ie_cat_option" onchange="set_gar_opt_cat(); return false;">
     <option id="0">Виберіть налаштування:</option>
     <?php $i = 1; foreach ($option as $one) : ?>
      
     <option value="<?php echo $one['id']; ?>" data-image="<?php echo getsiteurl(), $one['image']; ?>"  rel="<?php echo $i_to_cat; ?>"><?php echo $i; ?>  <?php echo mb_substr($one['name'], 0, 100); ?></option>

     <?php $i++; ++$i_to_cat; endforeach; ?>
    </select>
    <?php endif; ?>

  </div>

  <div class="clear"></div>

  <div class="field2" style="float: left;">

      <h2>Категорії:</h2>

    <?php $i_to_cat = 0; ?>


    <?php if (isset($cats) && count($cats) > 0) : ?>

    <select id="die_ie_cat" name="cat_option">
     <option id="0">Виберіть категорію:</option>
     <?php foreach ($cats as $one) : ?>
     <option <?php if($cat_true == $one['id']) echo 'selected'; ?> value="<?php echo $one['id']; ?>"><?php echo mb_substr($one['name'], 0, 40); ?></option>
     <?php ++$i_to_cat; endforeach; ?>
    </select>
    <?php endif; ?>

    <div class="clear"></div>

  </div>

  <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>

  <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
</div><!-- end creation -->
</div><!-- end content -->