<div id="content" style="width: 1300px;">
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), '/js/jquery.js'; ?>"></script>
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

<div class="clear"></div>

<div class="photos-list" style="width: 930px;">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/upload/uploadify.css" />
<script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>js/upload/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#upload").uploadify({
        uploader: '<?php echo base_url().'js/upload/uploadify.swf'; ?>',
        script:   '<?php echo base_url().'js/upload/uploadify.php'; ?>',
        cancelImg: '<?php echo base_url().'js/upload/cancel.png'; ?>',
        fileExt: '*.jpg;*.jpeg;*.gif;*.png;*.bmp',
        folder: '/public/images/data/gallery/images',
        height : '29',
        width : '123',
        scriptAccess: 'always',
        sizeLimit: '90000000',
        multi: true,
        'auto': true,
        buttonImg : '<?php echo base_url().'images/uploadify.png';?>',
        'onComplete': function (event, queueID, fileObj, response, data) {
            
            $.post('<?php echo base_url().'edit/save/gallery/'.$THISCATALOG; ?>', {filearray: response}, function(info){ $("#target").append(info); });
        }
    });
});
</script>
    
  <div class="clear"></div>
    <div class="add" style="left: -100px;"><span>Кількість фото: <span class="big"><?php echo $COUNTPRO; ?></span></span>
        <div style="position: absolute; top: -10px; right: -120px; z-index: 10;">
        <input type="file" name="Filedata" value="" id="upload" style="display: none;" width="123" height="29">
        </div>
    </div>
          
    <div class="clear"></div>

  <?php if (isset($content['data'])) : ?>
      
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" />
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(); ?>js/fancy.js"></script>
      
   <?php $i = 0; $count_bb = count($content['data']); foreach ($content['data'] as $one) : ?>
    
    <div class="photos" style="width: 180px; height: 212px;">
           <div class="foto" style="width: 180px; height: 182px;"><span class="vertical-foto"  style="width: 180px; height: 182px;"><img style="max-width: 180px; max-height: 182px;" src="<?php echo getsite_url(), $one['image_big']; ?>" alt="#"/></span></div>
            <div class="menu-foto">
              <span class="vertical"><a rel="images" href="<?php echo getsite_url(), $one['image_big']; ?>"><img title="подивитись картинку" src="<?php echo base_url(); ?>images/zoom.png" alt="#" /></a></span>

                <span class="vertical">
                    <?php if ($i > 0) : ?><a href="<?php echo base_url(), 'edit/pos/up/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-up.png'; ?>" /></a><?php endif; ?>
                </span><span class="vertical">
                    <?php if ($i < $count_bb - 1) : ?><a href="<?php echo base_url(), 'edit/pos/down/', $SUBMODULE, '/', $one['id']; ?>"><img src="<?php echo base_url(), 'images/arrow-down.png'; ?>" /></a><?php endif; ?>
                </span>

                <span class="vertical"><a href="javascript:void(0);" 
                <?php if (isset($one['visible']) && $one['visible'] == 1) : ?>
                  title="зробити невидимою" onclick="window.location = <?php echo "'", base_url(), 'edit/unvis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/eye.png'; ?>"
                <?php else : ?>
                  title="зробити видимою" onclick="window.location = <?php echo "'", base_url(), 'edit/vis/', $SUBMODULE, '/', $one['id'], "'"; ?>; return false;"><img style="opacity: 0.4;" src="<?php echo base_url(), 'images/eye.png'; ?>"
                <?php endif; ?>
                 alt="#" /></a></span>

                <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $one['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
            </div>
          </div>
    
   <?php ++$i; endforeach; ?>
    <div id="target"> </div>

      <div class="clear"></div>
      
<div class="pages">
<?php if (isset($ALLPAGE) && isset($COUNTONPAGE) && isset($THISPAGE)) : 
    $count_page = ceil($ALLPAGE/$COUNTONPAGE);
       if ($count_page > 1) :
?>
  <ul class="pages">
      
      <?php if ($THISPAGE > 1) : ?>
      <li>←</li>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $CATTHIS, '/', ($THISPAGE - 1); ?>">Назад</a></li>
      <?php endif; ?>
      
   <?php
   
   $first = $THISPAGE - 4;
   if ($first < 0) $first = 0;
   
   $last = $THISPAGE + 3;
   if ($last > $count_page) $last = $count_page;
   
   for ($i = $first; $i < $last; ++$i) : ?>
    <?php if (($i + 1) == $THISPAGE) : ?><li><?php echo ($i + 1); ?></li>
    <?php else : ?>
     <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $CATTHIS, '/', ($i + 1); ?>"><?php echo ($i + 1); ?></a></li>
    <?php endif; ?>
   <?php endfor; ?>
    
    <?php if ($THISPAGE < $count_page) : ?>
      <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $CATTHIS, '/', ($THISPAGE + 1); ?>">Вперед</a></li>
      <li>→</li>
      <?php endif; ?>
    
  </ul>
<?php endif; endif; ?>
</div>
      
  <?php endif; ?>

</div><!-- end page list -->

<div class="right-sidebar" style="width: 300px;"> 
<ul class="right-sidebar-menu">
    <li><h3>Категорії:</h3></li>
    <li class="clear"></li>
    <?php foreach ($categories as $one): ?> 
     <?php if ($THISCATALOG != $one['id']) : ?>
     <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $one['id']; ?>"><?php echo $one['name']; ?></a>
      
      <?php if (isset($one['children']) && !empty($one['children'])) : ?>
      <ul>
       <?php foreach ($one['children'] as $two) : ?>
        
        <?php if ($THISCATALOG != $two['id']) : ?>
        <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $two['id']; ?>"><?php echo $two['name']; ?></a></li>
        <?php else : ?>
        <li class="list-header">
             <div class="left"></div><?php echo $two['name']; ?><div class="right"></div>
        </li><div class="clear"></div>        
        <?php endif; ?>
        
       <?php endforeach; ?>
      </ul>
      <?php endif; ?>
      
     </li>
     <?php else: ?>
     <li class="list-header" style="height: auto;">
             <div class="left"></div><?php echo $one['name']; ?><div class="right"></div>
             
             <?php if (isset($one['children']) && !empty($one['children'])) : ?>
      <ul>
       <?php foreach ($one['children'] as $two) : ?>
        
        <?php if ($THISCATALOG != $two['id']) : ?>
        <li><a href="<?php echo base_url(), $MODULE, '/', $SUBMODULE, '/', $two['id']; ?>"><?php echo $two['name']; ?></a></li>
        <?php else : ?>
        <li class="list-header">
             <div class="left"></div><?php echo $two['name']; ?><div class="right"></div>
        </li><div class="clear"></div>        
        <?php endif; ?>
        
       <?php endforeach; ?>
      </ul>
      <?php endif; ?>
             
     </li><div class="clear"></div>
     <?php endif; ?>
    <?php endforeach; ?>

</ul>
</div><!-- end right sidebar -->

</div><!-- end content -->