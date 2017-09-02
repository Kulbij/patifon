<div class="ownbox-content form form-good">
  <a class="close ownbox-close" href="javascript:void(0);"></a>

  <div class="form-text">
  <?php if(isset($class) && !empty($class) && $class == 'bad') : ?>
  	Ая-яй!
  <?php else : ?>
  	<?php if (isset($text) && !empty($text)) echo $text; ?>
  <?php endif; ?>
  </div><!-- end .text -->
</div><!-- end .ownbox-content -->