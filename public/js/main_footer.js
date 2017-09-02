function footer() {
      if($('footer').length) {
        var $footerHeight = $('footer').outerHeight();

        $('main').css('padding-bottom', $footerHeight);
        $('footer').css('margin-top', -$footerHeight);
      }
    }

    $(function() {
      footer();

      $('.header--form input').focus(function(){
          $(this).closest('.header--form').css({
            'background': '#fff'
          });

          $('.header--form button').removeClass('button_1').addClass('button_2'); 
        }
      );

      $('.header--form input').blur(function(){
          $(this).closest('.header--form').css({
            'background': '#dddddd'
          });

          $('.header--form button').removeClass('button_2').addClass('button_1');
        }
      );


      // SLIDESHOW
      $('.bxslider_main .bxmain').bxSlider({
          mode: 'fade',
          adaptiveHeight: true,
          controls: false,
          pagerCustom: '.bxslider_main .bxpager'
        });

        $('.bxslider_main .jcarousel').jcarousel({
          vertical: true
        });

       $('.bxslider_main .jcarousel-left').on('jcarouselcontrol:active', function() {
          $(this).removeClass('disabled');
       }).on('jcarouselcontrol:inactive', function() {
          $(this).addClass('disabled');
       }).jcarouselControl({
          target: '-=1'
       });

       $('.bxslider_main .jcarousel-right').on('jcarouselcontrol:active', function() {
          $(this).removeClass('disabled');
       }).on('jcarouselcontrol:inactive', function() {
          $(this).addClass('disabled');
       }).jcarouselControl({
          target: '+=1'
       });


      // TABS TABSLET
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

        

        //$('.jcarousel_second').height($('.bxslider_second').outerHeight() - 40);
        //$('.bxslider_second .bxpager-box').fadeIn(100);
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
          $('.click_bay_1 span.select_block--add_price').detach();
          $('.click_bay_1').html('<span class="select_block--add_price">+' + data.price + ' грн. </span>');

          // remove bay option
          $('.click_bay_1 button.select_block--button').detach();
          $('.click_bay_1').append('<button class="select_block--button" onclick="cart_buy({id: ' + data.option + ', quantity: 1, color: 0, warranty: 1, id_product: ' + id_product + '}, 1);">Купить</button>');
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

          var id_object_inputs = $(this).parent().parent().find('#id_object_input').val();

        if($(this).prop("checked")){
          $(this).parent().empty();
          thisitem.html(function(){
             return '<input checked onclick="add_compare_object();" type="checkbox" id="product--det_check_' + id_object_inputs + '" class="product--det_check" data-product="' + product_id + '" href="<?php echo anchor_wta('add_to_compare'); ?>"><label for="product--det_check_' + id_object_inputs + '">Убрать из сравнения</label>';
         });
          setCookies(product_id);
        } else {
          $(this).parent().empty();
          thisitem.html(function(){
             return '<input onclick="add_compare_object();" type="checkbox" id="product--det_check_' + id_object_inputs + '" class="product--det_check" data-product="' + product_id + '" href="<?php echo anchor_wta('add_to_compare'); ?>"><label for="product--det_check_' + id_object_inputs + '">Добавить к сравнению</label>';
         });
          deleteCookies(product_id);
        }
    });
    $(document).on('click', 'input.product--check', function (e) {
        var product_id = $(this).data('product');
        var compare_count = Cookies.get('compare_catalog');
        var thisitem = $(this).parent();
        var count_compare = $(this).parent().find('#count_compare').val();

        if($(this).prop("checked")){
          $(this).parent().empty();
          thisitem.html(function(){
             return '<input type="checkbox" id="product--check_' + count_compare + '" class="product--check" checked data-product="' + product_id + '" href="' + CI_ROOT_LANG + 'compare"><label for="product--check_' + count_compare + '">Удалить</label>';
         });
          setCookies(product_id);
        } else {
          $(this).parent().empty();
          thisitem.html(function(){
             return '<input type="checkbox" id="product--check_' + count_compare + '" class="product--check" data-product="' + product_id + '" href="' + CI_ROOT_LANG + 'compare"><label for="product--check_' + count_compare + '">Сравнить</label>';
         });
          deleteCookies(product_id);
        }
    });
  // function addd like for product one object
  var counter = 0;
    $(document).on('click', 'a.product--detail_like', function (e) {
        var product_id = $('#id_product').val();
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

  $('a.all_user_comments').click(function(){
    //window.click('', '');
  })

  function PhotoResize() {
      $('.section_photo:visible .photo').height($('.section_photo:visible .photo').width());
    }

    $(document).ready(function() { // TIMER
      $.zTimer({
          day: 'sh_day',
          hour: 'sh_hour',
          minute: 'sh_min',
          second: 'sh_sec',
          weekOn: false,
          date: new Date(<?php echo strtotime($SITE_CONTENT['object']['date_gift']) * 1000; ?>)
           });

        $.zTimer('start');
      });