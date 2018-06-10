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
$x=1;
$flag=trim(file_get_contents("./flag"));
if($flag=="1"){
log_sql($back_trace['line'],$back_trace['file'],$back_trace['sql']);
}
else{
$x=search_regexp($sql);
}
if(!$x)die("not matched");
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
}
$conn->close();
}
function search_regexp($query = '') {
$db=db_conn();
$conn = new mysqli($db['server_name'], $db['u_name'], $db['passwd'], $db['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$win=find_window($query);
$win=json_decode($win);
$query_1=str_split($query,$win->start);
$query_1_md5 = md5($query_1[0]);

$sql = "select reg_exp,window from q_log where rem_q_hash='" . $query_1_md5."'";
$result = $conn->query($sql);
$res=array();
while($row = $result->fetch_assoc()) {
$res[]=$row;
}
if(!empty($res[0]['reg_exp'])){
if (!preg_match("/".$res[0]['reg_exp']."/",trim($query_1[1]))) {
  return 0; 
}
}
return 1;
$conn->close();
}

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
?>
