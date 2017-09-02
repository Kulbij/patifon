

<style type="text/css">
.input-reg {
	background: #fff;
	display: block;
	margin: 0 auto;
	margin-bottom: 5px;
	width: 200px;
	height: 30px;
	border-radius: 5px;
	padding-left: 5px;
	border: 0px;

	color: #000;
	font-size: 18px;
	font-weight: bold;
	font-family: Tahoma;
}
.input-reg:hover {
	background: #ddd;	
}

.select-reg{
	background: #fff;
	display: block;
	margin: 0 auto;
	width: 200px;
	margin-bottom: 5px;
	height: 30px;
	padding-left: 5px;
	border-radius: 5px;
	border: 0px;

	color: #000;
	font-size: 18px;
	font-weight: bold;
	font-family: Tahoma;
}
.select-reg:hover {
	background: #ddd;
}
.s-date {
	width: 200px;
	margin: 0 auto;
}
.s-date .block{
	background: #fff;
	width: 50px;
	margin-left: 16px;
	display: block;
	float: left;

	font-size: 15px;
}

.button {
	background: blue;
	width: 200px;
	height: 40px;

	color: #fff;
	font-size: 20px;
	font-weight: bold;
	font-family: Tahoma;
	text-align: center;
}
.button:hover {
	cursor: pointer;
	background: green;
}
</style>
<form action="<?php echo site_url('auth/check_reg/form'); ?>" method="post">
	<input type="text" class="input-reg error" name="name" placeholder="Name" />
	<input type="text" class="input-reg error" name="surname" placeholder="Surname" />
	<input type="text" class="input-reg error" name="fname" placeholder="Familyname" />
	<input type="text" class="input-reg error" name="phone" placeholder="Phone" />
	<select name="people" class="select-reg">
		<option value="0">--> All <--</option>
		<option value="1">1m</option>
		<option value="2">2w</option>
	</select>

	<div class="s-date">
		<select name="people" class="select-reg block">
			<option value="0">dd</option>
			<?php for ($i=1; $i < 32; $i++): ?>
			<option value="<?php echo $i; ?>">
				<?php echo $i; ?>
			</option>
			<?php endfor; ?>
		
		</select>
		<select name="people" class="select-reg block">
			<option value="0">mm</option>
			<option value="1">01</option>
			<option value="2">02..</option>
		</select>
		<select name="people" class="select-reg block">
			<option value="0">yyyy</option>
			<?php $count = 0; for($i = 1920; $i < 2015; $i++) : ?>
			<option value="<?php echo $count; ?>"><?php echo $i; ?></option>
			<?php endfor; $count++; ?>
		</select>
	</div>

	<input type="text" class="input-reg" name="email" placeholder="E-mail" />
	<input type="text" class="input-reg" name="password" placeholder="Password" />
	<input type="text" class="input-reg" name="password-conf" placeholder="Password couf" />

	<input type="submit" class="button input-reg .ajax-form" name="button" value="Go" />
	<input type="hidden" name="robot" value="1" />
</form>