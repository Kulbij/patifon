<div id="content">
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), '/js/jquery.js'; ?>"></script>
<h1><?php if (isset($content['modulename'])) echo $content['modulename']; ?></h1>

<?php if (isset($content['subs']) && count($content['subs']) > 0) : ?>
<ul class="additional-menu">
 <?php foreach ($content['subs'] as $one) : ?>
  <?php if ($one['link'] == $SUBMODULE) : ?>
   <li class="active"><div class="left"></div><?php echo $one['name']; ?> <?php if(isset($one['count']) && !empty($one['count']) && $one['count'] > 0) : ?> +<?php echo $one['count']; endif; ?><div class="right"></div></li>
  <?php else : ?>
   <li><a href="<?php echo base_url(), $MODULE, '/', $one['link']; ?>"><?php echo $one['name']; ?> <?php if(isset($one['count']) && !empty($one['count']) && $one['count'] > 0) : ?> +<?php echo $one['count']; endif; ?></a></li>
  <?php endif; ?>
 <?php endforeach; ?>
</ul>
<?php endif; ?>

<div class="clear"></div>

<div class="orders-list">

  <div class="clear"></div>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
  <ul>
      <form id="form_order" method="post" action="<?php echo base_url(), 'edit/actions/', $SUBMODULE; ?>">
   <?php $i = 0; foreach ($content['data'] as $one) : ?>
    
    <li class="item">
      <div class="check"><span class="vertical"><input type="hidden" name="chord[<?php echo $i; ?>]" value="0" /><input class="check__" type="checkbox" name="chord[<?php echo $i; ?>]" value="1" /><input type="hidden" name="idis[<?php echo $i; ?>]" value="<?php echo $one['id']; ?>" /></span></div>
      <div class="date"><span class="vertical"><?php echo $one['datetime']; ?></span></div>
      <div class="number-orders"><span class="vertical">№<?php echo $one['id']; ?></span></div>

      <div class="center-item"><span class="vertical"><a href="<?php echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; ?>">
      <?php if (isset($one['phone'])) echo mb_substr($one['phone'], 0, 35); ?>
    </a></span></div>

      <div class="right-item">
        
        <span class="vertical"><a href="javascript:void(0);" 
        <?php if ($one['check'] == 1) : ?>
          title="зробити неприйнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/uncheck/',$SUBMODULE , '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/check.png'; ?>"
        <?php else : ?>
          title="зробити прийнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/check/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/uncheck.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>
        
        <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити повідомлення?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
      </div>
    </li>
    
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
    <select name="option_">
      <option value="check">Зробити прийнятими</option>
      <option value="uncheck">Зробити неприйнятими</option>
      <option value="del">Видалити</option>
    </select>
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
      <li><a href="<?php echo base_url(), 'message/', $SUBMODULE, '/page/', ($THISPAGE - 1); ?>">Назад</a></li>
      <?php endif; ?>
      
   <?php
   
   $first = $THISPAGE - 4;
   if ($first < 0) $first = 0;
   
   $last = $THISPAGE + 3;
   if ($last > $count_page) $last = $count_page;
   
   for ($i = $first; $i < $last; ++$i) : ?>
    <?php if (($i + 1) == $THISPAGE) : ?><li><?php echo ($i + 1); ?></li>
    <?php else : ?>
     <li><a href="<?php echo base_url(), 'message/', $SUBMODULE, '/page/', ($i + 1); ?>"><?php echo ($i + 1); ?></a></li>
    <?php endif; ?>
   <?php endfor; ?>
    
    <?php if ($THISPAGE < $count_page) : ?>
      <li><a href="<?php echo base_url(), 'message/', $SUBMODULE, '/page/', ($THISPAGE + 1); ?>">Вперед</a></li>
      <li>→</li>
      <?php endif; ?>
    
  </ul>
<?php endif; endif; ?>
</div>
      
  <?php endif; ?>

</div><!-- end page list -->
</div><!-- end content -->