<?php
$servername = "localhost";
$username = "root";
$password = "siddharth12";
$dbname = "p_i";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM q_log where reduced_flag=1";
$name_of_file_to_dump_into="";
$rem_qhash="";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	$json['description']=$row['file'].'_'.$row['q_hash'].'_'.$row['rem_q_hash'].'_'.$row['app_line'];
	$name_of_file_to_dump_into=$json['description'];
	$rem_qhash=$row['rem_q_hash'];
	$json['examples'][]=array('string'=>$row['query'],'match'=>array(json_decode($row['window'])));
    }
} else {
    echo "0 results";
}
$file = '../data/'.$name_of_file_to_dump_into.".json";
$current = json_encode($json);
file_put_contents($file, $current);
exec("chmod 777 ".$file);

$cmd="../libs/regexturtle.sh -t 4 -g 1 -d '".$file."'";
$cmd="java -jar '../libs/ConsoleRegexTurtle.jar' -t 4 -g 1 -d '".$file."'";
//while (@ ob_end_flush()); // end all output buffers if any

//$proc = popen($cmd, 'r');
//while (!feof($proc))
//{
//    echo fread($proc, 4096);
//    @ flush();
//}
$regexp= shell_exec($cmd);
$regexp=str_split($regexp,strpos($regexp,"Best"));
$data="";
foreach($regexp as $k=>$d){
if($k>count($regexp)-5)
$data.=$d;
}
$sub=str_split($data,strpos($data,"Best on learning"));
$sub=str_split($sub[1],strpos($sub[1],"******Stats on training******"));
$sub=str_split($sub[0],strpos($sub[0],"Best on learning (JS):"));
$sub=str_split($sub[0],strpos($sub[0],":"));
$reg_exp_final=(trim(ltrim($sub[1],":")));
$reg_exp_final=addslashes($reg_exp_final);
$sql = "update q_log set reg_exp='$reg_exp_final' where rem_q_hash='$rem_qhash'";
if ($conn->query($sql) === TRUE) {
    //echo "New window created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
exec("chmod 777 -R .");
?>

