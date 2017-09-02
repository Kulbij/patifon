<div id="cnt">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

<!-- invoice -->
<div class="iv">
  <div class="ivtop">
   <div class="ivtx"><?php echo $this->lang->line('inp_title'); ?></div>

   <div class="ivpn">
    <i class="icpn"></i>
    <a class="pnlk" href="<?php echo anchor_wta(site_url('cart/invoice/print')); ?>">
     <?php echo $this->lang->line('site_print'); ?>
    </a>
   </div>
  </div>

  <div class="ivit">
   <div class="ittt"><?php echo $this->lang->line('inp_page_supplier'); ?>:</div>
   <div class="ittx"><?php if (isset($SITE_CONTENT['pp'])) echo $SITE_CONTENT['pp']; ?></div>

   <div class="clr"></div>
  </div>

  <div class="ivit">
    <div class="ittt"><?php echo $this->lang->line('inp_page_customer'); ?>:</div>
    <div class="ittx"><?php if (isset($SITE_CONTENT['customer']['name'])) echo $SITE_CONTENT['customer']['name']; ?></div>

    <div class="clr"></div>
  </div>

  <div class="ivit">
    <div class="ittt"><?php echo $this->lang->line('inp_page_payer'); ?>:</div>
    <div class="ittx"><?php echo $this->lang->line('inp_page_payer_text'); ?></div>

    <div class="clr"></div>
  </div>

  <div class="ivtt"><?php echo $this->lang->line('inp_main_text'); ?> №<?php if (isset($SITE_CONTENT['customer']['orderid'])) echo $SITE_CONTENT['customer']['orderid']; ?><br /><?php echo $this->lang->line('inp_main_text_from'); ?> <?php if (isset($SITE_CONTENT['customer']['datetime'])) echo date('d.m.Y', strtotime($SITE_CONTENT['customer']['datetime'])); ?> <?php echo $this->lang->line('inp_main_text_year'); ?></div>

  <table class="ivtb">
    <thead class="tbhdr">
      <tr class="tbrw">
        <td class="tbcol tbnm">№</td>
        <td class="tbcol"><?php echo $this->lang->line('inp_main_table_product'); ?></td>
        <td class="tbcol tbfx"><?php echo $this->lang->line('inp_main_table_qty'); ?></td>
        <td class="tbcol tbfx"><?php echo $this->lang->line('inp_main_table_price'); ?></td>
        <td class="tbcol tbfx"><?php echo $this->lang->line('inp_main_table_sum'); ?></td>
      </tr>
    </thead>

    <?php
     $index = 1;
     if (isset($SITE_CONTENT['content']) && !empty($SITE_CONTENT['content'])) :
    ?>
     <tbody class="tbcnt">
     <?php foreach ($SITE_CONTENT['content'] as $one) : ?>
      <tr class="tbrw">
       <td class="tbcol tbnm"><?php echo $index; ?></td>
       <td class="tbcol"><?php echo $one['name']; ?></td>
       <td class="tbcol tbfx"><?php echo $this->input->price_format($one['qty'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?></td>
       <td class="tbcol tbfx"><?php echo $this->input->price_format($one['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?></td>
       <td class="tbcol tbfx"><?php echo $this->input->price_format(($one['price'] * $one['qty']), $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?></td>
      </tr>
     <?php ++$index; endforeach; ?>
     </tbody>
    <?php endif; ?>

  </table>

  <div class="ivsm"><?php echo $this->lang->line('inp_main_total'); ?>: <?php if (isset($SITE_CONTENT['total_price'])) echo $this->input->price_format($SITE_CONTENT['total_price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <?php echo $this->lang->line('site_valuta'); ?></div>
  <div class="ivsmtx"><?php if (isset($SITE_CONTENT['total_price_str'])) echo $SITE_CONTENT['total_price_str']; ?></div>
</div>
<!-- invoice -->

</div>