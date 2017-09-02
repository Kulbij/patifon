<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <title>Адміністрування</title>
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>style/main.css" />
    <link rel="shortcut icon" href="<?php echo base_url().'favicon.ico'; ?>" type="image/x-icon" />
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/jquery.js'; ?>"></script>
    <script type="text/javascript" language="JavaScript" src="<?php echo base_url(), 'js/translit.js'; ?>"></script>
    
  </head>
  <body>
    <div id="main">
      <div id="header">
        <ul class="user">
          <li><img src="<?php echo base_url(); ?>images/user.png" alt="#" /><?php echo $top['administrator']; ?></li>
          <li><img src="<?php echo base_url(); ?>images/logout.png" alt="#" /><a href="<?php echo base_url().'logout'; ?>">Выход</a></li>
        </ul>
          
        <ul id="primary-menu">
         <?php foreach ($top['menu'] as $one) : ?>
          <?php // if ($PAGE != $one['link']) : ?>
           <li><p class="menu"><a href="<?php echo base_url(), $one['link']; ?>"><img src="<?php echo base_url(), $one['image']; ?>" alt="#" /><br /><span class="links"><?php echo $one['name']; ?></span></a></p>               
           
            
            <?php if (isset($top['order_round']) && $one['link'] == 'order' && $top['order_round'] > 0) : ?>
            <div class="orders-range" title="кількість нових замовлень"><?php echo $top['order_round']; ?></div>
           <?php endif; ?>
            
            <?php if (isset($top['message_round']) && $one['link'] == 'message' && $top['message_round'] > 0) : ?>
            <div class="message-range" title="кількість нових повідомлень"><?php echo $top['message_round']; ?></div>
           <?php endif; ?>
            
            <?php if (isset($top['clients_round']) && $one['link'] == 'clients' && $top['clients_round'] > 0) : ?>
            <div class="orders-range" title="кількість неактивованих користувачів"><?php echo $top['clients_round']; ?></div>
           <?php endif; ?>
            
            <?php if (isset($top['comment_round']) && $one['link'] == 'comments' && $top['comment_round'] > 0) : ?>
            <div class="message-range" title="кількість коментарів за сьогодні"><?php echo $top['comment_round']; ?></div>
           <?php endif; ?>
            
           </li>
            
          <?php // else : ?>
<!--           <li><p class="menu"><img src="<?php echo base_url(), $one['image']; ?>" alt="#" /><br /><?php echo $one['name']; ?></p>
           
            
            <?php if (isset($top['order_round']) && $one['link'] == 'order' && $top['order_round'] > 0) : ?>
            <div class="orders-range" title="кількість нових замовлень"><?php echo $top['order_round']; ?></div>
           <?php endif; ?>
            
            <?php if (isset($top['message_round']) && $one['link'] == 'message' && $top['message_round'] > 0) : ?>
            <div class="message-range" title="кількість нових повідомлень"><?php echo $top['message_round']; ?></div>
           <?php endif; ?>
            
            <?php if (isset($top['clients_round']) && $one['link'] == 'clients' && $top['clients_round'] > 0) : ?>
            <div class="orders-range" title="кількість неактивованих користувачів"><?php echo $top['clients_round']; ?></div>
           <?php endif; ?>
            
            <?php if (isset($top['comment_round']) && $one['link'] == 'comments' && $top['comment_round'] > 0) : ?>
            <div class="message-range" title="кількість коментарів за сьогодні"><?php echo $top['comment_round']; ?></div>
           <?php endif; ?>
            
           </li>-->
            
          <?php //endif; ?>
         <?php endforeach; ?>
        </ul>
      </div><!-- end header -->