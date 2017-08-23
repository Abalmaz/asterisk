<?php
$host = "";
$user = "";
$pass = "";
$dbname = "";


$mysqli = new mysqli($host, $user, $pass, $dbname);
$mysqli->set_charset("utf8");

if(mysqli_connect_errno()){
    echo mysqli_connect_error();
}

$query="SELECT DISTINCT id, phone FROM secret_phone where phone like '79%' and timezone is null;";
$phone=$mysqli->query($query);

 while ($tel = mysqli_fetch_array($phone)) {

     $query2 = "SELECT code_country FROM code_city";
     $city = $mysqli->query($query2);

     while ($dest = mysqli_fetch_array($city)) {
                   for ($i = strlen($tel['phone']); $i > 0; $i--) {
                     if (substr($tel['phone'], 0, $i) == $dest['code_country']) {
                         $country = $dest['code_country'];
                         $code_city = substr($tel ['phone'], strlen($country), 3);
                         $code = strlen($country) + 3;
                         $def = substr($tel['phone'], $code);
                         $res = "select * from code_city where code_country='$country' and code_oper = '$code_city' and  '$def' between deffrom and defto";
                         $res2 =$mysqli->query($res);


                         while ($result = mysqli_fetch_array($res2)) {
                             $timezone = $result['timezone'];
                             $sql="update secret_phone set timezone ='$timezone' where id=$tel[id]";
                             $res =$mysqli->query($sql);
                             break 3;
                         }

                     }
                 }

     }
 }
