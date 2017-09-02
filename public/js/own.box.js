//OWNBOX region

var __ownbox_close_handler = void(0);


var __ownbox_mask = '<div id="ownbox-mask"></div>';

var __ownbox_sender = false;

$('.ownbox-form').live('click', function(e){
 e.preventDefault();

 if (typeof window[$(this).data('before')] === 'function') window[$(this).data('before')]($(this));

 var link = $(this);
 var post_data = void(0);
 var autoclose = void(0);
 if (typeof link.data('post') !== 'undefined' && link.data('post') !== null) post_data = link.data('post');
 if (typeof link.data('autoclose') !== 'undefined' && link.data('autoclose') !== null && parseInt(link.data('autoclose'), 10) > 0) autoclose = parseInt(link.data('autoclose'), 10);

 var index_data = link.data('post');

 if(typeof index_data == 'undefined'){
  var own_index_count_image = 0;
 } else {
  var text = index_data;
  var arr = text.split(/[&:]/);
  var index_arr = arr[1];
  var true_index_image = index_arr.split(/[=:]/);
  var own_index_count_image = true_index_image[1];
 }

 own_box_show(link.attr('href'), post_data, autoclose, own_index_count_image);

 return false;
});

$('.ownbox-close, #ownbox-mask').live('click', function(e){
 e.preventDefault();

 own_box_close();
});

function own_box_show(link, param, autoclose, own_index_count_image) {

 link = typeof link !== 'undefined' ? link : '';
 param = typeof param !== 'undefined' ? param : '';
 autoclose = typeof autoclose !== 'undefined' ? autoclose : false;

 if (!__ownbox_sender && link) {
  clearTimeout(__ownbox_close_handler);
  __ownbox_sender = true;

  $('#ownbox #box').html('<div class="ownbox-loader" style="position: absolute; top: 50%; left: 50%; width: 24px; height: 24px; margin: -22px 0 0 -22px; padding: 10px; background: rgba(0, 0, 0, .9); border-radius: 5px;"><img src="' + CI_ROOT + 'public/images/data/ownbox/loading.gif" alt="loading"></div>');
  // own_box_load_style(CI_ROOT + 'public/style/form.css');

  $.ajax({
   url: link,
   type: 'POST',
   data: param,
   success: function(data) {
    

    if (typeof data !== 'undefined' && data !== null && data.length) {

     own_box_close();
     $('#ownbox #box').html(__ownbox_mask + data);

     $('body').on({
      mousewheel: function(e) {

       if (!$(e.target).closest('#ownbox').length) {
        e.preventDefault();
        e.stopPropagation();
       }

      },
      keyup:  function(e) {

       if (e.keyCode == 27) {
        own_box_close();
       }

      }
     });

     $('html').addClass('ownbox-lock');
     $('#ownbox').css('display', 'block');

     own_box_update();

     if (autoclose) {
      __ownbox_close_handler = setTimeout(function(){
        own_box_close();
      }, autoclose);
     }

    }

    __ownbox_sender = false;

   },
   error: function() {
    __ownbox_sender = false;
   }
  }).done(function() {
    PatifonSlider(own_index_count_image); // The body of the function at the end of file.
  });

 }

}

function own_box_close() {

 $('body').off('mousewheel').off('keyup');

 $('#ownbox').hide();
 $('html').removeClass('ownbox-lock');
 $('#ownbox #box').empty();

 if (typeof __ownbox_close_handler !== 'undefined') clearTimeout(__ownbox_close_handler);

 return true;
}

function own_box_update() {
 if ($('#ownbox #box > .ownbox-content').length &&
     $('#ownbox').css('display') == 'block'
    ) {

  var __elem = $('#ownbox #box > .ownbox-content').first();
  var __height = __elem.outerHeight();
  var __top = ($('#ownbox #box').height() - $('#ownbox #box > .ownbox-content').outerHeight()) / 2;

  if ($('#ownbox #box').height() > __height) {

   __elem.css('top', __top);

  } else {

   __elem.css('top', '');

  }

 }
}

// function own_box_load_style(css) {

//  if (typeof css !== 'undefined' && !$('#form-style').length) {

//   var head = document.getElementsByTagName('head')[0],
//       link = document.createElement('link');

//   link.type = 'text/css';
//   link.rel = 'stylesheet';
//   link.href = css;
//   link.id = 'form-style';

//   head.appendChild(link);

//   link.onload = function() {
//    own_box_update();
//   }

//  }

// }

$(window).load(function(){
 own_box_update();
});

$(window).resize(function(){
 own_box_update();
});

//this is the end ... */

// User script 

function PatifonSlider(image_index) { // The function for the site Patifon
  

      slider = $('.bxslider_second .bxmain').bxSlider({
        mode: 'fade',
        adaptiveHeight: true,
        prevText: '',
        nextText: '',
        pagerCustom: '.bxslider_second .bxpager'
      });
      slider.goToSlide(image_index);


      $('.bxslider_second .jcarousel').jcarousel({
        vertical: true
      });

     $('.bxslider_second .jcarousel-left').on('jcarouselcontrol:active', function() {
        $(this).removeClass('disabled');
     }).on('jcarouselcontrol:inactive', function() {
        $(this).addClass('disabled');
     }).jcarouselControl({
        target: '-=1'
     });

     $('.bxslider_second .jcarousel-right').on('jcarouselcontrol:active', function() {
        $(this).removeClass('disabled');
     }).on('jcarouselcontrol:inactive', function() {
        $(this).addClass('disabled');
     }).jcarouselControl({
        target: '+=1'
     });

  $('.bxslider_second .bx-viewport').height($('.bxslider_second .bx-wrapper').width());
  $('.bxslider_second .bx-viewport .bxitem').width($('.bxslider_second .bx-wrapper').width());
  $('.bxslider_second .jcarousel').height($('.bxslider_second .bx-viewport').height() - 40);
  $('.bxslider_second .bxpager').css('top', 0);
  $('.bxslider_second .bxpager-box').fadeIn(100);

  return slider;
}