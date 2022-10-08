<?php

$response="Results Scanning...".PHP_EOL;
//timeout ms
$timeout = 30;

//Instance of array of port in variable $ports
$ports=array();
if((count($argv))!=3) echo "Format : ipportscan host ports_separated_by_commas".PHP_EOL;
$host = $argv[1];$ip = gethostbyname($host);
if(!filter_var($ip, FILTER_VALIDATE_IP)) {echo $ip." is a non format ip address, try to insert name of host".PHP_EOL;return;}

//First argument of called file
$ports = explode(',',$argv[2]);//second argument of called file
$len=count($ports);
//code scanning ports
for ($i=0; $i<$len; $i++)

{
  
$time_start = microtime(true);
//open a tcp connection with host on port 
$connection=@fsockopen("tcp://".$host, $ports[$i], $errno, $errstr, $timeout);
if (is_resource($connection))
{ 

    
    $status_=socket_get_status($connection); 
    if($status_){$time_end=microtime(true);$ttl_=$time_end-$time_start;}
    $serv_=getservbyport($ports[$i], 'tcp');//service of tcp protocol of associated port
 
    if($serv_!='')
    {
      $response.= ' ' .' tcp  port '. $ports[$i] . ' is open with service  ' . $serv_ .' and time to live seconds '.$ttl_.PHP_EOL ; 

    }
     else $response.= ' '  .' tcp  port '. $ports[$i] . ' is open with service N/A '  .' and time to live seconds '.$ttl_.PHP_EOL ;
     
      //fclose($connection);
       
 
   
 fclose($connection);


}else {
$time_start1 = microtime(true);
//open a udp connection to host on ports
 $connection1 = @fsockopen("udp://".$host, $ports[$i], $errno, $errstr, $timeout);

 
  
  if (is_resource($connection1))
  
  {   
    $serv=getservbyport($ports[$i], 'udp');//service of udp associated port
 

 $status=socket_get_status($connection1); 
    if(!$status['timed_out']){echo $status['timed_out'];$time_end1=microtime(true);$ttl1_=$time_end1-$time_start1;}
    if($serv!='')
    {
        $response.=  ' ' .' udp  port '. $ports[$i] . ' is open with service  ' . $serv .' and time to live seconds '.$ttl1_.PHP_EOL ;

}
      else $response.= ' ' . ' udp  port '. $ports[$i] . ' is open with service N/A ' .' and time to live seconds'.$ttl1_.PHP_EOL ;
 fclose($connection1);

}
}
   
}   

echo $response;









?>