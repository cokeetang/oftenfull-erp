<?php
session_start();
$orgid=$_SESSION["OrgID"];
require_once("sqlconnect.php");
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
#bighouse{
	position:absolute;
	top:0px;
	left:0px;
	height:100%;
	width:100%;
	
	border:1px #039 solid;
	overflow:scroll;}
.smallhouse{
	width:150px;
	height:140px;
	border:1px #30C solid;
	float:left;
	margin-top:25px;
	}
.smallid{
	background-color:#30C;
	color:#999;
	width:30px;
	height:20px;}
.datebox{
	clear:left;
	}
.date{
	font-size:0.6em;
	border-top:1px #30c solid;
	width:100%；

	}
.smallbox{
	margin:10px;
	background-color:#333;
	color:#FFF;
	font-family:Georgia, "Times New Roman", Times, serif;

	width:40px;
	height:60px;
	border:1px #000 solid;
	float:left;}
img{
	float:left;
	margin-top:25px;}
.hover{
	cursor:pointer;
	background-color:#666;}
.org{
	margin-right:5px;
	float:left;
	font-size:0.6em;}
</style>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		   $(".smallbox").hover(function(){$(this).addClass("hover");},function(){$(this).removeClass("hover");});
		   $(".xiangqing").click(function(){
							   window.open("scripts/billinfo.php?billid="+$(this).attr("vid"),'',"width=600,height=600");});
		   $(".stock").click(function(){
							   window.open("scripts/stockinfo.php?billid="+$(this).attr("vid"),'',"width=600,height=600");});
		   
		   });
</script>
<title>Untitled Document</title>
</head>

<body>
<div id="bighouse">
<?php
function getNameFromOrgID($orgid)
{
	$query_1="select fdName from tbOrg where id={$orgid}";
$result_1=mysql_query($query_1);
return mysql_result($result_1,0,"fdName");
	}

$query="select * from tbBill where fdFromOrgID={$orgid} or fdToOrgID={$orgid}";
$result=mysql_query($query);
while($row=mysql_fetch_assoc($result))
{

echo "<div class='smallhouse'>";
echo "<div class='smallid'>".$row["id"]."</div>";
echo "<div>";
echo "<div class='smallbox xiangqing' vid=".$row['id'].">详情</div>";
echo "<div class='smallbox stock' vid=".$row['id'].">库存</div>";
echo "</div>";
echo "<div>";

echo "<div class='from org'>从：".getNameFromOrgID($row['fdFromOrgID'])."</div>";
echo " <div class='to org'>到：".getNameFromOrgID($row['fdToOrgID'])."</div>";

echo "</div>";
echo "<div class='datebox'>";
echo "<div class='date'>创建时间：".$row["fdCreate"]."</div>";
echo "<div class='date'>审核时间：".$row["fdAudit"]."</div>";
echo "<div class='date'>确认时间：".$row["fdConfirm"]."</div>";
echo "</div>";
echo "</div>";
echo "<img src='imgs/fromto.jpg'/>";

}
?>
</div>
</body>
</html>