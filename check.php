<?php
//比较两个数组，指出其不同，返回增加的和减少的；
function diffarrays($newarray,$oldarray)
{
	//
	}
//检查某org拥有的角色；
function orgHasRole($orgid)
{

$result=mysql_query("select fdRoleID from tbMember where fdOrgID={$orgid}");
$roleids=array();
while($row=mysql_fetch_assoc($result))
{
	array_push($roleids,$row["fdRoleID"]);
	}
return $roleids;
}
//检查某pri适合的角色；
function priHasRole($priid)
{
$result=mysql_query("select fdRoleID from tbGrant where fdPrivilegeID={$priid}");
$roleids=array();
while($row=mysql_fetch_assoc($result))
{
	array_push($roleids,$row["fdRoleID"]);
	}
return $roleids;
}
//检查两个数组是否拥有相同的元素；
function ifHasSame($array_1,$array_2)
{
	foreach($array_1 as $data_1)
	foreach($array_2 as $data_2)
	{
		if($data_1==$data_2)
		return 1;
		}
	return 0;
	}
//检查某org是否拥有某privilege
function isOrgHasPri($orgid,$priid)
{
	return ifHasSame(orgHasRole($orgid),priHasRole($priid));
	}
function orgHasPriInArray($org,$pris)
{
	$thePri=array();
	foreach($pris as $pri)
	{
		if(isOrgHasPri($org,$pri[0]+4))
		array_push($thePri,$pri);
		}
		$tobilltype=orgisBillTo($org);

	return deletecommon(array_merge($thePri,$tobilltype));
	
	}
//需要显示一些to的列表
function orgisBillTo($org)
{
	$query="select fdBillTypeID from tbBill where fdToOrgID={$org}";
	$result=mysql_query($query);
	$data=array();
	if(mysql_num_rows($result))
	{
		while($row=mysql_fetch_assoc($result))
		array_push($data,$row["fdBillTypeID"]);
		}
	$billtypeids=deletecommon($data);
	$billtype=array();
	foreach($billtypeids as $id)
	{
		array_push($billtype,array($id,billtypename($id)));
		}
	return $billtype;
	}
function billtypename($id)
{
	$query="select fdName from tbBillType where id={$id}";
$result=mysql_query($query);
return mysql_result($result,0,"fdName");
	}
function deletecommon($array)
{
	$returndata=array();
	foreach($array as $data)
	{
		if(isdatainarray($data,$returndata))
		array_push($returndata,$data);
		}
	return $returndata;
	}
function isdatainarray($data,$array)
{
foreach($array as $data_1)
{
if($data_1==$data)
return 0;
}
return 1;
}

require_once("sqlconnect.php");
//echo isOrgHasPri(16,10);
//print_r(orgHasPriInArray(7,array(array(1,"采购单"),array(2,"调拨单"),array(3,"销售单"),array(4,"退货单"))));


?>