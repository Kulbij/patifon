<?php
 if (isset($catalog) && !empty($catalog)) :

 $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();

?>
<?php $counter = 1; foreach ($catalog as $value) : ?>

      <div class="product 
      <?php if (
           (isset($value['in_stock']) && !$value['in_stock']) ||
           (isset($value['avail']) && $value['avail'])
          ) : ?>
      product_sale
      <<?php else :?>
        <?php if(isset($value['delivery_3_5']) && $value['delivery_3_5'] == 1):?>
          product_wait
        <?php else : ?>
          product_stock
        <?php endif; ?>
      <?php endif; ?>
      ">
      <?php if(isset($CATEGORYLINK)):?>
      <?php if(!empty($PARENTCATEGORYLINK)):?>
         <a class="product__link_img" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
             <?php else:?>
         <a class="product__link_img" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
             <?php endif;?>
             <?php else:?>
                 <a class="product__link_img" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/'.$value['link'])); ?>">
             <?php endif;?>
              <img class="product--img" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>" title="<?php echo $value['name'];?>">
              <span class="label_small"></span>
         </a>

          <div class="product_add_content clearfix">
            <p>
            <?php if(isset($PARENTCATEGORYLINK)):?>
            <?php if(!empty($PARENTCATEGORYLINK)):?>
              <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$value['link']));?>#subs-review-view" class="product--see_comments">
                <span class="product--see_quantity"><?php echo $value['comm_count'];?></span>
              </a>
              <?php else:?>
                  <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link']));?>#subs-review-view" class="product--see_comments">
                  <span class="product--see_quantity"><?php echo $value['comm_count'];?></span>
                </a>
                <?php endif;?>
              <?php else:?>
                <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/'.$value['link']));?>#subs-review-view" class="product--see_comments">
                  <span class="product--see_quantity"><?php echo $value['comm_count'];?></span>
                </a>
              <?php endif;?>
            </p>

            <p class="wrapper_rating">
              <span class="rating">
                <input name="val" value="<?php echo $value['mark'];?>" type="hidden" />
              </span>
            </p>
          </div>

          <div class="product__title">
          <?php if(isset($PARENTCATEGORYLINK)):?>
         <?php if(!empty($PARENTCATEGORYLINK)):?>
            <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
              <?php echo $value['name']; ?>
            </a>
            <?php else:?>
              <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
                <?php echo $value['name']; ?>
              </a>
              <?php endif;?>
              <?php else:?>
                <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/'.$value['link'])); ?>">
                  <?php echo $value['name']; ?>
                </a>
              <?php endif;?>
          </div>

          <div class="product_add_content product_add_content_middle clearfix">
            <p>
            <?php if (
                (isset($value['in_stock']) && !$value['in_stock']) ||
                (isset($value['avail']) && $value['avail'])
               ) : ?>
              <button class="product--buy_button" disabled="disabled"><?php echo $this->lang->line('site_buy'); ?></button>
              <?php else : ?>
                <button class="product--buy_button" onclick="cart_buy({id: '<?php echo $value['id']; ?>', quantity: 1, color: 0}, 1);"><?php echo $this->lang->line('site_buy'); ?></button>
            <?php endif; ?>
            </p>

            <p class="wrapper_price_button">
              <span class="product--price"><?php if (isset($value['price']) && $value['price'] > 0) : echo $this->input->price_format($value['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> </span>
              <span class="product--currency">&nbsp;<?php echo $this->lang->line('site_valuta'); ?>.</span>
              <?php else : echo '&nbsp;'; endif; ?>
            </p>
          </div>

          <div class="product_add_content clearfix">
          </div>
        </div>

<?php $counter++; endforeach; ?>
<?php endif; ?>