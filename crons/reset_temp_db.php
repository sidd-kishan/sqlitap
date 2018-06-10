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


get_db_arr("delete from q_log where id>1");
