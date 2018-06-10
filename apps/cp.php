<?php

function db_conn(){
$servername = "localhost";
$username = "root";
$password = "siddharth12";
$dbname = "p_i";
return array('server_name'=>$servername,'u_name'=>$username,'passwd'=>$password,'dbname'=>$dbname);
}


function get_db_arr($sql){
$db=db_conn();
$conn = new mysqli($db['server_name'], $db['u_name'], $db['passwd'], $db['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query($sql);
$res=array();
while($row = $result->fetch_assoc()) {
$res[]=$row;
}
$conn->close();
return $res;
}

$logs=get_db_arr("select * from q_log");

echo "<table><tr>";
foreach($logs[0] as $k=>$v){
echo "<td>$k</td>";
}
echo "</tr>";

foreach($logs as $v){
	echo "<tr>";
	foreach($v as $vv){
		echo "<td>$vv</td>";
	}
	echo "</tr>";
}

echo "</table>";

?>
<script>
function toggle_logging_steps(){
	var x= new XMLHttpRequest();
	x.onreadystatechange=function(){
		if(this.readyState==4 && this.status==200){
			if(this.responseText=="1")
				document.getElementById("flag").value="recording steps:started";
			else
				document.getElementById("flag").value="recording steps:stopped";
		}
	}
	x.open("GET","flag_togg.php",true);
	x.send();
}
function start_finding_window(){
	var x= new XMLHttpRequest();
	x.onreadystatechange=function(){
		if(this.readyState==4 && this.status==200){
			document.getElementById("training").value="window found";
			start_finding_regex();
		}
	}
	x.open("GET","../crons/window_cron.php",true);
	x.send();
}
function start_finding_regex(){
	var x= new XMLHttpRequest();
	x.onreadystatechange=function(){
		if(this.readyState==4 && this.status==200){
			document.getElementById("training").value="training done";
		}
	}
	x.open("GET","../crons/finalizer.php",true);
	x.send();
}
function reset_temp_db(){
	var x= new XMLHttpRequest();
	x.onreadystatechange=function(){
		if(this.readyState==4 && (this.status==200||this.status==500)){
			document.getElementById("reset").value="reset done";
		}
	}
	x.open("GET","../crons/reset_temp_db.php",true);
	x.send();
}
</script>
<input type='button' id='flag' onclick='toggle_logging_steps()' value='<?php $x=file_get_contents('./flag');if(trim($x)=='1')echo "recording steps:started";else echo "recording steps:stopped"; ?>'>
<input type='button' id='training' onclick='start_finding_window()' value='start training'>
<input type='button' id='reset' onclick='reset_temp_db()' value='reset temp db'>
