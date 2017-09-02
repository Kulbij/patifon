
$(document).ready(function () {

    $('.input-pattern').on('click', function () {
        $(this).hide();
        $(this).prev().trigger('focus');
    });

    $('input[type=text], textarea, .select2').on('focus', function () {        
        $(this).removeClass('er');
        if ($(this).next().hasClass('input-pattern')) {
            $(this).next().hide();
        }
    }).on('blur', function () {
        if ($(this).next().hasClass('input-pattern')) {
            if (!$(this).val().length) {
                $(this).next().show();
            }
        }
    });
    //select2 region
    $('.fmbx').on('select2:open', '[name=city], [name=point]', function(){        
        $(this).removeClass('er');
    });
    //end select2 region
    $('textarea').trigger('blur');
    $('input[type=text]').trigger('blur');

    var $sender = false;
    $('.ajax-form').live('click', function (e) {
        e.preventDefault();

        var but = $(this);
        var $form = $(this).closest('form');
        form_unsetErrors($form);

        if (!$sender) {
            $sender = true;
            if (but.data('request') == 'wait' && but.data('value')) {

                but
                        .attr('disabled', 'disabled')
                        .val('Отправляется...');

            }

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                async: true,
                data: $form.serialize(),
                success: function ($data) {
                    try {
                        $data = $.parseJSON($data);
                    } catch (ex) {
                        $data = undefined;
                    }

                    if (typeof $data !== 'undefined' && $data !== null) {

                        if ('success' in $data && $data.success) {
                            $form.find('.form-success').html($data.success).show();
                        }

                        if ('errors' in $data) {

                            if ($data.errors)
                                $form.find('.form-error').html($data.errors).show();

                        }

                        if ('refresh' in $data && $data.refresh) {

                            window.location.reload();
                            return true;

                        } else if ('redirect' in $data && $data.redirect) {

                            window.location = $data.redirect;
                            return true;

                        } else if ('okey' in $data && $data.okey) {

                            $form[0].reset();
                            form_showOkeyWindow(5000);

                        } else if ('is_err' in $data) {                            
                            form_setErrors($form, $data);

                        }

                    }

                    $sender = false;
                    if (but.data('request') == 'wait' && but.data('value')) {

                        but
                                .removeAttr('disabled')
                                .val('Оформить заказ');

                    }

                },
                error: function () {

                    $sender = false;
                    if (but.data('request') == 'wait' && but.data('value')) {

                        but
                                .removeAttr('disabled')
                                .val('Оформить заказ');

                    }

                }
            });
        }

        return false;
    });

    //operation

    $('.operation-link').live('click', function (e) {
        e.preventDefault();

        var elem = $(this);

        $.ajax({
            url: elem.attr('href'),
            type: 'POST',
            async: false,
            data: elem.data('post'),
            dataType: 'json',
            success: function (data) {

                if (typeof data !== 'undefined' && data !== null) {

                    if ('remove_class' in data && data.remove_class) {
                        elem.removeClass(data.remove_class);
                    } else if ('add_class' in data && data.add_class) {
                        elem.addClass(data.add_class);
                    }

                    if ('fav_count' in data) {
                        elem.find('.liknm').html(data.fav_count);
                    }

                    if ('elem' in data && 'elem_text' in data && data.elem && data.elem_text) {
                        $(data.elem).html(data.elem_text);

                        if ('elem_link' in data && data.elem_link)
                            $(data.elem).attr('href', data.elem_link);
                    }

                    if (typeof elem.data('compare') !== 'undefined')
                        elem.closest('.compare-item').remove();

                }

            }
        });

    });

    //end operation

});

function form_setErrors($form, $data) {
    for (var $key in $data) {
        if (typeof $data[$key] !== 'undefined' && $data[$key] !== null) {
            //if ($form.find('[name=' + $key + ']').prop('tagName') == 'SELECT'){                
              //  $form.find('[name=' + $key + ']').closest('.block-s3elect').find('.select-status').show();
            //}else{
                $form.find('[name=' + $key + ']').addClass('er');
            //}
        }

    }

}

function form_unsetErrors($form) {
    $form.find('.form-success').empty().hide();
    $form.find('.form-error').empty().hide();
    $form.find('.form-error2').empty().hide();
    $form.find('.select-status').hide();
    $form.find('.er').removeClass('er');
}

function form_showOkeyWindow(autoclose) {

    autoclose = (typeof autoclose === 'undefined') ? false : parseInt(autoclose, 10);

    own_box_show(CI_ROOT + 'ajax/form/success', '', autoclose);
}