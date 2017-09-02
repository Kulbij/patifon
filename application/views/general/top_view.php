<body itemscope itemtype="http://schema.org/WebPage">
<!--///////////////////////////////////////////////////////////////////////////////
                      HEADER
//////////////////////////////////////////////////////////////////////////////////-->
  <div class="wrapper">
    <header>
    <div class="header_wrapper new-year">
    <!-- TOP HEADER -->
    <div class="header__top">
      <!-- CONTAINER -->
      <div class="container header__top--container clearfix">
        <!-- ГЛАВНАЯ НАВИГАЦИЯ -->
        <?php if (isset($SITE_TOP['toppage']) && !empty($SITE_TOP['toppage'])) : ?>
        <nav class="main_nav">
          <ul>
          <?php foreach ($SITE_TOP['toppage'] as $value) : ?>
            <li class="<?php if(isset($SITE_CONTENT['page_link']) && !empty($SITE_CONTENT['page_link']) && $SITE_CONTENT['page_link'] == $value['link'] || (isset($SITE_CONTENT['page']['link']) && !empty($SITE_CONTENT['page']['link']) && $SITE_CONTENT['page']['link'] == $value['link'])) echo 'hide_599'; ?>">
              <a href="<?php if (isset($value['link'])) echo anchor_wta(site_url($value['link'])); ?>">
                <?php if (isset($value['name'])) echo $value['name']; ?>
              </a>
            </li>
            <?php endforeach; ?>
            <li class="<?php if(isset($SITE_CONTENT['page_link']) && !empty($SITE_CONTENT['page_link']) && $SITE_CONTENT['page_link'] == 'compare') echo 'hide_599'; ?>">
              <a href="<?php echo anchor_wta('compare'); ?>" class="comprasion_link">
                <i class="comprasion_link__count"><?php if (isset($_COOKIE[$this->config->item('compare_catalog_cookie_var')])) echo $_COOKIE[$this->config->item('compare_catalog_cookie_var')]; else echo 0; ?></i>
                <span><?php echo $this->lang->line('t_compare'); ?></span>
              </a>
            </li>
          </ul>
        </nav>
        <?php endif; ?>
        <!-- ГЛАВНАЯ НАВИГАЦИЯ -->

        <!-- ФОРМА В TOP HEADER -->
        <form action="<?php echo anchor_wta(site_url('catalog/search')); ?>" method="get" name="header--form" class="header--form clearfix">
          <button type="submit" class="header--form_submit button_1"></button>

          <div class="wrapper_header--form_input">
            <input class="header--form_input" required autocomplete="off" name="search">
            </div>
        </form>
        <!-- END ФОРМА В TOP HEADER -->
      </div>
      <!-- END CONTAINER -->
    </div>
    <!-- END TOP HEADER -->

    <!-- MIDDLE HEADER -->
    <div class="header__middle">
      <div class="container clearfix">
        <!-- LOGO COMPANY -->
        <?php if ($__PAGE == 'index') : ?>
          <a class="logo_company" title="Patifon">
          <img src="<?php echo baseurl('public/images/logo_company.png'); ?>" alt="Patifon">
          <!-- <i class="new-year-hat"></i> -->
          </a>
        <?php else : ?>
        <a href="<?php echo anchor_wta(); ?>" class="logo_company" title="Patifon">
          <img src="<?php echo baseurl('public/images/logo_company.png'); ?>" alt="Patifon">
          <!-- <i class="new-year-hat"></i> -->
        </a>
        <?php endif; ?>
        <!-- END LOGO COMPANY -->

        <!-- КОРЗИНА -->
        <div class="cart_box">
        <?php if (isset($SITE_TOP['cart']['catalogcount']) && $SITE_TOP['cart']['catalogcount'] > 0) : ?>
          <a href="javascript:void(0);" class="cart cart_full" onclick="cart_show(); return false;">
          <span class="cart__title"><?php echo $this->lang->line('t_cart_empty_text'); ?></span>
          <span class="cart_total_summ" id="main_c_total">
            <?php if (isset($SITE_TOP['cart']['catalogtotalsum']) && $SITE_TOP['cart']['catalogtotalsum'] > 0) echo $SITE_TOP['cart']['catalogtotalsum']; else echo 0; ?>
            <i>&nbsp;<?php echo $this->lang->line('site_valuta'); ?>.</i>
          </span>
          <span class="cart__count" id="main_c_count"><?php if (isset($SITE_TOP['cart']['catalogcount']) && $SITE_TOP['cart']['catalogcount'] > 0) echo $SITE_TOP['cart']['catalogcount']; ?></span>
        </a>
        <?php else : ?>
          <div class="cart cart_empty">
          <span class="cart__title"><?php echo $this->lang->line('t_cart_empty_text'); ?></span>
          <span class="cart_total_summ">
            284 200
            <i>&nbsp;<?php echo $this->lang->line('site_valuta'); ?>.</i>
          </span>
          <span class="cart__count"><?php if (isset($SITE_TOP['cart']['catalogcount']) && $SITE_TOP['cart']['catalogcount'] > 0) echo $SITE_TOP['cart']['catalogcount']; else echo "0"; ?></span>
        </div>
        <!-- END КОРЗИНА -->
        <?php endif; ?>
        </div>
        <!-- END КОРЗИНА -->

        <!-- КОНТАКТНАЯ ИНФА В HEADER -->
        <?php if (isset($SITE_TOP['phones']) && !empty($SITE_TOP['phones'])) : ?>
        <div class="header_contacts_info">
          <p class="time_work clearfix"> <strong>График работы Call-центра</strong> <em>&nbsp;Пн-Пт: 09:00-21:00, Сб-Вс: 10:00-20:00</em>
            <a href="<?php echo anchor_wta(site_url('ajax/form/callback-form')); ?>" class="call_us ownbox-form" rel="nofollow">
              <span>Перезвоните мне</span>
            </a>
          </p>
          <p class="contact_phones_group">
          <?php foreach ($SITE_TOP['phones'] as $value) : ?>
            <a href="tel:<?php if(isset($value['phone']) && !empty($value['phone'])) echo $value['phone']; ?>" class="contact_phone contact_phone_<?php echo $value['paket']; ?>">
              <em><?php if(isset($value['phone']) && !empty($value['phone'])) echo $value['phone']; ?></em>
            </a>
            <?php endforeach; ?>
          </p>
        </div>
        <?php endif; ?>
        <!-- END КОНТАКТНАЯ ИНФА В HEADER -->

        <span class="clearfix"></span>

        <div class="container_980 clearfix"></div>
      </div>
      <!-- END CONTAINER -->
    </div>
    <!-- END MIDDLE HEADER -->
    </div><!-- end .header_wrapper -->

    <!-- ДОПОЛНИТЕЛЬНАЯ НАВИГАЦИЯ -->
    <?php if (isset($SITE_TOP['menu']) && !empty($SITE_TOP['menu']) && count($SITE_TOP['menu']) > 0) : ?>
      <nav class="add_nav">
        <ul>
      <?php foreach ($SITE_TOP['menu'] as $value) : ?>
        <?php if(isset($value['children']) && !empty($value['children']) && count($value['children']) > 0) : ?>
          <?php if($value['id'] != '6') : ?>
          <li class="<?php if(!empty($SITE_TOP['url_memu']) && isset($SITE_TOP['url_memu']) && $value['link'] == $SITE_TOP['url_memu']) echo 'add_nav__active_link'; ?>">
          <a href="<?php echo anchor_wta(site_url('catalog/'.$value['link'])); ?>">
            <?php if(isset($value['name']) && !empty($value['name'])) echo $value['name']; ?>
          </a>
          <?php if(isset($value['children']) && !empty($value['children']) && count($value['children']) > 0) : ?>
            <ul class="sub_menu">
            <?php foreach($value['children'] as $child) : ?>
              <?php if($child['id'] == '6') : ?>
                <li>
                  <a href="<?php echo anchor_wta(site_url('pidcatalog/'.$child['link'])); ?>">
                    <?php if(isset($child['name']) && !empty($child['name'])) echo $child['name']; ?>
                  </a>
                </li>
              <?php else : ?>
              <li>
                <a href="<?php echo anchor_wta(site_url('catalog/'.$child['link'])); ?>">
                  <?php if(isset($child['name']) && !empty($child['name'])) echo $child['name']; ?>
                </a>
              </li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?></li>
          <?php else : ?>
            <li class="<?php if(!empty($SITE_TOP['url_memu']) && isset($SITE_TOP['url_memu']) && $value['link'] == $SITE_TOP['url_memu']) echo 'add_nav__active_link'; ?>"><a href="<?php echo anchor_wta(site_url('pidcatalog/'.$value['link'])); ?>"><?php if(isset($value['name']) && !empty($value['name'])) echo $value['name']; ?></a><?php if(isset($value['children']) && !empty($value['children']) && count($value['children']) > 0) : ?><ul class="sub_menu"><?php foreach($value['children'] as $child) : ?><li><a href="<?php echo anchor_wta(site_url('catalog/'.$value['link'].'/'.$child['link'])); ?>"><?php if(isset($child['name']) && !empty($child['name'])) echo $child['name']; ?></a></li><?php endforeach; ?></ul><?php endif; ?></li>
          <?php endif; ?>
        <?php else : ?>
          <li class="<?php if(!empty($SITE_TOP['url_memu']) && isset($SITE_TOP['url_memu']) && $value['link'] == $SITE_TOP['url_memu']) echo 'add_nav__active_link'; ?>"><a href="<?php echo anchor_wta(site_url('catalog/'.$value['link'])); ?>"><?php if(isset($value['name']) && !empty($value['name'])) echo $value['name']; ?></a></li>
        <?php endif; ?>
      <?php endforeach; ?>
        </ul>
      </nav>
      <?php endif; ?>
      <!-- END ДОПОЛНИТЕЛЬНАЯ НАВИГАЦИЯ -->
  </header>
  <!-- END HEADER -->