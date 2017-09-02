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
      <input type="text" class="title-field" name="name<?php echo $value; ?>" maxlength="250" value="<?php if (isset($content['name'])) echo htmlspecialchars($content['name']); ?>"

      <?php if ($value == $this->config->item('config_default_lang')) : ?>
      id="ethis"

      onkeypress="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeyup="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      onkeydown="translit(document.getElementById('ethis'), document.getElementById('elink'), document.getElementById('checker'));"
      <?php endif; ?>

      />
      <?php endforeach; ?>
   </div>

  <div class="clear"></div>   

  <div class="field">
  <h2>Картинка:</h2>

  </div><!-- end field2 -->
  
  <div class="clear"></div>
  <div class="line"></div>

  <div class="small-field">
     <?php if (isset($content['image']) && !empty($content['image'])) : ?><img src="<?php echo getsiteurl(), $content['image']; ?>" alt="image" /><?php endif; ?>
  </div>
  <div class="small-field">
      <div style="color: red; font-weight: bold;">Рекомендований розммір 42x42</div>
      <input type="file" name="image" accept="image/*" />
  </div>
  <div class="clear"></div>

  <div class="clear"></div>

  <div class="button" style="display: none;"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>

  </form>
</div><!-- end creation -->
</div><!-- end content -->