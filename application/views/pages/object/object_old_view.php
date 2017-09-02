<div id="cnt">
    <?php echo $this->load->view('inside/bread_view', null, true); ?>

    <div class="pd <?php
    if (
	    (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
	    (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
    )
	echo 'plof';
    ?>">

	<div class="pdim">

<?php if (isset($SITE_CONTENT['object']['image']) && !empty($SITE_CONTENT['object']['image'])) : ?>
    	    <!--noindex-->
    	    <a class="immain ownbox-form" href="<?php echo anchor_wta(site_url('ajax/form/product')); ?>" data-post="object=<?php echo $OBJECT_ID; ?>&image=0">
    		<span class="imvral">
                    <img class="imim" src="<?php echo baseurl($SITE_CONTENT['object']['image']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" title="<?php echo $SITE_CONTENT['object']['name'];?>">
    		</span>
    	    </a>
    	    <!--/noindex-->
	    <?php endif; ?>

<?php if (isset($SITE_CONTENT['images']) && !empty($SITE_CONTENT['images'])) : ?>
    <?php $index = 1;
    foreach ($SITE_CONTENT['images'] as $value) : ?>
		    <!--noindex-->
		    <a class="imit ownbox-form" href="<?php echo anchor_wta(site_url('ajax/form/product')); ?>" data-post="object=<?php echo $OBJECT_ID; ?>&image=<?php echo $index; ?>">
			<span class="imvral">
                            <img class="imim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $SITE_CONTENT['object']['name']; ?>" title="<?php echo $SITE_CONTENT['object']['name'];?>">
			</span>

			<span class="imhv"></span>
		    </a>
		    <!--/noindex-->
			<?php ++$index;
		    endforeach; ?>
		<?php endif; ?>

	    <div class="pdsp">
<?php if (isset($SITE_CONTENT['object']['share_class']) && !empty($SITE_CONTENT['object']['share_class']) && is_array($SITE_CONTENT['object']['share_class'])) : ?>
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

                    <?php endif;?>
	    </div>

	    <div class="clr"></div>
	</div>

	<!-- product info -->
	<div class="pdin">
<?php if ($SITE_CONTENT['object']['date_gift'] > date('Y-m-d')): ?>
    	    <script type="text/javascript" language="JavaScript" src="<?php echo site_url('public/js/own.timer.js'); ?>"></script>
    	    <script>
    		$(document).ready(function () {
    		    $.zTimer({
    			day: 'sh_day',
    			hour: 'sh_hour',
    			minute: 'sh_min',
    			second: 'sh_sec',
    			weekOn: false,
    			date: new Date(<?php echo strtotime($SITE_CONTENT['object']['date_gift']) * 1000; ?>)
    		    });
    		    $.zTimer('start');
    		});
    	    </script>
    	    <div class="pdtm">
    		<div class="tmnm">
    		    <i class="icnm"></i>
    		    <i class="icgf"></i>
    		    <?php echo $SITE_CONTENT['object']['gift'];?>
    		</div>

    		<div class="pdtmr">
    		    <div class="tmrtx">До окончания акции</div>

    		    <div class="tmrcnt">
    			<div class="cntnm" id="sh_day">
    			    00
    			    <div class="nmln"></div>
    			</div>

    			<div class="cnttx">дни</div>
    		    </div>

    		    <div class="tmrcln"></div>

    		    <div class="tmrcnt">
    			<div class="cntnm" id="sh_hour">
    			    00
    			    <div class="nmln"></div>
    			</div>

    			<div class="cnttx">часы</div>
    		    </div>

    		    <div class="tmrcln"></div>

    		    <div class="tmrcnt">
    			<div class="cntnm" id="sh_min">
    			    00
    			    <div class="nmln"></div>
    			</div>

    			<div class="cnttx">минуты</div>
    		    </div>

    		    <div class="tmrcln"></div>

    		    <div class="tmrcnt">
    			<div class="cntnm" id="sh_sec">
    			    00
    			    <div class="nmln"></div>
    			</div>

    			<div class="cnttx">секунды</div>
    		    </div>

    		    <div class="clr"></div>
    		</div>
                </div>
		<?php endif; ?>
	    <div class="pdav">
		<?php
		if (
			(isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
			(isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
		) :
		    ?>
    		<i class="icav no"></i>
		<?php echo $this->lang->line('op_not_in_stock'); ?>
		
		<!-- new upd -->

         <!-- end -->
<?php else : ?>
    		<!-- ПЕРЕУСТАНОВКА МЕСТАМИ -->

      <?php if(isset($SITE_CONTENT['object']['delivery_3_5']) && $SITE_CONTENT['object']['delivery_3_5'] == 1):?>
      <i class="icav wait"></i>
                Ожидание 2-3 дня
         <?php else : ?>
         <i class="icav yes"></i>
         	<?php echo $this->lang->line('op_in_stock'); ?>
         <?php endif;?>
                <!-- КОНЕЦ -->

<?php endif; ?>
	    </div>
	    <!-- 123 -->

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
	    			<a class="itlk" href="<?php echo anchor_wta(site_url('catalog/'.$value['links']['categorylink'].'/' . $value['link'])); ?>">
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
		<?php if (isset($SITE_CONTENT['object']['price'])) echo $this->input->price_format($SITE_CONTENT['object']['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?><span class="prvl"><?php echo $this->lang->line('site_valuta'); ?></span>
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
                
    	    <input class="pdbt db" type="button" value="<?php echo $this->lang->line('op_not_in_stock'); ?>" disabled="disabled" />
		       <?php else : ?>


		       <!-- БЫЛО ЗДЕСЬ -->



    	    <input class="pdbt" type="button" value="<?php echo $this->lang->line('site_buy'); ?>" onclick="cart_buy({id: '<?php echo $SITE_CONTENT['object']['id']; ?>', quantity: 1, color: 0, warranty: $('#warranty').val()}, 1);" />
		<?php endif; ?>
        </div>

	    <form action="<?php echo anchor_wta(site_url('ajax/form-send/buyback')); ?>" method="post">

		<input class="pdph" name="phone" type="text" placeholder="+38 (___) ___–__–__" <?php
		       if (
			       (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
			       (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
		       ) :
			   ?>  <?php endif; ?>>

		<input  class="ajax-form pdbt2 <?php
		       if (
			       (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
			       (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
		       )
			   echo 'off';
		       ?>" type="submit"
		       		<?php if (
			       (isset($SITE_CONTENT['object']['in_stock']) && !$SITE_CONTENT['object']['in_stock']) ||
			       (isset($SITE_CONTENT['object']['avail']) && $SITE_CONTENT['object']['avail'])
		       ) :
		       ?>
		       value="Сообщить о наличии" <?php else : ?> value="<?php echo $this->lang->line('site_buy_one_click'); ?>" 
		   <?php endif; ?>>

		<input type="hidden" name="link" value="<?php echo $OBJECT_ID; ?>" />
		<input type="hidden" name="robot" value="" />
	    </form>

	    <div class="clr"></div>

	    <div class="pdbx">
		<div class="pdrt">
		    <input name="val" value="<?php echo $SITE_CONTENT['object']['avg_mark']; ?>" type="hidden">
		</div>

		<div class="pdcmm">
		    <i class="iccmm"></i>
		    <a class="cmmlk" href="<?php echo anchor_wta(site_url('catalog/'.$PARENTCATEGORYLINK.'/'.$CATEGORYLINK.'/'. $OBJECT_LINK . '/tab/reviews#tabs')); ?>"><?php echo $SITE_CONTENT['comments_count']; ?></a>
		</div>

		<a class="pdcm <?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) && in_array($SITE_CONTENT['object']['id'], json_decode($this->input->cookie('compare')))) echo 'ac'; ?>" data-product="<?php echo $SITE_CONTENT['object']['id']; ?>" href="<?php echo anchor_wta('add_to_compare'); ?>" data-product="<?php echo $SITE_CONTENT['object']['id']; ?>" href="<?php echo anchor_wta('add_to_compare'); ?>">
		    <i class="icchbx"></i>
		    <span class="cmtx">
		    	<?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) 
		    	&& in_array($SITE_CONTENT['object']['id'], json_decode($this->input->cookie('compare')))) 
		    	if($this->input->cookie($this->config->item('compare_catalog_cookie_var')) > 1)
		    		echo "Удалить";
		    	else
		    	echo 'Убрать из сравнения';
		    	else echo "Добавить к сравнению";?></span>
		</a>
		<?php if ($this->input->cookie($this->config->item('compare_catalog_cookie_var')) 
		    	&& in_array($SITE_CONTENT['object']['id'], json_decode($this->input->cookie('compare')))
        && $this->input->cookie($this->config->item('compare_catalog_cookie_var')) > 0)  : ?>
		<a class="cmrm" href="<?php echo anchor_wta('compare'); ?>">
		    <span class="cmtx">В сравнение</span>
		</a>
		<?php endif; ?>

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
	<!-- end product info -->

<?php if (isset($SITE_CONTENT['product_info']) && !empty($SITE_CONTENT['product_info'])) : ?>
    	<div class="pddl">


    		<?php $price_old = $SITE_CONTENT['object']['price'];
    		$price_old = 1645;
    		$five_p = $price_old / 100 * 0.5;
    		$one_p = $price_old / 100 * 1;
    		$price = (22+$five_p)+(15+$one_p);
    		
    		$price_1 = round($price, -1);
    		$price_2 = round($price, 0);

    		$price_f = $price_1 - $price_2;
    		if($price_f < 0) {
    			if($price_f == -5){
    				$new_price = $price_2;
    			} else {
    				if($price_f < -5){
    					$price_01 = $price_2 + $price_f;
						$new_price = $price_01 + 10;
    				} else {
    					$price_01 = $price_2 + $price_f;
						$new_price = $price_01 + 5;
    				}
    			}
    		} else {
    			if($price_f == 5){
    				$new_price = $price_2;
    			}else {
    				if($price_f > 5){
	    				$price_01 = $price_2 + $price_f;
	    				$new_price = $price_01 + 10;
	    			} else {
	    				$price_01 = $price_2 + $price_f;
    					$new_price = $price_01 + 5;
	    			}
    			}
    		}

    		?>

    		<div class="dlbx">
			<div class="bxtt">Доставка</div>
			<div class="bxin">
			    <a class="inlk product-info" href="javascript:void(0);"></a>

			    <div class="indr">
				<a class="drex product-info-close" href="javascript:void(0);"></a>

				<div class="drtx">
		    <p><span style="font-size: small;"><strong>Самовывоз</strong> доступен в <strong>г.Ровно</strong> по адресу ул.Словацкого 4/6, бизнес-центр «Словацкий», офис 220.</span><br /><span style="font-size: small;"><strong>По Украине</strong> доставку осуществляем курьерской службой <strong>«Нова пошта»</strong> или любым другим удобным для Вас курьером.</span></p>
				</div>
			    </div>
			</div>
			<div class="clr"></div>
			    <div class="bxit">
					<p><strong>Из магазина Ровно – <span style="color: #000000;">бесплатно</span></strong></p>
					<p><strong>Регионы – «Нова пошта»</strong></p>
					<ul>
					<li>Наложенный платеж –<br />+<?php echo $new_price; ?> грн</li>
					<li>Предоплата –<br />+35 грн</li>
					</ul>
					</div>
		    </div>

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

<?php if (isset($SITE_CONTENT['accesories']) && $SITE_CONTENT['accesories']) : ?>
	<!-- accessories -->
          <div class="as">
            <div class="astt sm"><?php echo $this->lang->line('op_in_title_accessories'); ?></div>

             <div class="as-box">
              <div class="jcas">
                <ul class="jcls">
		            <!-- accessories item -->
		            <?php echo $this->load->view('inside/catalog/catalog_item_view_01', array('catalog' => $SITE_CONTENT['accesories']), true); ?>
		            <!-- end accessories item -->
            	</ul>
              </div><!-- end .jcas -->

              <a class="as-cnpr" href="javascript:void(0)" data-jcarouselcontrol="true"></a>
              <a class="as-cnnx" href="javascript:void(0)" data-jcarouselcontrol="true"></a>
            </div><!-- end .as-box -->
          </div>
          <!-- end accessories -->
<?php endif; ?>

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
	    			<a name="tabs" class="itlk" href="<?php echo anchor_wta('catalog/'.$CATEGORYLINK.'/'. $OBJECT_LINK . '/tab/' . ($value['link'] . '#tabs')); ?>">
	    <?php echo $value['name']; ?>
	    			</a>
	    		    </li>

	<?php endif; ?>

		<?php endforeach; ?>

    		</ul>
    	    </div>
<?php endif; ?>

    <?php if (isset($OBJ_SUBPAGE_DATA['view'])) echo $this->load->view('inside/object/' . $OBJ_SUBPAGE_DATA['view'], null, true); ?>

	</div>
	<!-- end product tab -->

    </div>
    <!-- end product -->

<?php if (isset($SITE_CONTENT['similar']) && !empty($SITE_CONTENT['similar'])) : ?>
        <div class="ct">
    	<div class="cttt sm"><?php echo $this->lang->line('op_similar_title'); ?></div>

    	<div class="cttl col-4">
    <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['similar']), true); ?>

    	    <div class="clr"></div>
    	</div>

        </div>
<?php endif; ?>

</div>
<!-- end #content -->