#!/usr/bin/php 
<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$host = "";
$user = "";
$pass = "";
$dbname = "";

$mysqli = new mysqli($host, $user, $pass, $dbname);

$mysqli->set_charset("utf8");
set_time_limit(10000);

if (mysqli_connect_error()) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

$query="SELECT id, dst, dcontext, billsec FROM cdr where disposition='ANSWERED'
and lastapp='Dial'  and dcontext not in ('callobok_inc','zadarma_inc', 'local','autoanswer', 'plan', 'test', 'scaner')
and  YEAR(calldate) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(calldate) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
AND call_rate is null";
$cdr=$mysqli->query($query);
while($rows=mysqli_fetch_array($cdr))
 {
$query2="SELECT provider, code, rate_usd FROM tarif ";
$tariff=$mysqli->query($query2);
  while($rate=mysqli_fetch_array($tariff)){
  for ($i=strlen($rows['dst']);$i>0;$i--)
		{
			if (substr($rows['dst'], 0,$i) == $rate['code'] )
			{
				if (stristr($rows['dcontext'],$rate['provider'])==TRUE)
				{
					//if (stristr($rows['dcontext'],'callobok')){
					//	$call_rate = ceil(($rows['billsec']+1) / 60) * $rate['rate_usd'];
					//}
                  	if (stristr($rows['dcontext'],'utel')){
						$call_rate = $rows['billsec']*$rate['rate_usd'];
					}
					else {
						$call_rate = ceil($rows['billsec']/ 60) * $rate['rate_usd'];
					}
					
                  	$sql="update cdr set call_rate=$call_rate where id=$rows[id]";
                     $res =$mysqli->query($sql) or trigger_error(mysql_error()." in ".$sql);

					break 2;
				}

			}


		}
  }
}

?>