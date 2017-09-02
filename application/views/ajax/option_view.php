<?php if (isset($options) && !empty($options)) : ?>
 <?php foreach ($options as $value) : ?>
  <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
 <?php endforeach; ?>
<?php endif; ?>