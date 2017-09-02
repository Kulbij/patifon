<div id="cnt">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

<div class="pd <?php if (
      (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
      (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
     ) echo 'plof'; ?>">

 <div class="pdim">

  <?php if (isset($SITE_CONTENT['object']['image']) && !empty($SITE_CONTENT['object']['image'])) : ?>
   <!--noindex-->
    <a class="immain ownbox-form" href="<?php echo anchor_wta(site_url('ajax/form/product')); ?>" data-post="object=<?php echo $OBJECT_ID; ?>&image=0">
     <span class="imvral">
      <img class="imim" src="<?php echo baseurl($SITE_CONTENT['object']['image']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>">
     </span>
    </a>
   <!--/noindex-->
  <?php endif; ?>

  <?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
   <?php $index = 1; foreach ($SITE_CONTENT['images'] as $value) : ?>
    <!--noindex-->
     <a class="imit ownbox-form" href="<?php echo anchor_wta(site_url('ajax/form/product')); ?>" data-post="object=<?php echo $OBJECT_ID; ?>&image=<?php echo $index; ?>">
      <span class="imvral">
       <img class="imim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>">
      </span>

      <span class="imhv"></span>
     </a>
    <!--/noindex-->
   <?php ++$index; endforeach; ?>
  <?php endif; ?>

  <div class="pdsp">
   <?php if (isset($SITE_CONTENT['object']['share_class']) && !empty($SITE_CONTENT['object']['share_class'])) : ?>
    <i class="spic <?php echo $SITE_CONTENT['object']['share_class']; ?>"></i>
   <?php endif; ?>
  </div>

  <div class="clr"></div>
 </div>

  <!-- product info -->
  <div class="pdin">
   <div class="pdav">
    <?php if (
      (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
      (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
     ) : ?>
     <i class="icav no"></i>
     <?php echo $this->lang->line('op_not_in_stock'); ?>
    <?php else : ?>
     <i class="icav yes"></i>
     <?php echo $this->lang->line('op_in_stock'); ?>
    <?php endif; ?>
   </div>

   <?php if (isset($SITE_CONTENT['colors']) && !empty($SITE_CONTENT['colors'])) : ?>
    <div class="pdcl">
     <div class="cltt"><?php echo $this->lang->line('op_color'); ?>:</div>

     <ul class="clls">

      <?php foreach ($SITE_CONTENT['colors'] as $value) : ?>

       <?php if ($value['id'] == $SITE_CONTENT['object']['id']) : ?>

        <li class="lsit ac">
         <i class="iccl" style="background: #<?php echo $value['color']; ?>"></i>
         <?php echo $value['name']; ?>
        </li>

       <?php else : ?>

        <li class="lsit">
         <a class="itlk" href="<?php echo anchor_wta(site_url('product/'.$value['link'])); ?>">
          <i class="iccl" style="background: #<?php echo $value['color']; ?>"></i>
          <?php echo $value['name']; ?>
         </a>
        </li>

       <?php endif; ?>

      <?php endforeach; ?>

     </ul>

     <div class="clr"></div>
    </div>
   <?php endif; ?>

    <div class="pdpr">
     <span class="product-main-price"><?php if (isset($SITE_CONTENT['object']['price'])) echo $this->input->price_format($SITE_CONTENT['object']['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?></span> <span class="prvl"><?php echo $this->lang->line('site_valuta'); ?></span>

     <?php if (isset($SITE_CONTENT['object']['old_price']) && $SITE_CONTENT['object']['old_price'] > $SITE_CONTENT['object']['price']) : ?>
      <div class="prol">
       <span class="olnm">
        <?php echo $this->input->price_format($SITE_CONTENT['object']['old_price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?>
        <span class="nmln"></span>
       </span>

       <span class="olvl"><?php echo $this->lang->line('site_valuta'); ?></span>

       <div class="olhl"><?php echo $this->lang->line('op_economy'); ?> &mdash; <?php echo $this->input->price_format(($SITE_CONTENT['object']['old_price'] - $SITE_CONTENT['object']['price']), $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <?php echo $this->lang->line('site_valuta'); ?></div>
      </div>
     <?php endif; ?>
    </div>

    <?php if (isset($SITE_CONTENT['warranty']) && !empty($SITE_CONTENT['warranty'])) : ?>
     <div class="pdsl">
      <a class="slmain" href="#">
       <span class="mainvral">
        <i class="icsl"></i>
        <?php echo $this->lang->line('op_warranty'); ?>
       </span>
      </a>

      <div class="sldr">
       <div class="drln"></div>

       <?php foreach ($SITE_CONTENT['warranty'] as $value) : ?>
        <a class="drlk" href="javascript:void(0);"><?php echo $value['name']; ?></a>
       <?php endforeach; ?>
      </div>
     </div>
    <?php endif; ?>

    <?php if (
     (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
     (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
    ) : ?>
     <input class="pdbt db" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" disabled="disabled" />
    <?php else : ?>
     <input class="pdbt" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" onclick="cart_buy({id: '<?php echo $SITE_CONTENT['object']['id']; ?>', quantity: 1, color: 0 }, 1);" />
    <?php endif; ?>

    <form action="<?php echo anchor_wta(site_url('ajax/form-send/buyback')); ?>" method="post">

     <input class="pdph" name="phone" type="text" placeholder="+38 (___) ___–__–__" value="+38 (___) ___–__–__" <?php if (
       (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
       (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
      ) : ?>disabled="disabled"<?php endif; ?>>

     <input class="ajax-form pdbt2 <?php if (
       (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
       (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
      ) echo 'db'; ?>" type="button" value="<?php echo $this->lang->line('site_buy_one_click'); ?>" <?php if (
       (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
       (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
      ) : ?>disabled="disabled"<?php endif; ?>>

     <input type="hidden" name="product" value="<?php echo $OBJECT_ID; ?>" />
     <input type="hidden" name="robot" value="" />
    </form>

    <div class="clr"></div>

    <div class="pdbx">
      <div class="pdrt">
        <input name="val" value="4" type="hidden">
      </div>

      <div class="pdcmm">
        <i class="iccmm"></i>
        <a class="cmmlk" href="#">229 отзывов</a>
      </div>

      <a class="pdcm" href="#">
        <i class="icchbx"></i>
        <span class="cmtx">Добавить к сравнению</span>
      </a>

      <a class="pdlik operation-link <?php
       $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();
       if (in_array($SITE_CONTENT['object']['id'], $cookie)) echo 'ac'; ?>" href="<?php echo anchor_wta(site_url('ajax/operation/favorite')); ?>" data-post="product=<?php echo $SITE_CONTENT['object']['id']; ?>">
       <i class="iclik"></i>
       <span class="liknm"><?php echo $SITE_CONTENT['object']['favorite_count']; ?></span>
      </a>

      <div class="clr"></div>
    </div>

    <?php if (isset($SITE_CONTENT['object']['filters']) && !empty($SITE_CONTENT['object']['filters'])) : ?>
     <div class="pdft">
      <div class="fttt"><?php echo $this->lang->line('op_in_title_features'); ?></div>

      <?php foreach ($SITE_CONTENT['object']['filters'] as $value) : ?>
       <div class="ftit">
        <i class="itic <?php echo $value['class']; ?>"></i>
        <span class="ittt"><?php echo $value['parent_name']; ?></span>
        <?php echo $value['name']; ?>
       </div>
      <?php endforeach; ?>

     </div>
    <?php endif; ?>

  </div>
  <!-- end product info -->

 <?php if (isset($SITE_CONTENT['product_info']) && !empty($SITE_CONTENT['product_info'])) : ?>
  <div class="pddl">

   <?php foreach ($SITE_CONTENT['product_info'] as $key => $value) : ?>
    <div class="dlbx">
     <div class="bxtt"><?php echo $value['name']; ?></div>

     <div class="bxin">
      <a class="inlk product-info" href="javascript:void(0);"></a>

      <div class="indr">
       <a class="drex product-info-close" href="javascript:void(0);"></a>

       <div class="drtx">
        <?php echo $value['text']; ?>
       </div>
      </div>
     </div>

     <div class="clr"></div>

     <?php echo $value['shorttext']; ?>
    </div>
   <?php endforeach; ?>

  </div>
 <?php endif; ?>

  <div class="clr"></div>

  <!-- product tab -->
  <div class="pdtab">

   <?php if (isset($SITE_CONTENT['views']) && !empty($SITE_CONTENT['views'])) : ?>
    <div class="tabmn">
     <ul class="mnls">

      <?php foreach ($SITE_CONTENT['views'] as $value) : ?>

       <?php if ($value['link'] == $OBJ_SUBPAGE) : ?>

        <li class="lsit ac">
         <div class="itbx">
          <?php echo $value['name']; ?>
         </div>
        </li>

       <?php else : ?>

        <li class="lsit">
         <a class="itlk" href="<?php echo anchor_wta(site_url('product/'.$OBJECT_LINK.'/'.$value['link'])); ?>">
          <?php echo $value['name']; ?>
         </a>
        </li>

       <?php endif; ?>

      <?php endforeach; ?>

     </ul>
    </div>
   <?php endif; ?>

   <?php if (isset($OBJ_SUBPAGE_DATA['view'])) echo $this->load->view('inside/object/'.$OBJ_SUBPAGE_DATA['view'], null, true); ?>

  </div>
  <!-- end product tab -->

</div>
<!-- end product -->

<?php if (isset($SITE_CONTENT['similar']) && !empty($SITE_CONTENT['similar'])) : ?>
 <div class="ct">
   <div class="cttt sm"><?php echo $this->lang->line('op_similar_title'); ?></div>

   <div class="cttl">
    <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['similar']), true); ?>

    <div class="clr"></div>
   </div>

 </div>
<?php endif; ?>

</div>
<!-- end #content -->