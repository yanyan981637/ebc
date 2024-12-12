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
    'refresh_token'=>'1000.b90e9f57ef1b3faf62a475fc3d2cc64b.b1a124a94b3ba9a655b9789141221762',
    'redirect_uri'=>'',
    'client_id'=>'1000.D10R9STXEK86WUBAA3WQKQHG386G2Z',
    'grant_type'=>'refresh_token',
    'client_secret'=>'cb9a671b0aebccd7093c64397590f54329a4ba4e0d'
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
$listkey="3za212eae4c1d60dd8157259c5a142bff340bf2eba9f48d1b29455bab8e40f7607";

$url="https://campaigns.zoho.com/api/v1.1/json/listunsubscribe?resfmt=JSON&listkey=".$listkey."&contactinfo=%7BContact+Email%3A%22".$mail."%22%7D";
$headers[]  =  "application/x-www-form-urlencoded"; 
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
    echo "delete";
    exit();
}
?>