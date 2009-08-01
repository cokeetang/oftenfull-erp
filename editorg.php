<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
a{
	font-size:0.8em;
	color:#900;}
form select{
	margin-left:48px;
	width:153px;}
form textarea{
	width:203px;}
</style>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
loginchange=0;
change=0;
$(function(){
		   $("#disable").mousedown(function(){
											 $("#tijiao").removeAttr("disabled");
											
											});
		  $("form input,textarea").keypress(function(){
												 $("#tijiao").removeAttr("disabled");
												 });
		$("form select").change(function(){
												 $("#tijiao").removeAttr("disabled");
												 });										 
		   beforelogin=$("#login").val();
		   
		   $("#login").change(function(){
									   loginchange=1;
									   });
		   $("#login").change(function(){
									 if(loginchange==1)
									 $.get("scripts/checkifone.php",{login:$("#login").val(),blogin:beforelogin},function(data){
									if(data==1)
									{
									alert("用户名不可用");
									$("#tijiao").attr("disabled","disabled");
									
									$("#login").val(beforelogin).focus();
									}
									else
									$("#tijiao").removeAttr("disabled");
									});
									
				
				
				
									 
									 
									 
		   });
		   });
</script>

</head>
<?php
require_once("sqlconnect.php");
require_once("getdata.php");
require_once("orgdata.php");
require_once("check.php");

$orgInfo=orgInfo($_GET["orgid"]);
?>

<form action="editorgreply.php" method="post">
<input style="display:none" type="text" value="<?php echo $orgInfo[0] ?>" name="id"/>
姓&nbsp;&nbsp;名<input type="text" value="<?php echo $orgInfo[1]?>" name="name" id="name"/><br/>
登陆名<input type="text" value="<?php echo $orgInfo[2]?>" name="login" id="login"/><br/>
角&nbsp;&nbsp;色<br/><select name="roles[]" id="roles" multiple="multiple" >
<?php
showorghasrolesoption(orgHasRole($_GET["orgid"]),showrole());
?>
</select><br/><a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;配合Ctrl和Shif多选</a><br/>
联系方式<br/><textarea name="contact" id="contact"><?php echo $orgInfo[3]?></textarea><br/>
<input type="checkbox" id="disable" name="disable" <?php if($orgInfo[4]==1) echo "checked='checked'" ?>>禁用</input><br/>
<input type="submit" value="提交" disabled="disabled" id="tijiao"/>
<input type="reset" value="重置" id="fangqi"/>

</form>

