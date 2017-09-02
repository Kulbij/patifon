<!--////////////////////////////////////////////////////////////////////////////////
                      FOOTER
////////////////////////////////////////////////////////////////////////////////////-->
<a href="javascript:void(0)" id="up_page" style="display: none;"></a>
<footer>
  <div class="container">
    <!-- TOP FOOTER -->
    <div class="footer__top">
      <!-- FOOTER NAV -->
      <?php
         if (isset($SITE_TOP['toppage']) && !empty($SITE_TOP['toppage'])) :
         $array_chunk = array_chunk($SITE_TOP['toppage'], ceil(count($SITE_TOP['toppage'])/2), true);
        ?>
      <?php foreach ($array_chunk as $value) : ?>
      <nav class="footer_nav">
        <ul>
        <?php foreach ($value as $page) : ?>
          <li>
            <a href="<?php if (isset($page['link'])) echo anchor_wta(site_url($page['link'])); ?>">
              <?php if (isset($page['name'])) echo $page['name']; ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <?php endforeach; ?>
      <?php endif; ?>
      <!-- END FOOTER NAV -->

      <!-- FOOTER CONTACTS -->
      <?php if (isset($SITE_TOP['phones']) && !empty($SITE_TOP['phones'])) : ?>
      <div class="footer_contacts" itemscope itemtype="http://schema.org/Organization">
        <span itemprop="name" style="display:none;">Интернет-магазин Patifon</span>
        <p>
        <?php $count = count($SITE_TOP['phones']); foreach ($SITE_TOP['phones'] as $value) : ?>
          <a href="tel:+38<?php if($value['phone'] !== $SITE_TOP['phones'][$count-1]['phone']) echo $value['phone'] . ','; else echo $value['phone'];?>">
            <?php if($value['phone'] !== $SITE_TOP['phones'][$count-1]['phone']) echo $value['phone'] . ','; else echo $value['phone'];?>
          </a>
          <?php endforeach; ?>

          <a rel="nofollow" href="<?php echo anchor_wta(site_url('ajax/form/callback-form')); ?>" class="footer_make_call ownbox-form" rel="nofollow">
            <span>Заказать звонок</span>
          </a>
        </p>
      </div>
      <?php endif; ?>
      <!-- END FOOTER CONTACTS -->

      <!-- FOOTER SOCIAL -->
      <div class="footer_social">
        <!-- <img src="<?php echo resource_url('public/images/social_footer.png'); ?>" alt=""> --></div>
      <!-- END FOOTER SOCIAL -->

    </div>  
    <!-- END TOP FOOTER -->

    <!-- BOTTOM FOOTER -->
    <div class="footer__bottom">
      <!-- COPYRIGHT -->
      <p class="copyright">
      &copy;&nbsp;<?php echo date('Y'); ?>&nbsp;<?php echo ((isset($SITE_FOOTER['footerdata'][0]['text'])) ? $SITE_FOOTER['footerdata'][0]['text'] : '') ; ?>
        
      </p>
      <!-- END COPYRIGHT -->

      <!-- LOGO 32X32 -->
      <div class="logo32x32">
        <a href="http://32x32.com.ua/" class="image">
          <img src="<?php echo resource_url('public/images/32x32.png'); ?>" alt="Студия дизайна 32x32"></a>
        Разработан и поддерживается
        <br>
        в
        <a href="http://32x32.com.ua/">компании 32x32</a>
      </div>
      <!-- END LOGO 32X32 -->
    </div>
    <!-- END BOTTOM FOOTER -->
  </div>
  <!-- END CONTAINER -->
</footer>
<!-- END FOOTER -->


<!--ownbox-->
 <div id="ownbox">
  <div id="box"></div>
 </div>
<!--/ownbox -->

<!-- jQuery -->



<script type="text/javascript" language="JavaScript"> CI_ROOT = '<?php echo baseurl(); ?>';</script>
<script type="text/javascript" language="JavaScript"> CI_ROOT_LANG = '<?php echo site_url(); ?>';</script>

<script type="text/javascript" language="JavaScript" src="<?php echo site_url('public/js/js.cookie.js'); ?>"></script>

<script src="<?php echo resource_url('public/js/jquery-1.8.3.min.js'); ?>"></script>

<script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/own.main.js', array('js' => true)); ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/own.form.js', array('js' => true)); ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/own.box.js', array('js' => true)); ?>"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/own.cart.js', array('js' => true)); ?>"></script>

<!-- Скрипт Slick Slider -->
<script src="<?php echo resource_url('public/js/slick.min.js'); ?>"></script>

<!-- Скрипт Tabs -->
<script src="<?php echo resource_url('public/js/jquery.tabslet.min.js'); ?>"></script>

<!-- Скрипт BxSlider -->
<script src="<?php echo resource_url('public/js/jquery.bxslider.min.js'); ?>"></script>

<!-- Скрипт jCarousel -->
<script src="<?php echo resource_url('public/js/jcarousel.js'); ?>"></script>

<!-- Скрипт Таймера обратного отсчета -->
<script src="<?php echo resource_url('public/js/own.timer.js'); ?>"></script>

<!-- Скрипт стилизации select -->
<script src="<?php echo resource_url('public/js/jquery.selectric.min.js'); ?>"></script>

<!-- Скрипт Маски ввода -->
<script src="<?php echo resource_url('public/js/jquery.maskedinput.min.js'); ?>"></script>

<!-- Скрипт Rating -->
<script src="<?php echo resource_url('public/js/rating.js'); ?>"></script>

<script src="javascript/own.box.js"></script>
<!-- файл скриптов функционала -->
<!-- <script src="<?php echo resource_url('public/js/main.js'); ?>"></script> -->


<script>

$(document).ready(function() {
      $(".drop-text").mCustomScrollbar({
        axis: "y",
        scrollbarPosition: "outside"
      });
    });

    function footer() {
      if($('footer').length) {
        var $footerHeight = $('footer').outerHeight();

        $('main').css('padding-bottom', $footerHeight);
        $('footer').css('margin-top', -$footerHeight);
      }
    }

    $(function() {
      footer();


      // SLIDESHOW
      $('.bxmain').bxSlider({
          mode: 'fade',
          adaptiveHeight: true,
          controls: false,
          pagerCustom: '.bxpager'
        });

      $('.mobile_bxslider').bxSlider({
        
        adaptiveHeight: true,
        pager: false
      });

        $('.jcarousel').jcarousel({
          vertical: true
        });

       $('.jcarousel-left').on('jcarouselcontrol:active', function() {
          $(this).removeClass('disabled');
       }).on('jcarouselcontrol:inactive', function() {
          $(this).addClass('disabled');
       }).jcarouselControl({
          target: '-=1'
       });

       $('.jcarousel-right').on('jcarouselcontrol:active', function() {
          $(this).removeClass('disabled');
       }).on('jcarouselcontrol:inactive', function() {
          $(this).addClass('disabled');
       }).jcarouselControl({
          target: '+=1'
       });


      // TABS TABSLET

      $('.all_user_comments, .product--comm').click(function(){
        $('.tabs, .tabs_detail_product').tabslet({active: 3});
      });
      $('.tabs, .tabs_detail_product').tabslet({});
      $('.tabs, .tabs_detail_product').on("_after", function() {
        $('.tabs_content .photo').height($('.tabs_content .photo').width());
      });


      // МЕНЯЕМ МЕСТАМИ 
      $(window).resize(function(){
          if( $(this).outerWidth() < 980 ){
          $('.container_980').prepend($('.contact_phones_group'));  
          }   
      });

      $(window).resize(function(){
          if( $(this).outerWidth() < 800 ){
          $('.container_800').append($('.select_block')); 
          }   
      });

      $(window).resize(function(){
          if( $(this).outerWidth() < 700 ){
          $('.container_980').append($('.call_us'));  
          }   
      });

      $(window).resize(function(){
          if( $(this).outerWidth() < 599 ){
              $('.header__mobile--top').append($('.header--form'));

              $('.header--form input').focus(function(){
                $(this).css({
              'box-shadow': 'inset 0 -4px 2px -2px  #FDCD39'
            });

            $(this).closest('.header--form').css({
              'background': '#fff'
            });
            }
          );

          $('.header--form input').blur(function(){
              $(this).css({
              'box-shadow': 'none'
              });
              $(this).closest('.header--form').css({
                'background': 'transparent'
              });
            }
          );


          // МЕНЮ МОБ. ВЕРСИЯ
              $('.toggle_mobile_nav').click(
                function(){
                  $('body').css({
                  'overflow-y':'hidden'});  

                  $('.mobile_open_content').fadeIn(5);
              $('.mobile_open__mask').fadeIn(100);
                  $('.mobile_open_content__inner').addClass('mobile_o_c_inner_open');
                }
              );


              $('.mobile_open__mask').click(
                function(){
                  $('.mobile_open_content__inner').removeClass('mobile_o_c_inner_open');

                  $('.mobile_open_content').stop(true,true).delay(300).fadeOut(50);
                  $('body').css({
                  'overflow-y':''});
                }
              );


          $('.product_description').before($('.time_end_action'));
          
          $('.mobile_open_content__inner').append($('.add_nav'));
          $('.add_nav').after($('.mobile_op_cont_form'));
          $('.mobile_op_cont_form').after($('.contact_phones_group, .call_us'));
          $('.call_us').after($('.main_nav'));
          $('.main_nav').after($('.mobile_open_content--copyright'));
          $('.tabs_detail_product').append($('.tabs_list'));

          
          // SCROLL TO TOP
          //var a = $('.container_599').outerHeight();
          var a = $('header__mobile ').outerHeight();
          var b = $('h1').outerHeight();
          var c = $('.product_code').outerHeight();
          //var d = $('.container_599').outerHeight();
          var totalOuterHeight = a + b + c + 150;

          $('.horizontal a').click(function ()
          {
            $('body,html').animate({scrollTop: totalOuterHeight}, 800);
            //return false;
          });

          }   
      });

      $(window).resize();
      


      // SELECT Selectric
      $('select').selectric({
        //maxHeight: 180,
        responsive: true
      });


      // Маска ввода
      $('.buy_one_click__input').mask('+38 (999) 999–99–99');
      


          // КАРУСЕЛЬ ПРОДУКЦИИ
      $('.product_gallery').slick({
          dots: false,
        infinite: false,
        //autoplay: true,
          speed: 400,
          adaptiveHeight: true,
        slidesToShow: 5,
        slidesToScroll: 2,
          responsive: [
          {
              breakpoint: 901,
              settings: {
              slidesToShow: 4,
              slidesToScroll: 2
            }
          },

          {
              breakpoint: 701,
              settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
              breakpoint: 601,
              settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
          {
              breakpoint: 481,
              settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          ]
      });


      // РЕЙТИНГ
      $('.rating, .user_comment__rating').rating({
        image: '<?php echo baseurl();?>public/images/stars.png',
          loader: '<?php echo baseurl();?>public/images/star_loader.png',
          fx: 'float',
          minimal: 0,
            readOnly: true,
            url: ''
      });

      $('.rating--product').rating({
        image: '<?php echo baseurl();?>public/images/stars_big.png',
          loader: '<?php echo baseurl();?>public/images/star_loader_big.png',
          fx: 'float',
          minimal: 0,
            readOnly: true,
            url: ''
      });

      
      // СМЕНА ТЕКСТА, РАСКРЫТЫЕ/СВОРАЧИВАНИЕ БЛОКА
      $('.hide_show_description').toggle(
        function(){
          $('.description_content').css({'height':'auto'});
          $(this).text('Свернуть');
        },
        function(){
          $('.description_content').css({'height':''});
          $(this).text('Читать полностью');
        }
      );


      $(window).resize(function() {;
          footer();
          JcarouselResize();
          PhotoResize();
      });


      // ОПРЕДЕЛЕНИЕ ВЫСОТЫ КОНТЕЙНЕРА ВЕРТИК. КАРУСЕЛИ ПОСЛЕ ЗАГРУЗКИ ВСЕГО КОНТЕНТА
      $(window).load(function() {
        footer();
        JcarouselResize();
        PhotoResize();

        

        $('.jcarousel').height($('#bxslider').outerHeight() - 40);
        $('.bxpager-box').fadeIn(100);
      });

      /*
      $('.jcarousel').height($('#bxslider').outerHeight() - 40); 40 это 20px *2 см. ниже
        .jcarousel {
            margin: 20px 0;
        }
      */

      //compare region

    }); // Конец ready

    function JcarouselResize() {
      $('.jcarousel_main').height($('.bxslider_main').outerHeight() - 40);
      $('.jcarousel_main .bxpager').css('top', '0');
      $('.bxslider_main .bxpager-box').fadeIn(100);
    }

    function removeOption() {
      var id = $('select#select_v_1 option:selected').val();
      var id_product = $('#id_product').val();

      var pos = $('select#select_v_1 option:selected').data('pos');
      pos = Number(pos) + Number(1);
      
      $.ajax({
        url: 'cart/show_bay_option',
        type: 'POST',
        data: 'id=' + id,
        //dataType: "json",
        success: function (data) {
          try { data = $.parseJSON(data); } catch (e) { data = undefined; }
          if (typeof data.id === 'undefined' || data.id === null) return false;
          if (typeof data.price === 'undefined' || data.price === null) return false;
          if (typeof data.option === 'undefined' || data.option === null) return false;

          var number_position_paket = pos;

          // remove price
          $('.click_bay_1 span.select_block--add_price').detach();
          $('.click_bay_1').html('<span class="select_block--add_price">+' + data.price + ' грн. </span>');

          // remove bay option
          $('.click_bay_1 button.select_block--button').detach();
          $('.click_bay_1').append('<button class="select_block--button" onclick="cart_buy({id: ' + data.option + ', quantity: 1, color: 0, warranty: 1, id_product: ' + id_product + '}, 1);">Купить</button>');

          $('.fixed_paket_number').replaceWith('<a href="' + CI_ROOT_LANG + 'ajax/form/paket" class="what_is_it ownbox-form fixed_paket_number" data-post="object=' + id_product + '&active=' + number_position_paket + '"></a>');
          // $('.wrapper_select').append('<a href="' + CI_ROOT_LANG + 'ajax/form/paket" class="what_is_it ownbox-form fixed_paket_number" data-post="object=' + id_product + '&active=' + number_position_paket + '"></a>');
        }
     });
    }

    function removeOption2() {
      var id = $('select#select_v_2 option:selected').val();
      var id_product = $('#id_product').val();

      $.ajax({
        url: 'cart/show_bay_option',
        type: 'POST',
        data: 'id=' + id,
        //dataType: "json",
        success: function (data) {
          try { data = $.parseJSON(data); } catch (e) { data = undefined; }
          if (typeof data.id === 'undefined' || data.id === null) return false;
          if (typeof data.price === 'undefined' || data.price === null) return false;
          if (typeof data.option === 'undefined' || data.option === null) return false;
          
          // remove price
          $('.click_bay_2 span.select_block--add_price').empty();
          $('.click_bay_2').html('<span class="select_block--add_price">+' + data.price + ' грн. </span>');

          // remove bay option
          $('.click_bay_2 button.select_block--button').detach();
          $('.click_bay_2').append('<button class="select_block--button" onclick="cart_buy({id: ' + data.option + ', quantity: 1, color: 0, warranty: 1, id_product: ' + id_product + '}, 1);">Купить</button>');
        }
     });
    }

    function removeOption3() {
      var id = $('select#tabs_content--select_1 option:selected').val();
      var id_product = $('#id_product').val();
      
      $.ajax({
        url: 'cart/show_bay_option',
        type: 'POST',
        data: 'id=' + id,
        //dataType: "json",
        success: function (data) {
          try { data = $.parseJSON(data); } catch (e) { data = undefined; }
          if (typeof data.id === 'undefined' || data.id === null) return false;
          if (typeof data.price === 'undefined' || data.price === null) return false;
          if (typeof data.option === 'undefined' || data.option === null) return false;
          
          // remove price
          $('.add_tabs_option span.tabs_content--add_price').empty();
          $('.add_tabs_option span.tabs_content--add_price').html('<p><span class="tabs_content--add_price">+' + data.price + '&nbsp;грн</span></p>');

          // remove bay option
          $('.add_tabs_option button.tabs_content--button').detach();
          $('.add_tabs_option').append('<button class="tabs_content--button" onclick="cart_buy({id: ' + data.option + ', quantity: 1, color: 0, warranty: 1, id_product: ' + id_product + '}, 1);">Купить</button>');
        }
     });
    }

    $(document).on('click', 'input#product--det_check_1, input#product--det_check_99, input#product--det_check_2, input#product--det_check_3, input#product--det_check_4, input#product--det_check_5, input#product--det_check_6, input#product--det_check_7', function (e) {
        //e.preventDefault();
        var product_id = $(this).data('product');
        var compare_count = Cookies.get('compare_catalog');
        var thisitem = $(this).parent();
        var id_product = $('#id_product').val();

        if(compare_count == 0 || compare_count == 1) compare_count = 1;

          var id_object_inputs = $(this).parent().parent().find('#id_object_input').val();

          if(typeof compare_count == 'undefined') compare_count = 0;

        if($(this).prop("checked")){
          $(this).parent().empty();
          thisitem.html(function(){
             return '<input checked onclick="add_compare_object();" type="checkbox" id="product--det_check_' + id_object_inputs + '" class="product--det_check" data-product="' + product_id + '" href="<?php echo anchor_wta('add_to_compare'); ?>"><label for="product--det_check_' + id_object_inputs + '">Убрать из сравнения</label>';
         });

          $('.main_nav').find('.comprasion_link__count').empty();
          $('.main_nav').find('.comprasion_link__count').html('<i class="comprasion_link__count">' + (Number(compare_count) + Number(1)) +'</i>');
          setCookies(product_id);
        } else {
          $(this).parent().empty();
          thisitem.html(function(){
             return '<input onclick="add_compare_object();" type="checkbox" id="product--det_check_' + id_object_inputs + '" class="product--det_check" data-product="' + product_id + '" href="<?php echo anchor_wta('add_to_compare'); ?>"><label for="product--det_check_' + id_object_inputs + '">Добавить к сравнению</label>';
         });
          $('.main_nav').find('.comprasion_link__count').empty();
          $('.main_nav').find('.comprasion_link__count').html('<i class="comprasion_link__count">' + (compare_count - 1) + '</i>');
          deleteCookies(product_id);
        }
    });
    $(document).on('click', 'input.product--check', function (e) {
        var product_id = $(this).data('product');
        var compare_count = Cookies.get('compare_catalog');
        var thisitem = $(this).parent();
        var count_compare = $(this).parent().find('#count_compare').val();

        if(compare_count == 0 || compare_count == 1) compare_count = 1;

        if(typeof compare_count == 'undefined') compare_count = 0;

        if($(this).prop("checked")){
          $(this).parent().empty();
          thisitem.html(function(){
             return '<input type="checkbox" id="product--check_' + count_compare + '" class="product--check" checked data-product="' + product_id + '" href="' + CI_ROOT_LANG + 'compare"><label for="product--check_' + count_compare + '">Удалить</label>';
         });

          $('.main_nav').find('.comprasion_link__count').empty();
          $('.main_nav').find('.comprasion_link__count').html('<i class="comprasion_link__count">' + (Number(compare_count) + Number(1)) +'</i>');
          setCookies(product_id);
        } else {
          $(this).parent().empty();
          thisitem.html(function(){
             return '<input type="checkbox" id="product--check_' + count_compare + '" class="product--check" data-product="' + product_id + '" href="' + CI_ROOT_LANG + 'compare"><label for="product--check_' + count_compare + '">Сравнить</label>';
         });
          $('.main_nav').find('.comprasion_link__count').empty();
          $('.main_nav').find('.comprasion_link__count').html('<i class="comprasion_link__count">' + (compare_count - 1) + '</i>');
          deleteCookies(product_id);
        }
    });
  // function addd like for product one object
    var counter = 0;
    $(document).on('click', 'a.product--detail_like', function (e) {
        var product_id = $(this).parent().parent().find('#id_like_object').val();
        var compare_count = Cookies.get('compare_catalog');
        var thisitem = $(this).parent();
        var count_like = $(this).parent().parent().find('#count_like_for_object').val();
        var count_like_true = $(this).parent().parent().find('#count_like_for_object').val();
        var count_like_plus = Number(count_like) + Number(1);
        var old_count = (count_like - 1);

              counter = counter + 1;

        if ($(this).hasClass('active')) {
          $(this).parent().empty();

          if ($(this).hasClass('on')) count_like = count_like - 1;
          if ($(this).hasClass('new2')) {
            if(counter == 2) count_like = count_like_plus;
            if(counter  == 4) count_like = count_like_plus;
            if(counter  > 4) count_like = count_like_plus;
            if(counter == 3) count_like = count_like - 1;

            else count_like = count_like - 1;
          }

          thisitem.append(function(){
            return '<a class="product--detail_like operation-link new" href="' + CI_ROOT_LANG + 'ajax/operation/favorite" data-post="product=' + product_id + '"><span class="product--detail_like__quant">' + count_like + '</span></a>';
         });
        } else {
          $(this).parent().empty();

          if ($(this).hasClass('on')) count_like_plus = count_like_plus;
          if ($(this).hasClass('new')) {
            if(counter == 2)
              count_like_plus = count_like_plus - 1;
            if(counter == 4) count_like_plus = count_like_plus - 1;
            if(counter > 5) count_like_plus = count_like_plus - 1;
            else count_like_plus = count_like_plus;
          }

          thisitem.append(function(){
            return '<a class="product--detail_like operation-link active new2" href="' + CI_ROOT_LANG + 'ajax/operation/favorite" data-post="product=' + product_id + '"><span class="product--detail_like__quant">' + count_like_plus + '</span></a>';
         });
        }
    });

  function PhotoResize() {
      $('.section_photo:visible .photo').height($('.section_photo:visible .photo').width());
    }

    $(document).ready(function() { // TIMER

      // slide tabset - up position
      $('.new_tab').live('click', function() {
        // $('html, body').animate({ scrollTop: $('.review-form').offset().top }, 500);
      });
      // end slide

    <?php if(isset($SITE_CONTENT['object']['date_gift']) && !empty($SITE_CONTENT['object']['date_gift'])) : ?>
      <?php if ($SITE_CONTENT['object']['date_gift'] > date('Y-m-d')): ?>
      $.zTimer({
          day: 'sh_day',
          hour: 'sh_hour',
          minute: 'sh_min',
          second: 'sh_sec',
          weekOn: false,
          date: new Date(<?php echo strtotime($SITE_CONTENT['object']['date_gift']) * 1000; ?>)
           });

        $.zTimer('start');

        <?php endif; ?>
      <?php endif; ?>
        
      });

    $(document).ready(function () {

    // function hude contants tabs
      function hideContant(){
        $('#subs-all-view').hide();
        $('#subs-desc-view').hide();
        $('#subs-review-view').hide();
        $('#subs-photo-view').hide();
        $('#subs-video-view').hide();
        $('#subs-acc-view').hide();
        $('#sub-option-view').hide();
      }
    $('.section_comments .make_comment').click(function(){
        hideContant();
        $('#subs-review-view').show();
        $('.tabs_detail_product ul li').removeClass('active');
        $('.tabs_detail_product ul li.otvet').addClass('active');
        $('html, body').animate({ scrollTop: $('.review-form').offset().top }, 400);
    });
    $('.all_user_comments, .product--comm').click(function(){
        hideContant();
        $('#subs-review-view').show();
        $('.tabs_detail_product ul li').removeClass('active');
        $('.tabs_detail_product ul li.otvet').addClass('active');
        $('html, body').animate({ scrollTop: 140}, 400);
    });
    // scroll
    $('#up_page').click(function(){
      $('html, body').animate({ scrollTop: 0}, 1000);
    });
    $(window).on("scroll", function() {
      if ($(window).scrollTop() > 300) {
        $('#up_page').show(800);
      }
      else $('#up_page').hide(800);
      });
    // end scroll
    $('#subs-review-view .make_comment').click(function(){
        $('html, body').animate({ scrollTop: $('.review-form').offset().top }, 400);
    });
    $('.subs-all-view').click(function(){
        $('#tab-1').hide();
        $('#tab-2').show();
        $('.tabs .horizontal li').removeClass('active');
        $('.tabs .horizontal li.all').addClass('active');
    });
      // $('.mobile_phones_link').live('click', function(){
      //   $('html, body').animate({ scrollTop: $('.footer_contacts').offset().top }, 500);
      // });
      $('#like_slide_to_comments').live('click', function(){
        own_box_close();
        hideContant();
        $('#subs-review-view').show();
        $('.tabs_detail_product ul li').removeClass('active');
        $('.tabs_detail_product ul li.otvet').addClass('active');
        $('html, body').animate({scrollTop: 140},500);
      });
      $('a.all_filters_object').click(function(){
        hideContant();
        $('#subs-desc-view').show();
        $('.tabs_detail_product ul li').removeClass('active');
        $('.tabs_detail_product ul li.subs-desc-view').addClass('active');
        $('html, body').animate({scrollTop: 140},500);
      });
        

          $('.mobile_phones_link').live('click', function(){
            $('.more_phones').show('slow');
            $(this).hide();
          });

        });


  </script>

  <script type="text/javascript" language="JavaScript">
                    $(document).ready(function () {
                        $('.review-rating .star').mouseover(function () {
                            $(this).prevAll().children().css('background-position', '0 -15px');
                        }).mouseout(function () {
                            $(this).prevAll().children().css('background-position', '');
                        }).click(function () {
                            $('input[name=mark]', '.review-rating').val($(this).data('mark'));
                            $('.rttx', '.review-rating').text($(this).data('text'));
                            $('.review-rating .star a').removeClass('ac');
                            $(this).children().addClass('ac');
                            $(this).prevAll().children().addClass('ac');
                        });
                    });
                </script>
                <!-- mCustomScrollbar -->
                <link rel="stylesheet" type="text/css" href="<?php echo resource_url('public/style/mCustomScrollbar.css', array('css' => true)); ?>" />

                <script type="text/javascript" src="<?php echo resource_url('public/js/jquery.mCustomScrollbar.min.js', array('js' => true)); ?>"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $(".drtx").mCustomScrollbar({
                            axis: "y",
                            scrollbarPosition: "outside"
                        });
                    });
                </script>
                <!-- END mCustomScrollbar -->


                <script>
                  $(document).ready(function () {
                    var url_site = window.location.href;
                    var array_url_site = url_site.split(/[#]/);
                    var class_url_site_href = array_url_site[1];

                    if(typeof class_url_site_href != 'undefined') {
                      // var counter_tab = 7;
                      // for (var i = 1; i <= counter_tab; i++) {
                      //   $('#tab-detail_' + i).hide();
                      // };

                      $('#subs-all-view').hide();
                      $('#subs-desc-view').hide();
                      $('#subs-review-view').hide();
                      $('#subs-photo-view').hide();
                      $('#subs-video-view').hide();
                      $('#subs-acc-view').hide();
                      $('#sub-option-view').hide();

                      var tab_index_active = class_url_site_href.split(/[_]/);
                      var this_tab_index = tab_index_active[1];

                      $('.tabs_detail_product ul li').removeClass('active');
                      $('.tabs_detail_product ul li.' + class_url_site_href).addClass('active');

                      $('#' + class_url_site_href).show();
                    }

                      $('.new_tab').live('click',function(){
                        var link = $(this).attr("href");
                        var array = link.split(/[#]/);
                        var new_class_href = array[1];

                        $('#' + new_class_href).show(10);

                          return true;
                      });

                      var counter_commenys = $('#thispage').val();
                      $('.pagination span.active_ajax').live('click', function(){
                        // total var
                        var count_element_li = 5;
                        var total_page = $('#total_page').val();
                        var last_element_el = $('ul.list li.element:last');
                        var last_element_el_number = last_element_el.data('post');
                        var last_element_el_number_plus = Number($('.element:last a').data('post')) + Number(1);
                        var last_min_page_count = total_page - 2;
                        // end total var

                        var id = $('#id_product').val();
                        var link = $(this);
                        var page = counter_commenys;
                        var countpage = $('#countpage').val();

                        var first_page = $('#thispage').val() - 1;

                        var category = $('#category').val();
                        var link_product = $('#link_product').val();

                        // var objects
                          var NextPage = '<a href="javascript:void(0);" class="next disabled">Следующая<i class="icon"></i></a>';
                          var button_contant = '<button class="button disabled" disabled="disabled"><i class="icon"></i><span class="name">Показать еще отзывы</span></button>';
                        // end var objects

                        $.ajax({
                          url: CI_ROOT_LANG + 'ajax/comment/' + page,
                          type: 'POST',
                          data: 'id=' + id,
                          success: function (data) {
                            if(first_page == 1) {
                              if(counter_commenys > 4){
                                $('.ajax_page_' + page).replaceWith('<li class="item selected del_el_' + page + '">' + page + '</li>');
                                if(total_page > 3) $('ul.list li.item').filter(':first').replaceWith('<li class="item selected">1 ... </li>');
                                $('#subs-review-view div.user_comment').filter(':last').append(data);

                                  var li_element = '<li class="item ajax_page_' + last_element_el_number_plus + ' element"><a href="' + CI_ROOT_LANG + 'catalog/' + category + '/' + link_product + '/page/' + last_element_el_number_plus + '.html#subs-review-view" data-post="' + last_element_el_number_plus + '" class="link">' + last_element_el_number_plus + '</a></li>';
                                  if(total_page > 3) $(li_element).insertAfter(last_element_el);

                                  if(page == total_page) {
                                    $('.tabs_content span').removeClass('.active_ajax');
                                    $('.tabs_content button').replaceWith(button_contant);
                                    $('.pagination .next').replaceWith(NextPage);
                                  }

                                  if(total_page == 5){
                                    $('.last_page').hide();
                                    if(counter_commenys == 5) {
                                      $('.ajax_page_6').hide();
                                    }
                                  } if(total_page == 4){
                                    $('.last_page').hide();
                                    if(counter_commenys == 4) {
                                      $('.ajax_page_5').hide();
                                    }
                                  } if(total_page == 3){
                                    $('.last_page').hide();
                                    if(counter_commenys == 3) {
                                      $('.ajax_page_4').hide();
                                      $('.ajax_page_5').hide();
                                    }
                                  } if(total_page == 2){
                                    $('.last_page').hide();
                                    if(counter_commenys == 2) {
                                      $('.ajax_page_3').hide();
                                    }
                                  }

                                if(total_page > 2){
                                  if(counter_commenys > 5){
                                    var del_orev_page = counter_commenys - 4;
                                    $('ul.list li.del_el_' + del_orev_page).hide();
                                  } if(counter_commenys > last_min_page_count){
                                    if(total_page == (Number(counter_commenys) - Number(1))){
                                      var size_li = $('.del_el_' + total_page).size();
                                      if(size_li >= 2) $('.del_el_' + total_page).filter(":last").hide();
                                      $('a.next').replaceWith('<a href="#" class="next disabled">Следующая<i class="icon"></i></a>');
                                      $('.pagination span.name'). removeClass();
                                    }
                                    var last_last_page_1 = Number(total_page) + Number(1);
                                    var last_last_page_2 = Number(total_page) + Number(2);
                                    $('ul.list li.ajax_page_' + last_last_page_1).hide();
                                    $('ul.list li.ajax_page_' + last_last_page_2).hide();
                                    $('.last_page').hide();
                                  }
                                }
                              } else {
                                $('.ajax_page_' + page).replaceWith('<li class="item selected del_el_' + page + '">' + page + '</li>');
                                $('#subs-review-view div.user_comment').filter(':last').append(data);
                                
                                  var li_element = '<li class="item ajax_page_' + last_element_el_number_plus + ' element"><a href="' + CI_ROOT_LANG + 'catalog/' + category + '/' + link_product + '/page/' + last_element_el_number_plus + '.html#subs-review-view" data-post="' + last_element_el_number_plus + '" class="link">' + last_element_el_number_plus + '</a></li>';
                                  if(total_page > 3) $(li_element).insertAfter(last_element_el);

                                  if(page == total_page) {
                                    $('.tabs_content span').removeClass('.active_ajax');
                                    $('.tabs_content button').replaceWith(button_contant);
                                    $('.pagination .next').replaceWith(NextPage);
                                  }
                                  
                                  if(total_page == 5){
                                    if(counter_commenys == 5) {
                                      $('.ajax_page_6').hide();
                                    } if(counter_commenys == 4) {
                                      $('.last_page').hide();
                                    }
                                  } if(total_page == 4){
                                    $('.last_page').hide();
                                    if(counter_commenys == 4) {
                                      $('.ajax_page_5').hide();
                                    }
                                  } if(total_page == 3){
                                    $('.last_page').hide();
                                    if(counter_commenys == 3) {
                                      $('.ajax_page_5').hide();
                                      $('.ajax_page_4').hide();
                                    }
                                  } if(total_page == 2){
                                    $('.last_page').hide();
                                    if(counter_commenys == 2) {
                                      $('.ajax_page_3').hide();
                                      $('.ajax_page_4').hide();
                                    }
                                  }
                                
                              }
                            } else {
                              if(counter_commenys > 3){
                                $('.ajax_page_' + page).replaceWith('<li class="item selected del_el_' + page + '">' + page + '</li>');
                                $('ul.list li.item').filter(':first').replaceWith('<li class="item ajax_page_1 element"><a href="' + CI_ROOT_LANG + 'catalog/' + category + '/' + link_product + '/page/1.html#subs-review-view" data-post="1" class="link">1 ... </a></li>');
                                $('#subs-review-view div.user_comment').filter(':last').append(data);

                                  var li_element = '<li class="item ajax_page_' + last_element_el_number_plus + ' element"><a href="' + CI_ROOT_LANG + 'catalog/' + category + '/' + link_product + '/page/' + last_element_el_number_plus + '.html#subs-review-view" data-post="' + last_element_el_number_plus + '" class="link">' + last_element_el_number_plus + '</a></li>';
                                  if(total_page > 3) $(li_element).insertAfter(last_element_el);

                                  if(page == total_page) {
                                    $('.tabs_content span').removeClass('.active_ajax');
                                    $('.tabs_content button').replaceWith(button_contant);
                                    $('.pagination .next').replaceWith(NextPage);
                                  }

                                  if(total_page == 4){
                                    $('.last_page').hide();
                                    if(counter_commenys == 4) {
                                      $('.ajax_page_5').hide();
                                    }
                                  } if(total_page == 3){
                                    $('.last_page').hide();
                                    if(counter_commenys == 3) {
                                      $('.ajax_page_4').hide();
                                    }
                                  } if(total_page == 2){
                                    $('.last_page').hide();
                                    if(counter_commenys == 2) {
                                      $('.ajax_page_3').hide();
                                    }
                                  }

                                if(counter_commenys > 5){
                                  if(first_page => 2){
                                    var del_orev_page = counter_commenys - 4;
                                    $('ul.list li.ajax_page_' + del_orev_page).hide();
                                    $('ul.list li.del_el_' + del_orev_page).hide();
                                  } else {
                                    var del_orev_page = counter_commenys - 4;
                                  $('ul.list li.del_el_' + counter_commenys).hide();
                                  }
                                } if(counter_commenys > last_min_page_count){
                                  if(total_page == (Number(counter_commenys) - Number(1))){
                                    var size_li = $('.del_el_' + total_page).size();
                                    if(size_li >= 2) $('.del_el_' + total_page).filter(":last").hide();
                                    $('a.next').replaceWith('<a href="#" class="next disabled">Следующая<i class="icon"></i></a>');
                                    $('.pagination span.name').removeClass();
                                  }
                                  var last_last_page_1 = Number(total_page) + Number(1);
                                  var last_last_page_2 = Number(total_page) + Number(2);
                                  var last_last_page_3 = Number(total_page) + Number(3);

                                  $('ul.list li.ajax_page_' + last_last_page_1).hide();
                                  $('ul.list li.ajax_page_' + last_last_page_2).hide();
                                  $('ul.list li.ajax_page_' + last_last_page_3).hide();
                                  $('.last_page').hide()
                                }
                              } else {
                                $('.ajax_page_' + page).replaceWith('<li class="item selected del_el_' + page + '">' + page + '</li>');
                                $('#subs-review-view div.user_comment').filter(':last').append(data);

                                var li_element = '<li class="item ajax_page_' + last_element_el_number_plus + ' element"><a href="' + CI_ROOT_LANG + 'catalog/' + category + '/' + link_product + '/page/' + last_element_el_number_plus + '.html#subs-review-view" data-post="' + last_element_el_number_plus + '" class="link">' + last_element_el_number_plus + '</a></li>';
                                if(total_page > 3) $(li_element).insertAfter(last_element_el);

                                if(page == total_page) {
                                    $('.tabs_content span').removeClass('.active_ajax');
                                    $('.tabs_content button').replaceWith(button_contant);
                                    $('.pagination .next').replaceWith(NextPage);
                                  }

                                if(total_page == 4){
                                    $('.last_page').hide();
                                    if(counter_commenys == 4) {
                                      $('.ajax_page_5').hide();
                                    }
                                  } if(total_page == 3){
                                    $('.last_page').hide();
                                    if(counter_commenys == 3) {
                                      $('.ajax_page_4').hide();
                                    }
                                  } if(total_page == 2){
                                    $('.last_page').hide();
                                    if(counter_commenys == 2) {
                                      $('.ajax_page_3').hide();
                                    }
                                  }
                              }
                            }
                          }
                       });

                        counter_commenys = (Number(counter_commenys) + Number(1));
                      });
                  

          // select osnovnoye
                  $('.tabs .horizontal li.all').addClass('active');
          // end select
          // create insert price in block informer
          var new_price = $('#new_price_informer').val();
          $('#price_product_uah').text(' +' + new_price + ' грн.');
          
                });

</script>


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter34708555 = new Ya.Metrika({
                    id:34708555,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/34708555" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

  </body>
</html>