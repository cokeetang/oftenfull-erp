<?php
//�Ƚ��������飬ָ���䲻ͬ���������ӵĺͼ��ٵģ�
function diffarrays($newarray,$oldarray)
{
	//
	}
//���ĳorgӵ�еĽ�ɫ��
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
//���ĳpri�ʺϵĽ�ɫ��
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
//������������Ƿ�ӵ����ͬ��Ԫ�أ�
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
//���ĳorg�Ƿ�ӵ��ĳprivilege
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
//��Ҫ��ʾһЩto���б�
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
//print_r(orgHasPriInArray(7,array(array(1,"�ɹ���"),array(2,"������"),array(3,"���۵�"),array(4,"�˻���"))));


?>