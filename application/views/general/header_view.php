<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="<?php echo baseurl(); ?>" />
        <?php echo meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>
        <?php if (isset($SITE_HEADER['meta_tkd'])) echo meta($SITE_HEADER['meta_tkd']); ?>
        <title><?php if (isset($SITE_HEADER['title'])) echo $SITE_HEADER['title']; ?></title>
        <?php echo link_tag('favicon.ico', 'shortcut icon', 'image/x-icon'); ?>

        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=cyrillic" />

        <?php if (isset($SITE_HEADER['style']) && is_array($SITE_HEADER['style']) && !empty($SITE_HEADER['style'])) : ?>
            <?php foreach ($SITE_HEADER['style'] as $one) : ?>
                <link rel="<?php echo $one['rel']; ?>" type="<?php echo $one['type']; ?>" href="<?php echo resource_url($one['href'], array('css' => true)); ?>" />
            <?php endforeach; ?>
        <?php endif; ?>
        <script>

            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-63316254-1', 'auto');
            ga('require','displayfeatures');
            ga('send', 'pageview');

        </script>
        <script type="text/javascript" language="JavaScript"> CI_ROOT = '<?php echo baseurl(); ?>';</script>
        <script type="text/javascript" language="JavaScript"> CI_ROOT_LANG = '<?php echo site_url(); ?>';</script>

        <!--[if lte IE 8]>
         <link rel="stylesheet" type="text/css" href="<?php echo resource_url('public/style/form.css', array('css' => true)); ?>" />
        <![endif]-->

        <script type="text/javascript" language="JavaScript" src="<?php echo site_url('public/js/js.cookie.js'); ?>"></script>

        <script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/jquery.min.js', array('js' => true)); ?>"></script>

        <script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/own.main.js', array('js' => true)); ?>"></script>
        <script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/own.form.js', array('js' => true)); ?>"></script>
        <script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/own.box.js', array('js' => true)); ?>"></script>
        <script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/own.cart.js', array('js' => true)); ?>"></script>

        <script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/jquery.mask.js', array('js' => true)); ?>"></script>
        <script type="text/javascript" language="JavaScript">
            $(document).ready(function () {
                $('input[name=phone]').mask('+38 (999) 999–99–99');
            });
        </script>

        <!-- Rating -->
        <link href="<?php echo resource_url('public/style/rating.css', array('css' => true)); ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo resource_url('public/js/jquery.rating.min.js', array('js' => true)); ?>"></script>

        <script type="text/javascript">
            $(window).load(function () {
                if ($('.pdrt').length) {

                    $('.pdrt').rating({
                        fx: 'float',
                        image: 'public/images/content/icon/rating-big.png',
                        loader: 'public/images/content/icon/load-rating-big.png',
                        minimal: 0.1,
                        readOnly: true
                    });

                }
                if ($('.itrt').length) {
                    $('.itrt').rating({
                        fx: 'float',
                        image: 'public/images/content/icon/rating.png',
                        loader: 'public/images/content/icon/load-rating.png',
                        minimal: 0.1,
                        readOnly: true
                    });
                }
            });
        </script>
        <!-- end Rating -->

        <!-- jCarousel -->
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('public/style/jcarousel.css', array('css' => true)); ?>">
            <script type="text/javascript" src="<?php echo resource_url('public/js/jquery.jcarousel.min.js', array('js' => true)); ?>"></script>
            <!-- end jCarousel -->

            <?php #PAGES REGION  ?>
            <?php if ($__PAGE == 'index') : ?>

                <!-- jCarousel -->
                <script type="text/javascript" language="JavaScript">
                $(document).ready(function () {
                    var jcarousel = $('.jc');

                    jcarousel.on('jcarousel:reload jcarousel:create', function () {
                        var carousel = $(this),
                          width = carousel.innerWidth(),
                          height = carousel.innerHeight();

                        carousel.jcarousel('items').css({
                          'width': Math.ceil(width) + 'px',
                          'height': Math.ceil(height) + 'px'
                        });

                        $('#sld .cnvral').css('height', Math.ceil(height) + 'px');
                    }).jcarousel({
                        wrap: 'circular',
                        transitions: true
                    }).jcarouselAutoscroll({
                        interval: 3000,
                        target: '+=1',
                        autostart: true
                    });

                    $('.cnpr').on('jcarouselcontrol:active', function () {
                        $(this).removeClass('db');
                    }).on('jcarouselcontrol:inactive', function () {
                        $(this).addClass('db');
                    }).jcarouselControl({
                        target: '-=1'
                    });

                    $('.cnnx').on('jcarouselcontrol:active', function () {
                        $(this).removeClass('db');
                    }).on('jcarouselcontrol:inactive', function () {
                        $(this).addClass('db');
                    }).jcarouselControl({
                        target: '+=1'
                    });

                    $('.cnpg').on('jcarouselpagination:active', 'a', function () {
                        $(this).addClass('ac');
                    }).on('jcarouselpagination:inactive', 'a', function () {
                        $(this).removeClass('ac');
                    }).on('click', function (e) {
                        e.preventDefault();
                    }).jcarouselPagination({
                        perPage: 1,
                        item: function (page) {
                            return '<a class="pglk" href="#' + page + '"></a>';
                        }
                    });

                    jcarousel.mouseover(function () {
                        $('.jc').jcarouselAutoscroll('stop');
                    }).mouseout(function () {
                        $('.jc').jcarouselAutoscroll('start');
                    });
                });
                </script>
                <!-- end jCarousel -->

            <?php elseif ($__PAGE == 'catalog') : ?>

                <!-- UI Slider -->
                <script type="text/javascript" src="<?php echo resource_url('public/js/jquery.ui.min.js', array('js' => true)); ?>"></script>

                <script type="text/javascript">
                $(document).ready(function () {

                    var $max_price = <?php echo (isset($SITE_LEFTPANEL['PRICES']['price']) && $SITE_LEFTPANEL['PRICES']['price'] > 0) ? (int) $SITE_LEFTPANEL['PRICES']['price'] : 0; ?>;
                    var $link = '<?php echo (isset($SITE_LEFTPANEL['SLIDES_LINKER']['price_linker'])) ? anchor_wta(site_url('catalog/' . $CATEGORYLINK . '/filter/' . $SITE_LEFTPANEL['SLIDES_LINKER']['price_linker'])) : ''; ?>';

                    var range = $('.slrn').slider({
                        range: true,
                        min: 0,
                        max: $max_price,
                        values: [<?php
            if (isset($SITE_CONTENT['FILTER']['min-price'][0]))
                echo $SITE_CONTENT['FILTER']['min-price'][0];
            else
                echo 0;
            ?>, <?php
            if (isset($SITE_CONTENT['FILTER']['max-price'][0]))
                echo $SITE_CONTENT['FILTER']['max-price'][0];
            else
                echo (isset($SITE_LEFTPANEL['PRICES']['price']) && $SITE_LEFTPANEL['PRICES']['price'] > 0) ? $SITE_LEFTPANEL['PRICES']['price'] : 0;
            ?>],
                        slide: function (event, ui) {
                            $('.slmin').val(ui.values[0]);
                            $('.slmax').val(ui.values[1]);
                        },
                        change: function (event, ui) {
                            var $string = ($link.replace('%_minp', ui.values[0])).replace('%_maxp', ui.values[1]);
                            window.location = $string;
                        }
                    });

                    $('.slmin').val($('.slrn').slider('values', 0));
                    $('.slmax').val($('.slrn').slider('values', 1));

                    $('.slrnbx').on('blur', '.slmin', function () {
                        $('.slrn').slider('values', [parseInt($(this).val(), 10), parseInt($('.slmax:first', '.slrnbx').val(), 10)]);
                    }).on('keydown', '.slmin', function (e) {
                        if (e.keyCode === 13)
                            $('.slrn').slider('values', [parseInt($(this).val(), 10), parseInt($('.slmax:first', '.slrnbx').val(), 10)]);
                    });

                    $('.slrnbx').on('blur', '.slmax', function () {
                        $('.slrn').slider('values', [parseInt($('.slmin:first', '.slrnbx').val(), 10), parseInt($(this).val(), 10)]);
                    }).on('keydown', '.slmax', function (e) {
                        if (e.keyCode === 13)
                            $('.slrn').slider('values', [parseInt($('.slmin:first', '.slrnbx').val(), 10), parseInt($(this).val(), 10)]);
                    });

                });
                </script>
                <!-- END UI Slider -->

            <?php elseif ($__PAGE == 'object') : ?>
                <script type="text/javascript" language="JavaScript">
                    $(document).ready(function () {
                        $('.fldrt .lsit').mouseover(function () {
                            $(this).prevAll().children().css('background-position', '0 -15px');
                        }).mouseout(function () {
                            $(this).prevAll().children().css('background-position', '');
                        }).click(function () {
                            $('input[name=mark]', '.fldrt').val($(this).children(":first").data('mark'));
                            $('.rttx', '.fldrt').text($(this).children(":first").data('text'));
                            $('.fldrt .lsit a').removeClass('ac');
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

            <?php elseif ($__PAGE == 'order') : ?>

                <!-- Uniform -->
                <script type="text/javascript" src="<?php echo resource_url('public/js/jquery.uniform.min.js', array('js' => true)); ?>"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('.itrd').uniform();
                    });
                </script>
                <!-- end Uniform -->

                <!-- Select 2 -->
                <script type="text/javascript" src="<?php echo resource_url('public/js/select2.min.js', array('js' => true)); ?>"></script>

                <script type="text/javascript">
                    $(document).ready(function () {
                        $(".fldsc").select2({
                            matcher: function (params, data) {
                                if ($.trim(params.term) === '') {
                                    return data;
                                }
                                params.term = params.term.charAt(0).toUpperCase() + params.term.substr(1, params.term.length-1);

                                if (data.text.indexOf(params.term) === 0) {
                                    var modifiedData = $.extend({}, data, true);    
                                    return modifiedData;
                                }
    // Return `null` if the term should not be displayed
                                return null;
                            }
                        });
                    });

                </script>
                <!-- end Select 2 -->


                <!-- mCustomScrollbar -->

                <script type="text/javascript">
                    $(document).ready(function () {
                        $('.fmbx').on("change", ".order-region-select", function () {
                            get_points($(this));
                        });
                    });
                </script>
                <!-- END mCustomScrollbar -->
            <?php elseif ($__LINK == 'compare'): ?>
                <link rel="stylesheet" type="text/css" href="<?php echo resource_url('public/style/mCustomScrollbar.css', array('css' => true)); ?>" />

                <script type="text/javascript" src="<?php echo resource_url('public/js/jquery.mCustomScrollbar.min.js', array('js' => true)); ?>"></script>
                <script>
                    $(document).ready(function () {
                        $(".cmcnt").mCustomScrollbar({
                            axis: "x",
                            scrollbarPosition: 'outside',
                            advanced: {
                                autoExpandHorizontalScroll: true
                            }
                        });
                    });
                </script>
            <?php endif; ?>
            <?php #end PAGES REGION ?>

            <?php
            if ($__PAGE == 'catalog' && isset($CATEGORYLINK)) :
                if (!isset($CANONICAL) || !$CANONICAL)
                    $CANONICAL = '';
                else
                    $CANONICAL = '/' . $CANONICAL;
                ?>
                <link rel="canonical" href="<?php echo anchor_wta(site_url('catalog/' . $CATEGORYLINK . $CANONICAL)); ?>" />
            <?php endif; ?>

            <?php if (isset($PRINT_PARAMETTER) && $PRINT_PARAMETTER == 'print') : ?>
                <link href="<?php echo resource_url('public/style/print.css', array('css' => true)); ?>" rel="stylesheet" type="text/css" />
            <?php endif; ?>
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>
            <script type="text/javascript">
                VK.init({apiId: 4934152, onlyWidgets: true});
            </script>

        <!-- jCarousel -->

            <script type="text/javascript">
      $(document).ready(function() {
        var jcarousel = $('.jcas');

        jcarousel.on('jcarousel:reload jcarousel:create', function () {
          var carousel = $(this),
            width = carousel.innerWidth();

          carousel.jcarousel('items').css('width', Math.ceil(width / 5) + 'px');
        }).jcarousel({
          wrap: 'circular',
        })

        $('.as-cnpr').on('jcarouselcontrol:active', function() {
          $(this).removeClass('db');
        }).on('jcarouselcontrol:inactive', function() {
          $(this).addClass('db');
        }).jcarouselControl({
          target: '-=1'
        });

        $('.as-cnnx').on('jcarouselcontrol:active', function() {
          $(this).removeClass('db');
        }).on('jcarouselcontrol:inactive', function() {
          $(this).addClass('db');
        }).jcarouselControl({
          target: '+=1'
        });
      });
    </script>

    <!-- end jCarousel -->

        <?php if($__PAGE == 'otherpage') : ?>
    
        <!-- Скрипт Таймера обратного отсчета -->
        <!-- <link rel="stylesheet" href="<?php echo resource_url('public/style/style.css'); ?>"> -->
        
            <script src="<?php echo resource_url('public/js/own.timer.js'); ?>"></script>
        <script src="<?php echo resource_url('public/js/jquery.bxslider.min.js'); ?>"></script>
        <script src="<?php echo resource_url('public/js/jcarousel.js'); ?>"></script>
        <?php endif; ?>


    </head>