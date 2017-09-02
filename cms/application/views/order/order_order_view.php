<div id="content">
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), '/js/jquery.js'; ?>"></script>
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), '/js/order_handler.js'; ?>"></script>
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

<style>
  .orders-list {
    width: 740px;
  }

  .orders-list .item {
    width: 990px;
  }

  .orders-list .item:hover {
    border-radius: 5px;
    background: #aacd50;
  }

  .orders-list .item .center-item {
    width: 625px;
  }

  #search_order .search {
    width: 300px;
    margin-bottom: 20px;
  }


</style>

<div class="orders-list">

  <div class="clear"></div>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
      <form id="order_status" method="post" action="<?php echo base_url(), 'edit/save/order_status'; ?>">
            <input type="hidden" id="item" name="item" value=""/>
            <input type="hidden" id="status" name="status" value=""/>          
        </form>
        <form id="order_status_email" method="post" action="<?php echo base_url(), 'edit/save/order_status_email'; ?>">
            <input type="hidden" id="item_email" name="item" value=""/>
            <input type="hidden" id="status_email" name="status" value=""/>          
            <input type="hidden" id="email" name="email" value=""/>
        </form>

      <form id="search_order" method="post" action="<?php echo base_url(), 'order'; ?>">
        <input class="search" type="text" name="search" placeholder="Введіть слово для пошуку" />
        <input class="button_search" type="submit" value="Пошук" />
      </form>

      <div class="clear"></div>

<form id="form_order" method="post" action="<?php echo base_url(), 'edit/actions/', $SUBMODULE; ?>">

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
    <select name="option_1">
    <option value="check">Зробити прийнятими</option>
      <option value="uncheck">Зробити неприйнятими</option>
      <option value="del">Видалити</option>
      <option value="sendmail">Відправити лист</option>
    </select>
  </div>

  <div class="button" style="margin-right:-250px;"><a href="javascript:void(0);" onclick="$('#form_order').submit();">Зберегти</a></div>
  <div class="clear"></div>

   <?php if(isset($_SESSION['order_search']) && !empty($_SESSION['order_search']) && $_SESSION['order_search'] == 1) : ?>
    </br>
    <center><h2>По вашому запросу нічого незнайдено!</h2></center>
    </br>
   <?php endif; ?>

   <ul>
   <?php if(isset($content['data']) && !empty($content['data'])) : ?>
   <?php $i = 0; foreach ($content['data'] as $one) : ?>
    
    <li class="item">
      <div class="check"><span class="vertical">
      <input type="hidden" name="chord[<?php echo $i; ?>]" value="0" />
      <input class="check__" type="checkbox" name="chord[<?php echo $i; ?>]" value="1" />
      <input type="hidden" name="idis[<?php echo $i; ?>]" value="<?php echo $one['id']; ?>" /></span></div>
      <input type="hidden" name="mail[<?php echo $i; ?>]" value="<?php echo $one['email']; ?>" />

      <div class="date"><span class="vertical"><?php echo date('d.m.Y H:i:s', strtotime($one['datetime'])); ?></span></div>
      <div class="number-orders"><span class="vertical">№<?php echo $one['id']; ?></span></div>

      <a href="<?php echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; ?>" style="color: #000000;">
      <div class="center-item">
       <span class="vertical">

       | <?php echo $one['phone']; ?> | 
        
         <?php if (isset($one['name'])) echo $one['name'] ; ?> | <?php if(isset($one['cart'][0]['name']) && !empty($one['cart'][0]['name'])) echo $one['cart'][0]['name']; ?>
        
       </span>
      </div>
        </a>

      <div class="right-item">
        
       <?php if (isset($one['user_id']) && $one['user_id'] > 0) : ?>
        <span class="vertical">
         <a href="<?php echo base_url(), 'edit/clients/clients/', $one['user_id']; ?>">
          <img style="width: 16px; height: 16px;" src="<?php echo base_url(), 'images/to_client.png'; ?>" title="перейти до клієнта" alt="перейти до клієнта" />
         </a>
        </span>
       <?php endif; ?>

        <span class="vertical"><a href="javascript:void(0);" 
        <?php if ($one['check'] == 1) : ?>
          title="зробити неприйнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/uncheck/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/check.png'; ?>"
        <?php else : ?>
          title="зробити прийнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/check/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/uncheck.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>

<?php if (isset($SDS)) : ?>
         <span class="vertical"><a href="javascript:void(0);" 
        <?php if ($one['canceled'] == 1) : ?>
          title="відновити замовлення" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="width: 14px; height: 14px;" src="<?php echo base_url(), 'images/cancel.png'; ?>"
        <?php else : ?>
          title="відмінити замовлення" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.6; width: 14px; height: 14px;" src="<?php echo base_url(), 'images/cancel.png'; ?>"
        <?php endif; ?>
         alt="#" /></a></span>
        <?php endif; ?>
        
        <?php if (!isset($SDS)) : ?>
         <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити замовлення?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
        <?php endif; ?>
         <span class="vertical drop-menu">
                                    <div class="item-status">
                                        <?php foreach ($content['statuses'] as $st): ?>
                                            <?php if ($st['id'] == $one['status_id']): ?>
                                                <div class="status-main"><a class="drop-menu" href="javascript:void(0);" onclick="open_statuses(this);"><span class="vertical drop-menu"><img class="drop-menu" title="<?php echo $st['name_ru']; ?>" src="<?php echo base_url(), 'images/' . $st['image']; ?>" alt="#" /></span></a></div>
                                            <?php endif; ?>
        <?php endforeach; ?>
                                        <div class="status-drop" style="display: none;">
                                            <div class="drop-top"></div>

                                            <div class="drop-content">                         
                                                <div class="drop-item arrow drop-menu" onclick="hide_statuses(this);"></div>
                                                <?php foreach ($content['statuses'] as $st): ?>
                                                    <?php if ($st['id'] != $one['status_id']): ?>
                                                        <div class="drop-item"><a href="javascript:void(0);" data-item="<?php echo $one['id']; ?>" data-status="<?php echo $st['id']; ?>" onclick="change_status(this);"><span class="vertical"><img title="<?php echo $st['name_ru']; ?>" src="<?php echo base_url(), 'images/' . $st['image']; ?>" alt="#" /></span></a></div>
                                                    <?php endif; ?>
        <?php endforeach; ?>                        
                                            </div><!-- end .drop-content -->

                                            <div class="drop-bottom"></div>
                                        </div><!-- end .status-drop -->
                                    </div><!-- end .item-status -->
                                </span>

                                <span class="vertical drop-menu">
                                    <div class="item-status">
                                        <?php foreach ($content['statuses_email'] as $st): ?>
                                            <?php if ($st['id'] == $one['status_email_id']): ?>
                                                <div class="status-main"><a class="drop-menu" href="javascript:void(0);" onclick="open_statuses(this);"><span class="vertical drop-menu"><img class="drop-menu" title="<?php echo $st['name_ru']; ?>" src="<?php echo base_url(), 'images/' . $st['image']; ?>" alt="#" /></span></a></div>
                                            <?php endif; ?>
        <?php endforeach; ?>
                                        <div class="status-drop" style="display: none;">
                                            <div class="drop-top"></div>

                                            <div class="drop-content">          
                                                <div class="drop-item arrow drop-menu" onclick="hide_statuses(this);"></div>
                                                <?php foreach ($content['statuses_email'] as $st): ?>
                                                    <?php if ($st['id'] != $one['status_email_id']): ?>
                                                        <div class="drop-item"><a href="javascript:void(0);" data-email="<?php if(isset($one['email']) && !empty($one['email'])) echo $one['email']; ?>" data-item_email="<?php echo $one['id']; ?>" data-status_email="<?php echo $st['id']; ?>" onclick="change_status_email(this);"><span class="vertical"><img title="<?php echo $st['name_ru']; ?>" src="<?php echo base_url(), 'images/' . $st['image']; ?>" alt="#" /></span></a></div>
                                                    <?php endif; ?>
        <?php endforeach; ?>                        
                                            </div><!-- end .drop-content -->

                                            <div class="drop-bottom"></div>
                                        </div><!-- end .status-drop -->
                                    </div><!-- end .item-status -->
                                </span>
      </div>
    </li>
    
   <?php ++$i; endforeach; ?>
 <?php endif; ?>
  </ul>
  
  <div class="value">
    <input id="ch_un_a" type="hidden" name="ch_un_a" value="0" />
    <a id="chek_un_all" href="javascript:void(0);" onclick="check_uncheck_all();">Вибрати всі</a>
    <select name="option_">
    <option value="check_1">Зробити прийнятими</option>
      <option value="uncheck_1">Зробити неприйнятими</option>
      <option value="del_1">Видалити</option>
      <option value="sendmail_1">Відправити лист</option>
    </select>
  </div>

  <div class="button" style="margin-right:-250px;"><a href="javascript:void(0);" onclick="$('#form_order').submit();">Зберегти</a></div>
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
      <li><a href="<?php echo base_url(), 'order/order/'.$CATTHIS.'/', ($THISPAGE - 1); ?>">Назад</a></li>
      <?php endif; ?>
      
   <?php
   
   $first = $THISPAGE - 4;
   if ($first < 0) $first = 0;
   
   $last = $THISPAGE + 3;
   if ($last > $count_page) $last = $count_page;
   
   for ($i = $first; $i < $last; ++$i) : ?>
    <?php if (($i + 1) == $THISPAGE) : ?><li><?php echo ($i + 1); ?></li>
    <?php else : ?>
     <li><a href="<?php echo base_url(), 'order/order/'.$CATTHIS.'/', ($i + 1); ?>"><?php echo ($i + 1); ?></a></li>
    <?php endif; ?>
   <?php endfor; ?>
    
    <?php if ($THISPAGE < $count_page) : ?>
      <li><a href="<?php echo base_url(), 'order/order/'.$CATTHIS.'/', ($THISPAGE + 1); ?>">Вперед</a></li>
      <li>→</li>
      <?php endif; ?>
    
  </ul>
<?php endif; endif; ?>
</div>
      
  <?php endif; ?>

</div><!-- end page list -->

<div class="right-sidebar" style="width:210px; margin-right:-70px;">

<ul class="right-sidebar-menu">

<?php if ($CATTHIS == 0) : ?>
<li><div class="selected"><strong>Всі замовлення</strong></div></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0'; ?>"><strong>Всі замовлення</strong></a></li>
<?php endif; ?>

<?php if ($CATTHIS == 1) : ?>
<li><div class="selected"><strong>Прийняті замовлення</strong></div></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/1'; ?>"><strong>Прийняті замовлення</strong></a></li>
<?php endif; ?>

<?php if ($CATTHIS == 2) : ?>
<li><div class="selected"><strong>Не прийняті замовлення</strong></div></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/2'; ?>"><strong>Не прийняті замовлення</strong></a></li>
<?php endif; ?>

</ul>

</div><!-- end right sidebar -->







</div><!-- end content -->