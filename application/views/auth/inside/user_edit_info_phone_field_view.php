
<div class="block-field">
 <div class="field-name">
  <div class="vertical"><?php echo $this->lang->line('accp_info_phone_title'); ?></div>
 </div>
 <div class="field-input">
  <input class="new-phone" type="text" maxlength="255" name="phone[<?php if (isset($id)) echo $id; ?>]" value="<?php if (isset($value)) echo $value; ?>" placeholder="+38 (___) ___-__-__" />
 </div>
 <div class="field-remove">
  <a href="javascript:void(0);" class="user-remove-phone" data-phone="<?php if (isset($id)) echo $id; ?>"></a>
 </div>

 <div class="clear"></div>
</div><!-- end .block-field -->