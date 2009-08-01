
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
div{
	float:left;
	width:280px;
	background-color:#666;;
	height:250px;}
form{
	background-color:#CCC;
	border:1px #666 solid;
	width:200px;
	height:180px;
	display:none;
	}
form textarea{
	width:90%;
	height:130px;
	margin:5px 10px;}
.wrong{
	border-color:#F00;
		}
</style>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		   $("input[type='button']").click(function(){
												   $(this).parent().find("form").show("slow");
												   });
		   $("#oldpwd").blur(function(){
									  var text=$(this);

									  $.get("getpwd.php",{oldpwd:text.attr("value")},function(data){if(data!="OK"){
																							text.addClass("wrong");}																				 });
			
									  });
		   $("#oldpwd").focus(function(){
									   $(this).removeClass("wrong");
									   
									   });
		   $("#newpwdagain").blur(function(){
									     if($("#newpwd").attr("value")!=$("#newpwdagain").attr("value"))
									   {
										   $("#newpwdagain").addClass("wrong");
										   }
									   
									   });
		   $("#newpwdagain").focus(function(){
									   $(this).removeClass("wrong");
									   
									   });
		   
		   $("#chpwd").click(function(){
									   if($("#oldpwd").hasClass("wrong"))
									   {
										  alert("原始密码错误");
									   }
									   else if($("#newpwdagain").hasClass("wrong"))
									   {
										   alert("新密码不相同");
										   }
										else
										{
											
										

											$.get("getpwd.php",{pwd:$("#newpwdagain").attr("value")},function(data){if(data=="OK"){
																													   $("#chpwd").parent().hide("slow");
																													   
																													   }
																													   });
									   }

									   });
		   $("#chchform").ready(function(){
									  text=$(this).find("textarea");
									  $.get("getpwd.php?info=1",function(data){
																		 text.text(data); 
																		 })
									 });
		    $("#chcon").click(function(){
									  text=$(this).parent().find("textarea").attr("value");
									  $.get("getpwd.php?info=1",{ch:text},function(data){if(data=="OK"){
																							$("#chcon").parent().hide("slow");
																							}});
									 });
		   
		   });
</script>
</head>

<body>
<div>
<input type="button" value="修改密码"/>
<form method="post" >
原密码<input type="password" name="oldpwd" id="oldpwd" value=""/><br/>
新密码<input type="password" name="newpwd" id="newpwd"/><br/>
确&nbsp;&nbsp;认<input type="password" name="newpwdagain" id="newpwdagain"/><br/>
<input type="button" value="提交" id="chpwd" />
</form>
</div>
<div>
<input type="button" value="修改联系方式"/>
<form method="post" id="chform" >
<textarea>
</textarea><br/>
<input type="button" id="chcon" value="提交" />
</form>
</div>
</body>
</html>