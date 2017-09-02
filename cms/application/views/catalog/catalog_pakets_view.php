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
                              url: '<?php echo baseurl('edit/ajax/sorting_pakets');?>',
                              data: $('#form_order').serialize(),
                              type: 'POST'                        
                           });
                        }
                        
                    });

                });

  </script>

<!--  -------------------------------- end Script -->

<style>
  .page-list {
    width: 640px;
  }

  .page-list .item {
    width: 790px;
  }

  .page-list .item:hover {
    border-radius: 5px;
    background: #aacd50;
  }

  .page-list .item .center-item {
    width: 625px;
  }

  #search_order .search {
    width: 300px;
    margin-bottom: 20px;
  }
  .number-pakets{
    position: relative;
    float: left;
    padding-right: 5px;
  }


</style>

<div class="clear"></div>

<div class="page-list">

  <div class="clear"></div>
  
  <?php if (!isset($SDS)) : ?>
  <div class="add"><img src="<?php echo base_url(); ?>images/plus.png" alt="#" /><a href="<?php echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE; ?>">Додати</a></div>
  <?php endif; ?>

  <?php if (isset($content['data']) && count($content['data']) > 0) : ?>

    <form id="form_order" method="post" action="<?php echo base_url(), 'edit/actions/pakets'; ?>">
  
  <ul id="sort">
   <?php $number = 1; $i = 0; $count_dd = count($content['data']); foreach ($content['data'] as $one) : ?>
    <li class="item">
      <input type="hidden" name="ids" value="<?php echo $one['id'];?>" />
      <input type="hidden" name="sort[<?php echo $one['id'];?>]" class="sorted" value="<?php echo $one['position'];?>" />
      <div class="left-item">
        <span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>">
      <span class="number-pakets"><?php echo $number; ?></span>
      <img src="<?php echo getsiteurl(), $one['image']; ?>" alt="#" /></a></span>
      </div>

      <div class="center-item"><span class="vertical"><a href="<?php 
      echo base_url(), 'edit/', $MODULE, '/', $SUBMODULE, '/', $one['id']; 
      ?>"><?php echo mb_substr($one['name'], 0, 100); ?></a></span></div>

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
        </div><div class="clear"></div>
    </li>
    
       <?php $number++; ++$i; endforeach; ?>
  </ul>

  </form>

  <?php endif; ?>

</div><!-- end page list -->
</div><!-- end content -->