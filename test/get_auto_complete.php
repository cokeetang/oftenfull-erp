<?php
$orgname_like=$_GET["q"];
require_once("sqlconnect.php");
$query="select fdName from tbOrg where fdName like '%{$orgname_like}%'";
$result=mysql_query($query);
if(mysql_affected_rows()>=1)
{
	while($rows=mysql_fetch_assoc($result))
	echo $rows["fdName"]."\n";
	}
else
echo '';
?>