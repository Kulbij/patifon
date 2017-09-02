<?php
 if (isset($catalog) && !empty($catalog)) :

 $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();

?>
<?php $counter = 300; foreach ($catalog as $value) : ?>

      <div class="product product_stock">
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
              <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$value['link']. '/reviews#tabs'));?>" class="product--see_comments">
                <span class="product--see_quantity"><?php echo $value['comm_count'];?></span>
              </a>
              <?php else:?>
                  <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link']. '/tab/reviews#tabs'));?>" class="product--see_comments">
                  <span class="product--see_quantity"><?php echo $value['comm_count'];?></span>
                </a>
                <?php endif;?>
              <?php else:?>
                <a href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/'.$value['link']. '/tab/reviews#tabs'));?>" class="product--see_comments">
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
            <p>
              <a class="product--detail_like operation-link on <?php
                   $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();
                   if (in_array($SITE_CONTENT['object']['id'], $cookie)) echo 'active'; ?>" 
              href="<?php echo anchor_wta(site_url('ajax/operation/favorite')); ?>"
               data-post="product=<?php echo $SITE_CONTENT['object']['id']; ?>">
                <span class="product--detail_like__quant"><?php echo $SITE_CONTENT['object']['favorite_count']; ?></span>
              </a>
            </p>
            <input type="hidden" id="count_like_for_object" value="<?php echo $SITE_CONTENT['object']['favorite_count']; ?>">
            <!-- лайки -->

            <p>
              <input type="hidden" id="count_compare" value="<?php echo $counter; ?>">
              <input type="checkbox" id="product--check_<?php echo $counter; ?>" 
              class="product--check" 
              <?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) && in_array($value['id'],  json_decode($this->input->cookie('compare')))) echo 'checked';?> data-product="<?php echo $value['id'];?>" href="<?php if (isset($_COOKIE[$this->config->item('compare_catalog_cookie_var')]) && count($_COOKIE[$this->config->item('compare_catalog_cookie_var')]) > 1) echo anchor_wta('compare'); else echo anchor_wta('add_to_compare');?>">
              
              <label for="product--check_<?php echo $counter; ?>">
                <?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) 
                && in_array($value['id'],  json_decode($this->input->cookie('compare')))) 
                if($this->input->cookie($this->config->item('compare_catalog_cookie_var')) > 1)
                echo "Удалить";
              else
                echo 'Сравнить'; else echo 'Сравнить';?>
              </label>
            </p>
          </div>
        </div>

<?php $counter++; endforeach; ?>
<?php endif; ?>