<div class="sdbr">
 <?php if (isset($SITE_TOP['menu']) && !empty($SITE_TOP['menu'])) : ?>
 <?php if($SITE_TOP['url'][0]['id'] != '6') : ?>
  <div class="fr">
   <div class="frtt"><?php echo $this->lang->line('cat_left_menu_title'); ?></div>

   <!-- filter box -->
   <div class="frbx">
    <ul class="bxls">

     <?php foreach ($SITE_TOP['menu'] as $value) : ?>

      <?php if (isset($CATEGORY_PAR) && $CATEGORY_PAR == $value['id']) : ?>
       <li class="lsit ac">
        <i class="icchbx"></i>
          <span class="lktx">
            <span class="txbd">
              <span class="lktx"><?php echo $value['name']; ?></span>
            </span>
          </span>
       </li>
      <?php else : ?>
        <?php if($SITE_TOP['url']['0']['id'] == '1') : ?>
          <?php if($value['id'] != '6') : ?>
           <li class="lsit">           
            <a class="itlk" href="<?php echo anchor_wta(site_url('catalog/'.$value['link'])); ?>">
             <i class="icchbx"></i>
              <span class="lktx">
                <span class="txbd">
                  <span class="lktx"><?php echo $value['name']; ?></span>
                </span>
              </span>
            </a>
           </li>
          <?php endif; ?>
        <?php else : ?>
          <li class="lsit">           
            <a class="itlk" href="<?php echo anchor_wta(site_url('catalog/'.$value['link'])); ?>">
             <i class="icchbx"></i>
              <span class="lktx">
                <span class="txbd">
                  <span class="lktx"><?php echo $value['name']; ?></span>
                </span>
              </span>
            </a>
           </li>
        <?php endif; ?>
      <?php endif; ?>

     <?php endforeach; ?>

    </ul>
   </div>
    
   <!-- filter box -->

  </div>
  <?php endif; ?>
 <?php endif; ?>

 <?php if (isset($SITE_LEFTPANEL['FILTERS']) && !empty($SITE_LEFTPANEL['FILTERS'])) : ?>
  <div class="fr">
   <div class="frtt"><?php echo $this->lang->line('cat_left_filter_title'); ?></div>

   <?php if (isset($SITE_LEFTPANEL['RESET_BUTTON']) && $SITE_LEFTPANEL['RESET_BUTTON'] !== false) : ?>
   <?php if(!empty($PARENTCATEGORYLINK)):?>
    <a class="frrs" href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/filter/'.$SITE_LEFTPANEL['RESET_BUTTON'])); ?>"><?php echo $this->lang->line('cat_reset_button'); ?></a>
    <?php else:?>
    <a class="frrs" href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/filter/'.$SITE_LEFTPANEL['RESET_BUTTON'])); ?>"><?php echo $this->lang->line('cat_reset_button'); ?></a>
    <?php endif;?>
   <?php endif; ?>

   <?php
    foreach ($SITE_LEFTPANEL['FILTERS'] as $value) :
     if (
      (isset($value['field']) && $value['field'] == 'price' &&
       (
        (isset($SITE_CONTENT['FILTER']['max-price'][0]) && $SITE_CONTENT['FILTER']['max-price'][0] > 0) ||
        (isset($SITE_LEFTPANEL['PRICES']['price']) && $SITE_LEFTPANEL['PRICES']['price'] > 0)
       )
      ) ||
      (isset($value['field']) && isset($value['children']) && !empty($value['children']))
     ) :
   ?>

    <?php if (isset($value['field']) && $value['field'] == 'price') : ?>

     <div class="frbx">
      <div class="bxtt"><?php if (isset($value['name'])) echo $value['name']; ?></div>
      <div class="slrn"></div>

      <div class="slrnbx">
       <input class="bxtx slmin" type="text" value="<?php if (isset($SITE_CONTENT['FILTER']['min-price'][0])) echo $SITE_CONTENT['FILTER']['min-price'][0]; else echo 0 ; ?>" />
       &mdash;
       <input class="bxtx slmax" type="text" value="<?php if (isset($SITE_CONTENT['FILTER']['max-price'][0])) echo $SITE_CONTENT['FILTER']['max-price'][0]; else echo (isset($SITE_LEFTPANEL['PRICES']['price']) && $SITE_LEFTPANEL['PRICES']['price'] > 0) ? $SITE_LEFTPANEL['PRICES']['price'] : 0 ; ?>" />
       <?php echo $this->lang->line('site_valuta'); ?>
      </div>

     </div>

    <?php elseif (isset($value['field']) && isset($value['children']) && !empty($value['children'])) : ?>

     <!-- filter box -->
     <div class="frbx">
      <div class="bxtt"><?php if (isset($value['name'])) echo $value['name']; ?></div>

      <ul class="bxls">

       <?php foreach ($value['children'] as $subvalue) : ?>
        <li class="lsit <?php if (isset($subvalue['link']) && isset($SITE_CONTENT['FILTER'][$value['field']]) && in_array($subvalue['link'], $SITE_CONTENT['FILTER'][$value['field']])) echo 'ac'; ?>">
            <?php if(!empty($PARENTCATEGORYLINK)):?>
         <a class="itlk" href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/filter/'.$subvalue['linker'])); ?>">
             <?php else:?>
         <a class="itlk" href="<?php echo anchor_wta(site_url('catalog/'.$CATEGORYLINK.'/filter/'.$subvalue['linker'])); ?>">
             <?php endif;?>
          <i class="icchbx"></i>
            <span class="lktx">
              <span class="txbd">
                <span class="lktx"><?php if (isset($subvalue['name_short'])) echo $subvalue['name_short']; ?></span>
              </span>
            </span>
          </a>
        </li>
       <?php endforeach; ?>

      </ul>
     </div>
     <!-- filter box -->

    <?php endif; ?>

   <?php endif; endforeach; ?>

  </div>
 <?php endif; ?>

</div>