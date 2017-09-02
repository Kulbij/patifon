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

<form id="saveform" action="<?php echo base_url().'edit/save/'.$SUBMODULE; ?>" method="post"  enctype="multipart/form-data">

 <input type="hidden" name="module" value="<?php echo $MODULE; ?>" />
 <input type="hidden" name="submodule" value="<?php echo $SUBMODULE; ?>" />
 <?php if (isset($ID) && is_numeric($ID) && $ID > 0) : ?><input type="hidden" name="id" value="<?php echo $ID; ?>" /><?php endif; ?>

  <h2>Відгук №<?php echo $content['id']; ?>&nbsp;
      <a href="javascript:void(0);" 
        <?php if ($content['check'] == 1) : ?>
          title="зробити неприйнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/uncheck/', $SUBMODULE, '/', $content['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/check.png'; ?>"
        <?php else : ?>
          title="зробити прийнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/check/', $SUBMODULE, '/', $content['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/uncheck.png'; ?>"
        <?php endif; ?>
       alt="#" /></a>
      
      <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $content['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a></span>
      
  </h2>
  
      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Дата:</strong></div>
      <div style="width: 70%; display: inline-block;">
          <input type="text" name="datetime" value="<?php echo $content['datetime']; ?>"/></div><br />
      </div>
      <div class="clear"></div><div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Ім'я:</strong></div><div style="width: 70%; display: inline-block;">
       <input type="text" name="name" maxlength="255" value="<?php echo $content['name']; ?>" />
      </div><br /></div>
      <div class="clear"></div>
<!--      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>E-mail:</strong></div><div style="width: 70%; display: inline-block;">
       <input type="text" name="email" maxlength="255" value="<?php echo $content['email']; ?>" />
      </div><br /></div>-->
      <div class="clear"></div><div class="field">
          <div style="width: 150px; display: inline-block;">
            <strong>Об'єкт:</strong>
          </div>
          <div style="width: 70%; display: inline-block;">
            <?php if (isset($content['object']['name']) && isset($content['object']['link'])) echo '<a href="', getsite_url(),'catalog/', $content['object']['catalog_link'], "/", $content['object']['link'],'.html'; ?>" target="_blank"><?php echo $content['object']['name'], '</a>'; ?></div><br /></div>
      <div class="clear"></div>
      <span>Виберіть рейтинг:</span>
      <select name="mark">
        <option <?php if($content['mark'] == 1) echo 'selected'; ?>>1</option>
        <option <?php if($content['mark'] == 2) echo 'selected'; ?>>2</option>
        <option <?php if($content['mark'] == 3) echo 'selected'; ?>>3</option>
        <option <?php if($content['mark'] == 4) echo 'selected'; ?>>4</option>
        <option <?php if($content['mark'] == 5) echo 'selected'; ?>>5</option>
      </select>
      <div class="clear"></div>
      <div class="field">
      <div style="width: 70%;">
        
        <h2>Повідомлення:</h2>

        <div class="editor">

        <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/plugins/tinybrowser/tb_tinymce.js.php'; ?>"></script>
        <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tinymce/tiny_mce.js'; ?>"></script>
        <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/tiny_all.js'; ?>"></script>

         <textarea style="height: 200px;" class="texts" name="text" cols="113" rows="20"><?php if (isset($content['text'])) echo $content['text']; ?></textarea>
        
        </div><div class="clear"></div>

      </div><br />
     </div>
      <div class="clear"></div>

      <?php if(isset($content['parent_id']) && $content['parent_id'] == 0) : ?>

      <h2>Відповісти:</h2>
      <textarea style="height: 200px;" class="texts" name="answor" cols="113" rows="20"></textarea>
      <input type="hidden" name="admin" value="Admin" />
      <div class="clear"></div>
      <div class="clear"></div>

      <?php endif; ?>

      <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>

<?php if (isset($content['data']) && count($content['data']) > 0 && !empty($content['data'])) : ?>

      <h2>Відповіді на відгук</h2>



<style>
  .orders-list {
    width: 640px;
  }

  .orders-list .item {
    width: 920px;
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

  <ul>

   <?php if(isset($content['data']) && !empty($content['data'])) : ?>
   <?php $i = 0; foreach ($content['data'] as $one) : ?>
    
    <li class="item">
      <div class="check"><span class="vertical"><input type="hidden" value="0" /><input class="check__" type="checkbox" value="1" /><input type="hidden" value="<?php echo $one['id']; ?>" /></span></div>
      <div class="date"><span class="vertical"><?php echo date('d.m.Y H:i:s', strtotime($one['datetime'])); ?></span></div>
      <div class="number-orders"><span class="vertical">№<?php echo $one['id']; ?></span></div>

      <a href="<?php echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; ?>" style="color: #000000;">
      <div class="center-item">
       <span class="vertical">
        
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
         
    </li>
    
   <?php ++$i; endforeach; ?>
 <?php endif; ?>
  </ul>

      <div class="clear"></div>
      
<div class="pages">

      
  <?php endif; ?>

</div><!-- end page list -->

























</form>
 
  </div>
  
  <div class="clear"></div>
    
</div><!-- end creation -->

</div><!-- end content -->

