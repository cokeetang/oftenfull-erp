<?php
require_once("sqlconnect.php");
function orgHasBiilType($org)
{
	$query="select fdRoleID from tbMember where fdOrgID='{$org}'";
	$result=mysql_query($query);
	$roles=array();
	while($row=mysql_fetch_assoc($result))
	{
		array_push($roles,$row["fdRoleID"]);
		}
	$sortbill=array(array(array(2),array(1,"进仓单")),array(array(2,3,4),array(2,"调货单")),array(array(2,3,4),array(3,"销售单")),array(array(3,4,5,6),array(4,"退货单")));
    $billtype=array();
	foreach($sortbill as $bill)
	{
		if(hasCommon($bill[0],$roles))
		array_push($billtype,array($bill[1][0],$bill[1][1]));
		}
	return $billtype;
	}
function hasCommon($array_1,$array_2)
{
	foreach($array_1 as $data_1)
	foreach($array_2 as $data_2)
	{
		if($data_1==$data_2)
		return 1;
		}
	return 0;
}
//print_r(orgHasBiilType(13));
?>