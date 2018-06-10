<?php
require "db_conn.php";
$sql = "SELECT * FROM company where id=".$_GET['id'].";";
//$arr=get_db_arr($sql);
echo "<table>";
foreach($arr as $row) {
echo "<tr>";        
foreach($row as $k=>$d){
echo "<td>".$k."</td>"."<td>".$d."</td>";
}
echo "</tr>";
}
echo "</table>";
?>
