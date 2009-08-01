<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(
  function(){
//	  $("input[name='name']").keypress(function(){
//												if($(this).val())
//												$("#submit").removeAttr("disabled");
//												
//												});

	  $("form").submit(function(){
								if($("input[name='name']").attr("value")=='')
								{
								alert("请输入姓名");
								return false;
								}
								
								});
	
	  });

</script>
<style type="text/css">
#attention{
	font-size:0.7em;
	color:#930;}
form a{
	color:#F00;}
</style>
<?php
$roleid=$_GET["role"];
$style=$_GET["style"];
require_once("sqlconnect.php");
$query="select fdName from tbRole where id={$roleid}";
$result=mysql_query($query);
$rolename=mysql_result($result,0,"fdName");

?>
<title>添加新的<?php echo $rolename; ?></title>
</head>

<body>
<form method="post" action="neworgreply.php">
姓名：<input type="text" name="name"/><a>*</a><br/>
登录名：<input type="text" name="login"/><br/>
密码：<input type="password" name="pass"/><br/>
联系方式：<textarea name="abstract"></textarea><br/>
<input type="text" value="<?php echo $roleid;?>" name="role" style="display:none"/>
<input type="text" value="<?php echo $style;?>" name="style" style="display:none"/>
<input type="submit" id="submit" value="添加"/>
</form>
<div id="attention">
注意：至少输入姓名，如其他为空，则登录名同姓名，密码为123456！
</div>
</body>
</html>