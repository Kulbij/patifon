








<style type="text/css">
	.msgs {
		margin: 0 auto;
		width: 1024px;
	}
	.send-msg {
		width: 500px;
		margin: 0 auto;
	}
	textarea {
		margin: 0 auto;
		width: 500px;
		height: 100px;

		font-size: 15px;
		font-family: Arial;
		font-weight: bold;

		padding: 10px;

		border-radius: 5px;
		border: solid 2px;
	}
	form .send-msg a.send-link {
		background: blue;
		padding: 5px;

		font-size: 15px;
		font-family: Arial;
		color: #fff;
		font-weight: bold;
		text-align: center;

		text-decoration: none;

		border: 0px;
		border-radius: 4px;

		float: right;

		margin-top: 10px;
	}
</style>


<div class="msgs">
	<form action="<?php echo baseurl('msg/send/1'); ?>" method="post" class="form-send-msg">
		<div class="send-msg">
			<textarea name="message" class="message"></textarea>
			<a href="javascript:void(0);" class="send-link">Відправити</a>
		</div>
		<input type="hidden" name="send-user-id" value="1" />
		<input type="hidden" name="id" value="100" />
	</form>
</div>
<script type="text/javascript" language="JavaScript" src="<?php echo resource_url('public/js/jquery.min.js', array('js' => true)); ?>"></script>

<script type="text/javascript">
	$(document).ready(function () {
		$('.send-link').live('click', function () {
			var TAMSG = $(this).parent().find('textarea')
			if(TAMSG.val() != '') {
				$(this).parent().parent().parent().find('.form-send-msg').submit();
			} else {
				TAMSG.focus();
			}
		});
	});
</script>