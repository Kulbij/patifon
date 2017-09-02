<?php
 if (isset($catalog) && !empty($catalog)) :

 $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();

?>
<?php foreach ($catalog as $value) : ?>

 <?php if (isset($_list) && $_list) : ?>

  <?php if(isset($value['name'])) : ?>

<div class="ct-box">
  <div class="ctit <?php if (
     (isset($value['in_stock']) && !$value['in_stock']) ||
     (isset($value['avail']) && $value['avail'])
    ) echo 'plof'; ?>">
   <a class="itim" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
    <span class="imvral">
        <img class="imim" src="<?php echo baseurl($value['image']); ?>" title="<?php echo $value['name'];?>" alt="<?php echo $value['name']; ?>" />
    </span>
   </a>
     
   <div class="itsp <?php if(isset($__PAGE) && $__PAGE == 'index' || $__PAGE == 'catalog') echo 'msp';?>">
    <?php if (isset($value['share_class']) && !empty($value['share_class']) && is_array($value['share_class'])) : ?>
       <?php foreach($value['share_class'] as $one):?>
             <i class="spic <?php echo $one; ?>"></i>
       <?php endforeach;?>
    <?php endif; ?>

    <?php if (
     (isset($value['in_stock']) && !$value['in_stock']) ||
     (isset($value['avail']) && $value['avail'])
    ) : ?>
     <i class="icav no"></i>
    <?php else : ?>
     <i class="icav yes"></i>
    <?php endif; ?>
   </div>

   <div class="itinn">
    <div class="ittt">
     <?php if(isset($CATEGORYLINK)):?>
     <a class="ttlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
         <?php else:?>         
     <a class="ttlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
         <?php endif ;?>
      <?php echo $value['name']; ?>         
     </a>
        
    </div>

    <div class="itrt">
      <input name="val" value="<?php echo $value['mark'];?>" type="hidden" />
    </div>

    <div class="itcmm">
      <i class="iccmm"></i>
      <?php if(isset($CATEGORYLINK)):?>
      <?php if(!empty($PARENTCATEGORYLINK)):?>
      <a class="cmmlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$value['link'].'/tab/reviews#tabs'));?>"><?php echo $value['comm_count'];?></a>
      <?php else:?>
      <a class="cmmlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link'].'/tab/reviews#tabs'));?>"><?php echo $value['comm_count'];?></a>
      <?php endif;?>
      <?php else:?>
      <a class="cmmlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/'.$CATEGORYLINK.'/'.$value['link'].'/tab/reviews#tabs'));?>"><?php echo $value['comm_count'];?></a>
      <?php endif;?>
    </div>
    <a class="itcm" href="<?php echo anchor_wta('add_to_compare');?>" data-product="<?php echo $value['id'];?>">
      <i class="icchbx"></i>
      <span class="cmtx">Убрать из сравнения</span>
    </a>

    <a class="itlik operation-link <?php if (in_array($value['id'], $cookie)) echo 'ac'; ?>" href="<?php echo anchor_wta(site_url('ajax/operation/favorite')); ?>" data-post="product=<?php echo $value['id']; ?>">
     <span class="liknm"><?php echo $value['favorite_count']; ?></span>
     <i class="iclik"></i>
    </a>

    <div class="clr"></div>

    <?php
     if (isset($value['filters']) && !empty($value['filters'])) :
     $array_chunk = array_chunk($value['filters'], ceil(count($value['filters'])/2), true);
    ?>
     <div class="itft">
      <?php foreach ($array_chunk as $chunk) : ?>
       <div class="ftbx">

        <?php foreach ($chunk as $item) : ?>
         <div class="ftit">
          <i class="itic <?php echo $item['class']; ?>"></i>
          <p class="ittx"><?php echo $item['name']; ?></p>    
         </div>
        <?php endforeach; ?>

       </div>
      <?php endforeach; ?>

       <div class="clr"></div>
      </div>
     <?php endif; ?>

     <div class="itbx">
      <div class="itpr itprol">
       <?php if (isset($value['price']) && $value['price'] > 0) : echo $this->input->price_format($value['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <span class="prvl"><?php echo $this->lang->line('site_valuta'); ?></span><?php else : echo '&nbsp;'; endif; ?>

       <?php if (isset($value['old_price']) && $value['old_price'] > $value['price']) : ?>
        <div class="prol">
         <?php echo $this->input->price_format($value['old_price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <span class="olvl"><?php echo $this->lang->line('site_valuta'); ?></span>
         <span class="olln"></span>
        </div>
       <?php endif; ?>
      </div>

      <?php if (
       (isset($value['in_stock']) && !$value['in_stock']) ||
       (isset($value['avail']) && $value['avail'])
      ) : ?>
       <input class="itbt db" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" disabled="disabled" />
      <?php else : ?>
       <input class="itbt" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" onclick="cart_buy({id: '<?php echo $value['id']; ?>', quantity: 1, color: 0}, 1);" />
      <?php endif; ?>

      <div class="clr"></div>
     </div>
    </div>

   <div class="clr"></div>
  </div>

</div>

<?php endif; ?>

 <?php else : ?>

<?php if(isset($value['name'])) : ?>

<div class="ct-box">
  <div class="ctit <?php if (
     (isset($value['in_stock']) && !$value['in_stock']) ||
     (isset($value['avail']) && $value['avail'])
    ) echo 'plof'; ?>">
   <div class="itinn">
       <?php if(isset($CATEGORYLINK)):?>
       <?php if(!empty($PARENTCATEGORYLINK)):?>
     <a class="itim" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
         <?php else:?>
     <a class="itim" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link'])); ?>">
         <?php endif;?>
         <?php else:?>
             <a class="itim" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/'.$value['link'])); ?>">
         
         <?php endif;?>
      <span class="imvral">
          <img class="imim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>" title="<?php echo $value['name'];?>">
      </span>
     </a>

     <div class="itsp <?php if(isset($__PAGE) && $__PAGE == 'index' || $__PAGE == 'catalog') echo 'msp';?>">
      <?php if (isset($value['share_class']) && !empty($value['share_class']) && is_array($value['share_class'])) : ?>
         <?php foreach($value['share_class'] as $one):?>
           <i class="spic <?php echo $one; ?>"></i>
         <?php endforeach;?>
      <?php endif; ?>
<?php if (isset($value['old_price']) && $value['old_price'] > $value['price']) : $percent = 100 - $value['old_price']/($value['price']/100);?>
                <div class="itds"><?php echo floor($percent) . '%';?></div>
                <?php endif;?>
      <?php if (
       (isset($value['in_stock']) && !$value['in_stock']) ||
       (isset($value['avail']) && $value['avail'])
      ) : ?>
       <i class="icav no"></i>
       <?php /* ?>
       <?php */ ?>
      <?php else : ?>
        <?php if(isset($value['delivery_3_5']) && $value['delivery_3_5'] == 1):?>
          <i class="icav wait"></i>
        <?php else : ?>
        <i class="icav yes"></i>
        <?php endif; ?>
      <?php endif; ?>

     </div>

     <div class="itrt">
      <input name="val" value="<?php echo $value['mark'];?>" type="hidden" />
     </div>

     <div class="itcmm">
      <i class="iccmm"></i>
      <?php if(isset($PARENTCATEGORYLINK)):?>
      <?php if(!empty($PARENTCATEGORYLINK)):?>
      <a class="cmmlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$value['link']));?>#subs-review-view"><?php echo $value['comm_count'];?></a>
      <?php else:?>
      <a class="cmmlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link']));?>#subs-review-view"><?php echo $value['comm_count'];?></a>
       <?php endif;?>
      <?php else:?>
      
      <a class="cmmlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/'.$value['link']));?>#subs-review-view"><?php echo $value['comm_count'];?></a>
      <?php endif;?>
     </div>

     <div class="clr"></div>

     <div class="ittt">
         <?php if(isset($PARENTCATEGORYLINK)):?>
         <?php if(!empty($PARENTCATEGORYLINK)):?>
      <a class="ttlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$value['link'])); ?>"><?php echo $value['name']; ?></a>
      <?php else:?>
      <a class="ttlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$CATEGORYLINK.'/'.$value['link'])); ?>"><?php echo $value['name']; ?></a>
      <?php endif;?>
       <?php else:?>
      
      <a class="ttlk" href="<?php echo anchor_wta(str_replace('//','/','catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/'.$value['link'])); ?>"><?php echo $value['name']; ?></a>
      <?php endif;?>
     </div>

     <div class="itpr itprol">
      <?php if (isset($value['price']) && $value['price'] > 0) : echo $this->input->price_format($value['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <span class="prvl"><?php echo $this->lang->line('site_valuta'); ?></span><?php else : echo '&nbsp;'; endif; ?>

      <?php if (isset($value['old_price']) && $value['old_price'] > $value['price']) : ?>
       <div class="prol">
        <?php echo $this->input->price_format($value['old_price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <span class="olvl"><?php echo $this->lang->line('site_valuta'); ?></span>
        <span class="olln"></span>
       </div>
      <?php endif; ?>
     </div>
     <?php if (
      (isset($value['in_stock']) && !$value['in_stock']) ||
      (isset($value['avail']) && $value['avail'])
     ) : ?>
      <input class="itbt db" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" disabled="disabled" />
     <?php else : ?>
      <input class="itbt" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" onclick="cart_buy({id: '<?php echo $value['id']; ?>', quantity: 1, color: 0, warranty: $('#warranty').val(), id_product: <?php echo $value['id']; ?>}, 1);">
     <?php endif; ?>

     <div class="clr"></div>

     <?php if(isset($value['product-visible']) && !empty($value['product-visible']) && $value['product-visible'] == 1) : ?>
     <a class="itcm <?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) && in_array($value['id'],  json_decode($this->input->cookie('compare')))) echo 'ac';?>" data-product="<?php echo $value['id'];?>" href="<?php if (isset($_COOKIE[$this->config->item('compare_catalog_cookie_var')]) && count($_COOKIE[$this->config->item('compare_catalog_cookie_var')]) > 1) echo anchor_wta('compare'); else echo anchor_wta('add_to_compare');?>">
      <i class="icchbx"></i>
      <span class="cmtx">
        <?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) 
        && in_array($value['id'],  json_decode($this->input->cookie('compare')))) 
        if($this->input->cookie($this->config->item('compare_catalog_cookie_var')) > 1)
        echo "Удалить";
      else
        echo 'Убарать из сравнения'; else echo 'Добавить к сравнению';?></span>
     </a>
     <?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) 
        && in_array($value['id'],  json_decode($this->input->cookie('compare')))
        && $this->input->cookie($this->config->item('compare_catalog_cookie_var')) > 1)  : ?>
     <a class="cmrm" href="<?php echo anchor_wta('compare'); ?>">
      <span class="cmtx">В сравнение</span>
     </a>
      <?php endif; ?>
    <?php endif; ?>

     <a class="itlik operation-link <?php if (in_array($value['id'], $cookie)) echo 'ac'; ?>" href="<?php echo anchor_wta(site_url('ajax/operation/favorite')); ?>" data-post="product=<?php echo $value['id']; ?>">
      <span class="liknm"><?php echo $value['favorite_count']; ?></span>
      <i class="iclik"></i>
     </a>

     <div class="clr"></div>

     <?php if (isset($value['filters']) && !empty($value['filters'])) : ?>
      <div class="itft">
       <?php foreach ($value['filters'] as $item) : ?>
        <div class="ftit">
         <?php if(empty($item['class'])) : ?>
            <i class="itic no-icon <?php echo $item['class_new']; ?>"></i>
         <?php else : ?>
         <i class="itic <?php echo $item['class']; ?>"></i>
        <?php endif; ?>
         <p class="ittx"><?php echo $item['name']; ?></p>
        </div>
       <?php endforeach; ?>
      </div>
     <?php endif; ?>

   </div>
  </div>

</div>

<?php endif; ?>

 <?php endif; ?>

<?php endforeach; ?>
<?php endif; ?>