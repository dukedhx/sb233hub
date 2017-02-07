<?php
$ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, 'http://ifconfig.co/json'); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$decoded=json_decode(curl_exec($ch));
curl_close($ch);
echo $decoded->{'ip'}
?>