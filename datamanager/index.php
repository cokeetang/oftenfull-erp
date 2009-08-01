<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.bigbtn{
	width:100%;
	border:1px #666 solid;}
.hover{
	background-color:#069;
	color:#6C3;}

</style>
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		   $(".bigbtn").hover(function(){
									   $(this).addClass("hover");
									   },function(){
										   
										    $(this).removeClass("hover");
										   });
		   $("#deleteWrongItemAndBill").click(function(){
													
													  $.get("manager.php",{deletewib:1},function(data){
																								
																								if(data=="OK")
																								{
																									alert("修复成功");}
																									else
																									{
																										alert("修复失败");}
																									 
																		   
																		   });
													   });
		   
		   
		   });
</script>
</head>


<body>
<input class="bigbtn" type="button" id="deleteWrongItemAndBill" value="删除item和bill表中无关联object的记录（确认后的数据）" />
</body>
</html>