<?php if(isset($comments) && !empty($comments) && count($comments) > 0) : ?>
	<?php foreach($comments as $value) : ?>
		<?php if($value['parent_id'] == 0) : ?>
				<!-- БЛОК ОТЗЫВА -->
				<div class="user_comment" itemscope itemtype="http://schema.org/Review">
					<h4 itemprop="name">
						<a href="http://patifon.com.ua/" itemprop="url" style="display: none;">
							Интернет магазин Patifon.com.ua - оригинальные смартфоны Lenovo в Украине по доступной цене, гарантия 12 месяцев в Украине!
						</a>
					</h4>

					<span class="user_comment__name" itemprop="author"><?php echo $value['name']; ?></span>
					<span class="user_comment__pubdate" itemprop="datePublished" content="2015-01-09"><?php echo date($value['datetime']); ?></span>

					<div class="user_comment__rating clearfix"><input name="val" value="<?php echo $value['mark']; ?>" type="hidden" /></div>
			<?php if(isset($value['text']) && !empty($value['text'])) : ?>
					<p class="text" itemprop="reviewBody">
						<?php echo $value['text']; ?>
					</p>
			<?php endif; ?>

					<span itemprop="itemReviewed" itemscope itemtype="http://schema.org/MobilePhoneStore" style="display: none;"></span>
				</div>
				<!-- END БЛОК ОТЗЫВА -->
				<a href="javascript:void(0);" class="ans_review" data-id="100">Відповісти</a>
			<?php endif; ?>
			<?php if(isset($value['children']) && !@empty($value['children'])) : ?>
				<?php foreach($value['children'] as $one) : ?>
					<div style="margin-left: 100px;">
										<!-- БЛОК ОТЗЫВА -->
									<div class="user_comment" itemscope itemtype="http://schema.org/Review">
										<h4 itemprop="name">
											<a href="http://patifon.com.ua/" itemprop="url" style="display: none;">
												Интернет магазин Patifon.com.ua - оригинальные смартфоны Lenovo в Украине по доступной цене, гарантия 12 месяцев в Украине!
											</a>
										</h4>

										<span class="user_comment__name" itemprop="author"><?php echo $one['name']; ?></span>
										<span class="user_comment__pubdate" itemprop="datePublished" content="2015-01-09"><?php echo date($one['datetime']); ?></span>

										<div class="user_comment__rating clearfix"><input name="val" one="<?php echo $one['mark']; ?>" type="hidden" /></div>
								<?php if(isset($one['text']) && !empty($one['text'])) : ?>
										<p class="text" itemprop="reviewBody">
											<?php echo $one['text']; ?>
										</p>
								<?php endif; ?>

										<span itemprop="itemReviewed" itemscope itemtype="http://schema.org/MobilePhoneStore" style="display: none;"></span>
									</div>
									<!-- END БЛОК ОТЗЫВА -->
					</div>
				<?php endforeach; ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>