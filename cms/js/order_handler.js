$(document).ready(function() {
    $(document).live('click', function(e){        
       if (!$(e.target).hasClass('drop-menu')) {           
          $('.status-drop').hide();
          $('.status-main').removeClass('active');
      }
      });      
});

function open_statuses(e) {
    if ($(e).parent().next('div').css('display') == 'none') {
        $('.status-drop').hide();
        $('.status-main').removeClass('active');
        $(e).parent().next('div').show();
    } else {
        $(e).parent().next('div').hide();
    }
    $(e).parent().toggleClass('active');    
}
function hide_statuses(e) {
    $(e).parent().parent().prev().toggleClass('active');
    console.log('hide');
    $(e).parent().parent().hide();
}
function change_status(e) {    
    var item = $(e).data('item');
    var status = $(e).data('status');
    $('#item').val(item);
    $('#status').val(status);
    $('#order_status').submit();
}
function change_status_email(e) {    
    var item = $(e).data('item_email');
    var status = $(e).data('status_email');
    var email = $(e).data('email');

    if(status == 1){
        if(typeof email == 'undefined' || email == ''){
            alert('E-mail отсутствует!')
            return;
        }
    }

    $('#item_email').val(item);
    $('#status_email').val(status);
    $('#email').val(email);
    $('#order_status_email').submit();
}
function change_payment(e) {        
    var item = $(e).data('item');
    var status = $(e).data('status');
    $('#order_item').val(item);
    $('#payment').val(status);
    $('#order_payment').submit();
}