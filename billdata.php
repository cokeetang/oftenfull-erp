<?php
session_start();
$orgid=$_SESSION["OrgID"];
$eachpage=15;
$grouppage=5;
//显示打印版的item列表
//暂时只针对销售单
function printbillitem($billtype,$billid)
{
	$query="select * from tbBill where id={$billid}";
	$result=mysql_query($query);
	$pay=mysql_result($result,0,"fdPayment");
	$orgfrom=mysql_result($result,0,"fdFromOrgID");
	$orgto=mysql_result($result,0,"fdToOrgID");
	$status=mysql_result($result,0,"fdStatus");
	$auditid=mysql_result($result,0,"fdAuditOrgID");
	$createtime=mysql_result($result,0,"fdCreate");
	
	$query="select fdName from tbOrg where id={$orgto}";
	$result=mysql_query($query);
	$orgtoname=mysql_result($result,0,"fdName");
	
	$query="select fdName from tbOrg where id={$orgfrom}";
	$result=mysql_query($query);
	$orgfromname=mysql_result($result,0,"fdName");
	
	if($auditid!=0)
	{
	$query="select fdName from tbOrg where id={$auditid}";
	$result=mysql_query($query);
	$auditname=mysql_result($result,0,"fdName");
	}
	
	$query="select fdName from tbOrg where id={$_SESSION["OrgID"]}";
	$result=mysql_query($query);
	$orgname=mysql_result($result,0,"fdName");

	echo "<table border='0'  cellspacing='0' cellpadding='0'>";
echo "<tr>";
	switch($billtype){
	case 1:
	echo "<td class='head'>进货单</td>";
	break;
	case 2:
	echo "<td class='head'>调货单</td>";
	break;
	case 3:
	echo "<td class='head'>销售送货单</td>";
	break;
	case 4:
	echo "<td class='head'>退货单</td>";
	break;}
	switch($status){
	case 0:
	echo "<td class='head'>状态：<b>未审核</b></td>";
	break;
	case 1:
	echo "<td class='head'>状态：<b>未确认</b></td>";
	break;
	case 2:
	echo "<td class='head'>状态：<b>已确认</b></td>";
	break;
	case 3:
	echo "<td class='head'>状态：<b>已作废</b></td>";
	break;}
	if($auditid==0)
	echo "<td class='head'>&nbsp;</td>";
	else
	echo "<td class='head'>审核：<b>$auditname</b></td>";
    echo "<td class='head'>打印：<b>$orgname</b></td>";
	echo "<td class='head'><a>上级签字：</a></td>";
echo "</tr>";

		echo "<tr>";
		if($billtye==3)
		echo "<td class='class' colspan='3' >客户：$orgtoname</td>";
		elseif($billtype==1||$billtype==2)
		echo "<td class='class'>从：$orgfromname 到：$orgtoname </td>";
		else
		echo "<td class='class'  >客户：$orgtoname</td>";

		echo "<td class='class' colspan='3'>日期：$createtime</td>";
		echo "<td class='class'>编号：$billid</td>";
		echo "</tr>";
		
		echo "<tr>";
	
	echo "<td class='head'>名称</td>";
	
	echo "<td class='head'>S/N</td>";
	echo "<td class='head'>数量</td>";
	
	if($billtype!=2){
	echo "<td class='head'>价格<a>（/元）</a></td>";
	echo "<td class='head'>小计<a>（/元）</a></td>";
	}
	echo "</tr>";
	$items=array();
	//fdBillID,fdObjectID,fdQuantity,fdPrice,fdClassID,fdSN
	$query="select * from tbItem where fdBillID={$billid}";
	$thebigcost=0;
	$result=mysql_query($query);	
		while($row=mysql_fetch_assoc($result))
	{
		$objectname=getobjectname($row["fdClassID"]);
		$sn=$row["fdSN"];
		$count=$row["fdQuantity"];
		if($billtype!=2)
		{
		$cost=$row["fdPrice"]/100;
		$full=$count*$cost;
		$thebigcost+=$full;
		}
		echo "<tr>";
	echo "<td class='class'>$objectname</td>";
	if($sn)
	echo "<td class='class'>$sn</td>";
	else
	echo "<td class='class'>&nbsp</td>";
	echo "<td class='class'>$count</td>";
	if($billtype!=2)
	{
	echo "<td class='class'>$cost</td>";
	echo "<td class='class'>$full</td>";
	}
	echo "</tr>";
	}
	echo "<tr>";
	if($billtype!=2)
	{
	echo "<td   class='heji'>合计：<a>$thebigcost </a>元</td>";
	echo "<td   class='heji' colspan='2'>已支付：<a>$pay </a>元</td>";
	echo "<td   class='heji' colspan='2'> 欠款：<a>".($thebigcost-$pay)."</a>元</td>";
	}
	
	
	echo "</tr>";
	echo "<tr><td></td><td colspan='2'>";
		if($billtype==1||$billtype==2)
	echo "确认人签字:";
	else
	echo "<a>客户签字：________________<a>";
	echo "</td>";
	echo "<td colspan='2'>";
	echo "签字时间：________________";
	echo "</td>";
	
	echo "</tr>";
	echo "</table>";

}
//显示某bill的item列表
function showbillitem($billtype,$billid)
{
	$items=array();
	//fdBillID,fdObjectID,fdQuantity,fdPrice,fdClassID,fdSN
	$query="select * from tbItem where fdBillID={$billid}";
	
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		$objectname=getobjectname($row["fdClassID"]);
		$sn=$row["fdSN"];
		$count=$row["fdQuantity"];
		$cost=$row["fdPrice"];
		$full=$count*$cost;
		array_push($items,array("<a class='edititem' id=".$row["id"]." href=".$row["id"].">".$row["id"]."</a>","<pp href=".$objectid.">".$objectname."</pp>",$sn,$count,$cost,$full,"<a href='#' class='deleteitem'>X</a>"));
		}
	echo "<table>";
	echo "<tr>";
	echo "<td class='head'>ID</td>";	
	echo "<td class='head'>名称</td>";
	echo "<td class='head'>S/N</td>";
	echo "<td class='head'>数量</td>";
	if($billtype!=2)
	{
	echo "<td class='head'>单价<tt>（/元）</tt></td>";
	echo "<td class='head'>合计<tt>（/元）</tt></td>";
	}
	echo "<td class='head'>删除</td>";
	echo "</tr>";
	foreach($items as $item)
	{
	echo "<tr class='olditem item'>";

		echo "<td class='class'>$item[0]</td>";	
		
		echo "<td class='class'>$item[1]</td>";

		if($item[2])
		echo "<td class='class'>$item[2]</td>";
		else
		echo "<td class='class'>&nbsp;</td>";
		echo "<td class='class'>$item[3]</td>";
		if($billtype!=2)
		{
		echo "<td class='class'>".($item[4]/100)."</td>";
		echo "<td class='class'>".($item[5]/100)."</td>";
		}
		echo "<td class='class'>$item[6]</td>";
		
	echo "</tr>";
		}
		echo "</table>";
	}
//查询某物体名称、的单价、sn
function getobjectname($classid)
{
		$query="select fdName from tbClass where id={$classid}";
		$result=mysql_query($query);
		$classname=mysql_result($result,0,"fdName");
		return $classname;

	}
function getobjectcost($objectid)
{
		$query="select fdCost from tbObject where id={$objectid}";
		$result=mysql_query($query);
		return mysql_result($result,0,"fdCost");

	}
function getobjectsn($objectid)
{
		$query="select fdSN from tbObject where id={$objectid}";
		$result=mysql_query($query);
		return mysql_result($result,0,"fdSN");

	}
function getfullcostbill($billid){
	$query="select fdPrice,fdQuantity from tbItem where fdBillID={$billid}";
	$result=mysql_query($query);
	$fullcost=0;
	while($row=mysql_fetch_assoc($result))
	{
		$fullcost+=$row["fdPrice"]*$row["fdQuantity"];
		
		}
	return $fullcost/100;
	}
function showbilltable($billtype,$org,$pagestart)
{
	echo "<table>";
	echo "<tr>";
	echo "<td class='head'>ID</td>";
	echo "<td class='head'>写单人</td>";
	echo "<td class='head'>日期</td>";
	echo "<td class='head'>从</td>";
	echo "<td class='head'>到</td>";
	echo "<td class='head'>状态</td>";
	if($billtype!=2)
	echo "<td class='head'>支付情况</td>";
	echo "<td class='head'>删除</td>";
	echo "<td class='head'>摘要</td>";
	echo "</tr>";
	$bills=getbillsfromtype($billtype,$org,($pagestart-1)*$GLOBALS["eachpage"]);
	
	foreach($bills as $bill)
	{
		$query="select fdStatus from tbBill where id={$bill[0]}";
		$result=mysql_query($query);
		$status=mysql_result($result,0,"fdStatus");
	echo "<tr>";
		echo "<td class='class'><a href=$bill[0] class='editid'>$bill[0]</a></td>";	
		echo "<td class='class'>$bill[7]</td>";	
		echo "<td class='class'>$bill[1]</td>";	
		echo "<td class='class'>$bill[2]</td>";	
		echo "<td class='class'>$bill[3]</td>";	
		echo "<td class='class'>$bill[4]</td>";	
		if($billtype!=2)
		{
			$full=getfullcostbill($bill[0]);
			if($full!=$bill[5])
			{
				if($status==2)
		echo "<td class='class'><a class='zhifu' href='scripts/zhifu.php?id=".$bill[0]."&has=".$bill[5]."&full=".$full."'>".$bill[5]."/".$full."</a></td>";	
			else
		echo "<td class='class'>".$bill[5]."/".$full."</td>";	
			}
		else
		{
		echo "<td class='class'>".$full."元支付完毕</td>";	
		}
		}
		if($status==0||$status==3)
		echo "<td class='class'><a class='deletebill' tt=$bill[0] href=$bill[0]>&Chi;<a></td>";	
		else
		echo "<td class='class'>&nbsp;</td>";	
		if($bill[6])
		echo "<td class='class'><a href='#' kk=$bill[0] class='editabstract'>查看</a></td>";	
		else
		echo "<td class='class' ><a href='#' kk=$bill[0] class='editabstract'>添加</a></td>";

	echo "</tr>";
}
	echo "</table>";
	echo "<div id='pages'>页码:";

	$counts=getfullcounts($billtype,$org);

$fullpage=ceil($counts/$GLOBALS["eachpage"]);
$grouppage=$GLOBALS["grouppage"];
$nowgroup=floor(($pagestart-1)/$grouppage);
$fullgroup=floor(($fullpage-1)/$grouppage);
$startpage=$nowgroup*$grouppage+1;
	if($nowgroup==$fullgroup)
	$endpage=$fullpage+1;
	else
	{
		if($fullgroup>=0)
	$endpage=($nowgroup+1)*$grouppage+1;
	else
	$endpage=0;
	}
if($fullgroup!=0&&$nowgroup!=0)
{
echo "<a href='#' class='pages' ref='1'><<</a> ";	
echo "<a  href='#'  class='pages' ref='".($startpage-1)."'><</a> ";
}

    while($startpage<$endpage)
    {
		if($startpage==$pagestart)
		echo "<a class='now'>".$startpage."</a>";
		else
		echo "<a href='#' class='pages' ref='".$startpage."'>".$startpage."</a>";
	$startpage++;
	}
if($fullgroup!=0&&$nowgroup!=$fullgroup&&$endpage!=0)
{

echo "<a href='#'  class='pages'  ref='".$startpage."'>></a> ";
echo "<a href='#'  class='pages'  ref='".$fullpage."'>>></a> ";	
}

	echo "</div>";

	
	}
//require_once("sqlconnect.php");
//echo showbilltable(1,1,0);
function getfullcounts($billtype,$org)
{
	if(isOrgHasPri($org,$billtype)||isOrgHasPri($org,$billtype+4))
	return mysql_result(mysql_query("select count(id) as count from tbBill where fdBilltypeID={$billtype}"),0,"count");
	return mysql_result(mysql_query("select count(id) as count from tbBill where fdBilltypeID={$billtype} and (fdFromOrgID=$org or fdToOrgID=$org or fdAuditOrgID=$org)"),0,"count");
	}
function getNamefromorgid($orgid)
{
	$query="select * from tbOrg where id={$orgid}";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		return $row["fdName"];
		}
	}
//从状态值返回其字面值
function getstringfromid($id)
{
	switch($id){
	case 0:
	return "<b class='s0'>未审核</b>";
	case 1:
	return "<b class='s1'>未确认</b>";
	case 2:
	return "<b class='s2'>已确认</b>";
	case 3:
	return "<b class='s3'>已作废</b>";}
	}
//返回某billtype的关于某org的所有bill
function getbillsfromtype($billtype,$org,$pagestart)
{
	
    $returndata=array();
require_once("check.php");
require_once("sqlconnect.php");
if(isOrgHasPri($org,$billtype)||isOrgHasPri($org,$billtype+4))
	$result=mysql_query("select * from tbBill where fdBilltypeID={$billtype} order by id desc LIMIT {$pagestart},{$GLOBALS['eachpage']}");
	else
	$result=mysql_query("select * from tbBill where fdBilltypeID={$billtype} and (fdFromOrgID=$org or fdToOrgID=$org or fdAuditOrgID=$org) order by id desc LIMIT {$pagestart},{$GLOBALS['eachpage']}");
	while($row=mysql_fetch_assoc($result))
	{
		array_push($returndata,array($row["id"],$row["fdCreate"],getNamefromorgid($row["fdFromOrgID"]),getNamefromorgid($row["fdToOrgID"]),getstringfromid($row["fdStatus"]),$row["fdPayment"],$row["fdAbstract"],getNamefromorgid($row["fdCreateOrgID"])));
//		$_SESSION["fromid"]=$row["fdFromOrgID"];
//		$_SESSION["toid"]=$row["fdToOrgID"];
//		$_SESSION["auditid"]=$row["fdAuditOrgID"];

}
	return $returndata;
	}

function getdata($table)
{
		$thedata=array();
	$query="select * from {$table}";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		array_push($thedata,array($row["id"],$row["fdName"]));
		}
	return $thedata;
	}
function data2a($page,$data)
{
	
	for($i=0;$i<count($data);$i++)
	{
	echo "<a class='link' href='".$page.".php?type=".$data[$i][0]."'>".$data[$i][1]."</a>  ";}
	}
function data2select($datas)
{
	echo "<select>";
	echo "<option disabled='disabled'>选择</option> ";
	foreach($datas as $data)
	echo "<option value=".$data[0].">".$data[1]."</option> ";
	
	echo "</select>";
}


?>