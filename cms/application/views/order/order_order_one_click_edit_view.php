<script src="<?php echo base_url(),'js/jquery-2.1.3.min.js';?>"></script>
 <script type="text/javascript" src="<?php echo base_url().'js/rangy/rangy-core.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url().'js/rangy/rangy-selectionsaverestore.js'; ?>"></script>
        <script>
            function addLink1() {
                var s = rangy.saveSelection();

                var body_element = document.getElementsByTagName('body')[0];

                var selection;

                selection = window.getSelection();  

                //var pagelink = "<br /><br />Èñòî÷íèê: <a href='" + document.location.href + "'>" + document.location.href + "</a>";

                //var wordCount = selection.toString().trim().split(' ').length;

                var copytext = selection;

                copytext = copytext.toString();
                copytext = copytext.split('');
                copytext = copytext[0]+copytext[1]+copytext[2]+' '+copytext[3]+copytext[4]+copytext[5]+' '+copytext[6]+copytext[7]+' '+copytext[8]+copytext[9];

                var newdiv = document.createElement('div');
                newdiv.style.position = 'absolute';
                newdiv.style.left = '-99999px';
                body_element.appendChild(newdiv);
                newdiv.innerHTML = copytext;
                selection.selectAllChildren(newdiv);

                window.setTimeout(function () {
                    body_element.removeChild(newdiv);
                    rangy.restoreSelection(s);
                }, 0);
            }
            if (window.location.pathname.indexOf('/search/') === -1) {
                document.oncopy = addLink;
            }
        </script> 

<div id="content">

<?php if (isset($breadcrumbs) && count($breadcrumbs) > 0) : ?>
<ul class="breadcrumbs">
  <?php foreach ($breadcrumbs as $one) : ?>
   <li><a href="<?php echo base_url(), $one['link']; ?>"><?php echo $one['name']; ?></a></li>
   <li>→</li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<div class="clear"></div>

<div class="creation_page">

  <h2>Замовлення №<?php echo $content['id']; ?>&nbsp;<?php if (isset($content['user_id']) && $content['user_id'] > 0) : ?><a href="<?php echo base_url(), 'edit/clients/clients/', $content['user_id']; ?>"><img style="width: 16px; height: 16px;" src="<?php echo base_url(), 'images/to_client.png'; ?>" title="перейти до клієнта" alt="перейти до клієнта" /></a>
      <?php endif; ?>
      <a href="javascript:void(0);"
        <?php if ($content['check'] == 1) : ?>
          title="зробити неприйнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/uncheck/', $SUBMODULE, '/', $content['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/check.png'; ?>"
        <?php else : ?>
          title="зробити прийнятим" onclick="window.location = <?php echo "'", base_url(), 'edit/check/', $SUBMODULE, '/', $content['id'], "'"; ?>; return false;"><img src="<?php echo base_url(), 'images/uncheck.png'; ?>"
        <?php endif; ?>
       alt="#" /></a>

      <?php if (isset($SDS)) : ?>
       <span class="vertical"><a title="видалити" href="javascript:void(0);" onclick="if (confirm('Видалити замовлення?')) { window.location = <?php echo "'", base_url(), 'edit/del/', $SUBMODULE, '/', $content['id'], "'"; ?>; } return false;"><img src="<?php echo base_url(); ?>images/del.png" alt="#" /></a></span>
      <?php endif; ?>

  </h2>

      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Дата:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['datetime']; ?></div><br /></div>
      <div class="clear"></div>

      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Телефон:</strong></div><div style="width: 70%; display: inline-block;"><?php echo $content['phone']; ?></div><br /></div>
      <div class="clear"></div>

      <div class="field">
      <div style="width: 150px; display: inline-block;"><strong>Товар:</strong></div><div style="width: 70%; display: inline-block;"><a href="<?php echo base_url(), 'edit/catalog/object/', $content['product_id']; ?>" target="_blank"><?php echo $content['object']['name']; ?></a></div><br /></div>
      <div class="clear"></div>



  </div>

  <div class="clear"></div>

</div><!-- end creation -->

</div><!-- end content -->