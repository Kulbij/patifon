<?php foreach ($this->cart->contents() as $key => $value) : ?>

        <div class="item">

        <?php if(isset($value['options']['image']) && !empty($value['options']['image'])) : ?>
          <a href="<?php if (isset($value['options']['link'])) echo anchor_wta(site_url('catalog/'.$links[$key]['parentcategorylink'].'/'.$links[$key]['categorylink'].'/'.$value['options']['link'])); ?>" class="image">
            <img src="<?php echo baseurl($value['options']['image']); ?>" alt="<?php echo $value['name']; ?>" alt="#">
          </a>
        <?php endif; ?>

          <div class="info">
            <div class="item-title">
              <a href="<?php if (isset($value['options']['link'])) echo anchor_wta(site_url('catalog/'.$links[$key]['parentcategorylink'].'/'.$links[$key]['categorylink'].'/'.$value['options']['link'])); ?>" class="link"><?php echo $value['name']; ?></a>
            </div><!-- end .title -->

            <div class="price">
              <span class="sum"><?php echo $this->input->price_format($value['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?></span> <?php echo $this->lang->line('site_valuta'); ?>
            </div><!-- end .price -->
          </div><!-- end .info -->

          <div class="item-box">
            <div class="amount qty-parent-amount" id="div_<?php echo $value['rowid']; ?>">
              <input type="text" class="input-text quantity-input global-qty-input" value="<?php echo $value['qty']; ?>" maxlength="3" name="<?php echo $value['rowid']; ?>">
              <a href="javascript:void(0);" class="minus cart-minus <?php if ($value['qty'] <= 1) echo 'disabled'; ?>" el="<?php echo $value['rowid']; ?>"></a>
              <a href="javascript:void(0);" class="plus cart-plus <?php if ($value['qty'] >= 99) echo 'disabled'; ?>" el="<?php echo $value['rowid']; ?>"></a>
            </div><!-- end .amount -->

            <div class="price-total">
              <span class="sum span_<?php echo $value['rowid']; ?>">
                <?php if (isset($value['price']) && isset($value['qty'])) echo $this->input->price_format($value['price'] * $value['qty'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?>
              </span> <?php echo $this->lang->line('site_valuta'); ?>
            </div><!-- end .price-total -->
          </div><!-- end .item-box -->

          <a href="javascript:void(0);" title="<?php echo $this->lang->line('ap_c_remove_product'); ?>" class="remove cart-remove" rel="<?php echo $value['rowid']; ?>"></a>
        </div><!-- end .item -->
<?php endforeach; ?>

<a href="<?php echo anchor_wta(site_url('cart/clear')); ?>" class="remove-cart">
  <i class="icon"></i>
  <?php echo $this->lang->line('ap_c_clear'); ?>
</a>

    <div class="total">
      <?php echo $this->lang->line('ap_c_sum'); ?>:
      <span class="value"><span class="sum">
        <?php echo $this->input->price_format($this->cart->total(), $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?>
      </span> <?php echo $this->lang->line('site_valuta'); ?></span></span>
    </div><!-- end .total -->

    <div class="clearfix"></div>

    <a href="javascript:void(0);" class="back ownbox-close"><?php echo $this->lang->line('ap_c_to_shop'); ?></a>
    <a href="<?php echo anchor_wta(site_url('cart/order')); ?>" class="button"><?php echo $this->lang->line('ap_c_order'); ?></a>
  </div><!-- end .cart -->