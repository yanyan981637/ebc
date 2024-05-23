<?php
//為了避免重複包含檔而造成錯誤，加了判斷函數是否存在的條件：
if(isset($_GET['page'])!=''){
@$page = intval($_GET['page']);
}else{
@$page = "";
}

if(isset($_GET['s_search'])!=''){
@$s_search = trim($_GET['s_search']);
}else{
@$s_search ="";
}

if(!function_exists('pageft')){
//定義函數pageft(),三個參數的含義為：
//$totle：資訊總數；
//$displaypg：每頁顯示資訊數，這裏設置為默認是20；
//$url：分頁導航中的鏈結，除了加入不同的查詢資訊“page”外的部分都與這個URL相同。
//　　　預設值本該設為本頁URL（即$_SERVER["REQUEST_URI"]），但設置預設值的右邊只能為常量，所以該預設值設為空字串，在函數內部再設置為本頁URL。
function pageft($totle,$displaypg=20,$shownum=0,$showtext=0,$showselect=0,$showlvtao=7,$url=''){

//定義幾個總體變數：
//$page：當前頁碼；
//$firstcount：（資料庫）查詢的起始項；
//$pagenav：頁面導航條代碼，函數內部並沒有將它輸出；
//$_SERVER：讀取本頁URL“$_SERVER["REQUEST_URI"]”所必須。
global $page,$firstcount,$pagenav,$_SERVER,$s_search,$url_query;

//為使函數外部可以訪問這裏的“$displaypg”，將它也設為總體變數。注意一個變數重新定義為總體變數後，原值被覆蓋，所以這裏給它重新賦值。
$GLOBALS["displaypg"]=$displaypg;

if(!$page) $page=1;
if(!$s_search) $s_search=1;

//如果$url使用默認，即空值，則賦值為本頁URL：
if(!$url){ $url=$_SERVER["REQUEST_URI"];}

//URL分析：
$parse_url=parse_url($url);
if(isset($parse_url["query"])!=''){
$url_query=$parse_url["query"]; //單獨取出URL的查詢字串
}else{
$url_query="";
}
if($url_query){
//因為URL中可能包含了頁碼資訊，我們要把它去掉，以便加入新的頁碼資訊。
//這裏用到了正則運算式，請參考“PHP中的正規運算式”
$url_query=preg_replace("/(^|&)page=$page/i","",$url_query);

//將處理後的URL的查詢字串替換原來的URL的查詢字串：
$url=str_replace($parse_url["query"],$url_query,$url);

//在URL後加page查詢資訊，但待賦值：
if($url_query) $url.="&page"; else $url.="page";
}else {
$url.="?page";
}

//頁碼計算：
//$lastpg=ceil($totle/$displaypg); //最後頁，也是總頁數
$lastpg=$totle;
$page=min($lastpg,$page);
$prepg=$page-1; //上一頁
$nextpg=($page==$lastpg ? 0 : $page+1); //下一頁
$firstcount=($page-1)*$displaypg;

//開始分頁導航條代碼：
if ($showtext==1){
$pagenav="<span class='disabled'>".($totle?($firstcount+1):0)."-".min($firstcount+$displaypg,$totle)."/$totle Records</span><span class='disabled'>$page/$lastpg 頁</span>";
}else{
$pagenav=""; 
}
//如果只有一頁則跳出函數：
if($lastpg<=1) return false;

if($prepg) $pagenav.="<a href='$url=1'>First Page</a>"; else $pagenav.='<span class="disabled">First Page</span>';
if($prepg) $pagenav.="<a href='$url=$prepg'>Previous Page</a>"; else $pagenav.='<span class="disabled">Previous Page</span>';
if ($shownum==1){
$o=$showlvtao;//中間頁碼表總長度，為奇數
$u=ceil($o/2);//根據$o計算單側頁碼寬度$u
$f=$page-$u;//根據當前頁$currentPage和單側寬度$u計算出第一頁的起始數字
//str_replace('{p}',,$fn)//替換格式
if($f<0){$f=0;}//當第一頁小於0時，賦值為0
$n=$lastpg;//總頁數,20頁
if($n<1){$n=1;}//當總數小於1時，賦值為1
if($page==1){
$pagenav.='<span class="current">1</span>';
}else{
$pagenav.="<a href='$url=1'>1</a>";
}
///////////////////////////////////////
for($i=1;$i<=$o;$i++){
if($n<=1){break;}//當總頁數為1時
$c=$f+$i;//從第$c開始累加計算
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
if($i>$n){break;}//當總頁數小於頁碼表長度時 
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
//下拉跳轉列表，迴圈列出所有頁碼：
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