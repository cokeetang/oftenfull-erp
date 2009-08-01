<?php
$bday=$_GET["bday"];
$orgid=$_GET["org"];
$classid=$_GET["class"];
if($orgid=='某单位')
$orgid=0;
if($classid=='某细类')
$classid=0;
$now=mktime();
require_once("../sqlconnect.php");

$now_0=getdate($now);

$now_0_unix=mktime(0,0,0,$now_0["mon"],$now_0["mday"],$now_0["year"]);

$diff=$bday*60*60*24;

$thattime=$now_0_unix-$diff;


$query_object="select fdQuantity from tbObject where fdOrgID={$orgid} and fdClassID={$classid}";
$result_object=mysql_query($query_object);
$nowcount=0;
while($row=mysql_fetch_assoc($result_object))
{
	$nowcount+=$row["fdQuantity"];
}


echo "<table cellspacing='0' cellpadding='0'>";
echo "<tr><td class='head'>日期</td><td class='head'>进</td><td class='head'>出</td><td class='head'>对方单位</td><td class='head'>库存</td></tr>";
$i=0;
while($now_0_unix>$thattime)
{
	
	$time_array=getdate($now_0_unix);
	$time=$time_array["year"]."-".$time_array["mon"]."-".$time_array["mday"];
	$time_1=$now_0_unix;
	$time_2=$now_0_unix+86400;
	$time_1_string=date("Y-n-j H:i:s",$time_1);
	$time_2_string=date("Y-n-j H:i:s",$time_2);
	$query="select id,fdToOrgID,fdFromOrgID,fdConfirm from tbBill where fdStatus=2 and fdConfirm>='{$time_1_string}' and fdConfirm<'{$time_2_string}' and (fdToOrgID={$orgid} or fdFromOrgID={$orgid})";
$result=mysql_query($query);
if(mysql_affected_rows()>0)
{
	$i+=1;
	$count_in=0;
$count_out=0;
	while($row=mysql_fetch_assoc($result))
	{
		//进
	if($row["fdToOrgID"]==$orgid)
	{
	$otherid=$row["fdFromOrgID"];	
	$billid=$row["id"];
	$theday=$row["fdConfirm"];
	$query_1="select fdQuantity from tbItem where fdClassID={$classid} and fdBillID={$billid}";
	$result_1=mysql_query($query_1);
	while($rows=mysql_fetch_assoc($result_1))
	$count_in+=$rows["fdQuantity"];
	
	}//出
	else
	{
	$otherid=$row["fdToOrgID"];
	$billid=$row["id"];
	$theday=$row["fdConfirm"];
	$query_1="select fdQuantity from tbItem where fdClassID={$classid} and fdBillID={$billid}";
	$result_1=mysql_query($query_1);
	while($rows=mysql_fetch_assoc($result_1))
	$count_out+=$rows["fdQuantity"];
	
	}
	}
	if($otherid)
	{
	$query_name="select fdName from tbOrg where id={$otherid}";
	$result_name=mysql_query($query_name);
	$othername=mysql_result($result_name,0,"fdName");
	}
	else
	$othername='&nbsp;';
	
	echo "<tr><td>".$time."</td><td>".$count_in."</td><td>".$count_out."</td><td>".$othername."</td><td>".$nowcount."</td></tr>";

}

$nowcount=$nowcount+($count_out-$count_in);
	$now_0_unix-=86400;
}
echo "</table>";
if($i==0)
echo "<script type='text/javascript'>alert('无任何数据');</script>";















//
//
//$query="select id,fdToOrgID,fdConfirm from tbBill where fdConfirm>='{$thatstringtime}' and (fdToOrgID={$orgid} or fdFromOrgID={$orgid})";
//$result=mysql_query($query);
//if(mysql_affected_rows()>0)
//{
//	while($row=mysql_fetch_assoc($result))
//	{
//		//进
//	if($row["fdToOrgID"]==$orgid)
//	{
//	$count_in=0;
//	$billid=$row["id"];
//	$theday=$row["fdConfirm"];
//	$query_1="select fdQuantity from tbItem where fdClassID={$classid} and fdBillID={$billid}";
//	$result_1=mysql_query($query_1);
//	while($rows=mysql_fetch_assoc($result_1))
//	$count_in+=$rows["fdQuantity"];
//	echo $theday." ".$count_in."<br/>";
//	}//出
//	else
//	{
//	$count_out=0;
//	$billid=$row["id"];
//	$theday=$row["fdConfirm"];
//	$query_1="select fdQuantity from tbItem where fdClassID={$classid} and fdBillID={$billid}";
//	$result_1=mysql_query($query_1);
//	while($rows=mysql_fetch_assoc($result_1))
//	$count_out+=$rows["fdQuantity"];
//	echo $theday." ".$count_out."<br/>";
//	}
//	}
//}


?>