<div id="content" style="width: 1020px;">

 <?php if (isset($SDS)) : ?>

  <a href="<?php echo base_url(), 'index?get_product_file'; ?>" target="_blank">Викачати файл з цінами</a>
  <br /><br /><hr /><br /><br />
  <form action="" method="post" enctype="multipart/form-data">
   <input type="file" name="price_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
   <input type="submit" name="read_prices" value="Відправити файл з цінами" style="padding: 5px;" />
  </form>

  <?php if (isset($f_errors) && !empty($f_errors)) : ?>
   <br /><br />
   <div style="width: 100%; padding: 10px; border: solid 1px red; color: red">
    <?php echo $f_errors; ?>
   </div>
  <?php endif; ?>

  <?php if (isset($f_okey) && !empty($f_okey)) : ?>
   <br /><br />
   <div style="width: 100%; padding: 10px; border: solid 1px green; color: green">
    <?php echo $f_okey; ?>
   </div>
  <?php endif; ?>

 <?php endif; ?>

</div><!-- end content -->