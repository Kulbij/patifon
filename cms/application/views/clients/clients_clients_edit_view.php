<div id="content">
    
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/ui/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/ui/jquery-ui-1.8.16.custom.min.js'; ?>"></script>

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
 <h2><?php echo $content['username'].' '.$content['identity']; ?></h2>

 <div class="clear"></div>

 <?php if (isset($content['orders']) && !empty($content['orders'])) : ?>

 <div class="field">
  <div style="width: 150px; display: inline-block;">
   <strong>Ім'я:</strong>
  </div>
  <div style="width: 70%; display: inline-block;">
   <?php echo $content['username']; ?>
  </div>
  <br />
 </div>
 <div class="clear"></div>
 
 <?php if (isset($content['is_social_from']) && $content['is_social_from']) : ?>
  <div class="field">
   <div style="width: 150px; display: inline-block;">
    <strong>Телефон:</strong>
   </div>
   <div style="width: 70%; display: inline-block;">
    <?php echo $content['phone']; ?>
   </div>
   <br />
  </div>
  <div class="clear"></div>
 <?php endif; ?>

 <?php if (isset($content['subscribe'])) : ?>
  <div class="field">
   <div style="width: 150px; display: inline-block;">
    <strong>Має підписку:</strong>
   </div>
   <div style="width: 70%; display: inline-block;">
    <?php if ($content['subscribe']) echo 'Так'; else echo 'Ні'; ?>
   </div>
   <br />
  </div>
  <div class="clear"></div>
 <?php endif; ?>

 <?php if (isset($content['share_50'])) : ?>
  <div class="field">
   <div style="width: 150px; display: inline-block;">
    <strong>Використав знижку за підписку:</strong>
   </div>
   <div style="width: 70%; display: inline-block;">
    <?php if ($content['share_50']) echo 'Так'; else echo 'Ні'; ?>
   </div>
   <br />
  </div>
  <div class="clear"></div>
 <?php endif; ?>
 
 <br /><br /><h2>Замовлення:</h2>

  <?php foreach ($content['orders'] as $value) : ?>
   <div class="small-field">
    <a href="<?php echo base_url(), 'edit/order/order/', $value['id']; ?>">
     <?php echo 'Замовлення №', $value['id'], ': от ', date('d.m.Y', strtotime($value['datetime'])), ' на ', $value['name']; ?>
    </a>
   </div>
   <div class="clear"></div>
  <?php endforeach; ?>

 <?php endif; ?>

</div><!-- end creation -->

</div><!-- end content -->