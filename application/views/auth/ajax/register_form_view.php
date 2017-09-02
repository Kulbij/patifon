
<link rel="stylesheet" type="text/css" href="<?php echo baseurl('public/style/form.css'); ?>" />
<script type="text/javascript">
 $(document).ready(function(){
  $('input[type="checkbox"]').uniform();
  $('input[name=phone]').mask('+38 (999) 999-99-99');
 });
</script>

<div class="form ownbox-content">
 <div class="form-top"></div>

 <form action="<?php echo anchor_wta(site_url('user/ajax/form-send/register-form')); ?>" method="post" autocomplete="off">

  <div class="form-content">
    <div class="form-exit">
     <a href="javascript:void(0);" class="ownbox-close"></a>
    </div>
    <div class="form-title">
     <h2>
      <?php echo $this->lang->line('ap_reg_title'); ?>
     </h2>
    </div>

    <div class="form-error" style="display: none;"></div>

    <div class="form-field">
      <div class="field-name">
       <?php echo $this->lang->line('ap_reg_field_phone'); ?>
      </div>
      <div class="field-input">
       <input type="text" name="phone" maxlength="255" placeholder="+38 (___) ___-__-__" value="" />
      </div>

      <div class="clear"></div>
    </div><!-- end .form-field -->

    <div class="form-field">
      <div class="field-name">
       <?php echo $this->lang->line('ap_reg_field_pass'); ?>
      </div>
      <div class="field-input">
       <input type="password" maxlength="255" name="password" value="" />
      </div>

      <div class="clear"></div>
    </div><!-- end .form-field -->

    <?php if (isset($SITE_FORM['knows']) && !empty($SITE_FORM['knows'])) : ?>
     <div class="form-question">
       <div class="question-title">
        <?php echo $this->lang->line('ap_reg_field_info'); ?>
       </div>

       <div class="question-content">

         <?php foreach ($SITE_FORM['knows'] as $value) : ?>
          <div class="question-field">
            <label>
              <span class="field-input">
               <input type="checkbox" name="info[]" value="<?php if (isset($value['id'])) echo $value['id']; ?>" />
              </span>
              <span class="field-text">
               <?php if (isset($value['name'])) echo $value['name']; ?>
              </span>
            </label>

            <div class="clear"></div>
          </div><!-- end .question-field -->
         <?php endforeach; ?>

         <div class="clear"></div>
       </div><!-- end .question-content -->
     </div><!-- end .form-question -->
    <?php endif; ?>

    <div class="form-conditions">
      <label>
        <span class="conditions-input">
         <input type="checkbox" name="licence" value="1" />
        </span>
        <span class="conditions-text">
         <?php echo $this->lang->line('ap_reg_field_licence_1'); ?> <a href="<?php echo anchor_wta(site_url('usloviya-ispolzovaniya')); ?>" target="_blank"><?php echo $this->lang->line('ap_reg_field_licence_2'); ?></a> <?php echo $this->lang->line('ap_reg_field_licence_3'); ?> <a href="<?php echo anchor_wta(site_url('obrabotka-personalnux-dannux')); ?>" target="_blank"><?php echo $this->lang->line('ap_reg_field_licence_4'); ?></a>
        </span>
      </label>

      <div class="clear"></div>
    </div><!-- end .form-conditions -->

    <div class="form-registration">
     <input class="ajax-form" type="button" value="<?php echo $this->lang->line('ap_reg_button'); ?>" />
    </div>

    <div class="clear"></div>
  </div><!-- end .form-content -->

  <input type="hidden" name="robot" value="" />
 </form>

 <div class="form-bottom"></div>
</div><!-- end .form -->