<?php
function isnotin($array,$data)
{
	foreach($array as $data_1)
	{
		if($data_1==$data)
		return 0;
		}
	return 1;
	}
//返回数组内角色拥有的org数组；
function getOrgFromRoles($rolesid)
{
	$orgs=array();
	$orgids=array();
	foreach($rolesid as $roleid)
	{
		$result_1=mysql_query("select fdOrgID from tbMember where fdRoleID={$roleid}");
		while($row=mysql_fetch_assoc($result_1))
		{
			if(isnotin($orgids,$row["fdOrgID"]))
			array_push($orgids,$row["fdOrgID"]);
		}
	}
			foreach($orgids as $orgid)
		{
		$result_2=mysql_query("select fdName from tbOrg where id={$orgid}");
		while($row=mysql_fetch_assoc($result_2))
		{
			array_push($orgs,array($orgid,$row["fdName"]));
		}
		}
		return $orgs;
	}
//将2维数组转化为列表；
function array2select($data)
{
	echo "<select>";
	for($i=0;$i<count($data);$i++)
	{
	echo "<option value=".$data[$i][0].">".$data[$i][1]."</option>  ";
	}
	echo "</select>";
}
function array2selectwithself($array,$data)
{
	echo "<select>";
		echo "<option value=".$array[0].">".$array[1]."</option>  ";

	for($i=0;$i<count($data);$i++)
	{
	echo "<option value=".$data[$i][0].">仓库&gt;".$data[$i][1]."</option>  ";
	}
	echo "</select>";
}
//require_once("sqlconnect.php");
//array2select(getOrgFromRoles(array(2,4)));
?>