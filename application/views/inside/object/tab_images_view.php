<?php $index = 1; foreach ($images as $value) : ?>
<div class="item">
		<a href="<?php if(isset($mobile) && $mobile == 0) echo anchor_wta(site_url('ajax/form/product')); ?>" class="photo ownbox-form" data-post="object=<?php echo $OBJECT_ID; ?>&image=<?php echo $index; ?>">
			<img src="<?php if (isset($value['image_big'])) echo baseurl($value['image_big']); ?>" alt="<?php if (isset($SITE_CONTENT['object']['name'])) echo $SITE_CONTENT['object']['name']; ?>" title="<?php if (isset($value['name'])) echo $value['name']; ?>">
	</a>
</div><!-- end .item -->
<?php ++$index; endforeach; ?>