<?php
session_start();
$nowOrg=$_SESSION["OrgID"];

require_once("sqlconnect.php");
$class=$_GET["class"];
$hasSN=0;
$query="select fdSortID from tbClass where id={$class}";
$result_3=mysql_query($query);
$sortid=mysql_result($result_3,0,"fdSortID");
$query="select fdHasSN from tbSort where id={$sortid}";
$result_4=mysql_query($query);
$hasSN=mysql_result($result_4,0,"fdHasSN");

$org=$_GET["org"];
$query="select fdName from tbClass where id={$class}";
$result_1=mysql_query($query);
$query="select fdName from tbOrg where id={$org}";
$result_2=mysql_query($query);
?><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo mysql_result($result_1,0,"fdName")."@".mysql_result($result_2,0,"fdName");?></title>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		      $("tr").mouseover(function(){$(this).addClass("onhover");});
		   $("tr").mouseout(function(){$(this).removeClass("onhover");});
		   
		   });
</script>
<style type="text/css">
#biaozhi{
	display:block;
	clear:right;
	}
table{
	width:100%;
	border:1px #666 solid;}
table .head{
	background-color:#06C;
	color:#CCC;
	font-size:1.1em;

	font-style:oblique;
	font-weight:500;
	border-bottom:2px #000 solid;
	}
table .class{
	border-bottom:1px #333 dotted;
	border-right:1px #666 solid;}
table .common{
	color:#00F;
	}
table .out{
	color:#333;}

#biaozhi div{
	float:left;
	width:auto;
	height:10px;
	border:1px #039 solid;
	font-size:0.7em;
	margin-left:10px;
	}
#biaozhi .common{
		color:#00f;
}
#biaozhi .out{
		color:#333;
}
.onhover{
	background-color:#f99;}
td a{
	font-size:0.7em;}
#table{
	float:none;
	display:block;}
</style>
</head>
<body>
<div id="biaozhi"><div class="common">正常</div><div class="out">在途</div></div>
<?php


require_once("sqlconnect.php");
require_once("check.php");
$isHasPri=isOrgHasPri($nowOrg,12);
function showObjecttr($class,$org,$status)
{


$query="select fdSN,fdQuantity,fdCost from tbObject where fdOrgID={$org} and fdClassID={$class} and fdStatus={$status} order by fdSN";


$result=mysql_query($query);
while($rows=mysql_fetch_assoc($result))
{
echo "<tr>";
if($status==0)
{
	if($rows["fdSN"])
echo "<td class='common class'>".$rows["fdSN"]."</td>";
else
echo "<td  class='common class'>".$rows["fdQuantity"]."</td>";
if($GLOBALS["isHasPri"])
echo "<td  class='common class'>".($rows["fdCost"]/100)."</td>";
}
else
{
if($rows["fdSN"])
echo "<td class='out class'>".$rows["fdSN"]."</td>";
else
echo "<td  class='out class'>".$rows["fdQuantity"]."</td>";
if($GLOBALS["isHasPri"])
echo "<td  class='cout class'>".($rows["fdCost"]/100)."</td>";	
}
echo "</tr>";
}
}
?>
<div id="table">
<table>
<thead>
<tr>

<?php
if($hasSN)
echo "<td class='head'>SN</td>";
else
echo "<td class='head'>数量</a></td>";
if($isHasPri)
echo "<td class='head'>价格<a>（/元）</a></td>";
?>
</tr>
<?php

showObjecttr($class,$org,0);
?>
</thead>
<thead>

<?php
showObjecttr($class,$org,1);
?>
</thead>
</table>
</div>
</body>