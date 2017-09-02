
<div id="cnt">
 <?php echo $this->load->view('inside/bread_view', null, true); ?>

<div class="or">

 <form action="<?php echo anchor_wta(site_url('cart/check-order')); ?>" method="post">

  <div class="orfm">
   <div class="fmbx">
    <div class="bxtt"><?php echo $this->lang->line('op_form_title'); ?></div>

    <div class="bxfld">
     <div class="fldtt">
      <div class="ttvral">
       <?php echo $this->lang->line('op_form_label_name'); ?>*
      </div>
     </div>

     <input class="fldtx" type="text" name="name" maxlength="255" value="" />

     <div class="fldhl">
      <div class="hlvral"><?php echo $this->lang->line('op_form_label_name_after'); ?></div>
     </div>

     <div class="clr"></div>
    </div>
<div class="bxfld">
     <div class="fldtt">
      <div class="ttvral">
       <?php echo $this->lang->line('op_form_label_phone'); ?>*
      </div>
     </div>

     <input class="fldtx" type="text" name="phone" maxlength="255" placeholder="+38 (___) ___-__-__" />

     <div class="fldhl">
      <div class="hlvral"><?php echo $this->lang->line('op_form_label_phone_after'); ?></div>
     </div>

     <div class="clr"></div>
    </div>
    <div class="bxfld">
     <div class="fldtt">
      <div class="ttvral">
       <?php echo $this->lang->line('op_form_label_email'); ?>
      </div>
     </div>

     <input class="fldtx" type="text" name="email" maxlength="255" value="" />

     <div class="fldhl">
      <div class="hlvral"><?php echo $this->lang->line('op_form_label_email_after'); ?></div>
     </div>

     <div class="clr"></div>
    </div>    
   </div>

   <div class="fmbx">
    <div class="bxtt"><?php echo $this->lang->line('op_form_label_delivery'); ?></div>

    <div class="bxfld">
     <div class="fldit">
      <label>
       <input class="itrd order-delivery" type="radio" name="delivery" value="1" checked />
       <span class="ittt"><?php echo $this->lang->line('op_form_label_delivery_new_post'); ?></span>
      </label>
      <div class="clr"></div>
     </div>

     <div class="fldit">
      <label>
       <input class="itrd order-delivery" type="radio" name="delivery" value="0" />
       <span class="ittt"><?php echo $this->lang->line('op_form_label_delivery_pickup'); ?></span>
      </label>

      <div class="clr"></div>
     </div>

     <div class="clr"></div>
    </div>

    <div class="bxfld order-delivery-post">
     <div class="fldtt">
      <div class="ttvral">
       <?php echo $this->lang->line('op_form_label_city'); ?>*
      </div>
     </div>

     <select name="city" class="fldsc order-region-select" data-callback="get_points">
      <option value="0">
       <?php echo $this->lang->line('op_form_label_city_select_default'); ?>
      </option>
      <?php foreach ($SITE_CONTENT['order_region'] as $value) : ?>
       <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
      <?php endforeach; ?>
     </select>

     <div class="fldhl">
      <div class="hlvral"><?php echo $this->lang->line('op_form_label_city_after'); ?></div>
     </div>

     <div class="clr"></div>
    </div>

    <div class="bxfld order-delivery-post">
     <div class="fldtt">
      <div class="ttvral">
       <?php echo $this->lang->line('op_form_label_point'); ?>*
      </div>
     </div>

     <select name="point" class="fldsc order-point-select">
      <option value="0">
       <?php echo $this->lang->line('op_form_label_point_select_default'); ?>
      </option>

     </select>

     <div class="fldhl">
      <div class="hlvral"><?php echo $this->lang->line('op_form_label_point_after'); ?></div>
     </div>

     <div class="clr"></div>
    </div>
    <div class="bxfld order-delivery-post">
        <div class="fldit">
      <label>
       <input class="itrd" type="radio" name="payment" value="0" checked/>
       <span class="ittt">Наложеный платеж</span>
      </label>
      <div class="clr"></div>
     </div>
     <div class="fldit">
      <label>
       <input class="itrd" type="radio" name="payment" value="1"/>
       <span class="ittt">Предоплата</span>
      </label>
      <div class="clr"></div>
     </div>
    <div class="clr"></div>
    </div>
   </div>

   <div class="fmbx">
    <div class="bxtt"><?php echo $this->lang->line('op_form_label_comment'); ?></div>

    <div class="bxfld">
     <div class="fldtt">
      <div class="ttvral">
       <?php echo $this->lang->line('op_form_label_comment_to_order'); ?>
      </div>
     </div>

     <textarea class="fldtxar" cols="30" rows="10" name="comment" maxlength="2000"></textarea>

     <div class="fldhl">
      <div class="hlvral">
       <?php echo $this->lang->line('op_form_label_comment_after'); ?>
      </div>
     </div>

     <div class="clr"></div>
    </div>

    <div class="fmrq"><span class="rqcl">*</span> <?php echo $this->lang->line('op_form_label_required'); ?></div>
    <input data-request="wait" class="ajax-form fmbt" type="button" data-value="<?php echo $this->lang->line('op_form_label_button'); ?>" value="<?php echo $this->lang->line('op_form_label_button'); ?>" />
   </div>
  </div>

  <div id="cart_order">
   <?php echo $this->load->view('ajax/cart/cart_order_view', null, true); ?>
  </div>

  <input type="hidden" name="robot" value="" />
 </form>

 <div class="clr"></div>
</div>

</div>