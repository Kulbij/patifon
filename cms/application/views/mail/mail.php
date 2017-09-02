<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  
    <title>mail</title>
  </head>
  
  <body style="cursor: auto;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td bgcolor="#ffffff" align="center">
          <table border="0" cellpadding="0" cellspacing="0" width="700">
            <tr>
              <td style="padding: 0 0 8px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td width="266"></td>

                    <td>
                      <a href="<?php echo getsiteurl(); ?>" target="_blank">
                        <img alt="Patifon" src="<?php echo base_url(), 'images/logo.png'; ?>" width="168" height="56" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; color: #484848;">
                      </a>
                    </td>

                    <td width="266"></td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td style="padding: 0 0 16px;">
              <?php if(isset($phones) && !empty($phones) && count($phones) >= 1) : ?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td width="80"></td>

                    <?php foreach($phones as $key => $valign) : ?>
                      <?php
                          if($valign['paket'] == 1) $pack = 'mts';
                          elseif($valign['paket'] == 2) $pack = 'kievstar';
                          elseif($valign['paket'] == 3) $pack = 'life';
                          
                      ?>
                    <td width="27"><img alt="Patifon - MTS" src="<?php echo base_url(), 'images/'.$pack.'.png'; ?>" width="20" height="21" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; color: #484848;"></td>
                    <td width="164" style="font-family: 'Arial'; font-size: 17px; color: #242424"><?php echo $valign['phone']; ?></td>
                    <?php endforeach; ?>

                    <td width="57"></td>
                  </tr>
                </table>
                <?php endif; ?>
              </td>
            </tr>

            <tr>
              <td height="48">
              <?php if(isset($cats) && !empty($cats) && count($cats) >= 1) : ?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>

                  <?php foreach($cats as $key => $one) : ?>
                    <td width="123" height="47" bgcolor="fdc008" align="center" style="border-right: 1px solid #fda803; border-bottom: 1px solid #fd9503; border-left: 1px solid #fda803;">
                      <a href="<?php echo getsiteurl(), 'catalog/', $one['link']; ?>" target="_blank" style="font-family: 'Arial', sans-serif; font-size: 14px; text-decoration: none; color: #242424;">
                        <div style="line-height: 3.357143; width: 123px; height: 48px; color: #242424;"><?php echo $one['name']; ?></div>
                      </a>
                    </td>
                    <?php endforeach; ?>

                  </tr>
                </table>
                <?php endif; ?>
              </td>
            </tr>

            <tr>
              <td align="center" style="padding: 22px 0 10px;"><img alt="Будем благодарны за отзыв!" src="<?php echo base_url(), 'images/review.png'; ?>" width="90" height="65" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; color: #484848;"></td>
            </tr>

            <tr>
              <td align="center" style="font-family: 'Arial'; font-size: 37px; padding: 0 0 6px; color: #242424">Будем благодарны за отзыв!</td>
            </tr>

            <tr>
              <td align="center" style="font-family: 'Arial'; font-size: 21px; padding: 0 0 13px; color: #3e3e3e">на одной с торговых площадок</td>
            </tr>

            <tr>
              <td style="padding: 0 0 31px; border-bottom: 1px solid #dddddd">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td width="212"></td>

                    <td style="padding: 0 13px;"><img alt="HotLine" src="<?php echo base_url(), 'images/hotline.png'; ?>" width="100" height="32" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; color: #484848;"></td>

                    <td width="1"></td>

                    <td style="padding: 6px 13px 0;"><img alt="Price.ua" src="<?php echo base_url(), 'images/price.png'; ?>" width="123" height="20" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; color: #484848;"></td>

                    <td width="212"></td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td style="font-family: 'Arial'; font-size: 16px; line-height: 1.6875; padding: 18px 30px 25px; color: #242424">Добрый день, уважаемый покупатель!<br>Мы благодарим вас за покупку и доверие к нашему интернет-магазину PATIFON.<br>Нам важна ваша оценка роботы персонала и самого магазина.</td>
            </tr>

            <tr>
              <td style="font-family: 'Arial'; font-size: 14px; line-height: 1.785714; padding: 0 30px 29px; color: #242424">Пожалуйста оставьте свой отзыв на одной с торговых площадок <a href="#" target="_blank" style="text-decoration: none; color: #3072ad;"><span style="color: #3072ad;">Hotline.ua</span></a> или <a href="#" target="_blank" style="text-decoration: none; color: #3072ad;"><span style="color: #3072ad;">Price.ua</span></a> перейдя по силке ниже. При возможности, для прохождения быстрой модерации и публикации вашего отзыва, прикрепите фото или копию чека о покупке. Заранее большое Спасибо за помочь в развитии магазина.</td>
            </tr>

            <tr>
              <td align="center" style="padding: 0 0 44px;">
                <table border="0" cellpadding="0" cellspacing="0" width="660">
                  <tr>
                    <td align="center" style="padding: 0 10px;">
                      <img alt="HotLine" src="<?php echo base_url(), 'images/hotline.png'; ?>" width="100" height="32" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; margin: 0 0 8px; color: #484848;"><a href="http://hotline.ua/yp/23480/#" target="_blank"><img alt="HotLine" src="<?php echo base_url(), 'images/hotline-button.png'; ?>" width="311" height="49" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; color: #484848;"></a>
                    </td>

                    <td align="center" style="padding: 9px 10px 0;">
                      <img alt="Price.ua" src="<?php echo base_url(), 'images/price.png'; ?>" width="123" height="20" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; margin: 0 0 11px; color: #484848;"><a href="http://price.ua/firm24953.html#review" target="_blank"><img alt="HotLine" src="<?php echo base_url(), 'images/price-button.png'; ?>" width="311" height="49" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; color: #484848;"></a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td style="font-family: 'Arial'; font-size: 16px; line-height: 1.6875; padding: 18px 30px 25px; color: #242424">С уважением, руководство интернет-магазина PATIFON.COM.UA</td>
            </tr>

            <tr>
              <td style="font-family: 'Arial'; font-size: 14px; line-height: 1.785714; padding: 0 30px 29px; color: #242424">Мы не хотим останавливаться в нашем развитии и делаем  все для улучшения сервиса и уровня обслуживания клиентов, сохраняя самые низкие цены на смартфоны. Пожалуйста пройдите регистрацию и напишите свое мнение.</td>
            </tr>

            <tr>
              <td align="center" bgcolor="eaeaea" style="padding: 27px 0 31px;">
                <table border="0" cellpadding="0" cellspacing="0" width="660">
                  <tr>
                    <td style="padding: 0 10px;">
                    <?php if(isset($pages) && !empty($pages) && count($pages) >= 1) : ?>
                      <table border="0" cellpadding="0" cellspacing="0" width="100%">

                      <?php foreach($pages as $value) : ?>
                        <tr>
                          <td style="padding: 0 0 7px">
                            <a href="<?php echo getsiteurl(), $value['link']; ?>" target="_blank" style="font-family: 'Arial'; font-size: 14px; text-decoration: none; color: #2d9c22;">
                              <span style="color: #2d9c22;"><?php echo $value['name']; ?></span>
                            </a>
                          </td>
                        </tr>
                        <?php endforeach; ?>

                      </table>
                      <?php endif; ?>
                    </td>

                    <td valign="top" style="padding: 0 10px;">
                      <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        
                        <tr>
                          <td rowspan="3" width="25" valign="top"><img alt="Patifon - Телефоны" src="<?php echo base_url(), 'images/phone.png'; ?>" width="12" height="18" border="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; display: block; margin: 0 0 11px; color: #484848;"></td>

                          <td>
                             <a href="tel:+38(099) 453 40 40" target="_blank" style="font-family: 'Arial'; font-size: 14px; text-decoration: none; color: #3e3e3e;">
                              <span style="color: #3e3e3e;">(099) 453 40 40</span>
                             </a>
                          </td>
                        </tr>

                        <tr>
                          <td style="padding: 7px 0 0">
                            <a href="tel:+38(098) 453 40 40" target="_blank" style="font-family: 'Arial'; font-size: 14px; text-decoration: none; color: #3e3e3e;">
                              <span style="color: #3e3e3e;">(098) 453 40 40</span>
                            </a>
                          </td>
                        </tr>

                        <tr>
                          <td style="padding: 7px 0 0">
                            <a href="tel:+38(093) 453 40 40" target="_blank" style="font-family: 'Arial'; font-size: 14px; text-decoration: none; color: #3e3e3e;">
                              <span style="color: #3e3e3e;">(093) 453 40 40</span>
                            </a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>