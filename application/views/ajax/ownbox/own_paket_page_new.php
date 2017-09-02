<div class="ownbox-content form form-packedge">
      <a class="close ownbox-close" href="javascript:void(0);"></a>

      <div class="tab-packedge">
        <ul class="tab-menu">
          <?php if(isset($SITE_CONTENT['cat_option']['share']) && !empty($SITE_CONTENT['cat_option']['share'])) : ?>
            <?php $i = 1; foreach($SITE_CONTENT['cat_option']['share'] as $key => $value) : ?>
              <?php if(isset($value['name']) && !empty($value['name'])) : ?>
              <li class="item">
              <a href="#packedge_box_<?php echo $i; ?>" class="link"><?php echo $value['name']; ?></a>
            </li>
                <?php endif; ?>
          <?php $i++; endforeach; ?>
        <?php endif; ?>
        </ul>

      <?php if(isset($SITE_CONTENT['cat_option']['share']) && !empty($SITE_CONTENT['cat_option']['share'])) : ?>
      <?php $i = 1; foreach($SITE_CONTENT['cat_option']['share'] as $key => $value) : ?>
        <div id="packedge_box_<?php echo $i; ?>" class="tab-box">

        <?php if(isset($value['children']) && !empty($value['children']) && count($value['children'] > 0)) : ?>
        <?php foreach($value['children'] as $two) : ?>

          <?php if(isset($two) && !empty($two) && count($two) > 0) : ?>
          <div class="packedge-item">
            <img src="<?php if(isset($two['image']) && !empty($two['image'])) echo baseurl($two['image']); ?>" alt="<?php if(isset($two['name']) && !empty($two['name'])) echo $two['name']; ?>" class="image">
            <?php if(isset($two['name']) && !empty($two['name'])) echo $two['name']; ?>
          </div><!-- end .packedge-item -->
            <?php endif; ?>

          <?php endforeach; ?>
          <?php endif; ?>
          
          <div class="clearfix"></div>

          <div class="box-bottom">
            <div class="packedge-price"><span class="sum"><?php echo $value['price']; ?></span> грн.</div>

            <div class="button-box">
              <input type="button" class="input-button" value="Добавить в корзину" onclick="cart_buy({id: <?php echo $value['ID']; ?>, quantity: 1, color: 0, warranty: 1, id_product: <?php echo $SITE_CONTENT['object']['id']; ?>}, 1);">
            </div><!-- end .button-box -->
          </div><!-- end .box-bottom -->
        </div><!-- end .tab-box -->
        
        <?php $i++; endforeach; ?>
        <?php endif; ?>

      </div><!-- end .tab-packedge -->
    </div><!-- end .ownbox-content -->

    <script type="text/javascript">
      $('.tab-packedge').tabslet({
        active: '<?php echo $SITE_CONTENT['active']; ?>'
      });
    </script>