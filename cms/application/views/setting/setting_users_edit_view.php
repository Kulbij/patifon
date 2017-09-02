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
    
   <?php if (isset($ERROR) && $ERROR != false) : ?>
    <div class="error__"><?php echo $ERROR; ?></div>
   <?php endif; ?>
    
  <form id="saveform" action="<?php echo base_url(), 'edit/saveuser'; ?>" method="post">
      
      <input type="hidden" name="table" value="<?php if (isset($TABLE)) echo $TABLE; ?>" />
      <input type="hidden" name="submodule" value="<?php if (isset($SUBMODULE)) echo $SUBMODULE; ?>" />
      
      <?php if (isset($LINK)) : ?>
       <input type="hidden" name="link" value="<?php echo $LINK; ?>" />
      <?php endif; ?>
      <?php if (isset($USERNAME)) : ?>
       <input type="hidden" name="username" value="<?php echo $USERNAME; ?>" />
      <?php endif; ?>
      
 <div class="field">
  Логін<br />
  <input type="text" class="title-field" name="login" value="<?php if (isset($content['username'])) echo $content['username']; ?>" /><br />
  Пароль<br />
  <input type="password" class="title-field" name="password" value="" />
  <div class="button"><a href="javascript:void(0);" onclick="document.getElementById('saveform').submit(); return false;">Зберегти</a></div>
  
 </div>
  </form>
    
</div><!-- end creation -->
</div><!-- end content -->