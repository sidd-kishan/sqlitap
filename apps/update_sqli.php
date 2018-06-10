<?php

require "db_conn.php";
if(isset($_GET['phone'])){
	$sql = "update  company set phone='{$_GET['phone']}' where id={$_GET['all_id']};";
	print_r($sql);
	$arr=get_db_arr($sql);
}
else{
$sql = "SELECT * FROM company where id=".$_GET['all_id'].";";
$arr=get_db_arr($sql);
echo "<center><table border=1>";
foreach($arr as $row) {
foreach($row as $k=>$d){
echo "<tr>";        
echo "<td>".$k."</td>"."<td>".$d."</td>";
echo "</tr>";
}
}
echo "</table></center>";
}

?>
