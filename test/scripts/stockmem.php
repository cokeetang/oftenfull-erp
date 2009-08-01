<?php
require_once("../sqlconnect.php");require_once("../getdata.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>库存流水记录查询</title>
<style type="text/css">
body{
	margin:0px;
	padding:0px;}
#head div{
	border:1px  #036 solid;
	
	padding:5px;
	
	font-size:0.9em;
	font-family:Arial, Helvetica, sans-serif;
	color:#930;
	float:left;
	
	height:25px;}

#head div div{
	font-style:normal;
	color:#000;}
td{
	border-left:1px #000 solid;
	border-bottom:1px #000 solid;}
.head{
	background-color:#333;
	color:#FFF;
	font-size:1.1em;}
#returndata{
	width:100%;}
table{
	width:95%;
	margin:0px;}
</style>
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		   	  $(".roleshow").change(function(){
											$.get("../getorg.php",{"roleid":$(".roleshow").val()},function(data){
																											   $("#orgshow").html(data);
																											   });
											});
		  $("#chaxun").click(function(){
									  
									  $.get("stockmemreply.php",{"bday":$("#bday").val(),"org":$("#orgshow").val(),"class":$("#classshow").val()},function(data){
																																						   $("#returndata").html(data);
																																						   })
									  });

		   });
</script>
</head>

<body>
<div id="head">
<div>
倒数<input type="text" class="days" id="bday" style="width:30px" value="7" />天内
<?php showRoleSelect(showrole()); echo "中";?>
<?php echoOrgs(roleHasOrg(0));?>
<?php echo "对"; echoclasss(showclasss());echo "的操作"?>
<input style="width:50px;height:25px;" type="button" id="chaxun" value="查询"/></div>
<div id="returndata" class="type" style="padding:0px; height:460px; overflow:scroll;"></div>
</body>
</html>