<?php
$roleid=$_GET["roleid"];
require_once("sqlconnect.php");
require_once("getdata.php");
//某org的完整信息；
function orgInfo($orgid)
{
	$query="select * from tbOrg where id={$orgid}";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		return array($row["id"],$row["fdName"],$row["fdLogin"],$row["fdContact"],$row["fdDisabled"]);
		}
	
	}

//某个role拥有的所有org完整信息；系2维数组;
function roleHasOrgsInfo($orgsid)
{
	$orgsInfo=array();
	foreach($orgsid as $orgid)
	array_push($orgsInfo,orgInfo($orgid));
	return $orgsInfo;
	}
//返回的表格html
function returnatble($roleid)
{
	$datas=roleHasOrgsInfo(roleHasOrgsID($roleid));
	echo "<table>";
	echo "<tr>";
	echo "<td class='head'>ID</td>";
	echo "<td class='head'>名称</td>";	
	echo "<td class='head'>登陆名</td>";
	echo "<td class='head'>联系方式</td>";
	echo "<td class='head'>禁用</td>";
	echo "<td class='head'>删除</td>";
	echo "</tr>";
	foreach($datas as $data)
	{
	echo "<tr>";
	echo "<td class='class'>$data[0]</td>";
	echo "<td class='class'><a tt='' href=editorg.php?orgid=".$data[0].">".$data[1]."</a></td>";	
	echo "<td class='class'>$data[2]</td>";
	echo "<td class='class'>$data[3]</td>";
	if($data[4]!=0)
	echo "<td class='class'>&times;</td>";
	else
	echo "<td class='class'></td>";
	echo "<td class='class'><a cc=".$data[0]." href='#'>&times;</></td>";
    echo "</tr>";		
		}
	echo "</table>";
}
if($roleid!='')
echo returnatble($roleid);

?>