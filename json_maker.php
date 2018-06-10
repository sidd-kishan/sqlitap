<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mind_meth";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM q_log where reduced_flag=1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	$json['description']=$row['file'].'_'.$row['q_hash'].'_'.$row['rem_q_hash'].'_'.$row['app_line'];
	$json['examples'][]=array('string'=>$row['query'],'match'=>array(json_decode($row['window'])));
    }
} else {
    echo "0 results";
}
echo json_encode($json, JSON_PRETTY_PRINT);die;
$conn->close();
?>
