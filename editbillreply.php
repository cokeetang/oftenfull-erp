<?php
session_start();
header("Cache-Control: no-cache, must-revalidate"); 
require_once("billdata.php");
$orgid=$_SESSION["OrgID"];
$billtype=$_POST["billtype"];
$billid=$_POST["billid"];
$array_del=$_POST["del"];
$array_edit=$_POST["edit"];
$array_add=$_POST["add"];
$from=$_POST["from"];
$error='';
if($from=="undefined")
{
	$from=$orgid;
	}
$to=$_POST["to"];
if($to=="undefined")
{
	$to=$orgid;}
require_once("sqlconnect.php");
if($billid==0)
{
$create=date("Y-n-j H:i:s");
$query="insert into tbBill(fdBillTypeID,fdFromOrgID,fdToOrgID,fdAuditOrgID,fdStatus,fdPayment,fdCreate,fdCreateOrgID) values({$billtype},{$from},{$to},0,0,0,'{$create}',{$orgid})";

$result=mysql_query($query);
$query="select id from tbBill where fdCreate='{$create}'";
$result=mysql_query($query);
$billid=mysql_result($result,0,"id");
	}
if(count($array_edit))
{
	foreach($array_edit as $edit)
{
//echo str_replace("\\","",$edit);
$item=json_decode(str_replace("\\","",$edit));
$id=$item->id;
$price=$item->price;
$sn=$item->sn;
$count=$item->count;
if(($item->price)=="undefined")
$price=0;
else
$price=(int)(($item->price)*100);
//fdBillID,fdObjectID,fdQuantity,fdPrice,fdClassID,fdSN
$query="update tbItem set fdSN='{$sn}',fdQuantity={$count},fdPrice={$price} where id={$id}";
mysql_query($query);

}
}
if(count($array_add))
	{
		foreach($array_add as $add)
		{
		//echo str_replace("\\","",$add);
			$item=json_decode(str_replace("\\","",$add));			
			$class=$item->id;			
			$sn=$item->sn;		
			$count=$item->count;
			if(($item->price)=="undefined")
			$price=0;
			else
			$price=(int)(($item->price)*100);
if($billtype==1)
{
	if($sn)
	{
	$query="select id from tbObject where fdSN='{$sn}'";
	
	mysql_query($query);
	if(mysql_affected_rows())
	{$error.="数据库存在SN为".$sn."的货物\n";
	echo $error;
	return 0;
	}
	}
}
elseif($billtype!=1)
{
	if($sn)
	{
if($billtype==3)
$query="select id from tbObject where fdSN='{$sn}' and fdOrgID={$from} and fdStatus=0";
else
$query="select id from tbObject where fdSN='{$sn}' and fdOrgID={$from} and fdStatus=0";

$result=mysql_query($query);

if(!mysql_num_rows($result))
{
	$error.="你没有sn为".$sn."的货物";
	echo $error;
	return 0;
	
	}
	}
	else
	{
					$query="select fdQuantity from tbObject where fdClassID={$class} and fdOrgID={$from} and fdStatus=0";
			$result=mysql_query($query);
			if(mysql_affected_rows())
			{
				$the_0_count=mysql_result($result,0,"fdQuantity");
			}
			else
			$the_0_count=0;
			if($the_0_count<$count)
			{
	$error.="你没有足够数目的".getobjectname($class)."\n";
	echo $error;
	return 0;
				
			}
		
		}
}
$query="insert tbItem(fdBillID,fdObjectID,fdQuantity,fdPrice,fdClassID,fdSN) values({$billid},0,{$count},{$price},{$class},'{$sn}') ";
//echo $query;
mysql_query($query);	

		}
		
	}
if(count($array_del))
{
	foreach($array_del as $del)
{
	$item=json_decode(str_replace("\\","",$del));
	$id=$item->id;
	$query="delete from tbItem where id={$id}";
	mysql_query($query);
	
}
	
}




if($error=='')
{
$query="select id from tbItem where fdBillID={$billid}";
mysql_query($query);
if(!mysql_affected_rows()&&!count($array_del))//不存在删除项
{
	$query="delete from tbBill where id={$billid}";
	mysql_query($query);
	echo "未添加任何表项";
	}
else
echo OK;
}
else
echo $eror;
	


//$del=str_replace("\\",'',$_POST["del"]);
////$del='{"a":1,"b":2,"c":3}';
//echo json_decode($del[1])->b;


?>