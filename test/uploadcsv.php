<?php
session_start();
$orgid=$_SESSION["OrgID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="table.css" rel="stylesheet" rev="stylesheet"/>
</head>
<?php
function showbillitemfromcsv($datas)
{
	
$billtype=$_POST["billtype"];
$from=$_POST["upfrom"];
$to=$_POST["upto"];


	require_once("sqlconnect.php");
				 
	$create=date("Y-n-j H:i:s");
$query="insert into tbBill(fdBillTypeID,fdFromOrgID,fdToOrgID,fdAuditOrgID,fdStatus,fdPayment,fdCreate,fdCreateOrgID) values({$billtype},{$from},{$to},0,0,0,'{$create}',{$orgid})";
$result=mysql_query($query);
$query="select id from tbBill where fdCreate='{$create}'";
$result=mysql_query($query);
$billid=mysql_result($result,0,"id");
foreach($datas as $item)
{
$class=$item[0];
$sn=$item[2];
$count=$item[3];
if($billtype!=2)
$price=$item[4]*100;
else
$price=0;
if($billtype!=1)
{
	if($sn!='')
	{
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
	
//	echo "<table>";
//
//	foreach($datas as $item)
//	{
//	echo "<tr class='newitem item'>";
//	echo "<td class='class'>&hearts;</td>";
//foreach($item as $itemstring)
//		echo "<td class='class'>$itemstring</td>";	
//		echo "<td class='class'>X</td>";
//	echo "</tr>";
//	}
//		echo "</table>";
}

if(is_uploaded_file($_FILES['csvfile']['tmp_name']))
{
$handle=fopen($_FILES['csvfile']['tmp_name'],"r");
$data=array();
if($handle)
{
	fgets($handle, 4096);
while (!feof($handle)) 
{
   $buffer = fgets($handle, 4096);
   array_push($data,split(",",$buffer));
}
fclose($handle);
}
$returndata=showbillitemfromcsv($data);
if($returndata=='')
{
	echo "<script type='text/javascript'>alert('数据上传加载完毕');window.close();window.opener.document.getElementsByTagName('select')[0].fireEvent('onchange');	</script>";

	

	}
else
{
	echo "<script type='text/javascript'>alert('数据上传加载失败，请检查数据格式，返回再试');window.close();</script>";
}


}




?>

