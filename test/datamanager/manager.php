<?php
//删除item和bill表中无关联object的记录（确认后的数据）；
$deleteWIB=$_GET["deletewib"];
require_once("../sqlconnect.php");
if($deleteWIB==1)
{
	$query="select id,fdObjectID,fdBillID from tbItem";
	$result=mysql_query($query);
	$error='';
	if(mysql_affected_rows())
	{
		while($rows=mysql_fetch_assoc($result))
		{
			$itemid=$rows["id"];
			$billid=$rows["fdBillID"];
			$objectid=$rows["fdObjectID"];
			$query="select id from tbObject where id={$objectid} and fdStatus=0";
			mysql_query($query);
			if(!mysql_affected_rows())
			{
				$query="delete from tbItem where id={$itemid}";
				mysql_query($query);
			if(!mysql_affected_rows())
			{
			$error.="item删除失败";	
			}
			
			}
			$query="select id from tbItem where fdBillID={$billid}";
			mysql_query($query);
			if(!mysql_affected_rows())
			{
			$query="delete from tbBill where id={$billid}";
			mysql_query($query);
			if(!mysql_affected_rows())
			{
			$error.="Bill删除失败";	
			}
			}
		
		}
	}
	$query="select id from tbBill";
	$result=mysql_query($query);
	if(mysql_affected_rows())
	{
	while($rows=mysql_fetch_assoc($result))
	{
	$billid=$rows["id"];
	$query="select id from tbItem where fdBillID={$billid}";
	mysql_query($query);
	if(!mysql_affected_rows())
	{
		$query="delete from tbBill where id={$billid}";
		mysql_query($query);
		if(!mysql_affected_rows())
		{
			$error.="Bill删除失败";	
		}
	}
	}
	}
	
	if($error=='')
	echo "OK";
	else
	echo $error;
	
}
?>