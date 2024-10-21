<?php

#(C)opyright:
#Author: Piermarcello Piazza
#Filename:ipportscanner.php ver 2.2
#Year 2024

$open="";
$timeout = 1;

$ports=array();

$host = $argv[1];$response="Results Scanning…".$host.PHP_EOL;
$ports = explode(',',$argv[2]);

foreach ($ports as $port)

{

$time_start = microtime(true);
$connection = @fsockopen("tcp://".$host, intval($port), $errno, $errstr, $timeout);

if (is_resource($connection))

{

$status=socket_get_status($connection);if(!$status['timed_out']) $open="listening";else  $open="filtered";

$time_end=microtime(true);$ttl_=$time_end-$time_start;
$serv_=getservbyport($port, 'tcp');


if($serv_!=' ')
{
  $response= ' ' .' tcp  port '. $port . ' is '.$open.' with service  ' . $serv_ .' and time to live seconds '.$ttl_.PHP_EOL ; 
}
else $response= ' ' .' tcp port '. $port . ' is '. $open.' with service N/A ' .' and time to live seconds '.$ttl_.PHP_EOL ;

 echo $response;
    fclose($connection);
}

else

{
$connection1 = @fsockopen("udp://".$host, intval($port), $errno, $errstr, $timeout);
if (is_resource($connection1))
{ 
$status1=socket_get_status($connection1);if(!$status1['timed_out']) $open="listening";else  $open="filtered";
$time_start1 = microtime(true);

{

$serv=getservbyport($port, 'udp');

$time_end1=microtime(true);$ttl1_=$time_end1-$time_start1;
if($serv!='')
{
$response= ' ' .' udp port '. $port . ' is '.$open.' with service ' . $serv .' and time to live seconds '.$ttl1_.PHP_EOL ;

}
else $response= ' ' . ' udp port '. $port . ' is '.$open.' with service N/A ' .' and time to live seconds '.$ttl1_.PHP_EOL ;

echo $response;



    fclose($connection1);
}

}
}
}

?>
