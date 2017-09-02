<?php if(isset($object) && !empty($object)) : ?>
<aside class="tab_info_product" itemscope itemtype="http://schema.org/Product">
	<i class="prezent"></i>

	<span itemprop="name" style="display:none;"><?php if(isset($object['name']) && !empty($object['name'])) echo $object['name']; ?></span>

	<?php if(isset($object['image_big']) && !empty($object['image_big'])) : ?>
		<a href="<?php if($SITE_CONTENT['mobile'] == 0) echo anchor_wta(site_url('ajax/form/product')); ?>" class="ownbox-form" data-post="object=<?php echo $OBJECT_ID; ?>&image=0">
			<img src="<?php echo baseurl($object['image_big']); ?>" alt="" itemprop="image">
		</a>
	<?php endif; ?>

	<span itemprop="description" style="display:none;">
		iPhone 6 не просто больше. Он лучше во всех отношениях. Больше, но при этом значительно тоньше. Мощнее, но при этом исключительно экономичный. Его гладкая металлическая поверхность плавно переходит в стекло нового HD-дисплея Retina, образуя цельный, законченный дизайн. Его аппаратная часть идеально работает с программным обеспечением. Это новое поколение iPhone, улучшенное во всём
	</span>

	<div class="style_info">
		<div class="wrapper_product_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

			<div class="product_price--new">
				<strong itemprop="price">
					<?php if (isset($SITE_CONTENT['object']['price'])) echo $this->input->price_format($SITE_CONTENT['object']['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?>
				</strong>
				<span><?php echo $this->lang->line('site_valuta'); ?>.</span>
				<span itemprop="priceCurrency">UAH</span>
			</div>

			<div class="product_price--old">
				<p class="product_price--old_p_1">
					<span>
						<?php echo $this->input->price_format($SITE_CONTENT['object']['old_price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?>
					</span>
					&nbsp;<?php echo $this->lang->line('site_valuta'); ?>.
				</p>
				<p class="product_price--old_p_2">
					Экономия -
					<span>
						<?php echo $this->input->price_format(($SITE_CONTENT['object']['old_price'] - $SITE_CONTENT['object']['price']), $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?>
					</span>
					&nbsp;<?php echo $this->lang->line('site_valuta'); ?>.
				</p>
			</div>
		</div>
	</div>

	<?php
	    if (
		    (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
		    (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
	    ) :
		?>
	<button class="add_to_basket" disabled>
		<span>Добавить в корзину</span>
	</button>
	<?php else : ?>
		<button class="add_to_basket" onclick="cart_buy({id: '<?php echo $object['id']; ?>', quantity: 1, color: 0, warranty: $('#warranty').val(), id_product: <?php echo $SITE_CONTENT['object']['id']; ?>}, 1);">
			<span>Добавить в корзину</span>
		</button>
	<?php endif; ?>

	<!-- КУПИТЬ В ОДИН КЛИК -->
	<form action="<?php echo anchor_wta(site_url('ajax/form-send/buyback')); ?>" method="post" class="form_buy_one_click">

			<input class="buy_one_click__input" name="phone" placeholder="+38 (___) ___–__–__" value="+38 (___) ___–__–__" required>
		
			<button type="submit" class="buy_one_click__button ajax-form">Купить в 1 клик</button>

		<input type="hidden" name="link" value="<?php echo $OBJECT_ID; ?>" />
		<input type="hidden" name="robot" value="" />
	</form>
	<!-- END КУПИТЬ В ОДИН КЛИК -->

	<div class="style_info">
		<div class="rating_comments_product">
			<div>
				<p class="wrapper_rating">
					<span class="rating--product"><input name="val" value="<?php echo $SITE_CONTENT['object']['avg_mark']; ?>" type="hidden" /></span>
				</p>
			</div>
			<div>
				<p>
					<a href="javascript:void(0);" class="product--comm">
						<span class="product--comm_quant"><?php echo $SITE_CONTENT['comments_count']; ?></span>
					</a>
				</p>
			</div>
		</div>
	</div>

	<div class="style_info">
		<div class="product_detail_add_cont clearfix">
			<p>
				<a class="product--detail_like operation-link <?php
			       $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();
			       if (in_array($SITE_CONTENT['object']['id'], $cookie))
				   echo 'active'; ?>" href="<?php echo anchor_wta(site_url('ajax/operation/favorite')); ?>" data-post="product=<?php echo $SITE_CONTENT['object']['id']; ?>">
					<span class="product--detail_like__quant"><?php echo $SITE_CONTENT['object']['favorite_count']; ?></span>
				</a>
			</p>
			<input type="hidden" id="count_like_for_object" value="<?php echo $SITE_CONTENT['object']['favorite_count']; ?>">
			<input type="hidden" id="id_like_object" value="<?php echo $SITE_CONTENT['object']['id']; ?>">
			<p class="check">
				<input onclick="add_compare_object();" type="checkbox" id="product--det_check_<?php echo $i; ?>" class="product--det_check"
				<?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) && in_array($SITE_CONTENT['object']['id'], json_decode($this->input->cookie('compare')))) echo 'checked'; ?> data-product="<?php echo $SITE_CONTENT['object']['id']; ?>" href="<?php echo anchor_wta('add_to_compare'); ?>">
				<!-- 123 connect ajax data -->

				<label for="product--det_check_<?php echo $i; ?>">
					<?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) 
			    	&& in_array($SITE_CONTENT['object']['id'], json_decode($this->input->cookie('compare')))) 
			    	if($this->input->cookie($this->config->item('compare_catalog_cookie_var')) > 1)
			    		echo "Убрать из сравнения";
			    	else
			    	echo 'Убрать из сравнения';
			    	else echo "Добавить к сравнению";?>
				</label>
			</p>
			<input type="hidden" id="id_object_input" value="<?php echo $i; ?>">
		</div>
	</div>
</aside>
<?php endif; ?>