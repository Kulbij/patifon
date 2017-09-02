 <?php if (isset($SITE_BREAD['breadcrumbs']) && is_array($SITE_BREAD['breadcrumbs']) && !empty($SITE_BREAD['breadcrumbs'])) : ?>
  <ul class="breadcrumbs clearfix" itemscope itemtype="http://schema.org/BreadcrumbList">
   <?php foreach ($SITE_BREAD['breadcrumbs'] as $value) : ?>
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">

      <?php echo anchor($value['link'], '<span>'.$value['name'].'</span>', array('itemprop' => 'item')); ?>

    </li>
   <?php endforeach; ?>
  </ul>
 <?php endif; ?>