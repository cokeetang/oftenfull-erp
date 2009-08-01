<?php
session_start();
$orgid=$_SESSION["OrgID"];
if($orgid=='')
require_once("returnlogin_1.html");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		   $(".head").click(function(){
									  $("input").removeClass("headactive");
									 $(this).find("input").addClass("headactive");
									
									 $(this).parent().find(".secondlevel").show("slow");
										$(this).parent().prevAll().find(".secondlevel").hide("slow");										  
										$(this).parent().nextAll().find(".secondlevel").hide("slow");
										
																				  });
		   $(".secondlevel").click(function(){
										  $("div").removeClass("secondactive");
									 $(this).addClass("secondactive");
											top.frames["content"].location=$(this).attr("src");
											//alert($(this).attr("src"));
												
											});
		   
		   });
</script>
<style type="text/css">
.headactive{
	background-color:#000;
	color:#FFF;
	font-size:1.1em;}

body{
	padding:0px;
	margin:0px;}
#menu{
	
	text-align:center;
	cursor:default;}
.firstlevel{
	border:1px #036 solid;}
.head{
	background-color:#333;
	color:#CCC;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-style:inherit;}
.secondlevel{
	background-color:#999;
	color:#FFF;
	font-size:0.8em;
	border:1px #666 solid;
	display:none;}
.head input{
	width:100%;
	height:30px;}
.name{
	background-color:#333;
	color:#FFF;
	font-weight:400;
	font:Georgia, "Times New Roman", Times, serif;}
#loginname a{
	font-size:0.7em;
	text-align:right;
	color:#FFC;}
.head input{
	border:1px #CCC solid;}
.secondactive{
	background-color:#333;
	color:#CCC;}
#logo{
	background-color:#000;}
#logo img{
	width:90%;
	margin:6px auto;
	
	}
</style>
<title>Untitled Document</title>
</head>

<body>
<div id="menu">
<?php
require_once("sqlconnect.php");
$query="select fdName from tbOrg where id={$_SESSION['OrgID']}";
$result=mysql_query($query);
$orgname=mysql_result($result,0,"fdName");
?>
<div id="logo"><img src="imgs/logo.gif"/></div>
<div class="firstlevel"><div class="head" class="name" id="loginname"><?php echo $orgname?><a>在线</a></div></div>
<div class="firstlevel"><div class="head"><input type="button" value="内容资讯"/></div></div>
<div class="firstlevel"><div class="head"><input type="button" value="终端用户"/></div><div class="secondlevel" src="object.php">查询</div><div class="secondlevel" src="release.php">版本</div></div>



<?php
require_once("sqlconnect.php");
require_once("check.php");

if(isOrgHasPri($orgid,9)||isOrgHasPri($orgid,10))
{
echo "<div class='firstlevel'><div class='head'><input type='button' value='进销存'/></div>";

}
if(isOrgHasPri($orgid,9))
{
echo "<div class='secondlevel' src='stockview.php'>库存</div>";


}
if(isOrgHasPri($orgid,10))
echo "<div class='secondlevel' src='billview.php'>单据</div>";
if(isOrgHasPri($orgid,9)||isOrgHasPri($orgid,10))
echo "</div>";
?>
<div class="firstlevel"><div class="head"><input type="button" value="系统管理"/></div>
<?php
if(isOrgHasPri($orgid,11))
{
echo "<div class='secondlevel' src='org.php'>组织</div>";
echo "<div class='secondlevel' src='grant.php'>授权</div>";
}
if($orgid==7)
echo "<div class='secondlevel' src='datamanager/index.php'>数据整理</div>";

?>

<div class="secondlevel" src="setting.php">设置</div><div class="secondlevel" src="logout.php">退出</div></div>
</div>
</body>
</html>