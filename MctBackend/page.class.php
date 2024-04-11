<?php
if(isset($_GET['page'])!=''){
@$page = intval($_GET['page']);
}else{
@$page = "";
}

if(!function_exists('pageft')){
function pageft($totle,$displaypg=20,$shownum=0,$showtext=0,$showselect=0,$showlvtao=7,$url=''){
global $page,$firstcount,$pagenav,$_SERVER;
$GLOBALS["displaypg"]=$displaypg;

if(!$page) $page=1;
if(!$url){ $url=$_SERVER["REQUEST_URI"];}

//URL分析：
$parse_url=parse_url($url);
if(isset($parse_url["query"])){
$url_query=$parse_url["query"];
}else{
$url_query="";
}
if($url_query){

$url_query=str_replace("(^|&)page=$page","",$url_query);
$url=str_replace($parse_url["query"],$url_query,$url);

if($url_query) $url.="&page"; else $url.="page";
}else {
$url.="?page";
}

$lastpg=$totle;
$page=min($lastpg,$page);
$prepg=$page-1;
$nextpg=($page==$lastpg ? 0 : $page+1);
$firstcount=($page-1)*$displaypg;
if($showtext==1){
$pagenav="<span class='disabled'>".($totle?($firstcount+1):0)."-".min($firstcount+$displaypg,$totle)."/$totle Records</span><span class='disabled'>$page/$lastpg 頁</span>";
}else{
$pagenav=""; 
}

if($lastpg<=1) return false;

if($prepg) $pagenav.="<a href='$url=1'>First Page</a>"; else $pagenav.='<span class="disabled">First Page</span>';
if($prepg) $pagenav.="<a href='$url=$prepg'>Previous Page</a>"; else $pagenav.='<span class="disabled">Previous Page</span>';
if ($shownum==1){
$o=$showlvtao;
$u=ceil($o/2);
$f=$page-$u;
if($f<0){$f=0;}
$n=$lastpg;
if($n<1){$n=1;}
if($page==1){
$pagenav.='<span class="current">1</span>';
}else{
$pagenav.="<a href='$url=1'>1</a>";
}

for($i=1;$i<=$o;$i++){
if($n<=1){break;}
$c=$f+$i;
if($i==1 && $c>2){
$pagenav.='...';
}
if($c==1){continue;}
if($c==$n){break;}
if($c==$page){
$pagenav.='<span class="current">'.$page.'</span>';
}else{
$pagenav.="<a href='$url=$c'>$c</a>";
}
if($i==$o && $c<$n-1){
$pagenav.='...';
}
if($i>$n){break;}
}
if($page==$n && $n!=1){
$pagenav.='<span class="current">'.$n.'</span>';
}else{
$pagenav.="<a href='$url=$n'>$n</a>";
}
}

if($nextpg) $pagenav.="<a href='$url=$nextpg'>Next Page</a>"; else $pagenav.='<span class="disabled">Next Page</span>';
if($nextpg) $pagenav.="<a href='$url=$lastpg'>Last Page</a>"; else $pagenav.='<span class="disabled">Last Page</span>';
if ($showselect==1){
$pagenav.="跳至<select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n";
for($i=1;$i<=$lastpg;$i++){
if($i==$page) $pagenav.="<option value='$i' selected>$i</option>\n";
else $pagenav.="<option value='$i'>$i</option>\n";
}
$pagenav.="</select>Page";
}
}
}
?>