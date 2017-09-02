$(document).on('click', '.itvral', function () {
    $('.cnnx').trigger('click');
});
$(document).on('click','.mCSB_container', function (e) {
    e.stopPropagation();
});
//$(document).on('click','.search-drop-down',function(e){
//   e.stopPropagation(); 
//});
//$(document).on('click',function(e){
//    if(e.target.className !== 'search-drop-down' && e.target.className !== 'srtx'){
//      // $('.search-drop-down').hide();
//    }
//});
$(document).on('click',function(e){
    if(e.target.className !== 'inlk product-info'){
       $('.indr').hide();
    }
});
$(document).ready(function () {

    $('.tbrw', '.prmnls').each(function () {
        $(this).find('.drop-menu:first').show();
        var first = $(this).find('.menu-link:first');
        if ($('.rwcol[data-menu="' + first.data('menu') + '"]').length > 0) {
            first.addClass('ac');
        }
    });

    $('.menu-link').hover(
            function () {
                var container = $(this).closest('.tbrw');
                container.find('.ac').removeClass('ac');
                $('.drop-menu').hide();

                container.find('.drop-menu:first').hide();
                container.find('.menu-link:first').removeClass('ac');
                if ($('.drop-menu[data-menu="' + $(this).data('menu') + '"]').length > 0) {
                    $(this).addClass('ac');
                    $('.drop-menu[data-menu="' + $(this).data('menu') + '"]').show();
                }

            },
            function () {
                //$(this).removeClass('ac');
                //$('.drop-menu[data-menu="' + $(this).data('menu') + '"]').hide();
//                var container = $(this).closest('.tbrw');
//                container.find('.drop-menu:first').show();
//                if ($('.drop-menu[data-menu="' + $(this).data('menu') + '"]').length > 0) {
//                    container.find('.menu-link:first').addClass('ac');
//                }
            }
    );
    $('.itdr').mouseleave(function () {
        $('.drop-menu').hide();
        var el = $(this).find('a.ac');
        el.removeClass('ac');

        var first = $(this).find('.menu-link:first');
        if ($('.rwcol[data-menu="' + first.data('menu') + '"]').length > 0) {
            $('.rwcol[data-menu="' + first.data('menu') + '"]').show();
            first.addClass('ac');
        }
    });
    $('.toggle-all-text').on('click', function () {
        if ($('.dctx').hasClass('short')) {
            $('.dctx').removeClass('short');
            $(this).text('Скрыть текст');
        } else {
            $('.dctx').addClass('short');
            $(this).text('Чиатать полностью');
        }
        /* end OBJECT PAGE */
    });
    //catalog more button

    $('.pg').on('click', '.catalog-more', function () {

        var button = $(this);

        $.ajax({
            url: CI_ROOT + 'catalog/' + $('input[name=catalog_more_category]').val() + '/filter/' + $('input[name=catalog_more_parametter]').val(),
            type: 'POST',
            async: false,
            data: 'ajax=true',
            success: function (data) {
                try {
                    data = $.parseJSON(data);
                } catch (ex) {
                    data = void(0);
                }

                if (typeof data !== 'undefined' && data !== null) {

                    if ('page_current' in data && data.page_current > 0) {
                        data.page_current = parseInt(data.page_current, 10);

                        $('[name=catalog_more_parametter_page]').val(data.page_current);
                        var inelem = $('.pgls .lsit[data-page=' + data.page_current + ']').first();

                        if (typeof inelem !== 'undefined' && inelem.length) {
                            inelem.addClass('ac').text(inelem.find('a').text());

                            if (data.page_current == parseInt($('[name=catalog_more_parametter_page_last]').val(), 10)) {
                                $('.pg .pgnx').addClass('db').attr('href', 'javascript:void(0);');
                            }

                        }
                    }

                    if ('view' in data && data.view.length && $('#div_catalog_more').length)
                        $('#div_catalog_more').append(data.view);

                    if (!('page_next_true' in data) || !data.page_next_true) {
                        button.attr('disabled', 'disabled');
                        button.addClass('db');
                        $('#div-catalog-more-button').remove();
                    }

                    if ('page_next_link' in data && data.page_next_link.length)
                        $('[name=catalog_more_parametter]').val(data.page_next_link);

                    if ('product_now_count' in data && data.product_now_count)
                        $('.catalog-showed-counter').html(data.product_now_count);

                }

                footer_resize();
            }
        });

    });

    //end - catalog more button


    //product info

    $('.delivery-info a.close').live('click', function () {
        $(this).parent().hide('100');
        //$(this).closest('.bxin').find('.indr').show();
    });
    $('*').not('.clarification').on('click', function(){
        $('.drop').hide('100');
    })
    $('.delivery-info a.clarification').live('click', function () {
        $(this).parent().find('.drop').show('100');

    });

    //end - product info

    //search drop

    $('.search-input').live('keyup', function () {

        $.ajax({
            url: CI_ROOT_LANG + 'ajax/search',
            type: 'GET',
            async: false,
            data: 'search=' + $(this).val(),
            success: function (data) {
                if (typeof data !== 'undefined' && data.length) {
                    $('#top-search-result').html(data);
                    $('#top-search-result').parent().show();
                } else {
                    $('#top-search-result').parent().hide();
                    $('#top-search-result').html('');
                }
            }
        });

    }).live('focus', function () {

        var $elem = $('.search-drop-down');

        if ($elem.css('display') != 'block') {
            $elem.show();

            var firstClick = true;

            $(document).bind('click.mySearch', function (e) {
                if (!firstClick && $(e.target).closest('.search-drop-down').length == 0 || !firstClick && $(e.target).closest('.search-drop-down ul li a input').length != 0) {
                    $elem.hide();
                    $(document).unbind('click.mySearch');
                }

                firstClick = false;
            });
        }

        if ($(this).val().length > 3 && $('#top-search-result').html().length > 0)
            $('#top-search-result').parent().show();
        else
            $('#top-search-result').parent().hide();
    });

    //end search drop

    //order

    $('.fldit').on('click', '.order-delivery', function () {
        if (parseInt($(this).val(), 10) === 1) {
            $('.order-delivery-post').slideDown(500);
        } else {
            $('.order-delivery-post').slideUp(500);
        }
    });

    //end - order
    //compare region
    $(document).on('click', '.itcm, .pdcm', function (e) {
        e.preventDefault();
        var product_id = $(this).data('product');
        var compare_count = Cookies.get('compare_catalog');

        var compare_one_c = 0;

        if ($(this).hasClass('ac')) {
            compare_one_c = compare_count - 1;
            $(this).parent().find('.cmrm').remove();
            var count_product = $('product_count_all').val();
             if(compare_count > 1) {
                 $(this).find('.cmtx').text('Добавить к сравнению');
                 var a = $(this).parent();
                 var url_site = document.location.href;
                 var arr = url_site.split(/[?]/);
                 var to_this_url_site = arr[0];
                 var url = CI_ROOT_LANG + 'compare';

                  if(a.find('.ac')){
                      if(to_this_url_site == url) {
                          window.location.replace(CI_ROOT_LANG + 'compare.html');
                      }
                  }
             } else {
            $(this).find('.cmtx').text('Добавить к сравнению');
             }
            deleteCookies(product_id);
        } else {
            if(typeof compare_count == 'undefined') compare_count = 0;
            compare_one_c = Number(compare_count) + Number(1);
            if(compare_count > 0) {
                $(this).find('.cmtx').text('Удалить');
                $(this).parent().find('.cmrm').remove();
                $(this).after('<a class="cmrm" href="' + CI_ROOT_LANG + 'compare.html"><span class="cmtx">В сравнение</span></a>');
                setCookies(product_id);
            } else {
                $(this).find('.cmtx').html('Убрать из сравнения');
                setCookies(product_id);
            }
        }

        $('.comprasion_link__count').text(compare_one_c);
        $(this).toggleClass('ac');

    });
    //end compare region
});

$(window).load(function () {
    drop_menu();
    footer_resize();
});
$(window).resize(function () {

});
$(window).scroll(function () {

});

function setCookies(product) {
    if (product !== null && product !== undefined) {
        var u_cookie = $.parseJSON(Cookies.get('compare'));
        if (u_cookie === undefined || u_cookie === null) {
            u_cookie = [];
        }
        if (u_cookie.indexOf(product) >= 0)
            return;
        u_cookie.push(product);
        u_cookie = JSON.stringify(u_cookie);
        var compare_count = Cookies.get('compare_catalog');
        if (compare_count === undefined) {
            compare_count = 0;
        }
        $('span.cmnm', 'a.hdrcm').text(++compare_count);
        Cookies.set('compare', u_cookie);
        Cookies.set('compare_catalog', compare_count);
    }
}
function deleteCookies(product) {
    if (product !== null && product !== undefined) {
        var compare_count = Cookies.get('compare_catalog');
        if (compare_count === undefined) {
            compare_count = 0;
        }
        $('span.cmnm', 'a.hdrcm').text(--compare_count < 0 ? 0 : compare_count);
        var u_cookie = $.parseJSON(Cookies.get('compare'));
        if (u_cookie === undefined || u_cookie === null) {
            u_cookie = [];
        }
        var ind = u_cookie.indexOf(product);
        JSON.stringify(u_cookie.splice(ind, 1));
        Cookies.set('compare', u_cookie);
        Cookies.set('compare_catalog', compare_count < 0 ? 0 : compare_count);
    }
}
var sender = false;
function show_more_comment() {
    if (!sender) {
        sender = true;
        var el = $('li.ac', 'ul.pgls').last().next();
        var page = el.children('a').first().text();
        var obj_id = $('.pgmr', 'div.pg').data('productid');
        el.addClass('ac');
        el.children('a').first().replaceWith(el.children('a').first().text());
        $('a.pgnx', 'div.pg').addClass('db').css('pointer-events', 'none').removeAttr('href');
        if (el.next('li').length === 0) {
            $('.pgmr', 'div.pg').addClass('db');
        }
        $.ajax({
            url: CI_ROOT_LANG + 'ajax/get-comments',
            type: 'POST',
            data: 'page=' + page + '&object_id=' + obj_id,
            dataType: "json",
            success: function (data) {
                if (typeof data !== 'undefined' && data.length) {
                    $('.cmmit', '.cmmcnt').last().after(data);
                    $('.itrt').rating({
                        fx: 'float',
                        image: 'public/images/content/icon/rating.png',
                        loader: 'public/images/content/icon/load-rating.png',
                        minimal: 0.1,
                        readOnly: true
                    });
                }
            }
        });
        sender = false;
    }

}
function get_points(elem) {
    if (!elem.length)
        return false;

    $.ajax({
        url: CI_ROOT_LANG + 'ajax/get-data',
        type: 'POST',
        async: false,
        data: 'region=' + elem.val(),
        success: function (data) {
            if (typeof data !== 'undefined' && data.length && $('.order-point-select').length) {
                $('.order-point-select').val($('.order-point-select option:first').val());
                $('.order-point-select option[value!=0]').remove();
                $('.order-point-select').append(data);
                $('.order-point-select').trigger('change');
            }
        }
    });

}

function drop_menu() {
    var menu_width = $('.prmn').width();

    $('.prmn .lsit').live('hover', function () {
        var prevall = $(this).prevAll(),
                prevall_width = 0;

        prevall.each(function () {
            prevall_width += $(this).outerWidth();
        });

        var all_width = prevall_width + $(this).find('.itdr').outerWidth();

        if (all_width > menu_width) {
            $(this).find('.itdr').css('left', menu_width - all_width);
        }
    });
}

function footer_resize() {
    if ($('#ftr').length && $('.clrftr').length) {
        $('.clrftr').height($('#ftr').outerHeight());
        $('#ftr').css('margin-top', -$('#ftr').outerHeight());
    }
}

function number_format(number, decimals, dec_point, thousands_sep) {
    //source: http://phpjs.org/functions/number_format/
    number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                        .toFixed(prec);
            };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
                .join('0');
    }
    return s.join(dec);
}

function global_goto(element, rizer) {
    if (!$(element).length)
        return false;

    rizer = rizer || 0;
    var destination = $(element).offset().top - rizer;
    if ($.browser.opera) {
        $('html').animate({scrollTop: destination}, 1100);
    } else {
        $('body').animate({scrollTop: destination}, 1100);
    }

    return false;
}