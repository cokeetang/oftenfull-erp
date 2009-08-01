<?php
require_once("sqlconnect.php");
function showOrgs()
{
	$thedata=array();
	$query="select * from tbOrg";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		array_push($thedata,array($row["id"],$row["fdLogin"]));
		}
	return $thedata;
	}
function showclasss()
{
	$thedata=array();
	$query="select * from tbClass";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		array_push($thedata,array($row["id"],$row["fdName"]));
		}
	return $thedata;
	}
function orgHasClassCount($orgid,$classid)
{
	$query="select * from tbObject where fdOrgID={$orgid} and fdClassID={$classid}";
	$result=mysql_query($query);
	return mysql_num_rows($result);
	}
function echoxmlOC($orgs,$classs)
{
	$string="<?xml version='1.0'?> <orgs></orgs>";
	$xml=simplexml_load_string($string);   
	for($i=0;$i<count($orgs);$i++){
        $org=$xml->addChild("org");
		$org->addAttribute("name",$orgs[$i][1]);
		for($j=0;$j<count($classs);$j++)
		{
			$org->addChild($classs[$j][1],orgHasClassCount($orgs[$i][0],$classs[$j][0]));			
			}		
		}
	echo  $xml->asXML();
}
	echoxmlOC(showOrgs(),showclasss());

?>