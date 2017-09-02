<a href="javascript:void(0)" id="up_page" style="display: block;"></a>
<!-- footer -->
    <div id="ftr">
  
      <!-- footer -->
      <div id="ftrinn">

    <?php
         if (isset($SITE_TOP['toppage']) && !empty($SITE_TOP['toppage'])) :
         $array_chunk = array_chunk($SITE_TOP['toppage'], ceil(count($SITE_TOP['toppage'])/2), true);
        ?>
        <!-- footer menu -->
        <div class="ftrmn">
        <?php foreach ($array_chunk as $value) : ?>
          <ul class="mnls">
          <?php foreach ($value as $page) : ?>
            <li class="lsit">
              <a class="itlk" href="<?php if (isset($page['link'])) echo anchor_wta(site_url($page['link'])); ?>"><?php if (isset($page['name'])) echo $page['name']; ?></a>
            </li>
            <?php endforeach; ?>
          </ul>
      <?php endforeach; ?>

        </div>
        <!-- end footer menu -->
        <?php endif; ?>

        <?php if (isset($SITE_TOP['phones']) && !empty($SITE_TOP['phones'])) : ?>
        <!-- FOOTER CONTACTS -->
        <div class="footer_contacts">
          <p>
          <?php $count = count($SITE_TOP['phones']); foreach ($SITE_TOP['phones'] as $value) : ?>
            <a href="tel:+38<?php echo $value['phone'];?>">
            <?php echo $value['phone'];?>
            </a>
            <?php endforeach; ?>
          </p>
        </div>
        <!-- END FOOTER CONTACTS -->
        <?php endif; ?>

        <div class="clr"></div>

        <div class="cpr">
          &copy;&nbsp;<?php echo date('Y'); ?>&nbsp;<?php echo ((isset($SITE_FOOTER['footerdata'][0]['text'])) ? $SITE_FOOTER['footerdata'][0]['text'] : '') ; ?>
        </div>

        <div class="lg32x32">
          <a href="http://32x32.com.ua/"><img src="<?php echo baseurl('public/images/footer/32x32.png'); ?>" alt="Студия дизайна 32x32" /></a>
          Разработан и поддерживается<br />в
          <a href="http://32x32.com.ua/">компании 32x32</a>
        </div>

      </div>
      <!-- end footer -->

    </div>
    <!-- end footer -->

    <!--ownbox-->
   <div id="ownbox">
      <div id="box"></div>
   </div>
  <!--/ownbox -->

  <!-- Yandex.Metrika counter -->
<script type="text/javascript">
$(document).ready(function () {
  // scroll
    $('#up_page').click(function(){
      $('html, body').animate({ scrollTop: 0}, 1000);
    });
    $(window).on("scroll", function() {
      if ($(window).scrollTop() > 300) {
        $('#up_page').show(800);
      }
      else $('#up_page').hide(800);
      });
    // end scroll
  });

    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter34708555 = new Ya.Metrika({
                    id:34708555,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/34708555" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

  </body>
</html>