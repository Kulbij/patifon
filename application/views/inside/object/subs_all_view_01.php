<div class="tabbx">
 <div class="bxlf">

  <?php if (
   (isset($SITE_CONTENT['object']['features_text']) && !empty($SITE_CONTENT['object']['features_text'])) ||
   (isset($SITE_CONTENT['object']['filters']) && !empty($SITE_CONTENT['object']['filters']))
  ) : ?>
   <div class="bxft">
     <div class="fttt"><?php echo $this->lang->line('op_in_title_features_tex'); ?></div>

     <div class="ftmn">
      <ul class="mnls">
       <?php if (isset($SITE_CONTENT['object']['filters']) && !empty($SITE_CONTENT['object']['filters'])) : ?>
        <li class="lsit ac">
         <?php echo $this->lang->line('op_in_title_features_tex_main'); ?>
        </li>
       <?php endif; ?>

       <?php if (isset($SITE_CONTENT['object']['features_text']) && !empty($SITE_CONTENT['object']['features_text'])) : ?>
        <li class="lsit">
         <a class="itlk" href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$OBJECT_LINK.'/tab/characteristics#tabs')); ?>">
          <?php echo $this->lang->line('op_in_title_features_tex_all'); ?>
         </a>
        </li>
       <?php endif; ?>
      </ul>

      <div class="clr"></div>
     </div>

    <?php if (isset($SITE_CONTENT['object']['filters']) && !empty($SITE_CONTENT['object']['filters'])) : ?>
     <div class="ftsh">

      <?php foreach ($SITE_CONTENT['object']['filters'] as $value) : ?>
       <div class="ftit">
        <span class="ittt"><?php echo $value['parent_name']; ?></span>
        <?php echo $value['name']; ?>
       </div>
      <?php endforeach; ?>

     </div>
    <?php endif; ?>

   </div>
  <?php endif; ?>

  <?php if (isset($SITE_CONTENT['object']['text']) && !empty($SITE_CONTENT['object']['text'])) : ?>
   <div class="bxdc">
    <div class="dctt"><?php echo $this->lang->line('op_in_title_desc'); ?></div>

    <div class="dctx <?php if (isset($SITE_CONTENT['object']['text']) && mb_strlen($SITE_CONTENT['object']['text']) > 550) : ?>short<?php endif; ?>">
     <?php echo $SITE_CONTENT['object']['text']; ?>
    </div>

    <?php if (isset($SITE_CONTENT['object']['text']) && mb_strlen($SITE_CONTENT['object']['text']) > 550) : ?>
     <a class="dcmr toggle-all-text" href="javascript:void(0);" class="product-see-text"><?php echo $this->lang->line('op_in_title_desc_all'); ?></a>
    <?php endif; ?>

   </div>
  <?php endif; ?>

  <?php if (isset($SITE_CONTENT['object']['video']) && !empty($SITE_CONTENT['object']['video'])) : ?>
   <div class="bxvd">
    <div class="vdtt"><?php echo $this->lang->line('op_in_title_video'); ?></div>

    <div class="vdbx" style="width: 460px; height: 275px;">
     <?php echo $SITE_CONTENT['object']['video']; ?>
    </div>
   </div>
  <?php endif; ?>

 </div>

 <div class="bxrg">

   <!-- box comments -->
   <div class="bxcmm">

   <?php if(isset($SITE_CONTENT['comments']) && !empty($SITE_CONTENT['comments'])):?>
     <!-- comment content -->
     <div class="cmmcnt">
       <div class="cmmtt">Отзывы</div>

       <div class="cmmadd">
         <i class="iccmm"></i>
         <a class="addlk" href="<?php echo anchor_wta('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'. $OBJECT_LINK . '/tab/reviews#tabs');?>">Написать отзыв</a>
       </div>
       <!-- comment item -->
	<?php foreach($SITE_CONTENT['comments'] as $one):?>
	     <div class="cmmit">
	       <div class="itus"><?php echo $one['name'];?></div>
	       <div class="itdt"><?php echo date("d.m.Y",strtotime($one['datetime']));?></div>
	       <div class="clr"></div>
	       <div class="itrt">
		 <input name="val" value="<?php echo $one['mark'];?>" type="hidden">
	       </div>
	       <div class="ittx">
		 <p><?php echo $one['text'];?></p>
	       </div>
	     </div>  
	<?php endforeach;?>
       <!-- end comment item -->
     </div>
     <!-- end .comment content -->
     <a class="cmmmr" href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$OBJECT_LINK.'/tab/reviews#tabs')); ?>">
       Все отзывы<i class="icmr"></i>
     </a>
     <?php else:?>
     <!-- comment form -->
     <form method="post" action="<?php echo anchor_wta('ajax/form-send/add_comment');?>">
	 <input type="hidden" name="robot" value=""/>
	 <input type="hidden" name="product_id" value="<?php echo $SITE_CONTENT['object']['id'];?>"/>
	      <div class="cmmfm rg">
		<div class="fmtt">Написать отзыв</div>

		<div class="fmbx">
		  <div class="bxfld">
		    <div class="fldtt">Ваше имя*</div>
		    <input class="fldtx" name="name" type="text">
		  </div>

		  <div class="bxfld">
		    <div class="fldtt">Отзыв*</div>
		    <textarea class="fldtxar" name="text" rows="5" cols="30"></textarea>
		  </div>

		  <div class="bxfld">
		    <div class="fldtt">Оценка</div>

		    <div class="fldrt">
		      <ul class="rtls">
			<li class="lsit">
			    <a class="itlk" data-mark="1" data-text="Плохо" href="javascript:void(0)"></a>
			</li>

			<li class="lsit">
			  <a class="itlk" data-mark="2" data-text="Удовлетворительно" href="javascript:void(0)"></a>
			</li>

			<li class="lsit">
			  <a class="itlk" data-mark="3" data-text="Нормально"  href="javascript:void(0)"></a>
			</li>

			<li class="lsit">
			  <a class="itlk" data-mark="4" data-text="Хорошо" href="javascript:void(0)"></a>
			</li>

			<li class="lsit">
			  <a class="itlk" data-mark="5" data-text="Отлично" href="javascript:void(0)"></a>
			</li>
		      </ul>
			<input type="hidden" name="mark" value="0"/>
			<div class="rttx"></div>
		      <div class="clr"></div>
		    </div>
		  </div>

		    <input class="ajax-form bxbt" type="button" value="Оставить отзыв">
		</div>
	      </div>
	 </form>
                  <!-- end comment form -->
   <?php endif;?>

   </div>
   <!-- end box comments -->

 </div>

 <div class="clr"></div>

 <?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
  <div class="bxpt">
   <div class="pttt"><?php echo $this->lang->line('op_in_title_photo'); ?></div>

   <?php $index = 1; foreach ($SITE_CONTENT['images'] as $value) : ?>
    <!--noindex-->
     <a class="ptit ownbox-form" href="<?php echo anchor_wta(site_url('ajax/form/product')); ?>" data-post="object=<?php echo $OBJECT_ID; ?>&image=<?php echo $index; ?>">
      <span class="itvral">
          <img class="itim" src="<?php if (isset($value['image_big'])) echo baseurl($value['image_big']); ?>" alt="<?php if (isset($SITE_CONTENT['object']['name'])) echo $SITE_CONTENT['object']['name']; ?>" title="<?php if (isset($SITE_CONTENT['object']['name'])) echo $SITE_CONTENT['object']['name']; ?>">
      </span>
     </a>
    <!--/noindex-->
   <?php ++$index; endforeach; ?>

   <div class="clr"></div>
  </div>
 <?php endif; ?>

 <?php if (isset($SITE_CONTENT['accesories']) && $SITE_CONTENT['accesories']) : ?>
  <div class="ct">
   <div class="cttt sm"><?php echo $this->lang->line('op_in_title_accessories'); ?></div>

   <div class="cttl">

    <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['accesories']), true); ?>

    <div class="clr"></div>

    <a class="ctmr" href="<?php echo anchor_wta(site_url('product/'.$OBJECT_LINK.'/accessories')); ?>">
     <?php echo $this->lang->line('op_in_title_accessories_all'); ?><i class="icmr"></i>
    </a>
   </div>

  </div>
 <?php endif; ?>

</div>