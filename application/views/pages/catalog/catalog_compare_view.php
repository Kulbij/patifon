<div id="cnt">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>
    <!-- comparison -->
     <?php $compare = json_decode($this->input->cookie('compare'));
 if($compare === null) $compare = []; ?>
        <div class="cm">

          <!-- comparison info -->
          <div class="cmin">
            <div class="intt">Общие характеристики</div>
            <div class="init">Процессор</div>
            <div class="init">Оперативная память (RAM)</div>
            <div class="init">Камера, Мп</div>
            <div class="init">Размер экрана</div>
            <div class="init">Внутренняя память (ROM)</div>
            <div class="init">Операционная система</div>  
            <div class="init">Аккумулятор</div>
            <div class="init">3G</div>
            <div class="init">Sim-карты</div>

          </div>
          <!-- end comparison info -->

          <!-- comparison content -->
          <div class="cmcnt">
            <!-- comparison item -->
      <?php $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array(); ?>
      <?php foreach($SITE_CONTENT['catalog'] as $one):?>
            <div class="cmit <?php if (
      (isset($one['in_stock']) && !$one['in_stock']) ||
      (isset($one['avail']) && $one['avail'])
     ) echo 'plof';?>">
              <a rel="nofollow" class="itim ownbox-form" href="<?php echo anchor_wta('ajax/form/product');?>" data-post="object=<?php echo $one['id'];?>&image=0">
                <span class="imvral">
                  <img class="imim" src="<?php echo baseurl($one['image']);?>" alt="#">
                </span>
              </a>
              <div class="itsp">
      <?php if (isset($one['share_class']) && !empty($one['share_class'])) : ?>
                <i class="spic <?php echo $one['share_class']; ?>"></i>
    <?php endif; ?>
                <?php if (isset($one['old_price']) && $one['old_price'] > $one['price']) : $percent = 100 - $one['old_price']/($one['price']/100);?>
                <div class="itds"><?php echo floor($percent) . '%';?></div>
                <?php endif;?>
                <?php if (
      (isset($one['in_stock']) && !$one['in_stock']) ||
      (isset($one['avail']) && $one['avail'])
     ) :?>
                    <i class="icavtx"></i>
                    <?php endif;?>
              </div>

              <div class="itrt">
                <input name="val" value="<?php echo $one['mark'];?>" type="hidden">
              </div>

              <div class="itcmm">
                <i class="iccmm"></i>
                <a class="cmmlk" href="<?php echo anchor_wta(site_url('catalog/'.$one['links']['parentcategorylink'].'/'.$one['links']['categorylink'].'/'.$one['link'].'/reviews#tabs')); ?>"><?php echo $one['comm_count'];?></a>
              </div>
              <div class="clr"></div>
              <div class="ittt">
                <a class="ttlk" href="<?php echo anchor_wta(site_url('catalog/'.$one['links']['parentcategorylink'].'/'.$one['links']['categorylink'].'/'.$one['link'])); ?>"><?php echo $one['name'];?></a>
              </div>
              <div class="itpr itprol">
                <?php echo $this->input->price_format($one['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep'));?> <span class="prvl">грн</span>
    <?php if(isset($one['old_price']) && $one['old_price'] > 0):?>
        <div class="prol">
          <?php echo $this->input->price_format($one['old_price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep'));?> <span class="olvl">грн</span>
          <span class="olln"></span>
        </div>
    <?php endif;?>
              </div>

              <input class="itbt <?php if (
      (isset($one['in_stock']) && !$one['in_stock']) ||
      (isset($one['avail']) && $one['avail'])
     ) echo 'db" disabled="disabled'; ?>" type="submit" value="Купить" onclick="cart_buy({id: '<?php echo $one['id']; ?>', quantity: 1, color: 0}, 1);">

              <div class="clr"></div>

              <a data-product="<?php echo $one['id'];?>" class="itcm <?php if(in_array($one['id'], $compare)) echo 'ac';?>" href="<?php echo anchor_wta('add_to_compare');?>" href="<?php echo anchor_wta('add_to_compare');?>">
                <i class="icchbx"></i>
                <span class="cmtx"><?php if(in_array($one['id'], $compare)) echo 'Убрать из сравнения'; else echo "Добавить к сравнению";?></span>
              </a>

              <a class="itlik operation-link <?php if (in_array($one['id'], $cookie)) echo 'ac'; ?>" href="<?php echo anchor_wta(site_url('ajax/operation/favorite')); ?>" data-post="product=<?php echo $one['id']; ?>">
                <span class="liknm"><?php echo $one['favorite_count'];?></span>
                <i class="iclik"></i>
              </a>

              <div class="clr"></div>

              <div class="itft">
                <div class="fttt">Общие характеристики</div>
    <?php $counter=0; foreach($one['filters'] as $key => $item):?>
                <div class="ftit"><span class="itvral"><?php echo $item;?></span></div>
        <?php if($key == 27) break;?>       
    <?php $counter++;endforeach;?>                
              </div>
            </div>
            <!-- comparison item -->
      <?php endforeach;?>    
          </div>
          <!-- end comparison content -->
          <div class="clr"></div>
        </div>

  </div>

 <div class="clr"></div>
</div>