//OWNBOX region

var __ownbox_mask = '<div id="ownbox-mask"></div>';

var __ownbox_sender = false;
$('.ownbox-form').live('click', function(e){
 e.preventDefault();

 var link = $(this);
 var post_data = '';
 if (typeof link.data('post') !== 'undefined' && link.data('post') !== null) post_data = link.data('post');

 own_box_show($(this).attr('href'), post_data);

 return false;
});

$('.ownbox-close, #ownbox-mask').live('click', function(e){
 e.preventDefault();

 own_box_close();
});

function own_box_show(link, param, autoclose) {
 
 link = typeof link !== 'undefined' ? link : '';
 param = typeof param !== 'undefined' ? param : '';
 autoclose = typeof autoclose !== 'undefined' ? autoclose : false;

 if (!__ownbox_sender && link) {
  __ownbox_sender = true;

  $.ajax({
   url: link,
   type: 'POST',
   data: param,
   success: function(data) {

    if (typeof data !== 'undefined' && data !== null) {

     $('#ownbox-mask').trigger('click');
     $('#ownbox #box').html(__ownbox_mask + data);

     $('body').on({
      'mousewheel': function(e) {
       e.preventDefault();
       e.stopPropagation();
      }
     });

     $('html').addClass('ownbox-lock');
     $('#ownbox').show();

     own_box_update();

     if (autoclose) {
      setTimeout(function(){
        own_box_close();
      }, 5000);
     }

    }

    __ownbox_sender = false;

   },
   error: function() {
    __ownbox_sender = false;
   }
  });

 }

}

function own_box_close() {
 
 $('body').off('mousewheel');

 $('#ownbox').hide();
 $('html').removeClass('ownbox-lock');
 $('#ownbox #box').empty();
 
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

//this is the end ... */