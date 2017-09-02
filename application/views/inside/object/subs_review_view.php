<div class="tabbx">

    <!-- box comments -->
    <div class="bxcmm">

	<!-- comment content -->
	<div class="cmmcnt lf">
	    <div class="cmmtt">Отзывы</div>
	    <?php if(!empty($SITE_CONTENT['comments'])): ?>
	    <?php foreach($SITE_CONTENT['comments'] as $one): ?>
	    <!-- comment item -->
	    <div class="cmmit">
		<div class="itus"><?php echo $one['name']; ?></div>
		<div class="itdt"><?php echo date('d.m.Y', strtotime($one['datetime'])); ?></div>
		<div class="clr"></div>
		<?php if($one['mark'] > 0): ?>
		<div class="itrt">
		    <input name="val" value="<?php echo $one['mark']; ?>" type="hidden">
		</div>
		<?php endif; ?>
		<div class="ittx">
		    <p><?php echo $one['text']; ?></p>
		</div>
	    </div>
	    <!-- end comment item -->
	    <?php endforeach; ?>
	    <?php else: ?>
	    <div>Отзывов пока нет!</div>
	    <?php endif; ?>

	    <?php
	    if (isset($SITE_CONTENT['product_pages']['count_page']) && $SITE_CONTENT['product_pages']['count_page'] > 1) :

	    $page_start = $SITE_CONTENT['product_pages']['this_page'] - $SITE_CONTENT['product_pages']['count_show_page'];
	    if ($page_start <= 0) $page_start = 1;

	    $page_finish = $SITE_CONTENT['product_pages']['this_page'] + $SITE_CONTENT['product_pages']['count_show_page'];
	    if ($page_finish > $SITE_CONTENT['product_pages']['count_page']) $page_finish = $SITE_CONTENT['product_pages']['count_page'];
	    ?>
	    <!-- pagination -->
	    <div class="pg">
		 <?php if ($SITE_CONTENT['product_pages']['this_page'] < $SITE_CONTENT['product_pages']['count_page']) : ?>
		<button class="pgmr" data-productid="<?php echo $SITE_CONTENT['object']['id'];?>" onclick="show_more_comment();">
		    <i class="icmr"></i>
		    <span class="mrtx">Показать еще отзывы</span>
		</button>
		<?php endif;?>

		<ul class="pgls">
		     <?php for ($i = $page_start; $i <= $page_finish; ++$i) : ?>
		       <?php if ($SITE_CONTENT['product_pages']['this_page'] == $i) : ?>
		    <li class="lsit ac">
			<?php echo $i; ?>
		    </li>
		    <?php else : ?>
		    <li class="lsit">
                        <a class="itlk" href="<?php echo anchor_wta(site_url('product/'.$__GEN['obj_link'].'/reviews/page/'.$i)), '#tabs'; ?>">
			    <?php echo $i; ?>
			</a>
		    </li>
		    <?php endif; ?>

      <?php endfor; ?>		    
		</ul>
		 <?php if ($SITE_CONTENT['product_pages']['this_page'] > 1) : ?>
		<a href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$__GEN['obj_link'].'/reviews/page/'.($SITE_CONTENT['product_pages']['this_page'] - 1))), '#tabs'; ?>" class="pgpr">
		    <i class="pgar"></i>Предыдущая
		</a>
		<?php else : ?>
<a style="pointer-events: none;" class="pgpr db">
		    <i class="pgar"></i>Предыдущая
		</a>
	<?php endif;?>
    <?php if ($SITE_CONTENT['product_pages']['this_page'] < $SITE_CONTENT['product_pages']['count_page']) : ?>
		<a href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'.$__GEN['obj_link'].'/reviews/page/'.($SITE_CONTENT['product_pages']['this_page'] + 1))), '#tabs'; ?>" class="pgnx">
		    Следующая<i class="pgar"></i>
		</a>
    <?php else : ?>
<a style="pointer-events: none;" class="pgnx db">
		    Следующая<i class="pgar"></i>
		</a>
<?php endif;?>
	    </div>
	    <!-- end pagination -->
<?php endif; ?>
	</div>
	<!-- end .comment content -->

	<!-- comment form -->
	<div class="cmmfm rg">
	    <div class="fmtt">Написать отзыв</div>
	    <form method="post" action="<?php echo anchor_wta('ajax/form-send/add_comment'); ?>">
		<input type="hidden" name="robot" value=""/>
		<input type="hidden" name="product_id" value="<?php echo $SITE_CONTENT['object']['id']; ?>"/>
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
	    </form>
	</div>
	<!-- end comment form -->

	<div class="clr"></div>

    </div>
    <!-- end box comments -->
</div>
<!-- end product tab -->
