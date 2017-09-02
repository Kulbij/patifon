    <div class="ownbox-content form form-product">
    <?php if(isset($SITE_CONTENT['object']['name']) && !empty($SITE_CONTENT['object']['name'])) : ?>
      <div class="title"><?php echo $SITE_CONTENT['object']['name']; ?></div>
    <?php endif; ?>
    <?php
    $compare = json_decode($this->input->cookie('compare'));
    if ($compare === null)
  $compare = [];
    ;
    ?>

      <a class="close ownbox-close" href="javascript:void(0);"></a>

      <div class="product_info_detail__bl_1">
      <?php if(isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images']) || 
        isset($SITE_CONTENT['object']) && !empty($SITE_CONTENT['object'])) : ?>
        <div id="bxslider" class="bxslider_second">
          <div class="bxpager-box">
            <div class="jcarousel jcarousel_second">
              <ul class="bxpager">
              <?php if (isset($SITE_CONTENT['object']['image_sm']) && !empty($SITE_CONTENT['object']['image_sm'])) : ?>
                <li class="bxitem">
                  <a href="#" class="bxlink" data-slide-index="0">
                    <img src="<?php echo baseurl($SITE_CONTENT['object']['image_sm']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="item-image"></a>
                </li>
                <?php endif; ?>
                <?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
                  <?php $index = 1; foreach ($SITE_CONTENT['images'] as $value) : ?>
                <li class="bxitem">
                  <a href="#" class="bxlink" data-slide-index="<?php echo $index; ?>">
                    <img src="<?php echo baseurl($value['image']); ?>" alt="#" class="item-image"></a>
                </li>
                <?php ++$index; endforeach; ?>
              <?php endif; ?>
              </ul>
            </div>

            <a href="#" class="jcarousel-left"></a>
            <a href="#" class="jcarousel-right"></a>
          </div>

          <ul class="bxmain bxsecond">
          <?php if(isset($SITE_CONTENT['object']) && !empty($SITE_CONTENT['object'])) : ?>
            <li class="bxitem">
                <img src="<?php echo baseurl($SITE_CONTENT['object']['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="item-image" itemprop="image">
              </li>
              <?php endif; ?>
            <?php $index = 1; foreach ($SITE_CONTENT['images'] as $value) : ?>

            <li class="bxitem">
              <a href="javascript:vaid(0);" class="bxlink">
                <img src="<?php echo baseurl($value['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" class="item-image" itemprop="image"></a>
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
          <?php if ($SITE_CONTENT['object']['date_gift'] > date('Y-m-d')): ?>

          <div class="time_end_action clearfix">
            <em><span>
              <?php echo $SITE_CONTENT['object']['gift'];?>
            </span>
            
              <i class="prezent"></i></em>

            <!-- ТАЙМЕР -->
            <div class="timmer_wrapper">
              <div class="inner_timmer_wrapper">
                <div class="tmrcnt">
                  <div class="cntnm" id="sh_day1">00</div>
                </div>

                <div class="tmrcln"></div>

                <div class="tmrcnt">
                  <div class="cntnm" id="sh_hour1">
                    00
                    <div class="nmln"></div>
                  </div>
                </div>

                <div class="tmrcln"></div>

                <div class="tmrcnt">
                  <div class="cntnm" id="sh_min1">00</div>
                </div>

                <div class="tmrcln"></div>

                <div class="tmrcnt">
                  <div class="cntnm" id="sh_sec1">00</div>
                </div>
              </div>
            </div>
            <!-- END ТАЙМЕР -->
          </div>
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
              
                <input type="text" class="buy_one_click__input" name="phone" placeholder="+38 (___) ___–__–__" value="+38 (___) ___–__–__"  required>
              
                <button type="submit" class="buy_one_click__button ajax-form">Купить в 1 клик</button>
              
              <input type="hidden" name="link" value="<?php echo $SITE_CONTENT['object']['id']; ?>" />
        <input type="hidden" name="robot" value="" />
            </form>
            <!-- END КУПИТЬ В ОДИН КЛИК -->

            <div class="style_info">
              <div class="rating_comments_product">
                <div>
                  <p class="wrapper_rating">
                    <span class="rating--product"><input name="val" value="<?php echo $SITE_CONTENT['object']['mark']; ?>" type="hidden" /></span>
                  </p>
                </div>
                <div>
                  <p>
                    <a href="<?php echo anchor_wta('catalog/'.$SITE_CONTENT['ulr_category'].'/'.$SITE_CONTENT['object']['link']); ?>#subs-review-view" class="product--comm" id="like_slide_to_comments">
                      <span class="product--comm_quant"><?php echo $SITE_CONTENT['object']['comm_count']; ?></span>
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
                   data-post="product=<?php echo $SITE_CONTENT['object']['id']; ?>">
                    <span class="product--detail_like__quant"><?php echo $SITE_CONTENT['object']['favorite_count']; ?></span>
                  </a>
                </p>
                <input type="hidden" id="count_like_for_object" value="<?php echo $SITE_CONTENT['object']['favorite_count']; ?>">
                <input type="hidden" id="id_like_object" value="<?php echo $SITE_CONTENT['object']['id']; ?>">

                <!-- лайки -->

                <p class="check">
                  <input onclick="add_compare_object();" type="checkbox" id="product--det_check_99" class="product--det_check"
                  <?php if (in_array($SITE_CONTENT['object']['id'], $compare)) echo 'checked'; ?> data-product="<?php echo $SITE_CONTENT['object']['id']; ?>" href="<?php echo anchor_wta('add_to_compare'); ?>">
                  <!-- 123 connect ajax data -->

                  <label for="product--det_check_99">
                  <?php if (in_array($SITE_CONTENT['object']['id'], $compare)) echo 'Убрать из сравнения';
                      else echo "Добавить к сравнению"; ?>
                  </label>
                </p>
                <input type="hidden" id="id_object_input" value="99">
              </div>
            </div>
          </div>
          <!-- END КРАТКО О ТОВАРЕ -->
          
        </div>
        <!-- END КОНТЕНТ ИНФ. О ТОВАРЕ -->
    </div><!-- end .ownbox-content -->

    <input type="hidden" class="own_inde_product" value="<?php echo $SITE_CONTENT['image']; ?>" />

    <script type="text/javascript">
    $('input[name=phone]').mask('+38 (999) 999–99–99');
 $.zTimer({
          day: 'sh_day1',
          hour: 'sh_hour1',
          minute: 'sh_min1',
          second: 'sh_sec1',
          weekOn: false,
          date: new Date(<?php echo strtotime($SITE_CONTENT['object']['date_gift']) * 1000; ?>)
           });
    </script>