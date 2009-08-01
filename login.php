<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		   $("#submit").hover(function(){$(this).addClass("onhover")},function(){$(this).removeClass("onhover")});});
</script>
<title>威播视VBOX 登陆</title>
<style type="text/css">
.onhover{
	background-color:#333;
	color:#FFF;}
body{
	background-color:#666;}
#logindiv{
	margin:100px auto;
	background-color:#CCC;
	border:1px #663 solid;
	width:320px;
	height:150px;
	font-family:"Arial Black", Gadget, sans-serif;
	}
form{
	width:100%;
	height:100%;}
#verimg{
	width:px;
	font-size:0.8em;
	color:#C09;
	display:inline;
	margin-top::20px;
	}
#verimg img{
	margin-left:10px;
	
	width:80px;}
form{
	padding:20px;
	font-size:1.3em;
	font-family:"Times New Roman", Times, serif;
	font-style:italic;}
form a{
	text-decoration:underline;
	color:#900;
	font-size:1.1em;
	margin-top:-1px;}
form input{
	border:1px #333 dashed;
	margin-left:5px;
	height:30px;
	width:100px;
	font-size:1.2em;
	}
.text{
	width:200px;
	font-size:1.2em;}
#submit{
	margin:3px 68px;}
#verify{
	width:70px;}
#coinfo{
	float:right;
	font-size:0.8em;}
</style>
</head>
<body>
<div id="logindiv">
<form id="form" action="loginreply.php" method="post">
<label>用户名</lable><input class="text" type="text" name="id"/><br/>
<label>密&nbsp;&nbsp;码</lable>
<input type="password" class="text" name="pwd"/><br/>
<label>验证码</lable><input type="text" name="verify" id="verify"/><div id="verimg"><img  src="verify.php" /><a href="#" onclick="window.location.reload(); return false;">刷新</a></div><br/>
<input id="submit" type="submit" value="登陆"/>
</form>
<div id="coinfo">© 广州市常盈网络科技有限公司 威播视 VBOX</div>
</div>
</body>
</html>

