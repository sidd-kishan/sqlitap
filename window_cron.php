<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mind_meth";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM q_log where reduced_flag=0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	$window=find_window($row['query']);
	//$win_inv=find_inv_window(json_decode($window));
	$window_arr=json_decode($window);
	$rem_q_hash=str_split($row['query'],$window_arr->start);
	$sql = "update q_log set window='$window',reduced_flag=1,rem_q='{$rem_q_hash[0]}',rem_q_hash='".md5($rem_q_hash[0])."',q_hash='".md5($sql)."' where id={$row['id']}";
	if ($conn->query($sql) === TRUE) {
	    //echo "New window created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
    }
} else {
    echo "0 results";
}
$conn->close();


function find_window($sql){
$frags=explode(' ',$sql);
$start=0;
$end=0;
if(strcasecmp($frags[0],'select')==0){
$start=strpos($sql,'where')+strlen('where');
$end=strlen($sql);
return json_encode(array('start'=>$start,'end'=>$end));
}
}
function find_inv_window($window){
$start=$window->start;
$end=0;
return json_encode(array('start'=>$start,'end'=>$end));
}

?>
