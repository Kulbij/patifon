<script src="<?php echo base_url(),'js/jquery-2.1.3.min.js';?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), '/js/order_handler.js'; ?>"></script>
 <script type="text/javascript" src="<?php echo base_url().'js/rangy/rangy-core.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/rangy/rangy-selectionsaverestore.js'; ?>"></script>
        <script>
            function addLink() {

                var s = rangy.saveSelection();

                var body_element = document.getElementsByTagName('body')[0];

                var selection;

                selection = window.getSelection();

                //var pagelink = "<br /><br />Èñòî÷íèê: <a href='" + document.location.href + "'>" + document.location.href + "</a>";

                //var wordCount = selection.toString().trim().split(' ').length;

                var copytext = selection;

                var phone = $('#phone').val();
                copytext = copytext.toString();
                if(copytext == phone){
                  copytext = copytext.split('');
                  copytext = copytext[0]+copytext[1]+copytext[2]+' '+copytext[3]+copytext[4]+copytext[5]+' '+copytext[6]+copytext[7]+' '+copytext[8]+copytext[9];
                }

                var newdiv = document.createElement('div');
                newdiv.style.position = 'absolute';
                newdiv.style.left = '-99999px';
                body_element.appendChild(newdiv);
                newdiv.innerHTML = copytext;
                selection.selectAllChildren(newdiv);

                window.setTimeout(function () {
                    body_element.removeChild(newdiv);
                    rangy.restoreSelection(s);
                }, 0);
            }
            if (window.location.pathname.indexOf('/search/') === -1) {
                document.oncopy = addLink;
            }
        </script> 

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

<form id="order_status" method="post" action="<?php echo base_url(), 'edit/save/order_status'; ?>">
            <input type="hidden" id="item" name="item" value=""/>
            <input type="hidden" id="status" name="status" value=""/>          
        </form>

<div class="creation_page">

  <h2>Замовлення №<?php echo $content['id']; ?>&nbsp;<?php if (isset($content['user_id']) && $content['user_id'] > 0) : ?><a href="<?php echo base_url(), 'edit/clients/clients/', $content['user_id']; ?>"><img style="width: 16px; height: 16px;" src="<?php echo base_url(), 'images/to_client.png'; ?>" title="перейти до клієнта" alt="перейти до клієнта" /></a>
      <?php endif; ?>
      <a href="javascript:void(0);"
        <?php if ($content['check'] == 1) : ?>
          title="зробити неприйнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/uncheck/', $SUBMODULE, '/', $content['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/check.png'; ?>"
        <?php else : ?>
          title="зробити прийнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/check/', $SUBMODULE, '/', $content['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/uncheck.png'; ?>"
        <?php endif; ?>
       alt="#" /></a>

      
       <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити замовлення?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $content['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
      
      
       <span class="vertical drop-menu" style="float:right; margin-right:570px; margin-top:10px;">
                                    <div class="item-status">
                                        <?php foreach ($content['statuses'] as $st): ?>
                                            <?php if ($st['id'] == $content['status_id']): ?>
                                                <div class="status-main"><a class="drop-menu" href="javascript:void(0);" onclick="open_statuses(this);"><span class="vertical drop-menu"><img class="drop-menu" title="<?php echo $st['name_ru']; ?>" src="<?php echo base_url(), 'images/' . $st['image']; ?>" alt="#" /></span></a></div>
                                            <?php endif; ?>
        <?php endforeach; ?>
                                        <div class="status-drop" style="display: none;">
                                            <div class="drop-top"></div>

                                            <div class="drop-content">                         
                                                <div class="drop-item arrow drop-menu" onclick="hide_statuses(this);"></div>
                                                <?php foreach ($content['statuses'] as $st): ?>
                                                    <?php if ($st['id'] != $content['status_id']): ?>
                                                        <div class="drop-item"><a href="javascript:void(0);" data-item="<?php echo $content['id']; ?>" data-status="<?php echo $st['id']; ?>" onclick="change_status(this);"><span class="vertical"><img title="<?php echo $st['name_ru']; ?>" src="<?php echo base_url(), 'images/' . $st['image']; ?>" alt="#" /></span></a></div>
                                                    <?php endif; ?>
        <?php endforeach; ?>                        
                                            </div><!-- end .drop-content -->

                                            <div class="drop-bottom"></div>
                                        </div><!-- end .status-drop -->
                                    </div><!-- end .item-status -->
                                </span>
  </h2>

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
      <div style="width: 50%; float: left;">
      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Ім'я:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['name']; ?></div><br /></div>
      <div class="clear"></div><div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Пошта:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['email']; ?></div><br /></div>
      <div class="clear"></div><div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Дата:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['datetime']; ?></div><br /></div>
      <div class="clear"></div><div class="field">
      <input type="hidden" name="phone_ajax" id="phone" value="<?php echo $content['phone']; ?>" />
      <div style="width: 150px; display: inline-block;"><strong>Телефон:</strong></div><div id="phone" style="width: 70%; display: inline-block;">
        <a href="tel:+380<?php echo $content['phone']; ?>" style="text-decoration:none;">
          <?php echo $content['phone']; ?>
        </a>
      </div><br /></div>
      <div class="clear"></div>
      </div>

      <div style="width: 50%; float: left;">
      <?php if (!isset($SDS)) : ?>
      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Місто:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['city']; ?></div><br /></div>
      <div class="clear"></div>


      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Пункт видачі:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['point']; ?></div><br /></div>
      <div class="clear"></div>
      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Тип оплати:</strong></div><div style="width: 70%; display: inline-block;">
          <?php switch($content['payment_type']):
              case 1:{
                  echo 'Предоплата';
                  break;
              }
              case 0:{
                  echo 'Наложеный платеж';
                  break;
              }
          endswitch;
?>
      </div><br /></div>
      <div class="clear"></div>

      <?php endif; ?>
</div>


      <div class="clear"></div><div class="field">
      <div>
      <?php if (isset($content['ordercart']) && count($content['ordercart']) > 0) : ?>
          <strong>Товари:</strong><br />
          <table width="100%" style="border: solid 1px black; margin: 5px 0;" rules="all">
              <tr>
                  <th style="padding: 3px;">Назва товару</th>
                  <th width="100px" style="padding: 3px;">Кількість, шт.</th>
                  <th width="70px" style="padding: 3px;">Ціна, грн.</th>
                  <th width="70px" style="padding: 3px;">Вартість, грн.</th>
              </tr>
          <?php $i = 1; $total = 0;
        foreach ($content['ordercart'] as $one) : ?>
            <tr style="padding: 10px;">
            <td style="padding: 3px;"><a target="_blank" href="<?php echo getsite_url(), 'catalog/', $one['parent_cat'], '/', $one['link'], '.html'; ?>"><?php echo $one['name']; ?></a></td>
            <td style="padding: 3px;"><?php echo $one['quantity']; ?></td>
            <td style="padding: 3px;"><?php echo round($one['sum'], 2); ?></td>
            <td style="padding: 3px;"><?php echo round($one['quantity'] * $one['sum'], 2); ?></td>
           <?php
            ++$i;
            $total += ($one['quantity'] * $one['sum']); ?>
          </tr>
        <?php endforeach; ?>



        <?php $discount = 0; if (isset($content['discount']) && $content['discount']) :
         $discount = $this->config->item('auth_user_discount');
        ?>
         <tr style="padding: 10px;">
          <td style="padding: 3px;">Знижка</td>
          <td style="padding: 3px;"></td>
          <td style="padding: 3px;"></td>
          <td style="padding: 3px;"></td>
          <td style="padding: 3px;"><?php echo round($this->config->item('auth_user_discount'), 2); ?></td>
         <?php $total -= $discount; ?>
        </tr>
        <?php endif; ?>

          </table>
          <div style="width: 600px;"><b>Сума замовлення: </b><?php echo round($total, 2), " грн."; ?></div>
        <?php endif; ?>
      </div></div>

  </div>

  <br />
  <div class="clear"></div>

<form id="saveform" action="<?php echo base_url().'edit/save/order_order'; ?>" method="post"  enctype="multipart/form-data">
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit();return false;">Зберегти</a></div>
<div class="clear"></div>
  <input type="hidden" name="id" value="<?php echo $content['id']; ?>" />

  <?php foreach ($this->config->item('config_languages') as $value) : ?>

  <h3>Коментарій до замовлення (<?php echo ltrim($value, '_'); ?>):</h3>
  <div class="editor">
     <textarea style="height:140px; width:100%;" class="texts" name="shorttext<?php echo $value; ?>" cols="113" rows="30"><?php if (isset($content['text'])) echo $content['text']; ?></textarea>
   </div>
   <div class="clear"></div>
  <div class="line"></div>
  <div class="clear"></div>
  <br />
 <?php endforeach; ?>

  </form>
    
</div><!-- end creation -->

</div><!-- end content -->