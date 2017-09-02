	<!--////////////////////////////////////////////////////////////////////////////////
									MAIN 
////////////////////////////////////////////////////////////////////////////////////-->
<main>
<!--CONTAINER -->
<div class="container">
	<?php echo $this->load->view('inside/bread_new_view', null, true); ?>

	<!-- ДЕТАЛЬНО О ТОВАРЕ -->
	<section class="product_info_detail clearfix" itemscope itemtype="http://schema.org/Product">

	<?php if(isset($SITE_CONTENT['object']['name']) && !empty($SITE_CONTENT['object']['name'])) : ?>
		<h1 itemprop="name"><?php echo $SITE_CONTENT['object']['name']; ?></h1>
	<?php endif; ?>

	<?php if(isset($SITE_CONTENT['object']['id']) && !empty($SITE_CONTENT['object']['id'])) : ?>
		<strong class="product_code">Код товара:&nbsp;
			<span><?php echo $SITE_CONTENT['object']['id']; ?></span></strong>
	<?php endif; ?>

		<!-- TABS ДЕТАЛЬНО О ТОВАРЕ -->
		<div class="tabs_detail_product">
		<?php if (isset($SITE_CONTENT['views']) && !empty($SITE_CONTENT['views'])) : ?>
			<ul class="horizontal tabs_list">
			<?php $i = 1; foreach ($SITE_CONTENT['views'] as $value) : ?>
				<li class="<?php if($value['position'] == '3') echo 'otvet'; ?> <?php if($value['position'] == '2') echo 'all'; ?> <?php echo $value['view']; ?>">
					<a class="new_tab" href="<?php echo anchor_wta('catalog/'.$SITE_CONTENT['product_url'].'/'.$SITE_CONTENT['object']['link']); ?>#<?php echo $value['view']; ?>" id="<?php if($value['position'] == '3') echo 'otvet'; ?>">
						<?php echo $value['name']; ?>
					</a>
				</li>
				<?php $i++; endforeach; ?>
			</ul>
			<?php endif; ?>

			<div id="subs-all-view">

		<div id="tab-detail_1" class="tabs-container">
			<div class="container_599">
				<ul class="mobile_bxslider">
				<?php if(isset($SITE_CONTENT['object']) && !empty($SITE_CONTENT['object'])) : ?>
					<li class="item">
						<img src="<?php echo baseurl($SITE_CONTENT['object']['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="image" itemprop="image">
					</li>
				<?php endif; ?>
				<?php $index = 0; foreach ($SITE_CONTENT['images'] as $value) : ?>
					<li class="item">
						<img src="<?php echo baseurl($value['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="image" itemprop="image">
					</li>
				<?php ++$index; endforeach; ?>
					</ul>
				<i class="prezent"></i>
			</div>

				<!-- КОНТЕНТ СО СЛАЙДЕРОМ -->
				<div class="product_info_detail__bl_1">

			<?php if(isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images']) || 
				isset($SITE_CONTENT['object']) && !empty($SITE_CONTENT['object'])) : ?>
					<div id="bxslider" class="bxslider_main">
				<?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
						<div class="bxpager-box">
							<div class="jcarousel jcarousel_main">
								<ul class="bxpager">
								<?php if(isset($SITE_CONTENT['object']['image_sm']) && !empty($SITE_CONTENT['object']['image_sm'])) : ?>
									<li class="bxitem">
										<a href="#" class="bxlink" data-slide-index="0">
											<img src="<?php echo baseurl($SITE_CONTENT['object']['image_sm']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="item-image"></a>
									</li>
								<?php endif; ?>
								<?php $index = 1; foreach ($SITE_CONTENT['images'] as $value) : ?>
									<li class="bxitem">
										<a href="#" class="bxlink" data-slide-index="<?php echo $index; ?>">
											<img src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="item-image"></a>
									</li>
									<?php ++$index; endforeach; ?>
								</ul>
							</div>

					<?php if(count($SITE_CONTENT['images']) > 5) : ?>
							<a href="javascript:void(0);" class="jcarousel-left"></a>
							<a href="javascript:void(0);" class="jcarousel-right"></a>
					<?php endif; ?>
						</div>
					<?php endif; ?>

						<ul class="bxmain">
						<?php if(isset($SITE_CONTENT['object']) && !empty($SITE_CONTENT['object'])) : ?>
							<li class="bxitem">
								<a href="<?php if($SITE_CONTENT['mobile'] == 0) echo anchor_wta(site_url('ajax/form/product')); ?>" class="bxlink ownbox-form" data-post="object=<?php echo $OBJECT_ID; ?>&image=0">
									<img src="<?php echo baseurl($SITE_CONTENT['object']['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="item-image"></a>
							</li>
						<?php endif; ?>
						<?php $index = 1; foreach ($SITE_CONTENT['images'] as $value) : ?>
							<li class="bxitem <?php if($index == 2) echo 'active'; ?>">
								<a href="<?php if($SITE_CONTENT['mobile'] == 0) echo anchor_wta(site_url('ajax/form/product')); ?>" class="bxlink ownbox-form" data-post="object=<?php echo $OBJECT_ID; ?>&image=<?php echo $index; ?>">
									<img src="<?php echo baseurl($value['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="item-image"></a>
							</li>
							<?php ++$index; endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php if(isset($SITE_CONTENT['all_info']) && !empty($SITE_CONTENT['all_info'])) : ?>
					<p class="product_description" itemprop="description">
					<?php foreach($SITE_CONTENT['all_info'] as $info) : ?>
						<?php echo $info; ?>
					<?php endforeach; ?>
					</p>
				<?php endif; ?>

				<?php if(isset($SITE_CONTENT['object']['filters']) && !empty($SITE_CONTENT['object']['filters'])) : ?>
					<ul class="product_parametres">
					<?php foreach($SITE_CONTENT['object']['filters'] as $amd) : ?>
						<?php if(isset($amd['class']) && !empty($amd['class']) && $amd['class'] == 'icpc') : ?>
						<li>
							<em><?php echo $amd['procesor_count']; ?></em>
							<span><?php echo $amd['procesor_value']; ?></span>
						</li>
						<?php endif; ?>
					<?php endforeach; ?>

				<?php foreach($SITE_CONTENT['object']['filters'] as $value) : ?>
					<?php if(isset($value['image']) && !empty($value['image']) && $value['class'] != 'icpc') : ?>
						<li>

							<img src="<?php echo baseurl($value['image']); ?>" alt="">
							<?php if(isset($value['name_icon']) && !empty($value['name_icon'])) : ?>
							<span><?php echo $value['name_icon']; ?></span>
							<?php endif; ?>

						</li>
					<?php endif; ?>
				<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				</div>
				<!-- END КОНТЕНТ СО СЛАЙДЕРОМ -->

				<!-- КОНТЕНТ ИНФ. О ТОВАРЕ -->
				<div class="product_info_detail__bl_2">

					<!-- ДО ОКОНЧАНИЯ АКЦИИ... -->
					<?php if(isset($SITE_CONTENT['object']['gift']) && !empty($SITE_CONTENT['object']['gift'])) : ?>
				<?php if ($SITE_CONTENT['object']['date_gift'] > date('Y-m-d')): ?>
					<div class="time_end_action clearfix">
						<em><span>
								<?php echo $SITE_CONTENT['object']['gift'];?>
							</span>

							<i class="prezent"></i>
							<i class="triangle"></i></em>

						
						<!-- ТАЙМЕР -->
						<div class="timmer_wrapper">
							<div class="inner_timmer_wrapper">
								<div class="tmrcnt">
									<div class="cntnm" id="sh_day">00</div>
								</div>

								<div class="tmrcln"></div>

								<div class="tmrcnt">
									<div class="cntnm" id="sh_hour">
										00
										<div class="nmln"></div>
									</div>
								</div>

								<div class="tmrcln"></div>

								<div class="tmrcnt">
									<div class="cntnm" id="sh_min">00</div>
								</div>

								<div class="tmrcln"></div>

								<div class="tmrcnt">
									<div class="cntnm" id="sh_sec">00</div>
								</div>
							</div>
						</div>
						<!-- END ТАЙМЕР -->
					</div>
					<?php endif; ?>
					<?php endif; ?>
					<!-- END ДО ОКОНЧАНИЯ АКЦИИ... -->

					<!-- КРАТКО О ТОВАРЕ -->
					<div class="product_info_detail--short_info">
				<?php if (isset($SITE_CONTENT['colors']) && !empty($SITE_CONTENT['colors'])) : ?>
						<div class="style_info style_info_product_color">
							<div class="product_color">
								<em>Другие цвета:</em>

								<?php foreach ($SITE_CONTENT['colors'] as $value) : ?>
									<?php if ($value['id'] == $SITE_CONTENT['object']['id']) : ?>
										<a href="<?php echo anchor_wta(site_url('catalog/'.$value['links']['categorylink'].'/' . $value['link'])); ?>" class="color_link select_color">
											<?php echo $value['name']; ?>
											<span class="color_v" style="background: #<?php echo $value['color']; ?>"></span>
										</a>
									<?php else : ?>
										<a href="<?php echo anchor_wta(site_url('catalog/'.$value['links']['categorylink'].'/' . $value['link'])); ?>" class="color_link">
											<?php echo $value['name']; ?>
											<span class="color_v" style="background: #<?php echo $value['color']; ?>"></span>
										</a>
									<?php endif; ?>
							<?php endforeach; ?>

							</div>
						</div>
					<?php endif; ?>

						<div class="style_info">
						<?php
							if (
								(isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
								(isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
							) :
							    ?>
							<span class="available_product available_product_no">Товар отсутствует</span>
						<?php else : ?>
							<?php if(isset($SITE_CONTENT['object']['delivery_3_5']) && $SITE_CONTENT['object']['delivery_3_5'] == 1):?>
			                  <span class="available_product available_product_wait">В ожидании</span>
			                <?php else : ?>
			              <span class="available_product available_product_yes">Есть в наличии</span>
			                  <?php endif;?>
						<?php endif; ?>
						</div>

					<?php if (isset($SITE_CONTENT['object']['old_price']) || $SITE_CONTENT['object']['old_price'] > $SITE_CONTENT['object']['price']) : ?>
						<div class="style_info">
							<div class="wrapper_product_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

								<div class="product_price--new">
									<strong itemprop="price">
										<?php if (isset($SITE_CONTENT['object']['price'])) echo $this->input->price_format($SITE_CONTENT['object']['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?>
									</strong>
									<span><?php echo $this->lang->line('site_valuta'); ?>.</span>
									<span itemprop="priceCurrency">UAH</span>
								</div>

								<?php if(isset($SITE_CONTENT['object']) && !empty($SITE_CONTENT['object']['old_price']) && ceil($SITE_CONTENT['object']['old_price']) > 0) : ?>
								
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
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php
					    if (
						    (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
						    (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
					    ) :
						?>
						<button class="add_to_basket" disabled>
							<span>
								Добавить в корзину
							</span>
						</button>
					<?php else : ?>
						<button class="add_to_basket" onclick="cart_buy({id: '<?php echo $SITE_CONTENT['object']['id']; ?>', quantity: 1, color: 0, warranty: $('#warranty').val(), id_product: <?php echo $SITE_CONTENT['object']['id']; ?>}, 1);">
							<span>
								Добавить в корзину
							</span>
						</button>
					<?php endif; ?>

						<!-- КУПИТЬ В ОДИН КЛИК -->
						<form action="<?php echo anchor_wta(site_url('ajax/form-send/buyback')); ?>" method="post" class="form_buy_one_click">
								<input type="text" class="buy_one_click__input" name="phone" placeholder="+38 (___) ___–__–__"  required>
							
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
										<a href="<?php echo anchor_wta('catalog/'.$SITE_TOP['ulr_category'].'/'.$SITE_CONTENT['object']['link']); ?>#subs-review-view" class="product--comm">
											<span class="product--comm_quant"><?php echo $SITE_CONTENT['comments_count']; ?></span>
										</a>
									</p>
								</div>
							</div>
						</div>

						<div class="style_info">
							<div class="product_detail_add_cont clearfix">
								<p>
									<a class="product--detail_like operation-link on <?php
								       $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();
								       if (in_array($SITE_CONTENT['object']['id'], $cookie)) echo 'active'; ?>" 
									href="<?php echo anchor_wta(site_url('ajax/operation/favorite')); ?>"
									 data-post="product=<?php echo $SITE_CONTENT['object']['id']; ?>" title="<?php echo $SITE_CONTENT['object']['name']; ?>">
										<span class="product--detail_like__quant"><?php echo $SITE_CONTENT['object']['favorite_count']; ?></span>
									</a>
								</p>
								<input type="hidden" id="count_like_for_object" value="<?php echo $SITE_CONTENT['object']['favorite_count']; ?>">
								<input type="hidden" id="id_like_object" value="<?php echo $SITE_CONTENT['object']['id']; ?>">
								<!-- лайки -->

								<p class="check">
									<input onclick="add_compare_object();" type="checkbox" id="product--det_check_1" class="product--det_check"
									<?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) && in_array($SITE_CONTENT['object']['id'], json_decode($this->input->cookie('compare')))) echo 'checked'; ?> data-product="<?php echo $SITE_CONTENT['object']['id']; ?>" href="<?php echo anchor_wta('add_to_compare'); ?>">
									<!-- 123 connect ajax data -->

									<label for="product--det_check_1">
										<?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) 
								    	&& in_array($SITE_CONTENT['object']['id'], json_decode($this->input->cookie('compare')))) 
								    	if($this->input->cookie($this->config->item('compare_catalog_cookie_var')) > 1)
								    		echo "Убрать из сравнения";
								    	else
								    	echo 'Убрать из сравнения';
								    	else echo "Добавить к сравнению";?>
									</label>
								</p>
								<input type="hidden" id="id_object_input" value="1">
							</div>
						</div>
					</div>
					<!-- END КРАТКО О ТОВАРЕ -->

					<!-- О ДОСТАВКЕ/ГАРАНТИИ ТОВАРА -->
								<div class="product_info_detail--delivery_warranty">
								<?php $price_old = $SITE_CONTENT['object']['price'];
						    		$five_p = $price_old / 100 * 0.5;
						    		$one_p = $price_old / 100 * 1;
						    		$price = (22+$five_p)+(15+$one_p);

						    		$price_1 = round($price, -1);
						    		$price_2 = round($price, 0);

						    		$price_f = $price_1 - $price_2;
						    		if($price_f < 0) {
						    			if($price_f == -5){
						    				$new_price = $price_2;
						    			} else {
						    				if($price_f < -5){
						    					$price_01 = $price_2 + $price_f;
												$new_price = $price_01 + 10;
						    				} else {
						    					$price_01 = $price_2 + $price_f;
												$new_price = $price_01 + 5;
						    				}
						    			}
						    		} else {
						    			if($price_f == 5){
						    				$new_price = $price_2;
						    			}else {
						    				if($price_f > 5){
							    				$price_01 = $price_2 - $price_f;
							    				$new_price = $price_01 + 10;
							    			} else {
							    				$new_price = $price_2 + $price_f;
						    					//$new_price = $price_01 + 5;
							    			}
						    			}
						    		}

						    		?>

									<?php if(isset($SITE_CONTENT['indormer']) && !empty($SITE_CONTENT['indormer']) && $SITE_CONTENT['indormer'] >= 1) : ?>
									<!-- ДОСТАВКА -->
									<?php foreach($SITE_CONTENT['indormer'] as $value) : ?>
									<section class="<?php if(isset($value['key']) && !empty($value['key'])) echo $value['key']; ?>">
										<div class="delivery-top">
										<h4 class="style_title">
											<?php if(isset($value['name']) && !empty($value['name'])) echo $value['name']; ?>
										</h4>

										<?php if(isset($value['text']) && !empty($value['text'])) : ?>
										<div class="delivery-info">
											<a href="javascript:void(0);" class="clarification"></a>

											<div class="drop">
							                  <a class="close" href="javascript:void(0);"></a>

							                  <div class="drop-text">
							                    <?php echo $value['text']; ?>
							                  </div>
							                </div>
										</div><!-- end .delivery-info -->
										<?php endif; ?>
										<?php if(isset($value['key']) && !empty($value['key'])) : ?>
											<?php if($value['key'] == 'delivery') : ?>
												<div class="delivery-text">Заказы оформленные до 16:00 отправляем в день заказа</div>
											<?php endif; ?>
										<?php endif; ?>
										</div>

										<?php if(isset($value['shorttext']) && !empty($value['shorttext'])) : ?>
											<?php echo $value['shorttext']; ?>
										<?php endif; ?>
									</section>
									<?php endforeach; ?>
									<!-- END ДОСТАВКА -->
									<?php endif; ?>

								</div>
								<!-- END О ДОСТАВКЕ/ГАРАНТИИ ТОВАРА -->

								<span class="clearfix"></span>

								<!-- SELECT BLOCK -->
								<div class="select_block">
						<?php if(isset($SITE_CONTENT['cat_option']['share']) && !empty($SITE_CONTENT['cat_option']['share'])) : ?>
									<div class="style_info">
										<div class="select_block_inner">
											<div>
												<label for="select_v_1"><?php if(isset($SITE_CONTENT['cat_option']['name']) && !empty($SITE_CONTENT['cat_option']['name'])) echo $SITE_CONTENT['cat_option']['name']; ?></label>

												<div class="wrapper_select">
													<select onchange="removeOption();" class="select_v" name="select_v" id="select_v_1">
														<?php $i = 1; if(isset($SITE_CONTENT['cat_option']['share']) && !empty($SITE_CONTENT['cat_option']['share'])) :
														 foreach($SITE_CONTENT['cat_option']['share'] as $value) : ?>
														 	<?php if(isset($value) && !empty($value)) : ?>
																<option data-pos="<?php echo $value['position']; ?>" value="<?php echo $value['id']; ?>"><?php if(isset($value['name']) && !empty($value['name'])) echo $value['name']; ?></option>														
															<?php endif; ?>
															<?php $i++; endforeach; endif; ?>
													</select>
												</div>
												<a href="<?php echo anchor_wta(site_url('ajax/form/paket')); ?>" class="what_is_it ownbox-form fixed_paket_number" data-post="object=<?php echo $OBJECT_ID; ?>&active=1"></a>
											</div>

											<div class="click_bay_1">
												<span class="select_block--add_price">+<?php if(isset($SITE_CONTENT['cat_option']['share'][0]['price']) && !empty($SITE_CONTENT['cat_option']['share'][0]['price'])) echo $SITE_CONTENT['cat_option']['share'][0]['price']; ?> грн.</span>

												<button class="select_block--button" onclick="cart_buy({id: '<?php if(isset($SITE_CONTENT['cat_option']['share'][0]['ID']) && !empty($SITE_CONTENT['cat_option']['share'][0]['ID'])) echo $SITE_CONTENT['cat_option']['share'][0]['ID']; ?>', quantity: 1, color: 0, warranty: $('#warranty').val(), id_product: <?php echo $SITE_CONTENT['object']['id']; ?>}, 1);">Купить</button>
											</div>
										</div>
									</div>
						<?php endif; ?>
						<?php if(isset($SITE_CONTENT['more_option']['share']) && !empty($SITE_CONTENT['more_option']['share'])) : ?>
									<div class="style_info">
										<div class="select_block_inner">
											<div>
												<label for="select_v_2"><?php if(isset($SITE_CONTENT['more_option']['name']) && !empty($SITE_CONTENT['more_option']['name'])) echo $SITE_CONTENT['more_option']['name']; ?></label>

												<div class="wrapper_select">
													<select onchange="removeOption2();" class="select_v" name="select_v" id="select_v_2">
														<?php $i = 1; if(isset($SITE_CONTENT['more_option']['share']) && !empty($SITE_CONTENT['more_option']['share'])) :
														 foreach($SITE_CONTENT['more_option']['share'] as $value) : ?>
														 	<?php if(isset($value) && !empty($value)) : ?>
																<option value="<?php echo $value['id']; ?>"><?php if(isset($value['name']) && !empty($value['name'])) echo $value['name']; ?></option>
															<?php endif; ?>
														<?php $i++; endforeach; endif; ?>
													</select>
												</div>

											</div>

											<div class="click_bay_2">
												<span class="select_block--add_price">+<?php if(isset($SITE_CONTENT['more_option']['share'][0]['price']) && !empty($SITE_CONTENT['more_option']['share'][0]['price'])) echo $SITE_CONTENT['more_option']['share'][0]['price']; ?> грн.</span>

												<button class="select_block--button" onclick="cart_buy({id: '<?php if(isset($SITE_CONTENT['more_option']['share'][0]['ID']) && !empty($SITE_CONTENT['more_option']['share'][0]['ID'])) echo $SITE_CONTENT['more_option']['share'][0]['ID']; ?>', quantity: 1, color: 0, warranty: $('#warranty').val(), id_product: <?php echo $SITE_CONTENT['object']['id']; ?>}, 1);">Купить</button>
											</div>
										</div>
									</div>
								<?php endif; ?>
								</div>
								<!-- END SELECT BLOCK -->
							</div>
							<!-- END КОНТЕНТ ИНФ. О ТОВАРЕ -->

							<span class="clearfix"></span>

							<div class="container_800"></div>

					<?php if(isset($SITE_CONTENT['accesories']) && !empty($SITE_CONTENT['accesories'])) : ?>
							<section class="section">
								<h2>Аксессуары</h2>

								<!-- КАРУСЕЛЬ ПРОДУКЦИИ -->
								<div class="wrapper_product_gallery">
									<div class="product_gallery">
            							<?php echo $this->load->view('inside/catalog/catalog_item_acc_view', array('catalog' => $SITE_CONTENT['accesories']), true); ?>
									</div>
								</div>
								<!-- END КАРУСЕЛЬ ПРОДУКЦИИ -->
							</section>
					<?php endif; ?>

							<div class="clearfix section_t_par_comments">
								<div class="wrapper_t_parametres clearfix">
									<!-- ТЕХНИЧЕСКИЕ Х-КИ -->
			<?php if(isset($SITE_CONTENT['object']['filters']) && !empty($SITE_CONTENT['object']['filters'])) : ?>
									<section class="section t_parametres_1">
										<h2>Технические характеристики</h2>

										<!-- TABS -->
										<div class="tabs">
											<ul class="horizontal">
												<li class="all">
													<a href="#tab-1">
														<span>Основные</span>
													</a>
												</li>

											<?php if(isset($SITE_CONTENT['filter_object']) && !empty($SITE_CONTENT['filter_object'])) : ?>												
												<li>
													<a href="<?php echo anchor_wta('catalog/'.$SITE_TOP['ulr_category'].'/'.$SITE_CONTENT['object']['link']); ?>#subs-desc-view" class="all_filters_object">
														<span>Все характеристики</span>
													</a>
												</li>
											<?php endif; ?>
											
											</ul>

			<?php if(isset($SITE_CONTENT['object']['filters']) && !empty($SITE_CONTENT['object']['filters'])) : ?>
											<div id="tab-1">
												<table class="table_parametres">
													<col class="col_1">
													<col class="col_2">
								<?php $i = 1; foreach($SITE_CONTENT['object']['filters'] as $value) : ?>
													<tr>
														<td>
															<em class="par_<?php if(isset($value['classid']) && !empty($value['classid'])) echo $value['classid']; else echo $value['classid_new']; ?>"><?php echo $value['parent_name']; ?>:</em>
														</td>
														<td>
															<?php echo $value['name']; ?>
														</td>
													</tr>
								<?php $i++; endforeach; ?>
												</table>
											</div>
											<div id="tab-2">
												<table class="table_parametres">
													<col class="col_1">
													<col class="col_2">
													<?php $i = 1; foreach($SITE_CONTENT['object']['filters'] as $value) : ?>
													<tr>
														<td>
															<em class="par_<?php echo $value['classid']; ?>"><?php echo $value['parent_name']; ?>:</em>
														</td>
														<td>
															<strong><?php echo $value['name']; ?></strong>
														</td>
													</tr>
													<?php $i++; endforeach; ?>
												</table>
											</div>
					<?php endif; ?>
										</div>
										<!-- END TABS -->
									</section>
		<?php endif; ?>
									<!-- END ТЕХНИЧЕСКИЕ Х-КИ -->

									<!-- ОПИСАНИЕ -->
					<?php if(isset($SITE_CONTENT['object']['text']) && !empty($SITE_CONTENT['object']['text'])) : ?>
									<section class="section t_parametres_2">
										<h2>Описание</h2>
						
										<div class="description_content">
							
											<p class="text">
												<?php echo $SITE_CONTENT['object']['text']; ?>
											</p>

										<!-- <a href="#" class="hide_show_description">Читать полностью</a> -->

								</section>
								<?php if(isset($SITE_CONTENT['more_text']) && !empty($SITE_CONTENT['more_text']) && $SITE_CONTENT['more_text'] > 1000) : ?>
								<a href="#" class="hide_show_description">Читать полностью</a>
								<?php endif; ?>
									<?php if(isset($SITE_CONTENT['video']) && !empty($SITE_CONTENT['video'])) : ?>
									<?php foreach($SITE_CONTENT['video'] as $video) : ?>
										<div class="video">
											<?php if(isset($video['text']) && !empty($video['text'])) echo $video['text']; ?>
										</div>
									<?php endforeach; ?>
									<?php endif; ?>
								<!-- new insert this a -->
					<?php endif; ?>
								<!-- END ОПИСАНИЕ -->
							</div>

							<!-- ОТЗЫВЫ -->
							<section class="section section_comments">
								<h2>Отзывы</h2>

								<a href="<?php echo anchor_wta('catalog/'.$SITE_TOP['ulr_category'].'/'.$SITE_CONTENT['object']['link']); ?>#subs-review-view" class="make_comment">Написать отзыв</a>

					<?php echo $this->load->view('inside/object/tab_comments_view', array('comments' => $SITE_CONTENT['night_comment']), true); ?>

					<?php if(isset($SITE_CONTENT['comments']) && !empty($SITE_CONTENT['comments'])) : ?>
								<a class="all_user_comments" href="<?php echo anchor_wta('catalog/'.$SITE_CONTENT['product_url'].'/'.$SITE_CONTENT['object']['link']); ?>#subs-review-view">
									<span>Все отзывы</span>
								</a>
					<?php endif; ?>
							</section>
							<!-- ОТЗЫВЫ -->
						</div>
						<?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
						<!-- ФОТО -->
						<section class="section section_photo">
							<h2>Фото</h2>
							<div class="wrapper_photo clearfix">
								<?php echo $this->load->view('inside/object/tab_images_view', array('images' => $SITE_CONTENT['images'], 'OBJECT_ID' => $SITE_CONTENT['object']['id'], 'mobile' => $SITE_CONTENT['mobile']), true); ?>
							</div>
						</section>
						<!-- END ФОТО -->
						<?php endif; ?>
					</div>
				</div>

					<div id="subs-desc-view" class="tabs-container">
						<div class="tabs_content">
							<?php if(isset($SITE_CONTENT['filter_object']) && !empty($SITE_CONTENT['filter_object'])) : ?>
									<?php echo $SITE_CONTENT['filter_object']; ?>
						<?php endif; ?>

							<!--<?php if(isset($SITE_CONTENT['object']['features_text']) && !empty($SITE_CONTENT['object']['features_text'])) echo $SITE_CONTENT['object']['features_text']; ?>-->
						</div>

						<?php echo $this->load->view('inside/object/tab_object_view', array('object' => $SITE_CONTENT['object'], 'i' => 2), true); ?>

						<span class="clearfix"></span>
					</div>

					<div id="subs-review-view" name="tab_detail_otvet" class="tabs-container">
						<div class="tabs_content">
							<a href="javascript:void(0);" class="make_comment">Написать отзыв</a>
								<?php echo $this->load->view('inside/object/tab_comments_view', array('comments' => $SITE_CONTENT['comments']), true); ?>
									
							<?php if(isset($SITE_CONTENT['comments']) && !empty($SITE_CONTENT['comments'])) : ?>
								<!-- pagination -->
						          <div class="pagination">
						          <?php if($SITE_CONTENT['product_pages']['this_page'] == $SITE_CONTENT['product_pages']['count_page']) : ?>
						          	<button class="button disabled" disabled="disabled">
						              <i class="icon"></i>
						              <span class="name">Показать еще отзывы</span>
						            </button>
						          <?php else : ?>
						            <button class="button" disabled="disabled">
						              <i class="icon"></i>
						              <span class="name active_ajax">Показать еще отзывы</span>
						            </button>
						        	<?php endif; ?>

						            <input type="hidden" id="thispage" value="<?php echo ceil((int)$SITE_CONTENT['product_pages']['this_page'] + 1); ?>">
						            <input type="hidden" id="countpage" value="<?php echo $SITE_CONTENT['product_pages']['count_page']; ?>">

						            <ul class="list">
						            <?php

						            	$last_page_min = $SITE_CONTENT['count_comments'] - 3;
						            	$last_page_min_one = $SITE_CONTENT['count_comments'] - 1;
						            	$last_page = $SITE_CONTENT['count_comments'];

						            	$prev_page_min = $SITE_CONTENT['count_comments'] - 4;

						            	if($SITE_CONTENT['product_pages']['this_page'] > 3) $prev_page = $SITE_CONTENT['product_pages']['this_page'] - 2;
						            	 else $prev_page = 1;
						            	if($SITE_CONTENT['product_pages']['this_page'] == $SITE_CONTENT['count_comments']) $SITE_CONTENT['count_comments'] = $SITE_CONTENT['count_comments'];
						            	elseif($SITE_CONTENT['product_pages']['this_page'] == $last_page_min_one) $SITE_CONTENT['product_pages']['this_page'] + 1;
						            	else $SITE_CONTENT['count_comments'] = $SITE_CONTENT['product_pages']['this_page'] + 2;


						            ?>

						            <input type="hidden" id="category" value="<?php echo $SITE_TOP['ulr_category']; ?>">
						            <input type="hidden" id="link_product" value="<?php echo $SITE_CONTENT['object']['link']; ?>">
						            <input type="hidden" id="total_page" value="<?php echo $SITE_CONTENT['product_pages']['count_page']; ?>">

						            <?php if($SITE_CONTENT['product_pages']['this_page'] > 3) : ?>
							          		<li class="item ajax_page_<?php echo 1; ?>">
								                <a href="<?php echo anchor_wta('catalog/'.$SITE_TOP['ulr_category'].'/'.$SITE_CONTENT['object']['link'].'/page/1'); ?>#subs-review-view" data-post="<?php echo 1; ?>" class="link"><?php echo 1; ?> ... </a>
							              </li>
							          	<?php endif; ?>

						            <?php for ($i=$prev_page; $i <= $SITE_CONTENT['count_comments']; $i++) : ?>

			            			<?php if($SITE_CONTENT['product_pages']['this_page'] == $i) : ?>
						              <li class="item selected del_el_<?php echo $i; ?>"><?php echo $i; ?></li>
					          		<?php else : ?>
					          			<li class="item ajax_page_<?php echo $i; ?> element">
						                <a href="<?php echo anchor_wta('catalog/'.$SITE_TOP['ulr_category'].'/'.$SITE_CONTENT['object']['link'].'/page/'.$i); ?>#subs-review-view" data-post="<?php echo $i; ?>" class="link"><?php echo $i; ?></a>
						              </li>
						          	<?php endif; ?>

						          	<?php endfor; ?>
						          	<?php if($SITE_CONTENT['product_pages']['this_page'] <= $last_page_min) : ?>
						          		<li class="item ajax_page_<?php echo $last_page; ?> last_page">
							                <a href="<?php echo anchor_wta('catalog/'.$SITE_TOP['ulr_category'].'/'.$SITE_CONTENT['object']['link'].'/page/'.$last_page); ?>#subs-review-view" data-post="<?php echo $last_page; ?>" class="link"> ... <?php echo $last_page; ?></a>
						              </li>
						          	<?php endif; ?>
						            </ul>

					            <?php if($SITE_CONTENT['product_pages']['this_page'] == 1) : ?>
						            <a href="javascript:void(0);" class="prev disabled"><i class="icon"></i>Предыдущая</a>
					        	<?php else : ?>
					        		<a href="<?php echo anchor_wta('catalog/'.$SITE_TOP['ulr_category'].'/'.$SITE_CONTENT['object']['link'].'/page/'.$SITE_CONTENT['product_pages']['page_prev']); ?>#subs-review-view" class="prev"><i class="icon"></i>Предыдущая</a>		
					        	<?php endif; ?>

					        	<?php if($SITE_CONTENT['product_pages']['this_page'] == $SITE_CONTENT['product_pages']['count_page']) : ?>
					        		<a href="javascript:void(0);" class="next disabled">Следующая<i class="icon"></i></a>
					        	<?php else : ?>
						            <a href="<?php echo anchor_wta('catalog/'.$SITE_TOP['ulr_category'].'/'.$SITE_CONTENT['object']['link'].'/page/'.$SITE_CONTENT['product_pages']['page_next']); ?>#subs-review-view" class="next">Следующая<i class="icon"></i></a>
						        <?php endif; ?>
						          </div>
						          <!-- end pagination -->
						         <?php endif; ?>

								<div class="review-form" style="display: block;" style="display:none">
								<h2>Отзывы</h2>

							<form method="post" action="<?php echo anchor_wta('ajax/form-send/add_comment'); ?>">
							<input type="hidden" name="robot" value=""/>
							<input type="hidden" name="id_comment" value="0"/>
							<input type="hidden" name="product_id" value="<?php echo $SITE_CONTENT['object']['id']; ?>"/>
								<div class="review-box">
									<div class="field">
										<div class="name">Ваше имя</div>
										<input type="text" class="input-text fldtx" name="name">
									</div><!-- end .field -->

									<div class="field">
										<div class="name">Отзыв</div>
										<textarea cols="30" rows="10" class="textarea" name="text"></textarea>
									</div><!-- end .field -->

									<div class="field">
										<div class="name">Оценка</div>

										<div class="review-rating">
											<a href="javascript:void(0);" class="star" data-mark="1" data-text="Плохо"></a>
											<a href="javascript:void(0);" class="star" data-mark="2" data-text="Удовлетворительно"></a>
											<a href="javascript:void(0);" class="star" data-mark="3" data-text="Нормально"></a>
											<a href="javascript:void(0);" class="star" data-mark="4" data-text="Хорошо"></a>
											<a href="javascript:void(0);" class="star" data-mark="5" data-text="Отлично"></a>
										<input type="hidden" name="mark" value="0"/>
										<div class="rttx"></div>
										</div><!-- end .rating -->
									</div><!-- end .field -->

									<input type="submit" class="ajax-form input-button" value="Добавить отзыв">
								</div><!-- end .form-box -->
								</form>
							</div><!-- end .review-form -->
						</div>
							<?php echo $this->load->view('inside/object/tab_object_view', array('object' => $SITE_CONTENT['object'], 'i' => 3), true); ?>
						<span class="clearfix"></span>
					</div>

					<div id="subs-photo-view" class="tabs-container">
						<div class="tabs_content">
							<div class="wrapper_photo clearfix">
								<?php echo $this->load->view('inside/object/tab_images_view', array('images' => $SITE_CONTENT['images']), true); ?>
							</div>
						</div>

						<?php echo $this->load->view('inside/object/tab_object_view', array('object' => $SITE_CONTENT['object'], 'i' => 4), true); ?>

						<span class="clearfix"></span>
					</div>

					<div id="subs-video-view" class="tabs-container">
						<div class="tabs_content">
							<?php if(isset($SITE_CONTENT['object']['video']) && !empty($SITE_CONTENT['object']['video'])) : ?>
							<?php foreach($SITE_CONTENT['video'] as $video) : ?>
								<div class="video">
									<?php if(isset($video['text']) && !empty($video['text'])) echo $video['text']; ?>
								</div>
							<?php endforeach; ?>
							<?php endif; ?>
						</div>

						<?php echo $this->load->view('inside/object/tab_object_view', array('object' => $SITE_CONTENT['object'], 'i' => 5), true); ?>

						<span class="clearfix"></span>
					</div>

					<div id="subs-acc-view" class="tabs-container">
						<div class="tabs_content">
							<div class="wrapper_similar_products clearfix">
							<?php echo $this->load->view('inside/catalog/catalog_item_popular_view', array('catalog' => $SITE_CONTENT['accesories']), true); ?>
							</div>
						</div>

						<?php echo $this->load->view('inside/object/tab_object_view', array('object' => $SITE_CONTENT['object'], 'i' => 6), true); ?>

						<span class="clearfix"></span>
					</div>

					<div id="sub-option-view" class="tabs-container">
						<div class="tabs_content">

						<?php $i = 1; if(isset($SITE_CONTENT['cat_option']['share']) && !empty($SITE_CONTENT['cat_option']['share'])) :
						 $i = 1;
						 foreach($SITE_CONTENT['cat_option']['share'] as $value) : ?>
						 	<?php if(isset($value) && !empty($value)) : ?>
							<div class="style_info_tabs">
								<div>
									<strong class="tabs_content--v_service">
									<?php if(isset($value['name']) && !empty($value['name'])) echo $value['name']; ?>
									<a href="<?php echo anchor_wta(site_url('ajax/form/paket')); ?>" class="what_is_it ownbox-form" data-post="object=<?php echo $OBJECT_ID; ?>&active=<?php echo $i; ?>"></a>
									</strong>
								</div>
								<div>
									<p>
										<span class="tabs_content--add_price">+<?php if(isset($value['price']) && !empty($value['price'])) echo $value['price']; ?>&nbsp;грн</span>
									</p>
									<button class="tabs_content--button" onclick="cart_buy({id: '<?php echo $value['ID']; ?>', quantity: 1, color: 0, warranty: $('#warranty').val(), id_product: <?php echo $SITE_CONTENT['object']['id']; ?>}, 1);">Купить</button>
								</div>
							</div>
							<?php endif; ?>
						<?php $i++; endforeach; endif; ?>

			<?php if(isset($SITE_CONTENT['more_option']['share']) && !empty($SITE_CONTENT['more_option']['share'])) : ?>
							<div class="style_info_tabs">
								<div class="tabs_content__add_v">

									<div class="tabs_content--wrapper_select">
										<label for="tabs_content--select_1">Дополнительно</label>

										<select onchange="removeOption3();" class="tabs_content--select" name="tabs_content--select" id="tabs_content--select_1">
											<?php $i = 1; if(isset($SITE_CONTENT['more_option']['share']) && !empty($SITE_CONTENT['more_option']['share'])) :
											 foreach($SITE_CONTENT['more_option']['share'] as $value) : ?>
											 	<?php if(isset($value) && !empty($value)) : ?>
													<option value="<?php echo $value['id']; ?>"><?php if(isset($value['name']) && !empty($value['name'])) echo $value['name']; ?></option>
												<?php endif; ?>
											<?php $i++; endforeach; endif; ?>
										</select>
									</div>
								</div>
								<div class="add_tabs_option">
									<p>
										<span class="tabs_content--add_price">+<?php if(isset($SITE_CONTENT['more_option']['share'][0]['price']) && !empty($SITE_CONTENT['more_option']['share'][0]['price'])) echo $SITE_CONTENT['more_option']['share'][0]['price']; ?>&nbsp;грн</span>
									</p>
									<button class="tabs_content--button" onclick="cart_buy({id: '<?php if(isset($SITE_CONTENT['more_option']['share'][0]['ID']) && !empty($SITE_CONTENT['more_option']['share'][0]['ID'])) echo $SITE_CONTENT['more_option']['share'][0]['ID']; ?>', quantity: 1, color: 0, warranty: $('#warranty').val(), id_product: <?php echo $SITE_CONTENT['object']['id']; ?>}, 1);">Купить</button>
								</div>
							</div>
						</div>
			<?php endif; ?>

						<?php echo $this->load->view('inside/object/tab_object_view', array('object' => $SITE_CONTENT['object'], 'i' => 7), true); ?>

						<span class="clearfix"></span>
					</div>
				</div>
				<!-- END TABS ДЕТАЛЬНО О ТОВАРЕ -->
			</section>
			<!-- END ДЕТАЛЬНО О ТОВАРЕ -->

			<!-- ПОХОЖИЕ ТОВАРЫ -->
		<?php if(isset($SITE_CONTENT['similar']) && !empty($SITE_CONTENT['similar'])) : ?>
			<section class="section section_similar_products section_before_footer">
				<h2>Похожие товары</h2>
					<div class="wrapper_similar_products clearfix">
						<?php echo $this->load->view('inside/catalog/catalog_populars_view', array('catalog' => $SITE_CONTENT['similar']), true); ?>
				</div>
			</section>
		<?php endif; ?>
			<!-- END ПОХОЖИЕ ТОВАРЫ -->
		</div>
		<!-- END CONTAINER -->
	</main>
	<input type="hidden" id="id_product" value="<?php echo $SITE_CONTENT['object']['id']; ?>">
	<input type="hidden" id="new_price_informer" value="<?php echo $new_price; ?>">
	<!-- END MAIN -->
</div>