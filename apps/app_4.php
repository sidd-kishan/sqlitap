<?php
require "db_conn.php";
if($_REQUEST['mode']=='address'){
$sql = "SELECT address FROM company where id=".$_GET['id'].";";
}
if($_REQUEST['mode']=='email'){
$sql = "SELECT email FROM company where id=".$_GET['id'].";";
}
if($_REQUEST['mode']=='phone'){
$sql = "SELECT phone FROM company where id=".$_GET['id'].";";
}

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
