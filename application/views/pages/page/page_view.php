





<style type="text/css">
	#registration {
		margin: 0 auto;
		width: 50%;
	}

	input {
		background: #ddd;
		display: block;
		margin-top: 10px;
		padding: 10px;

		font-size: 19px;
		font-weight: bold;
	}

	form a.submit {
		background: green;
		padding: 10px;
		display: block;

		color: #fff;
		font-size: 20px;
		text-decoration: none;
		text-align: center;
	}
</style>

<?php 


?>




<div id="registration">
	<form action="<?php echo baseurl('registration/ok'); ?>" method="POST">
		<input type="text" name="name" value="name" />
		<input type="text" name="surname" value="surname" />
		<input type="email" name="email" value="mail@mail.ru" />
		<input type="phone" name="phone" placeholder="(___) ___-__-__" value="9999999999" />

		<input type="radio" name="people" value="1" checked>
		<input type="radio" name="people" value="0">

		<input type="password" name="password" value="password" />
		<input type="password" name="password_conf" value="repass" />

		<!-- <input type="submit" name="registration_user" value="Регистпация" /> -->
		<a class="submit" href="javascript:void(0);">Регистрация</a>
	</form>
</div>

<script type="text/javascript">

	$("form a.submit").live('click', function() {
		$.ajax({
		    url: CI_ROOT + 'registration',
		    type: 'POST',
		    // async: true,
		    data: $('form').serialize(),
		    success: function (data) {
		    	if(data > 0) {
		    		$('form').submit();
		    	}
		    },
		});
	});

	function form_setErrors($form, $data) {
    for (var $key in $data) {
        if (typeof $data[$key] !== 'undefined' && $data[$key] !== null) {
            //if ($form.find('[name=' + $key + ']').prop('tagName') == 'SELECT'){                
              //  $form.find('[name=' + $key + ']').closest('.block-s3elect').find('.select-status').show();
            //}else{
                $form.find('[name=' + $key + ']').addClass('er');
            //}
        }

    }

}
</script>