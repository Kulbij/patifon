<?php if(!empty($comments)): ?>
    <?php foreach($comments as $one): ?>
	<!-- comment item -->
	<div class="cmmit">
	    <div class="itus"><?php echo $one['name']; ?></div>
	    <div class="itdt"><?php echo date('d.m.Y', strtotime($one['datetime'])); ?></div>
	    <div class="clr"></div>
	    <?php if($one['mark'] > 0): ?>
	    <div class="itrt">
		<input name="val" value="<?php echo $one['mark']; ?>" type="hidden">
	    </div>
	    <?php endif; ?>
	    <div class="ittx">
		<p><?php echo $one['text']; ?></p>
	    </div>
	</div>
	<!-- end comment item -->
    <?php endforeach; ?>
<?php endif; ?>