<?php
$handle=fopen("../upload/demo.csv","r");
$data=array();
if($handle)
{
	while (!feof($handle)) {
   $buffer = fgets($handle, 4096);
   array_push($data,split(",",$buffer));
  }
fclose($handle);
}
function showbillitemfromcsv($datas)
{
	echo "<table>";
	echo "<tr>";
	echo "<td class='head'>ID</td>";	
	echo "<td class='head'>����</td>";
	echo "<td class='head'>S/N</td>";
	echo "<td class='head'>����</td>";
	echo "<td class='head'>����<tt>��/Ԫ��</tt></td>";
	echo "<td class='head'>�ϼ�<tt>��/Ԫ��</tt></td>";
	echo "<td class='head'>ɾ��</td>";
	echo "</tr>";
	foreach($datas as $item)
	{
	echo "<tr class='newitem item'>";
	echo "<td class='class'>�༭</td>";
foreach($item as $itemstring)
		echo "<td class='class'>$itemstring</td>";	
		echo "<td class='class'>X</td>";
	echo "</tr>";
		}
		echo "</table>";
	}
showbillitemfromcsv($data);
?>