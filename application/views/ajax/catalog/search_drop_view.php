<?php if (isset($products) && !empty($products)) : ?>
 <?php foreach ($products as $value) : ?>
  <div class="drit">
   <a class="itim" href="<?php if (isset($value['link'])) echo anchor_wta('product/'.$value['link']); ?>">
    <span class="imvral">
     <img class="imim" src="<?php if (isset($value['image'])) echo baseurl($value['image']); ?>" alt="<?php if (isset($value['name'])) echo $value['name']; ?>">
    </span>
   </a>

   <div class="ittt">
    <a class="ttlk" href="<?php if (isset($value['link'])) echo anchor_wta('product/'.$value['link']); ?>">
     <?php if (isset($value['name'])) echo $value['name']; ?>
    </a>
   </div>

   <div class="itpr">
    <?php if (isset($value['price'])) echo $this->input->price_format($value['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <span class="prvl"><?php echo $this->lang->line('site_valuta'); ?></span>

    <?php if (isset($value['old_price']) && $value['old_price'] > $value['price']) : ?>
     <div class="prol">
      <?php echo $this->input->price_format($value['old_price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <span class="olvl"><?php echo $this->lang->line('site_valuta'); ?></span>
      <span class="olln"></span>
     </div>
    <?php endif; ?>
   </div>

   <div class="clr"></div>
  </div>
 <?php endforeach; ?>
<?php endif; ?>