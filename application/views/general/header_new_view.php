<!DOCTYPE html>
<html>
<head>
    <base href="<?php echo baseurl(); ?>" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($SITE_HEADER['meta_tkd'])) echo meta($SITE_HEADER['meta_tkd']); ?>
    <title><?php if (isset($SITE_HEADER['title'])) echo $SITE_HEADER['title']; ?></title>
    <?php echo link_tag('favicon.ico', 'shortcut icon', 'image/x-icon'); ?>

    <!-- Сбрасывание стандартных стилей браузеров для HTML-элементов-->
    <link rel="stylesheet" href="<?php echo resource_url('public/style/reset.css'); ?>" />

    <!-- Пользовательскиe стили -->
    <link rel="stylesheet" href="<?php echo resource_url('public/style/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo resource_url('public/style/form_new.css'); ?>">

    <!-- Стилизация BxSlider -->
    <link rel="stylesheet" href="<?php echo resource_url('public/style/jquery.bxslider.css'); ?>">

    <!-- Стилизация select -->
    <link rel="stylesheet" href="<?php echo resource_url('public/style/selectric.css'); ?>">

    <!-- Стили Slick Slider -->
    <link rel="stylesheet" href="<?php echo resource_url('public/style/slick.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo resource_url('public/style/slick-theme.css'); ?>"/>

    <!-- Стили Rating -->
    <link rel="stylesheet" href="<?php echo resource_url('public/style/jquery.rating.css'); ?>" />


</head>