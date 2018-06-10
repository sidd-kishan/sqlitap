<?php

$flip=file_get_contents("./flag");
if($flip=="1"){
$flip="0";
}
else{
$flip="1";
}
echo $flip;
file_put_contents("./flag",$flip);
