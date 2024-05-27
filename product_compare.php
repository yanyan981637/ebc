<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
header('Content-Type: text/html; charset=utf-8');
header("Cache-control: private");

error_reporting(0);

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
echo "<script language='javascript'>self.location='/404.htm'</script>";
exit;
}

//$a=explode("@" , $_SERVER["HTTP_REFERER"]);

require "./config.php";

function dowith_sql($str){
   $str = str_replace("and","",$str);
   $str = str_replace("execute","",$str);
   $str = str_replace("update","",$str);
   $str = str_replace("count","",$str);
   $str = str_replace("chr","",$str);
   $str = str_replace("mid","",$str);
   $str = str_replace("master","",$str);
   $str = str_replace("truncate","",$str);
   $str = str_replace("char","",$str);
   $str = str_replace("declare","",$str);
   $str = str_replace("select","",$str);
   $str = str_replace("create","",$str);
   $str = str_replace("delete","",$str);
   $str = str_replace("insert","",$str);
   $str = str_replace("'","",$str);
   $str = str_replace('"',"",$str);
   $str = str_replace(".","",$str);
   $str = str_replace("or","",$str);
   $str = str_replace("=","",$str);
   $str = str_replace("?","",$str);
   $str = str_replace("%","",$str);
   $str = str_replace("0x02BC","",$str);
   $str = str_replace("<script","",$str);
   $str = str_replace("script>","",$str);
   $str = str_replace("(","",$str);
   $str = str_replace(")","",$str);
   return $str;
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

/*if($_COOKIE["RFQsku"]!=""){
  $arr_SKU=$_COOKIE["RFQsku"];
  $arr_SKU=dowith_sql($arr_SKU);
  $arr_SKU=filter_var($arr_SKU);
}*/

if(isset($_REQUEST['PLang'])!=''){
  $PLang_si=dowith_sql(trim($_REQUEST['PLang']));
  $PLang_si=str_replace(".php","",$PLang_si);

  if($PLang_si=="en-US" || $PLang_si==""){
    $PLang_si01="EN";
    $PLang_si="en-US";
  }else if($PLang_si=="ja-JP"){
    $PLang_si01="JP";
    $PLang_si="ja-JP";

  }else if($PLang_si=="zh-CN"){
    $PLang_si01="CN";
    $PLang_si="zh-CN";
  }else if($PLang_si=="zh-TW"){
    $PLang_si01="ZH";
    $PLang_si="zh-TW";
  }else{
    $PLang_si01="EN";
    $PLang_si="en-US";
  }
}else{
  $PLang_si01="EN";
  $PLang_si="en-US";
}

$sku=dowith_sql($_GET["sku"]);
$sku=htmlspecialchars($sku);

$type=dowith_sql($_GET["type"]);
$type=htmlspecialchars($type);

//$sku="PH12SI PH11CMI";
//$type="109";

$a=explode(" ",$sku);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$num=count($a);

if($type == "107"){ //IndustrialPanelPC 46
  $prod_imgurl="./images/product/PanelPc/";
  $TypeName="IndustrialPanelPC";
}else if($type == "108"){ //EmbeddedSystem 47
  $prod_imgurl="./images/product/Embedded/";
  $TypeName="EmbeddedSystem";
}else if($type == "109"){ //IndustrialMotherboard 48
  $prod_imgurl="./images/product/IndustriaMB/";
  $TypeName="IndustrialMotherboard";
}else if($type == "110"){ //OCPserver 49
  $prod_imgurl="./images/product/OCPserver/";
  $TypeName="OCPserver";
}else if($type == "111"){ //OCPMezz 50
  $prod_imgurl="./images/product/OCPMezz/";
  $TypeName="OCPMezz";
}else if($type == "112"){ //JBODJBOF 51
  $prod_imgurl="./images/product/JBODJBOF/";
  $TypeName="JBODJBOF";
}else if($type == "113"){ //OCPRack 52
  $prod_imgurl="./images/product/OCPrack/";
  $TypeName="OCPRack";
}else if($type == "114"){ //POS 53
  $prod_imgurl="./images/product/POS/";
  $TypeName="POS";
}else if($type == "115"){ //5GEdgeComputing 54
  $prod_imgurl="./images/product/5G/";
  $TypeName="5GEdgeComputing";
}

foreach ($a as $key => $value) {
  if($value!=""){
    $str="SELECT Product_SKU_Auto_ID FROM product_skus WHERE SKU='".$value."'";
    $cmd=mysqli_query($link_db, $str);
    $data = mysqli_fetch_row($cmd);
    $str_value="SELECT b.SPECOptionID, a.SPECTypeID, b.SPECOptionValue FROM specvalues a INNER JOIN specoptions b ON a.SPECTypeID=b.SPECTypeID WHERE a.Product_SKU_Auto_ID='".$data[0]."'";
    $cmd_value = mysqli_query($link_db,$str_value);
    while($data_value = mysqli_fetch_row($cmd_value)) {
      $arr_value[$data_value[0]]=$data_value[2];
    }
  }
}

/*$str_value="SELECT ID, TYPE_ID, CATE_ID, UNDER_TYPEID, VALUE FROM new_spec_value WHERE TYPE_ID='".$type."' ORDER BY Sequence ASC";
$cmd_value = mysqli_query($link_db,$str_value);
while($data_value = mysqli_fetch_row($cmd_value)) {
  $arr_value[$data_value[0]]=$data_value[4];
}*/

$url=$_SERVER['HTTP_REFERER'];

/*$str_num = "SELECT * FROM new_spec_under_type WHERE Compare_button=1 AND TYPE_ID='".$type."'";
$cmd_num = mysqli_query($link_db,$str_num);
$data_num = mysqli_num_rows($cmd_num);*/
// $data_num="";
$data_num=0;
$str_cate = "SELECT SPECCategories, SPECType FROM producttypes WHERE ProductTypeID='".$type."'";
$cmd_cate = mysqli_query($link_db,$str_cate);
$data_cate = mysqli_fetch_row($cmd_cate);
$cateID=explode(",", $data_cate[0]);
$prSPECType=$data_cate[1];
$tt = str_replace(',',"','",$prSPECType);
foreach ($cateID as $key => $value) {
  if($value!=""){
    $str_cate1 = "SELECT SPECCategoryID, SPECCategoryName FROM speccategroies WHERE SPECCategoryID='".$value."'"; //categories sort to 後台Product Types調整
    $cmd_cate1 = mysqli_query($link_db,$str_cate1);
    while ($data_cate1 = mysqli_fetch_row($cmd_cate1)) {

      $cateID1=$data_cate1[0];
      $str_UT="SELECT count(SPECTypeID) FROM spectypes WHERE SPECCategoryID='".$cateID1."' AND SPECTypeID IN ('".$tt."')ORDER BY SPECTypeSort ASC";
      //echo $str_UT."<br>";
      $cmd_UT = mysqli_query($link_db,$str_UT);
      $data_UT = mysqli_fetch_row($cmd_UT);
      $data_num += $data_UT[0];

    }

  }
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="/images/ico/favicon.ico">
  <script src="js1/jquery.js"></script>
	<!-- Stylesheets
	============================================= -->
  <link rel="stylesheet" href="css1/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css1/style.css" type="text/css" />
  <link rel="stylesheet" href="css1/swiper.css" type="text/css" />
  <link rel="stylesheet" href="css1/dark.css" type="text/css" />
  <link rel="stylesheet" href="css1/font-icons.css" type="text/css" />
  <link rel="stylesheet" href="css1/animate.css" type="text/css" />
  <link rel="stylesheet" href="css1/magnific-popup.css" type="text/css" />
  <link rel="stylesheet" href="css1/custom.css" type="text/css" />
  <link rel="stylesheet" href="css1/quote.css" type="text/css" />

  <!-- compare css ============================================ -->
  <link rel="stylesheet" href="/css1/compare/tabella.css">
  <!-- Document Title
	============================================= -->
	<title>Comparing products | MiTAC Computing Technology</title>

  <?php
  //************ google analytics ************
  if($s_cookie!=2){
    include_once("analyticstracking.php");
  }
  ?>

  <style type="text/css">
  .pro-remove { margin:4px;
    padding: 2px;
    position:absolute;
    right:5px;
  }

  .pro-remove:hover  {margin:4px; background-color:#434343; color:#fff !important; border-radius: 30px; padding:2px;
    height: 30px;
    width: 30px;
  }


  #rowvalue {
    text-align:left;
  }

  .fleft {float:left}
  .fright {float:right}


  </style>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">
  <?php
  //include("RFQ_content.php");
  ?>
	<?php
  include("top1.htm");
  ?>

		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1 class="fleft">Compare Products - <?=$num;?> <?=$TypeName;?></h1>

				<div class="fright">
          <form id="excel" name="excel" method="post" action="productCompare">
            <input id="SKU" name="SKU" type="hidden" value="<?=$sku?>" >
            <input id="TYPE" name="TYPE" type="hidden" value="<?=$type?>" >
            <a href="javascript:document.excel.submit();" class="button button-mini button-border button-circle button-dark"/>Export Comparison</a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?=$url?>" class="button button-mini button-border button-circle button-dark" /><i class="icon-arrow-left2"></i>Back</a>
          </form>
        </div>
			</div>

		</section><!-- #page-title  -->

		<input id="num" type="hidden" value="<?=$data_num?>">
		<!-- Content
		============================================= -->




		<div class="container-fluid" style="">


		<div id="tabella" class="tabella-ctr"></div>


		</div>
				<div class="clear bottommargin"></div>




		<!-- #content end -->

	<!-- Footer ============================================= -->
  <?php
  include("foot1.htm");
  ?>
  <!-- #footer end -->


<!-- External JavaScripts
============================================= -->
<script src="js1/plugins.min.js"></script>

<!-- Footer Scripts
============================================= -->
<script src="js1/functions.js"></script>

<!-- compare Scripts
============================================= -->
<script src="/css1/compare/tabella.js"></script>

<script src="/js1/top.js"></script>

<script type="text/javascript">
(function() {
  var tabellaCtr = document.getElementById('tabella');
  const animals = ['pigs', 'goats', 'sheep'];
  var data = {};

  data.tableHeader = [
  <?php
  $pID=array();
  foreach ($a as $key => $value) {
    if($value!=""){
      $str="SELECT Product_SContents_Auto_ID, ProductTypeID_SKU, SKU, MODELCODE, ProductFileCom FROM `contents_product_skus` WHERE `SKU`='".$value."' ORDER BY Product_SContents_Auto_ID DESC";
      $cmd=mysqli_query($link_db,$str);
      $data=mysqli_fetch_row($cmd);
      $pID[]=$data[0];
      $sku="'".$data[2]."'";
      //$img=explode(",", $data[4]);
          /*$str1="SELECT Quote, ProductTypeID FROM `product_skus` WHERE `SKU`='".$value."' ORDER BY Product_SKU_Auto_ID DESC";
          $cmd1=mysqli_query($link_db,$str1);
          $data1=mysqli_fetch_row($cmd1);
          $Quote=$data1[0];
          if($Quote=="1"){
            $QuoteButton="<a href=# class=button button-small button-border button-rounded onclick=AddRFQ(".$sku.",".$data1[1].")><i class=icon-plus1></i>Add to Quote</a>";
          }*/
          ?>
          [
          <?php
          echo '"<td style=text-align:center><a href='.$TypeName.'_'.$data[3].'_'.$data[2].'><img src='.$prod_imgurl.$data[4].'></a></td>",';
          echo '"<td style=text-align:center><a href='.$TypeName.'_'.$data[3].'_'.$data[2].'>'.$data[2].'('.$data[3].')</a></td>",';
          //echo '"('.$data[3].')",';
          //echo '"'.$QuoteButton.'"';
        }
        ?>
        ],
        <?php
      }
      ?>

      ];

      data.rows = [
      <?php
      //$str_cate = "SELECT ID, TYPE_ID, CATEGORY FROM new_spec_category WHERE TYPE_ID='".$type."' AND ID=any(SELECT DISTINCT CATE_ID FROM new_spec_under_type WHERE Compare_button=1) ORDER BY Sequence ASC";
      //$str_cate = "SELECT SPECCategories, SPECType FROM producttypes WHERE ProductTypeID='".$type."'";
      $str_cate="SELECT SKU_CategorySort, SKU_Type FROM product_skus WHERE SKU=".$sku;
      $cmd_cate = mysqli_query($link_db,$str_cate);
      $data_cate = mysqli_fetch_row($cmd_cate);
      $cateID=explode(",", $data_cate[0]);
      $pr_SPECType=$data_cate[1];
      foreach ($cateID as $key => $value) {
        if($value!=""){
        $str_cate1 = "SELECT SPECCategoryID, SPECCategoryName FROM speccategroies WHERE SPECCategoryID='".$value."'"; //categories sort to 後台Product Types調整
        $cmd_cate1 = mysqli_query($link_db,$str_cate1);
        while ($data_cate1 = mysqli_fetch_row($cmd_cate1)) {
          //$typeID=$data_cate[1];
          $cateID1=$value;
          ?>
          {
            rowHeader: '<h4><?php echo $data_cate1[1];?></h4>',

            rowDesc:
            [
            <?php
            $tmp_utpyeID=array();
            $str_UT="SELECT SPECTypeID, SPECCategoryID, SPECTypeName, SPECTypeSort FROM spectypes WHERE SPECCategoryID='".$cateID1."' ORDER BY SPECTypeSort ASC";
            $cmd_UT = mysqli_query($link_db,$str_UT);
            while ($data_uType = mysqli_fetch_row($cmd_UT)) {
              if(preg_match("/{$data_uType[0]}/i", $pr_SPECType)) {
                $tmp_utpyeID[]=$data_uType[0];
                echo '"'.$data_uType[2].'",';
              }else{
                //echo("False");
              }

            }
            ?>
            ],

            rowVal:
            [
            <?php
            foreach ($tmp_utpyeID as $key => $uTypeID) {
              ?>
              [
              <?php
              foreach ($pID as $key1 => $value1) {
                $tmp_value="";
                //$str_value="SELECT ID, VALUE_ID FROM new_spec_table WHERE `Product_SKU_Auto_ID`='".$value."' AND TYPE_ID='".$typeID."' AND CATE_ID='".$cateID."' AND UNDER_TYPEID='".$uTypeID."'";
                $str_value="SELECT SPEC_Vaule_ID, SPECValue FROM specvalues WHERE Product_SKU_Auto_ID='".$value1."' AND SPECTypeID='".$uTypeID."'";
                $cmd_value = mysqli_query($link_db,$str_value);
                $data_value = mysqli_fetch_row($cmd_value);
                if($data_value[1]==""){
                  echo '"",';
                }else{
                  $remove=$uTypeID."|";
                  $tmp_vID=explode(",",$data_value[1]);
                  $num1=count($tmp_vID);
                  foreach ($tmp_vID as $key => $value) {
                        if (strpos($value, $remove) !== false) { // 判斷欄位有 typID+|+valuID
                        }else{
                          if($value!=""){
                            if($num1==2){
                              $tmp_value.=$arr_value[$value];
                            }else{

                              $tmp_value.=$arr_value[$value];
                              // $tmp_value.=" / ";
                            }
                          }

                        }
                      }
                      $tmp_value=str_replace(
                        array("<br />", "<br/>", "<br>"), // make sure that you have your version of <br> tag here
                        "\n",
                        $tmp_value
                      );
                      $tmp_value=htmlspecialchars($tmp_value);
                      $tmp_value=str_replace("\n","<br />",$tmp_value);
                      echo '"'.$tmp_value.'",';
                    }

                  }
                  ?>
                  ],
                  <?php
                }
                ?>
                ]

              },
              <?php
        } //while end
      }
    } // foreach end
    ?>



  ];
  var hotelarowVal = new Tabella(tabellaCtr, data);
  })();

    function reomve_compare(i){
      dtablerow(i);
      var num=<?php echo json_encode($num);?>;
      var type=<?php echo $type;?>;

      //var tmp=<?php echo json_encode($a);?>;
      var tmpsku=Cookies.get("tmpsku");

      if(tmpsku==undefined){
        var tmpsku=Cookies.get("sku");
      }else{
        var tmpsku=Cookies.get("tmpsku");
      }
      tmpsku = tmpsku.split(",");

      //delete tmp[i];
      tmpsku[i]="NULL";

      var sku="";
      var j=0;
      for (var i = 0; i < tmpsku.length; i++) {
        if(tmpsku[i]!="NULL"){
          j++;
          if(sku==""){
            sku+=tmpsku[i];
          }else{
            sku+=",";
            sku+=tmpsku[i];
          }

        }
      };
      var nums =j;
      if(nums=="0"){
        Cookies.remove("type");
      }

      var getUrlString = location.href;
      var lang="";
      if(getUrlString.indexOf('en-US')>0 || getUrlString.indexOf('EN')>0){
        lang="en-US";
      }else if(getUrlString.indexOf('ja-JP')>0 || getUrlString.indexOf('JP')>0){
        lang="ja-JP";
      }else if(getUrlString.indexOf('zh-CN')>0 || getUrlString.indexOf('CN')>0){
        lang="zh-CN";
      }else if(getUrlString.indexOf('zh-TW')>0 || getUrlString.indexOf('TW')>0){
        lang="zh-TW";
      }else{
        lang="en-US";
      }

      var url = window.location.href;
      var valiable = url.split("@")[0];
      valiable +="@"+sku+"@"+type+"@"+lang;
      window.history.pushState({},0,valiable);

      document.cookie = "tmpsku="+ tmpsku + ";;path=/";
      document.cookie = "sku="+ sku + ";path=/";
      document.getElementById("compare_process").href="/prcompare@"+sku+"@"+type+"@"+lang;
      document.getElementById("compare_process").innerHTML="Compare ("+nums+"/10)&nbsp;&nbsp;&nbsp;";


    }

    function dtablerow(i){
      var num = document.getElementById("num").value;
      var row = document.getElementById("title"+i);

      row.parentNode.removeChild(row);
      var tmp="rowvalue"+i;

      for (var i = 0; i < num-1; i++) {
        var row2 = document.getElementById(tmp);
        row2.remove();
      };
    }

    </script>



</body>
</html>
<?php
mysqli_Close($link_db);
?>