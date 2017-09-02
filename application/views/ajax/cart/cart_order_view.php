<div class="orcr">
 <div class="crtt"><?php echo $this->lang->line('cpp_step_title_first'); ?></div>

 <?php foreach ($this->cart->contents() as $key => $value) : ?>
  <div id="div_<?php echo $value['rowid']; ?>" class="crit">
   <a class="itim" href="<?php if (isset($value['options']['link'])) echo anchor_wta(site_url('catalog/'.$links[$key]['parentcategorylink'].'/'.$links[$key]['categorylink'].'/'.$value['options']['link'])); ?>">
    <span class="imvral">
     <img class="imim" src="<?php echo baseurl($value['options']['image']); ?>" alt="<?php echo $value['name']; ?>">
    </span>
   </a>

   <div class="itin">
    <div class="intt">
     <a class="ttlk" href="<?php if (isset($value['options']['link'])) echo anchor_wta(site_url('catalog/'.$links[$key]['parentcategorylink'].'/'.$links[$key]['categorylink'].'/'.$value['options']['link'])); ?>">
      <?php echo $value['name']; ?>
     </a>
    </div>

    <div class="innm">х<?php echo $value['qty']; ?></div>
    <div class="inpr"><?php echo $this->input->price_format($value['price'], $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <span class="prvl"><?php echo $this->lang->line('site_valuta'); ?></span></div>

    <div class="clr"></div>        
   </div>

   <div class="clr"></div>
  </div>
 <?php endforeach; ?>

 <div class="crsm"><?php echo $this->lang->line('ap_c_sum'); ?>: <span class="smnm"><?php echo $this->input->price_format($this->cart->total(), $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep')); ?> <span class="nmvl"><?php echo $this->lang->line('site_valuta'); ?></span></span></div>
</div>