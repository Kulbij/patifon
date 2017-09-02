<div id="content">
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
<script type="text/javascript" language="JavaScript" src="<?php echo base_url(), '/js/jquery.js'; ?>"></script>
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
                              url: '<?php echo baseurl('edit/ajax/sorting_option');?>',
                              data: $('#form_order').serialize(),
                              type: 'POST'                        
                           });
                        }
                        
                    });

                });

  </script>

<!--  -------------------------------- end Script -->

<div class="clear"></div>

<div class="page-list">
<div class="catalog-list">
  <div class="clear"></div>
  
  <?php if (!isset($SDS)) : ?>
  <div class="add"><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE; ?>">Додати пакет</a></div>
  <?php endif; ?>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>
  <form id="form_order" method="post" action="<?php echo base_url(), 'edit/actions/paket_option'; ?>">
  <?php if(isset($content['data']) && !empty($content['data'])) : ?>
  <ul id="sort">
   <?php $i = 0; $count_dd = count($content['data']); foreach ($content['data'] as $one) : ?>
    <li class="item">
      <input type="hidden" name="ids" value="<?php echo $one['id'];?>" />
      <input type="hidden" name="sort[<?php echo $one['id'];?>]" class="sorted" value="<?php echo $one['position'];?>" />
      <div class="left-item">
        <span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><img src="<?php echo base_url(); ?>images/move.png" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><?php echo $one['name']; ?></a></span></div>

        <div class="right-item">
         
         
         <span class="vertical">
         <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
            <a href="javascript:void(0);" title="зробити невидимою" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php else : ?>
            <a href="javascript:void(0);" title="зробити видимою" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>" /></a>
         <?php endif; ?>
        </span>
         
            <?php if (!isset($SDS)) : ?>
            <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити виробника?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
            <?php endif; ?>
        </div>
    </li>
       <?php ++$i; endforeach; ?>
  </ul>
<?php endif; ?>
</form>

  <?php endif; ?>

</div><!-- end page list -->
</div><!-- end page list -->

<div class="right-sidebar">

<?php if (isset($cats) && count($cats) > 0) : ?>

<ul class="right-sidebar-menu">

<?php if ($CATTHIS == 0) : ?>
<li><div class="selected"><strong>Всі товари</strong></div></li>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/0'; ?>"><strong>Всі настройки</strong></a></li>
<?php endif; ?>

<div style="margin-top: 5px"></div>


<?php foreach ($cats as $one) : ?>

<?php if ($one['id'] == $CATTHIS) : ?>
<li><div class="selected"><strong><?php echo strip_tags($one['name']); ?></strong></div></li>
<?php else : ?>

<?php if (isset($one['children']) && count($one['children']) > 0) : ?>
<?php else : ?>
<li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $one['id'], '/'; ?>"><strong><?php echo strip_tags($one['name']); ?></strong></a></li>
<?php endif; ?>

<?php endif; ?>

<?php endforeach; ?>
</ul>
<?php endif; ?>


</div><!-- end right sidebar -->



</div><!-- end content -->