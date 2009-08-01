<?php
require_once("sqlconnect.php");
$result=mysql_query("select * from tbSort");
while($rows=mysql_fetch_assoc($result))
{
echo $rows["fdName"]."<->".$rows['id']."<br/>";
}

?>