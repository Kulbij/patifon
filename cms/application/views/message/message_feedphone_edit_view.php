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

  <h2>Замовлення №<?php echo $content['id']; ?>&nbsp;
      <a href="javascript:void(0);" 
        <?php if ($content['check'] == 1) : ?>
          title="зробити неприйнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/uncheck/', $SUBMODULE, '/', $content['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/check.png'; ?>"
        <?php else : ?>
          title="зробити прийнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/check/', $SUBMODULE, '/', $content['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/uncheck.png'; ?>"
        <?php endif; ?>
       alt="#" /></a>
      
      <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити повідомлення?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $content['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="X" /></a></span>
      
  </h2>
  
      <?php if (isset($SDS)) : ?>
      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Ім'я:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['name']; ?></div><br /></div>
      <div class="clear"></div>
      <?php endif; ?>

      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Дата:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['datetime']; ?></div><br /></div>
      <div class="clear"></div><div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Телефон:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['phone']; ?></div><br /></div>
      <div class="clear"></div><div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Текст:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['text']; ?></div><br /></div>
      <br /><hr /><br />
      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Браузер:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['browser']; ?></div><br /></div>
      <div class="clear"></div><div class="field">
      <div style="width: 150px; display: inline-block;"><strong>IP:</strong></div><div style="width: 70%; display: inline-block;"><?php $CI = &get_instance(); echo $CI->int2ip($content['ip']); ?></div><br /></div>
      <div class="clear"></div><div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Зі сторінки:</strong></div><div style="width: 70%; display: inline-block;"><a href="<?php echo $content['link']; ?>" target="_blank"><?php echo $content['link']; ?></a></div><br /></div>
      
  </div>
  
  <div class="clear"></div>
    
</div><!-- end creation -->

</div><!-- end content -->