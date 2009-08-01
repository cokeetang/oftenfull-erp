<?php
$linkID=@mysql_connect("localhost","db","db") or die("Could not connect the server");
@mysql_select_db("vbox_test") or die("Could not connect the database");
mysql_query("SET NAMES 'utf8'");
?>