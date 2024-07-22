<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

function base64_url_encode($input)
{
    return strtr(base64_encode($input), '+/=', '-_,');
}

session_start();
if (empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])) {
    echo "<script language='JavaScript'>location='../login.php'</script>";
    exit();
}

require "../config.php";
include_once('../page.class.php');
setcookie("NM002", '', time() - 3600);

$PType_id = "";
$slang = "";
if (isset($_REQUEST['PType_id']) != "") {
    $PType_id = intval($_REQUEST['PType_id']);
} else {
}

$link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if (isset($_REQUEST['sku_upid']) != '') {
    $sku_upid = intval($_REQUEST['sku_upid']);
    $str_csk1 = "select `ProductTypeID` from `contents_product_skus` where `Product_SContents_Auto_ID`=" . $sku_upid;
    $csk1_cmd = mysqli_query($link_db, $str_csk1);
    $csk1_data = mysqli_fetch_row($csk1_cmd);
    if ($csk1_data[0] != '') {
        if ($csk1_data[0] == 101 || $csk1_data[0] == 102) {
            $str_updcsku = "UPDATE `contents_product_skus` SET `ProductTypeID`=1,`STATUS`=0,`slang`='EN,',`ProductTypeID_SKU`=" . intval($csk1_data[0]) . " WHERE `Product_SContents_Auto_ID`=" . $sku_upid;
            $updcsku_cmd = mysqli_query($link_db, $str_updcsku);
        } else if ($csk1_data[0] == 103 || $csk1_data[0] == 104 || $csk1_data[0] == 108) {
            $str_updcsku = "UPDATE `contents_product_skus` SET `ProductTypeID`=2,`STATUS`=0,`slang`='EN,',`ProductTypeID_SKU`=" . intval($csk1_data[0]) . " WHERE `Product_SContents_Auto_ID`=" . $sku_upid;
            $updcsku_cmd = mysqli_query($link_db, $str_updcsku);
        } else if ($csk1_data[0] == 105 || $csk1_data[0] == 106) {
            $str_updcsku = "UPDATE `contents_product_skus` SET `ProductTypeID`=3,`STATUS`=0,`slang`='EN,',`ProductTypeID_SKU`=" . intval($csk1_data[0]) . " WHERE `Product_SContents_Auto_ID`=" . $sku_upid;
            $updcsku_cmd = mysqli_query($link_db, $str_updcsku);
        } else if ($csk1_data[0] == 1109) {
            $str_updcsku = "UPDATE `contents_product_skus` SET `ProductTypeID`=4,`STATUS`=0,`slang`='EN,',`ProductTypeID_SKU`=" . intval($csk1_data[0]) . " WHERE `Product_SContents_Auto_ID`=" . $sku_upid;
            $updcsku_cmd = mysqli_query($link_db, $str_updcsku);
        } else if ($csk1_data[0] == 107) {
            $str_updcsku = "UPDATE `contents_product_skus` SET `ProductTypeID`=5,`STATUS`=0,`slang`='EN,',`ProductTypeID_SKU`=" . intval($csk1_data[0]) . " WHERE `Product_SContents_Auto_ID`=" . $sku_upid;
            $updcsku_cmd = mysqli_query($link_db, $str_updcsku);
        } else if ($csk1_data[0] == 117) {
            $str_updcsku = "UPDATE `contents_product_skus` SET `ProductTypeID`=22,`STATUS`=0,`slang`='EN,',`ProductTypeID_SKU`=" . intval($csk1_data[0]) . " WHERE `Product_SContents_Auto_ID`=" . $sku_upid;
            $updcsku_cmd = mysqli_query($link_db, $str_updcsku);
        }
        //echo $str_updcsku;
        echo "<script>self.location='default.php'</script>";
        exit();
    }
}

if (isset($_REQUEST['wstatus']) != '' && isset($_REQUEST['sku_id']) != '') {
    $wstatus = trim($_REQUEST['wstatus']);
    $sku_id = intval($_REQUEST['sku_id']);
    if ($wstatus == 'Y' && $sku_id != '') {

        $str_csku = "SELECT `Product_SContents_Auto_ID`, `slang` FROM `contents_product_skus` WHERE `Product_SContents_Auto_ID`=" . $sku_id . " and `slang`='EN,'";
        $csku_cmd = mysqli_query($link_db, $str_csku);
        $csku_data = mysqli_fetch_row($csku_cmd);
        if ($csku_data[0] != '') {
        } else {

            $str_instcsku = "INSERT INTO `contents_product_skus`(`Product_SContents_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `slang`,  `crea_d`, `crea_u`, `upd_d`, `upd_u`) SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `slang`,  `crea_d`, `crea_u`, `upd_d`, `upd_u` FROM `product_skus` WHERE `Product_SKU_Auto_ID`=" . $sku_id . " limit 1;";
            if (!$instcsku_cmd = mysqli_query($link_db, $str_instcsku)) {
                echo "<script>alert('" . addslashes(mysqli_error($link_db)) . "');</script>";
                echo "<script>self.location='default.php?sku_upid=" . $sku_id . "'</script>";
                exit;
            }
        }
    }
}

if (isset($_REQUEST['kinds']) == 'copy') {

    $str_m = "select Product_SKU_Auto_ID FROM product_skus order by Product_SKU_Auto_ID desc limit 1";
    $check_m = mysqli_query($link_db, $str_m);
    $Max_COptionID = mysqli_fetch_row($check_m);
    $MCount = $Max_COptionID[0] + 1;

    $p_SKU = $_REQUEST['pSKU'];

    $guid = com_create_guid();
    $guid = str_replace("{", '', $guid);
    $guid = str_replace("}", '', $guid);

    $str_sku_m = "select * from product_skus where Product_SKU_Auto_ID=" . $p_SKU;
    $cmd_sku_m = mysqli_query($link_db, $str_sku_m);
    $record_sku_m = mysqli_fetch_row($cmd_sku_m);

    if (empty($record_sku_m)) :
    else :
        $str_sku = "insert into product_skus (`Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `NetWorking`, `SAS`, `FormFactor`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `slang`) values ($MCount,$record_sku_m[1],'$record_sku_m[2]','$record_sku_m[3]','$record_sku_m[4]','$record_sku_m[5]','$record_sku_m[6]','$record_sku_m[7]','$record_sku_m[8]','$record_sku_m[9]','$record_sku_m[10]','$guid','$record_sku_m[12]','$record_sku_m[13]','$record_sku_m[16]')";

        if ($cmd_sku = mysqli_query($link_db, $str_sku)) {
            echo "<script>alert('Copy be Finish!');self.location='default.php';</script>";
        }
    endif;
}

$seol = "";
if ($PType_id <> '') {
    if (isset($_REQUEST['s_search']) <> '') {
        $s_search = preg_replace("/['\"\$\r\n\t;<>\*%\?]/i", '', $_REQUEST['s_search']);
        $s_search = htmlspecialchars($s_search, ENT_QUOTES);
        $str1 = "select count(*) from product_skus where (SKU like '%" . $s_search . "%' or MODELCODE like '%" . $s_search . "%') and ProductTypeID=" . $PType_id;
    } else {

        if (isset($_REQUEST['slang']) <> '') {

            $slang = $_REQUEST['slang'];
            $slang = str_replace("|", "%' or slang like '%", $slang);
            $slang = substr($slang, 0, strlen($slang) - 19);
            if (isset($_REQUEST['seol']) != '') {
                $seol = $_REQUEST['seol'];
            } else {
                $seol = "";
            }
            if ($slang <> '' && $seol <> '') {
                $str1 = "SELECT count(*) FROM product_skus where ProductTypeID=" . $PType_id . " and IS_EOL=" . $seol . " and (slang LIKE '%" . $slang . "%')";
            } else if ($slang == '' && $seol <> '') {
                $str1 = "SELECT count(*) FROM product_skus where ProductTypeID=" . $PType_id . " and IS_EOL=" . $seol;
            } else {
                $str1 = "SELECT count(*) FROM product_skus where ProductTypeID=" . $PType_id;
            }
        } else {

            if (isset($_REQUEST['seol']) != '') {
                $seol = $_REQUEST['seol'];
            } else {
                $seol = "";
            }
            if ($seol <> '') {
                $str1 = "SELECT count(*) FROM product_skus where ProductTypeID=" . $PType_id . " and IS_EOL=" . $seol;
            } else {
                $str1 = "SELECT count(*) FROM product_skus where ProductTypeID=" . $PType_id;
            }
        }
    }
} else {
    if (isset($_REQUEST['s_search']) <> '') {
        $s_search = preg_replace("/['\"\$\r\n\t;<>\*%\?]/i", '', $_REQUEST['s_search']);
        $s_search = htmlspecialchars($s_search, ENT_QUOTES);
        $str1 = "select count(*) from product_skus where (SKU like '%" . $s_search . "%' or MODELCODE like '%" . $s_search . "%')";
    } else {

        if (isset($_REQUEST['slang']) <> '') {

            $slang = trim($_REQUEST['slang']);

            $slang = str_replace("|", "%' or slang like '%", $slang);
            $slang = substr($slang, 0, strlen($slang) - 19);

            if (isset($_REQUEST['seol']) != '') {
                $seol = $_REQUEST['seol'];
            } else {
                $seol = "";
            }

            if ($slang <> '' && $seol <> '') {
                $str1 = "SELECT count(*) FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.IS_EOL=" . $seol . " and (a.slang LIKE '%" . $slang . "%')";
            } else if ($slang == '' && $seol <> '') {
                $str1 = "SELECT count(*) FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.IS_EOL=" . $seol;
            } else {
                $str1 = "SELECT count(*) FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID";
            }
        } else {

            if (isset($_REQUEST['seol']) != '') {
                $seol = $_REQUEST['seol'];
            } else {
                $seol = "";
            }
            if ($seol <> '') {
                $str1 = "SELECT count(*) FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.IS_EOL=" . $seol;
            } else {
                $str1 = "select count(*) from product_skus";
            }
        }
    }
}

$list1 = mysqli_query($link_db, $str1);
list($public_count) = mysqli_fetch_row($list1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SPEC Creation Tool - SPEC List</title>
    <link rel="stylesheet" type="text/css" href="../backend.css" />
    <link rel="stylesheet" type="text/css" href="../css/css.css" />
    <script type="text/javascript" src="../jquery.min.js"></script>
    <script type="text/javascript" src="jquery.cookie.js"></script>

    <script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
        $(document).ready(function() {

            for (i = 1; i < 26; i++) {
                $("#Fancy_iframe" + i).fancybox({
                    'width': '100%',
                    'height': '100%',
                    'autoScale': false,
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'type': 'iframe'
                });
            }

            for (j = 1; j < 16; j++) {
                $("#Fancy_iframe_copy" + j).fancybox({
                    'width': '35%',
                    'height': '56%',
                    'autoScale': false,
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'type': 'iframe'
                });
            }

            for (k = 1; k < 11; k++) {
                $("#Fancy_iframe_edit" + k).fancybox({
                    'width': '35%',
                    'height': '56%',
                    'autoScale': false,
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'type': 'iframe'
                });
            }

            $("#Add_SPEC01").fancybox({
                'width': '100%',
                'height': '100%',
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'type': 'iframe'
            });
        });
    </script>

    <script language="JavaScript">
        <!--
        document.onkeydown = function() {
            if (window.event)
                if (event.keyCode == 13 && event.srcElement.nodeName != "TEXTAREA" && event.srcElement.type != "submit")
                    event.keyCode = 9;
        }

        function copy_data(str_id) {
            self.location = "?kinds=copy&pSKU=" + str_id;
        }

        function search_value() {
            self.location = "?s_search=" + document.getElementById('sear_txt').value;
            return false;
        }

        function Lang_check() {

            var P01 = '<?= $PType_id ?>';

            var str_lang = "";
            var lang01 = document.getElementsByName('slang');

            for (var i = 0; i < lang01.length; i++) {
                if (lang01[i].checked == true) {
                    str_lang = str_lang + lang01[i].value + "|";
                }
            }

            var eol01 = document.getElementById('s_eol');
            var str_eol = "";
            if (eol01.checked == true) {
                str_eol = '&seol=' + eol01.value;
            } else if (eol01.checked == false) {
                str_eol = '&seol=0';
            }

            self.location = "?PType_id=" + P01 + "&slang=" + str_lang + str_eol;

        }

        //
        -->
    </script>


    <script language="JavaScript">
        function MM_PT(selObj) {
            var eol01 = document.getElementById('s_eol');
            var str_eol = "";
            if (eol01.checked == true) {
                str_eol = '&seol=' + eol01.value;
            } else if (eol01.checked == false) {
                str_eol = '&seol=0';
            }
            var str_lang = "";
            var lang01 = document.getElementsByName('slang');


            for (var i = 0; i < lang01.length; i++) {
                if (lang01[i].checked == true) {
                    str_lang = str_lang + lang01[i].value + "|";
                }
            }

            window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value, "_self");
        }

        function MM_o(selObj) {
            window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value, "_self");
        }

        function Clear_Cookies_values() {
            var str_u;
            var str_v;

            $.cookie("SEL_PMODEL01", null);
            $.cookie("SKU_value01", null);
            $.cookie("UPC_value01", null);

            $.cookie("SEL_PN1", null);
            $.cookie("SEL_PN2", null);
            $.cookie("SEL_PN3", null);
            $.cookie("SEL_PN4", null);
            $.cookie("SEL_PN5", null);
            $.cookie("SEL_PN6", null);
            $.cookie("SEL_PN7", null);
            $.cookie("SEL_PN8", null);
            $.cookie("SEL_PN9", null);
            $.cookie("SEL_PN10", null);

            for (str_u = 3; str_u < 20; str_u++) {

                str_u1 = str_u.toString();

                if (str_u1.length > 1) {
                    $.cookie("c_seVal" + str_u1, null);
                } else {
                    ch_k = "0" + str_u1;
                    $.cookie("c_seVal" + ch_k, null);
                }

            }
        }


        function doEnter(event) {

            var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
            if (keyCodeEntered == 13) {
                search_value();
            }
        }
    </script>
</head>

<body onload="Clear_Cookies_values()"><a name="top"></a>
    <div>
        <div class="left">
            <h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1>
        </div>

        <div id="logout">Hi <b><?= str_replace('@mic.com.tw', '', $_SESSION['user']); ?></b> <a href="logo.php">Log out &gt;&gt;</a></div>
    </div>

    <div class="clear"></div>
    <?php
    include("./menu.php");
    ?>
    <div class="clear"></div>

    <div id="Search">
        <div>
            <select id="SEL_PTYPE" name="SEL_PTYPE" onChange="MM_PT(this)">
                <option value="default.php?PType_id=">Product Type: All</option>
                <?php
                $str_type = "select ProductTypeID,ProductTypeName from producttypes";
                $type_result = mysqli_query($link_db, $str_type);
                while (list($ProductTypeID, $ProductTypeName) = mysqli_fetch_row($type_result)) {
                ?>
                    <option value="default.php?PType_id=<?= $ProductTypeID ?>" <?php if ($PType_id == $ProductTypeID) {
                                                                                    echo "selected";
                                                                                } ?>><?= $ProductTypeName ?></option>
                <?php
                }
                ?>
            </select> &nbsp;&nbsp;
            <strong>Lauguage: </strong><input id="slang" name="slang" type="checkbox" value="EN" <?php if (strrchr($slang, "EN|") == true) {
                                                                                                        echo "checked";
                                                                                                    } ?> /> English | <input id="slang" name="slang" type="checkbox" value="CN" <?php if (strrchr($slang, "CN|") == true) {
                                                                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                                                                        } ?> /> 簡中 <input id="slang" name="slang" type="checkbox" value="ZH" <?php if (strrchr($slang, "ZH|") == true) {
                                                                                                                                                                                                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                                                                                                                                                                                                    } ?> /> 繁中 <input id="slang" name="slang" type="checkbox" value="JP" <?php if (strrchr($slang, "JP|") == true) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?> /> 日本語&nbsp;&nbsp;<input id="s_eol" name="s_eol" type="checkbox" value="1" <?php if ($seol == '1') {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?> /> EOL <input id="scheck_checked" name="scheck_checked" type="button" value="Search" onclick="Lang_check();" />
        </div>
    </div>
    <p class="clear"></p>
    <div id="content">
        <h3 class="left">Product SPEC List:</h3>
        <p class="clear"></p>
        <!--datatable starts here-->

        <div>
            <div class="pagination left">Total: <span class="w14bblue"><?= $public_count; ?></span> records &nbsp;&nbsp;
            </div>
            <div class="left">
                <form id="form1" name="form1" method="post" action="default.php">
                    <input id="sear_txt" name="sear_txt" type="text" size="20" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" />
                </form>
            </div>
        </div>

        <p class="clear"></p>

        <?php
        if (isset($_REQUEST['PSPEC']) <> '') {

            $PSPEC_Value_str = trim($_REQUEST['PSPEC']);

            $PP01 = "ProductTypeName";
            $PM01 = "MODELCODE";
            $PS01 = "SKU";
            $PL01 = "slang";
            $PE01 = "IS_EOL";
            $PD01 = "upd_d";
            $PU01 = "upd_u";

            if ($PSPEC_Value_str == "ProductTypeName") {
                $PSPEC_Value = $PSPEC_Value_str;
                $PP01 = "ProductTypeName_A";
                $P_value = "Desc";
            } else if ($PSPEC_Value_str == "ProductTypeName_A") {
                $PSPEC_Value = "ProductTypeName";
                $PP01 = "ProductTypeName";
                $P_value = "Asc";
            }

            if ($PSPEC_Value_str == "MODELCODE") {
                $PSPEC_Value = $PSPEC_Value_str;
                $PM01 = "MODELCODE_A";
                $P_value = "Desc";
            } else if ($PSPEC_Value_str == "MODELCODE_A") {
                $PSPEC_Value = "MODELCODE";
                $PM01 = "MODELCODE";
                $P_value = "Asc";
            }

            if ($PSPEC_Value_str == "SKU") {
                $PSPEC_Value = $PSPEC_Value_str;
                $PS01 = "SKU_A";
                $P_value = "Desc";
            } else if ($PSPEC_Value_str == "SKU_A") {
                $PSPEC_Value = "SKU";
                $PS01 = "SKU";
                $P_value = "Asc";
            }

            if ($PSPEC_Value_str == "slang") {
                $PSPEC_Value = $PSPEC_Value_str;
                $PL01 = "slang_A";
                $P_value = "Desc";
            } else if ($PSPEC_Value_str == "slang_A") {
                $PSPEC_Value = "slang";
                $PL01 = "slang";
                $P_value = "Asc";
            }

            if ($PSPEC_Value_str == "IS_EOL") {
                $PSPEC_Value = $PSPEC_Value_str;
                $PE01 = "IS_EOL_A";
                $P_value = "Desc";
            } else if ($PSPEC_Value_str == "IS_EOL_A") {
                $PSPEC_Value = "IS_EOL";
                $PE01 = "IS_EOL";
                $P_value = "Asc";
            }

            if ($PSPEC_Value_str == "upd_d") {
                $PSPEC_Value = $PSPEC_Value_str;
                $PD01 = "upd_d_A";
                $P_value = "Desc";
            } else if ($PSPEC_Value_str == "upd_d_A") {
                $PSPEC_Value = "upd_d";
                $PD01 = "upd_d";
                $P_value = "Asc";
            }

            if ($PSPEC_Value_str == "upd_u") {
                $PSPEC_Value = $PSPEC_Value_str;
                $PU01 = "upd_u_A";
                $P_value = "Desc";
            } else if ($PSPEC_Value_str == "upd_u_A") {
                $PSPEC_Value = "upd_u";
                $PU01 = "upd_u";
                $P_value = "Asc";
            }
        } else {
            $PSPEC_Value = "upd_d";

            $PP01 = "ProductTypeName";
            $PM01 = "MODELCODE";
            $PS01 = "SKU";
            $PL01 = "slang";
            $PE01 = "IS_EOL";
            $PD01 = "upd_d";
            $PU01 = "upd_u";
            $P_value = "Desc";
        }
        ?>
        <table class="list_table">
            <tr>
                <th><a href="?PSPEC=<?= $PP01; ?>" STYLE="text-decoration:none">*Product Type</a></th>
                <th><a href="?PSPEC=<?= $PM01; ?>" STYLE="text-decoration:none">*Model Name</a></th>
                <th><a href="?PSPEC=<?= $PS01; ?>" STYLE="text-decoration:none">*SKU</a></th>
                <th><a href="?PSPEC=<?= $PL01; ?>" STYLE="text-decoration:none">*Language</a></th>
                <th><a href="?PSPEC=<?= $PE01; ?>" STYLE="text-decoration:none">*EOL</a></th>
                <th><a href="?PSPEC=<?= $PD01; ?>" STYLE="text-decoration:none">*Updated Date</a></th>
                <th><a href="?PSPEC=<?= $PU01; ?>" STYLE="text-decoration:none">*Update by</a></th>
                <th><a href="add_spec.php" STYLE="text-decoration:none"> Add New </a>
                    <div class="button14" style="width:80px;" onClick="location='add_spec.php'">Add New</div>
                </th>
            </tr>
            <?php
            if (isset($_REQUEST['page']) == "") {
                $page = "1";
            } else {
                $page = intval($_REQUEST['page']);
            }
            if (empty($page)) $page = "1";

            $read_num = "10";
            $start_num = $read_num * ($page - 1);

            if ($PType_id <> '') {

                if (isset($_REQUEST['s_search']) <> '') {
                    $s_search = preg_replace("/['\"\$\r\n\t;<>\*%\?]/i", '', $_REQUEST['s_search']);
                    $s_search = htmlspecialchars($s_search, ENT_QUOTES);
                    $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where (a.SKU like '%" . $s_search . "%' or a.MODELCODE like '%" . $s_search . "%') and a.ProductTypeID=" . $PType_id . " ORDER BY " . $PSPEC_Value . " " . $P_value . " limit $start_num,$read_num;";
                } else {

                    if (isset($_REQUEST['slang']) <> '') {

                        $slang = trim($_REQUEST['slang']);

                        $slang = str_replace("|", "%' or slang like '%", $slang);
                        $slang = substr($slang, 0, strlen($slang) - 19);

                        $seol = $_REQUEST['seol'];
                        if ($slang <> '' && $seol <> '') {
                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=" . $PType_id . " and a.IS_EOL=" . $seol . " and (a.slang LIKE '%" . $slang . "%') ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        } else if ($slang == '' && $seol <> '') {
                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=" . $PType_id . " and a.IS_EOL=" . $seol . " ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        } else {
                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=" . $PType_id . " ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        }
                    } else {

                        if (isset($_REQUEST['seol']) != "") {
                            $seol = trim($_REQUEST['seol']);
                        } else {
                            $seol = "";
                        }
                        if ($seol <> '') {
                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=" . $PType_id . " and a.IS_EOL=" . $seol . " ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        } else {
                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.ProductTypeID=" . $PType_id . " ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        }
                    }
                }
            } else {
                if (isset($_REQUEST['s_search']) <> '') {
                    $s_search = preg_replace("/['\"\$\r\n\t;<>\*%\?]/i", '', $_REQUEST['s_search']);
                    $s_search = htmlspecialchars($s_search, ENT_QUOTES);
                    $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where (a.SKU like '%" . $s_search . "%' or a.MODELCODE like '%" . $s_search . "%') ORDER BY " . $PSPEC_Value . " " . $P_value . " limit $start_num,$read_num;";
                } else {

                    if (isset($_REQUEST['slang']) <> '') {

                        $slang = $_REQUEST['slang'];

                        $slang = str_replace("|", "%' or slang like '%", $slang);
                        $slang = substr($slang, 0, strlen($slang) - 19);

                        $seol = $_REQUEST['seol'];
                        if ($slang <> '' && $seol <> '') {
                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.IS_EOL=" . $seol . " and (a.slang LIKE '%" . $slang . "%') ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        } else if ($slang == '' && $seol <> '') {
                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.IS_EOL=" . $seol . " ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        } else {
                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        }
                    } else {

                        if (isset($_REQUEST['seol']) != '') {
                            $seol = trim($_REQUEST['seol']);
                        } else {
                            $seol = "";
                        }

                        if ($seol <> '') {

                            $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID where a.IS_EOL=" . $seol . " ORDER BY " . $PSPEC_Value . " " . $P_value . ",a.Product_SKU_Auto_ID limit $start_num,$read_num;";
                        } else {

                            if (isset($_REQUEST['PSPEC']) <> '') {
                                $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID ORDER BY " . $PSPEC_Value . " " . $P_value . " limit $start_num,$read_num;";
                            } else {
                                $str = "SELECT a.*,b.ProductTypeName FROM product_skus a inner join producttypes b on a.ProductTypeID=b.ProductTypeID ORDER BY a.upd_d Desc limit $start_num,$read_num;";
                            }
                        }
                    }
                }
            }

            $result = mysqli_query($link_db, $str);
            $i = 0;
            while (list($Product_SKU_Auto_ID, $ProductTypeID, $SKU, $MODELCODE, $MODELDESCRIPT, $NetWorking, $SAS, $FormFactor, $Riser, $HDD_Bay, $PSU, $Host_IF, $Conn_Type, $Conn_Qty, $UPCcode, $FAN, $IS_EOL, $Web_Disable, $GUID, $crea_d, $crea_u, $upd_d, $upd_u, $slang, $SKU_CategorySort, $SKU_Type, $ProductTypeName) = mysqli_fetch_row($result)) {
                $i = $i + 1;
                putenv("TZ=Asia/Taipei");
            ?>
                <tr class="list_table_con">
                    <td>
                        <?php
                        $str_type = "select * from producttypes where ProductTypeID=" . $ProductTypeID;
                        $type_result = mysqli_query($link_db, $str_type);
                        $data = mysqli_fetch_row($type_result);
                        echo $data[1];
                        ?></td>
                    <td><?= $MODELCODE; ?></td>
                    <td>
                        <a href="#" onclick="window.open('../mockups/product_spec_tmp.php?sku_id=<?= base64_url_encode($Product_SKU_Auto_ID); ?>&sku_name=<?= base64_url_encode($SKU); ?>&sku_mcode=<?= base64_url_encode($MODELCODE); ?>'); return false"><?= $SKU; ?></a>
                    </td>
                    <td>
                        <?php
                        echo "EN";
                        ?></td>
                    <td>
                        <?php
                        if ($IS_EOL == 1) {
                            echo "YES";
                        } else if ($IS_EOL == 0) {
                            echo "NO";
                        }
                        ?></td>
                    <td>
                        <?php
                        echo $upd_d;
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($upd_u == '') {
                            echo $crea_u;
                        } else {
                            echo $upd_u;
                        }
                        ?>
                    </td>
                    <td><a href="edit_spec.php?p_id=<?= $Product_SKU_Auto_ID; ?>"> Edit </a> &nbsp;&nbsp;<a href="Copy_spec.php?p_id=<?= $Product_SKU_Auto_ID; ?>">COPY</a>&nbsp;
                        <?php
                        //$str_csku="SELECT `Product_SContents_Auto_ID`, `slang` FROM `contents_product_skus` WHERE `Product_SContents_Auto_ID`=".$Product_SKU_Auto_ID." and `slang`='EN,'";
                        $str_csku = "SELECT `Product_SContents_Auto_ID`, `slang` FROM `contents_product_skus` WHERE `Product_SContents_Auto_ID`=" . $Product_SKU_Auto_ID;
                        $csku_cmd = mysqli_query($link_db, $str_csku);
                        $csku_data = mysqli_fetch_row($csku_cmd);
                        if ($csku_data[0] != '') {
                        } else {
                        ?>
                            &nbsp;&nbsp;<a href="?sku_id=<?= $Product_SKU_Auto_ID; ?>&wstatus=Y">Enable</a>&nbsp;&nbsp;&nbsp;
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan=8>
                    <?php
                    $all_page = ceil($public_count / $read_num);
                    $pageSize = $page;
                    $total = $all_page;
                    pageft($total, $pageSize, 1, 0, 0, 15);
                    ?>
                </td>
            </tr>
        </table>
        <!--end of datatable-->
    </div>
    <div class="sabrosus"><span class="w14bblue"><?= $read_num ?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
        <select id="pskus_page" name="pskus_page" onChange="MM_o(this)">
            <?php
            for ($j = 1; $j <= $total; $j++) {
            ?>
                <option value="?page=<?= $j ?>&s_search=<?= $s_search ?>" <?php if ($page == $j) {
                                                                            echo "selected";
                                                                        } ?>><?= $j ?></option>
            <?php
            }
            ?>
        </select>&nbsp;&nbsp;
        <?php echo $pagenav; ?>
    </div>

    <p class="clear">&nbsp;</p>
    <div id="footer"> Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div>
    </div>
</body>

</html>