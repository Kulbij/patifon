<?php if (isset($SITE_CONTENT['banners']) && !empty($SITE_CONTENT['banners'])) : ?>
    <div id="sld">
        <div class="jc">
            <ul class="jcls">

                <?php foreach ($SITE_CONTENT['banners'] as $value) : ?>
                    <?php if ($value['obj_id'] > 0): ?>
                        <li class="lsit">
                            <a class="itlk" href="<?php echo anchor_wta('catalog/'.$value['object']['links']['categorylink'].'/'.$value['object']['link']);?>">
                                <div class="lklfbg"></div>
                                <div class="lkrgbg"></div>

                                <div class="lkcntr">
                                    <div class="lklf">
                                        <img src="<?php echo baseurl($value['object']['image']);?>" alt="<?php echo $value['object']['name'];?>">
                                    </div>
                                    <div class="lkrg">
                                        <div class="lkvral">
                                            <div class="lktt"><?php echo $value['object']['name'];?></div>
                                            <?php if(isset($value['object']['filters']) && !empty($value['object']['filters'])):?>
                                            <div class="lkft">
                                                <?php foreach($value['object']['filters'] as $one):?>
                                                <div class="ftit">
                                                <?php if(empty($one['class'])) : ?>
                                                        <i class="itic <?php echo $one['class_new'];?>"></i>
                                                 <?php else : ?>
                                                        <i class="itic <?php echo $one['class'];?>"></i>
                                                <?php endif; ?>
                                                    <span class="ittt"><?php echo $one['parent_name'];?></span>
                                                    <p class="ittx"><?php echo $one['name'];?></p>
                                                </div>
                                                <?php endforeach;?>
                                            </div>
<?php endif;?>
                                            <div class="lkpr"><?php echo $value['object']['price'];?><span class="prvl"> грн</span></div>
                                            <div class="lkbt itbt">Купить</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="lsit">
                            <a class="itlk" href="<?php if (isset($value['link'])) echo $value['link']; ?>" style="background-image: url('<?php if (isset($value['image'])) echo baseurl($value['image']); ?>');"></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="jccn">
            <div class="cnvral">
                <a class="cnpr" href="javascript:void(0)" data-jcarouselcontrol="true"></a>

                <div class="cnpg"></div>

                <a class="cnnx" href="javascript:void(0)" data-jcarouselcontrol="true"></a>
            </div>
        </div>
    </div>
<?php endif; ?>

<div id="cnt">

    <?php if (isset($SITE_CONTENT['catalog']) && !empty($SITE_CONTENT['catalog'])) : ?>
        <div class="ct">
            <div class="cttt"><?php echo $this->lang->line('i_p_liders'); ?></div>

            <div class="cttl col-4">
                <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['catalog']), true); ?>

                <div class="clr"></div>
            </div>

        </div>
    <?php endif; ?>

        <?php if (isset($SITE_CONTENT['catalognew']) && !empty($SITE_CONTENT['catalognew'])) : ?>
        <div class="ct ctas">
            <div class="cttt">Аксессуары</div>

            <div class="cttl col-4">
                <?php echo $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $SITE_CONTENT['catalognew']), true); ?>

                <div class="clr"></div>
            </div>

        </div>
    <?php endif; ?>

    <?php if (isset($SITE_CONTENT['last_articles']) && !empty($SITE_CONTENT['last_articles'])) : ?>
        <div class="ar">
            <div class="artt"><?php echo $this->lang->line('i_p_last_articles'); ?></div>

            <?php foreach ($SITE_CONTENT['last_articles'] as $key => $value) : ?>

                <?php if ($key == 0) : ?>

                    <div class="arbgit">
                        <a class="itim" href="<?php echo anchor_wta(site_url('articles/detail/' . $value['link'])); ?>">
                            <span class="imvral">
                                <img class="imim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>">
                            </span>
                        </a>

                        <div class="ittt">
                            <a class="ttlk" href="<?php echo anchor_wta(site_url('articles/detail/' . $value['link'])); ?>">
                                <?php echo $value['name']; ?>
                            </a>
                        </div>

                        <div class="ittx">
                            <p><?php echo $value['shorttext']; ?></p>
                        </div>
                    </div>

                <?php else : ?>

                    <a class="arslit" href="<?php echo anchor_wta(site_url('articles/detail/' . $value['link'])); ?>">
                        <span class="itvral">
                            <img class="itim" src="<?php echo baseurl($value['image']); ?>" alt="<?php echo $value['name']; ?>">
                        </span>

                        <span class="ithv"></span>
                        <span class="ittt"><?php echo $value['name']; ?></span>
                    </a>

                <?php endif; ?>

            <?php endforeach; ?>

            <div class="clr"></div>
        </div>
    <?php endif; ?>

</div>
<!-- end content -->