<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Вхід</title>
</head>
<body>
<style type="text/css">
<!--
body
{
	background-color: #444444;
	min-width:900px;
}
.BoxMsg
{
    position: absolute;
    padding: 20px;
    top: 15px;
    right: 5%;
    background-color:#000000;
    font-size: 12px;
    color:#ffffff;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    font-family: Verdana;
}
.login_table
{
	position: absolute;
	left:30%;
	top:25%;
	background-color:#333333;
	padding:50px;
	-moz-border-radius: 25px;
    -webkit-border-radius: 25px;
}
.LoginFormText
{
	color:#9db323;
	font-size:12px;
	font-family:Verdana, Geneva, sans-serif;
}
input.edit
{
	height:20px;
	font-size:14px;
}
/* submit button */
#button {
    display: block;
    float: left;
    width: 90px;
	height: 25px;
    padding: 1px;
    background: #9db323;
    border: solid 1px #9db323;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none;
	color: #ffffff;
}
#button:hover {
  color: #ffffff;
  background: #9db323;
  border: solid 1px #a19f9a;
  -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
  -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
  box-shadow: 0 1px 2px rgba(0,0,0,.2);
  cursor:pointer;
}
-->
</style>
<table width="35%" border="0" cellspacing="0" cellpadding="0" class="login_table">
  <tr>
    <td>
    <form name="enterform" method="post" action="<?php echo base_url(); ?>">
      <label class="LoginFormText">
        Ім'я:<br /><div style="height:5px"></div>
        <input style="width: 98%;" type="text" name="username" class="edit" value="" />
      </label>
      <br /><div style="height:10px"></div>
      <label class="LoginFormText">
		Пароль:<br /><div style="height:5px"></div>
        <input style="width: 98%" type="password" name="password" class="edit" value="" />
      </label>
      <br /><div style="height:12px"></div>
      <?php if (isset($error)) : ?>
       <span style="color: white;">* невірний логін або, пароль</span>
      <?php endif; ?>
      <div style="height:12px"></div>
        <input name="LoginButon" type="submit" id="button"  value="Увійти"/>
    </form>
    </td>
  </tr>
</table>
</body>
</html>