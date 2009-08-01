<?php
$billid=$_GET['id'];
$pay=$_GET['pay'];
$full=$_GET['full'];
require_once("../sqlconnect.php");
$query="update tbBill set fdPayment=fdPayment+{$pay} where id={$billid}";
mysql_query($query);
if(mysql_affected_rows()==1)
{
echo "OK";
$query="select fdPayment,fdToOrgID from tbBill where id={$billid}";
$result=mysql_query($query);
$pay=mysql_result($result,0,'fdPayment');
$org=mysql_result($result,0,'fdToOrgID');
if($full==$pay)
{
$query="select * from tbItem where fdBillID={$billid}";
$result_1=mysql_query($query);
while($row=mysql_fetch_assoc($result_1))
{
	$sn=$row["fdSN"];
	$count=$row["fdQuantity"];
	$class=$row["fdClassID"];
	if($sn)
	{
		$query="update tbObject set fdPaid=1 where fdSN='{$sn}'";
		mysql_query($query);
	}
	else
	{
		//正常且未付款的项目数量
		$query="select fdQuantity,fdCost from tbObject where fdClassID={$class} and fdOrgID={$org} and fdStatus=0 and fdPaid=0";
		$result=mysql_query($query);
		$count_nopay=mysql_result($result,0,"fdQuantity");
		$cost=mysql_result($result,0,"fdCost");
		$left_nopay=$count_nopay-$count;
		$query="update tbObject set fdQuantity={$left_nopay} where fdClassID={$class} and fdOrgID={$org} and fdStatus=0 and fdPaid=0";
		mysql_query($query);
		$query="select fdQuantity from tbObject where fdClassID={$class} and fdOrgID={$org} and fdStatus=0 and fdPaid=1";
		mysql_query($query);
		if(!mysql_affected_rows())
		{
			//为空，新建记录
			$query="insert into tbObject(fdClassID,fdSN,fdStatus,fdQuantity,fdCost,fdOrgID,fdPaid) values({$class},'',0,{$count},{$cost},{$org},1)";
			mysql_query($query);
			}
		else
		{
			$query="update tbObject set fdQuantity=fdQuantity+{$count} where fdClassID={$class} and fdOrgID={$org} and fdStatus=0 and fdPaid=1";
			mysql_query($query);
			//不为空更新记录
			
			}
		
		
		}
}
}
}
else
echo "插入失败";
?>