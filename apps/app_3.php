<?php
require "db_conn.php";
$sql = "SELECT address FROM company where id=".$_GET['address_id'].";";
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
?>
