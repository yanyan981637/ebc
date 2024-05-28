<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

error_reporting(0);

if(strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
header('Location: /404.html');
exit;
}

$mail="";

$mail01=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', $_POST['mail']);
$mail=filter_var($mail01);

$post=[
    'refresh_token'=>'1000.6deae81624b7300d9021d5d3f7f12f01.09e8b43ace670b4691bce42aa498f13b',
    'redirect_uri'=>'',
    'client_id'=>'1000.TBTIYFLTQ50HHLCNB5M75SY7ETKLYG',
    'grant_type'=>'refresh_token',
    'client_secret'=>'90994963b99b7707c212c7d4033a6ce4b84973cfba'
];

//'refresh_token'=>'1000.b15ea7a31a209ff6dc0492cada2a01c3.eeb273fdd1a72b0515d0a9cd27a454ef',


$url="https://accounts.zoho.com/oauth/v2/token";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
$result2 = curl_exec($ch);
$result2 = json_decode($result2, true);
$accessToken=$result2['access_token'];


$token=$accessToken;
$listkey="3z32bfcb27da1e6fb87fb3c01da2a3122759c16181c3b9b6ac4d0e152cfb03d30e";


$url="https://campaigns.zoho.com/api/v1.1/addlistsubscribersinbulk?resfmt=JSON&emailids=".$mail."&listkey=".$listkey;

$headers[]  =  "Content-Type: application/json";
$headers[]  =  "Authorization:Zoho-oauthtoken ".$token;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result2 = curl_exec($ch);
$result2 = json_decode($result2, true);
$status=$result2['status'];
if($status=="success"){
    echo "refresh";
    exit();
}

?>