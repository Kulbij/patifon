<div class="ownbox-content fmpd">
    <div class="fmtt"><?php echo $SITE_CONTENT['object']['name']; ?></div>
    <a class="fmex ownbox-close" href="javascript:void(0);"></a>
    <?php
    $compare = json_decode($this->input->cookie('compare'));
    if ($compare === null)
	$compare = [];
    ;
    ?>
    <div class="pd">

	<!-- jCarousel -->
	<script type="text/javascript">
	    $(document).ready(function () {

		var connector = function (itemNavigation, carouselStage) {
		    return carouselStage.jcarousel('items').eq(itemNavigation.index());
		};

		var carouselStage = $('.pdjc').jcarousel();
		var carouselNavigation = $('.pdcnpg').jcarousel();
		
		carouselStage.jcarousel({
		    wrap: 'circular'
		});

		carouselNavigation.jcarousel('items').each(function () {
		    var item = $(this);

		    var target = connector(item, carouselStage);
		    
		    item
			    .on('jcarouselcontrol:active', function () {
				carouselNavigation.jcarousel('scrollIntoView', this);
				item.addClass('ac');
			    })
			    .on('jcarouselcontrol:inactive', function () {
				item.removeClass('ac');
			    })
			    .jcarouselControl({
				target: target,
				carousel: carouselStage
			    });		
		});
    		carouselStage.jcarousel('scrollIntoView', <?php echo (int) $SITE_CONTENT['image']; ?>);
    		//carouselNavigation.jcarousel('scroll', <?php echo (int) $SITE_CONTENT['image']; ?>);
		$('.cnpr').on('jcarouselcontrol:active', function () {
		    $(this).removeClass('db');
		}).on('jcarouselcontrol:inactive', function () {
		    $(this).addClass('db');
		}).jcarouselControl({
		    target: '-=1'
		});

		$('.cnnx').on('jcarouselcontrol:active', function () {
		    $(this).removeClass('db');
		}).on('jcarouselcontrol:inactive', function () {
		    $(this).addClass('db');
		}).jcarouselControl({
		    target: '+=1'
		});
	    });
	</script>
	<!-- end jCarousel -->

	<div class="pdim">
	    <div class="pdjc">
		<ul class="jcls">

<?php if (isset($SITE_CONTENT['object']['image_big']) && !empty($SITE_CONTENT['object']['image_big'])) : ?>
    		    <li class="lsit">
    			<span class="itvral">
    			    <img class="itim" src="<?php echo baseurl($SITE_CONTENT['object']['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" />
    			</span>
    		    </li>
		    <?php endif; ?>

<?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
    <?php foreach ($SITE_CONTENT['images'] as $value) : ?>
			    <li class="lsit">
				<span class="itvral">
				    <img class="imim" src="<?php echo baseurl($value['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" />
				</span>
			    </li>
    <?php endforeach; ?>
<?php endif; ?>

		</ul>
	    </div>
	    <a class="cnpr" href="#"></a>
              <a class="cnnx" href="#"></a>
	    <div class="pdcnpg">
		<ul>

<?php if (isset($SITE_CONTENT['object']['image_big']) && !empty($SITE_CONTENT['object']['image_big'])) : ?>
    		    <li class="pglk">
    			<a href="javascript:void(0);">
    			    <span class="lkvral">
    				<img class="lkim" src="<?php echo baseurl($SITE_CONTENT['object']['image_big']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" />
    			    </span>
    			    <span class="lkhv"></span>
    			</a>
    		    </li>
		    <?php endif; ?>

<?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
    <?php foreach ($SITE_CONTENT['images'] as $value) : ?>
			    <li class="pglk">
				<a href="javascript:void(0);">
				    <span class="lkvral">
					<img class="lkim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" />
				    </span>
				    <span class="lkhv"></span>
				</a>
			    </li>
    <?php endforeach; ?>
<?php endif; ?>

		</ul>
	    </div>

	    <div class="pdsp">
<?php if (isset($SITE_CONTENT['object']['share_class']) && !empty($SITE_CONTENT['object']['share_class'])) : ?>
                <?php foreach($SITE_CONTENT['object']['share_class'] as $one):?>
    		<i class="spic <?php echo $one; ?>"></i>
                <?php endforeach;?>
<?php endif; ?>
                <?php if (isset($SITE_CONTENT['object']['old_price']) && $SITE_CONTENT['object']['old_price'] > $SITE_CONTENT['object']['price']) : $percent = 100 - $SITE_CONTENT['object']['old_price']/($SITE_CONTENT['object']['price']/100);?>
                <div class="itds"><?php echo floor($percent) . '%';?></div>
                <?php endif;?>
                 <?php if (
       (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
       (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
      ) : ?>
      			<?php /* ?>
                <i class="icavtx"></i>
                <?php */ ?>
                <?php endif;?>
	    </div>

	    <div class="clr"></div>
	</div>

	<div class="pdin">
	    <div class="pdav">
		<?php
		if (
			(isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
			(isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
		) :
		    ?>
    		<i class="icav no"></i>
    <?php echo $this->lang->line('op_not_in_stock'); ?>
	    <?php else : ?>
    
    <?php if(isset($SITE_CONTENT['object']['delivery_3_5']) && $SITE_CONTENT['object']['delivery_3_5'] == 1):?>
              <i class="icav wait"></i>
                Ожидание 2-3 дня
         <?php else : ?>
         	<i class="icav yes"></i>
         	<?php echo $this->lang->line('op_in_stock'); ?>
         <?php endif;?>

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
	    			<a class="itlk" href="<?php echo anchor_wta(site_url('catalog/'.$value['links']['parentcategorylink'].'/'.$value['links']['categorylink'].'/' . $value['link'])); ?>">
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
            <div class="pdbuy">
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

	    <?php
	    if (
		    (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
		    (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
	    ) :
		?>
    	    <input class="pdbt db" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" disabled="disabled" />
		<?php else : ?>
             <?php if(isset($SITE_CONTENT['object']['delivery_3_5']) && $SITE_CONTENT['object']['delivery_3_5'] == 1):?>
                <div class="pdtx">Доставка 3-5 дней</div>
                <?php endif;?>
    	    <input class="pdbt" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" onclick="cart_buy({id: '<?php echo $SITE_CONTENT['object']['id']; ?>', quantity: 1, color: 0}, 1);" />
		       <?php endif; ?>
            </div>
	    <form action="<?php echo anchor_wta(site_url('ajax/form-send/buyback')); ?>" method="post">

		<input class="pdph" name="phone" type="text" placeholder="+38 (___) ___–__–__" value="+38 (___) ___–__–__" <?php
		       if (
			       (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
			       (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
		       ) :
			   ?>disabled="disabled"<?php endif; ?> />

		<input class="ajax-form pdbt2 <?php
		   if (
			   (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
			   (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
		   )
		       echo 'db';
		       ?>" type="button" value="<?php echo $this->lang->line('site_buy_one_click'); ?>" <?php
		   if (
			   (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
			   (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
		   ) :
		       ?>disabled="disabled"<?php endif; ?> />

		<input type="hidden" name="link" value="<?php echo $SITE_CONTENT['object']['id']; ?>" />
		<input type="hidden" name="robot" value="" />
	    </form>

	    <div class="clr"></div>

	    <div class="pdbx">
		<div class="pdrt">
		    <script type="text/javascript">
			$(document).ready(function () {

			    $('.pdrt').rating({
				fx: 'float',
				image: 'public/images/content/icon/rating-big.png',
				loader: 'public/images/content/icon/load-rating-big.png',
				minimal: 0.1,
				readOnly: true
			    });

			    $('input[name=phone]').mask('+38 (999) 999–99–99');

			});
		    </script>
		    <input name="val" value="<?php echo $SITE_CONTENT['object']['mark']; ?>" type="hidden" />
		</div>

		<div class="pdcmm">
		    <i class="iccmm"></i>
		    <a class="cmmlk" href="<?php echo anchor_wta(site_url('catalog/'.$SITE_CONTENT['object']['links']['parentcategorylink'].'/'.$SITE_CONTENT['object']['links']['categorylink'].'/'  . $SITE_CONTENT['object']['link'] . '/tab/reviews#tabs')); ?>"><?php echo $SITE_CONTENT['object']['comm_count']; ?></a>
		</div>

		<a class="pdcm <?php if (in_array($SITE_CONTENT['object']['id'], $compare)) echo 'ac'; ?>" href="<?php echo anchor_wta('add_to_compare'); ?>" data-product="<?php echo $SITE_CONTENT['object']['id']; ?>">
		    <i class="icchbx"></i>
		    <span class="cmtx"><?php if (in_array($SITE_CONTENT['object']['id'], $compare)) echo 'Убрать из сравнения';
		else echo "Добавить к сравнению"; ?></span>
		</a>

		<a class="pdlik operation-link <?php
		$cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();
		if (in_array($SITE_CONTENT['object']['id'], $cookie))
		    echo 'ac';
		       ?>" href="<?php echo anchor_wta(site_url('ajax/operation/favorite')); ?>" data-post="product=<?php echo $SITE_CONTENT['object']['id']; ?>">
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
			    <p class="ittx"><?php echo $value['name']; ?></p>
			</div>
    <?php endforeach; ?>

    	    </div>
<?php endif; ?>

	</div>

	<div class="clr"></div>
    </div>

</div>


