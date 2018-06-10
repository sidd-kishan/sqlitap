<?php
function db_conn(){
$servername = "localhost";
$username = "root";
$password = "siddharth12";
$dbname = "p_i";
return array('server_name'=>$servername,'u_name'=>$username,'passwd'=>$password,'dbname'=>$dbname);
}
function get_db_arr($sql){
$back_trace=array('file'=>md5(debug_backtrace()[0]['file']),'line'=>debug_backtrace()[0]['line'],'sql'=>debug_backtrace()[0]['args'][0]);
log_sql($back_trace['line'],$back_trace['file'],$back_trace['sql']);
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

function log_sql($line,$file,$sql){
$db=db_conn();
$conn = new mysqli($db['server_name'], $db['u_name'], $db['passwd'], $db['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO q_log set app_line='$line',file='$file', query='$sql', q_hash='".md5($sql)."'";
if ($conn->query($sql) === TRUE) {
    //echo "q logged";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}
?>
