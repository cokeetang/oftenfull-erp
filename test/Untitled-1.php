<?php
$nowpage=$_GET["page"];
$fullpage=$_GET["full"];
$grouppage=5;
$nowgroup=floor(($nowpage-1)/$grouppage);
$fullgroup=floor(($fullpage-1)/$grouppage);
$startpage=$nowgroup*$grouppage+1;
	if($nowgroup==$fullgroup)
	$endpage=$fullpage+1;
	else
	$endpage=($nowgroup+1)*$grouppage+1;
	
if($fullgroup!=0&&$nowgroup!=0)
{
echo "<a href='1'><<</a> ";	
echo "<a href='".($startpage-1)."'><</a> ";
}


	

    while($startpage<$endpage)
    {
		echo $startpage." ";
	$startpage++;
	}
if($fullgroup!=0&&$nowgroup!=$fullgroup)
{

echo "<a href='".$startpage."'>></a> ";
echo "<a href='".$fullpage."'>>></a> ";	
}

?>