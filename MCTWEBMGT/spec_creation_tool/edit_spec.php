<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

@session_start();
if (empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])) {
    echo "<script language='JavaScript'>location='../login.php'</script>";
    exit();
}
error_reporting(0);
require "../config.php";
ini_set('max_execution_time', 0);
$Save_State = "";

if (isset($_REQUEST['Mart_type']) != '') {
    if (trim($_REQUEST['Mart_type']) == 'Add') {
        $s1 = strtr($_REQUEST['str_val1'], '±', '+');
        $s1 = htmlspecialchars($s1, ENT_QUOTES);
        $s2 = trim($_REQUEST['str_val2']);
        $s3 = trim($_REQUEST['str_val3']);
        $s4 = trim($_REQUEST['str_val4']);
        $s5 = trim($_REQUEST['str_val5']);
        $s6 = trim($_REQUEST['str_val6']);
        $u1 = trim($_REQUEST['sku_id']);

        if (strlen($s4) > 1) {
            $PA_1 = $s4;
        } else {
            $PA_1 = "0" . $s4;
        }

        if ($s1 <> "") {
            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
            mysqli_query($link_db, 'SET NAMES utf8');
            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
            //$select=mysqli_select_db($dataBase, $link_db);

            $str_values = "select MValue_id FROM `matrix_values` order by MValue_id desc limit 1";
            $check_values = mysqli_query($link_db, $str_values);
            $Max_CValID = mysqli_fetch_row($check_values);
            $MCount = $Max_CValID[0] + 1;

            function getGUID()
            {
                if (function_exists('com_create_guid')) {
                    return com_create_guid();
                } else {
                    mt_srand((float)microtime() * 10000); //optional for php 4.2.0 and up.
                    $charid = strtoupper(md5(uniqid(rand(), true)));
                    $hyphen = chr(45); // "-"
                    $uuid = chr(123) // "{"
                        . substr($charid, 0, 8) . $hyphen
                        . substr($charid, 8, 4) . $hyphen
                        . substr($charid, 12, 4) . $hyphen
                        . substr($charid, 16, 4) . $hyphen
                        . substr($charid, 20, 12)
                        . chr(125); // "}"
                    return $uuid;
                }
            }

            $guid = getGUID();
            $guid = strtr($guid, '{', '');
            $guid = strtr($guid, '}', '');

            putenv("TZ=Asia/Taipei");
            $now = date("Y/m/d H:i:s");
            $_SESSION["SEL_PMatrix01"] = $s6;
            $strs = "insert into `matrix_values` (`MValue_id`, `MValue_Mid`, `MValue_SUBName`, `MValue_VName`, `SKUs`, `GUID`, `crea_d`, `crea_u`, `IsShow`, `Tooltips`) values ($MCount," . $s2 . ",'" . $s3 . "','" . $s1 . "','','','$now','1782','1','" . $s5 . "')";
            $cmds = mysqli_query($link_db, $strs);
            echo "<script>self.location='edit_spec.php?p_id=" . $u1 . "&p_PMA" . $PA_1 . "=" . $PA_1 . "&p_seVal" . $PA_1 . "=" . $s1 . "&get_cookies=Yes#product_matrix';</script>";
            exit();
        } else {
            echo "<script>self.location='edit_spec.php?p_id=" . $u1 . "&p_PMA" . $PA_1 . "=" . $PA_1 . "&p_seVal" . $PA_1 . "=" . $s1 . "#product_matrix';</script>";
            exit();
        }
    }
}


if (isset($_REQUEST['methods']) != '') {
    if (trim($_REQUEST['methods']) == 'update_spec') {
        $str_s = "";
        $str = "";
        /*清除所有Cookies*/
        foreach ($_COOKIE as $key => $value) {
            setCookie($key, "", time() - 60);
        }
        /* end */

        $spec_mid = intval($_POST['spec_mid']);

        $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
        mysqli_query($link_db, 'SET NAMES utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        //$select=mysqli_select_db($dataBase, $link_db);

        putenv("TZ=Asia/Taipei");
        $now_s = date("Y/m/d H:i:s");

        for ($Pout = 1; $Pout < 15; $Pout++) {

            if (strlen($Pout) > 1) {
                $Pout = $Pout;
            } else {
                $Pout = "0" . $Pout;
            }
            unset($_SESSION["p_seVal" . $Pout]);
        }
        unset($_SESSION["SEL_PMatrix01"]);

        /* Update product_skus Date */
        $sql_pskus = "UPDATE `product_skus` SET `upd_d`='$now_s' WHERE `Product_SKU_Auto_ID`=" . $spec_mid;
        $query_pskus = mysqli_query($link_db, $sql_pskus);
        /* end */

        $str_sku = "select Product_SKU_Auto_ID FROM product_skus order by Product_SKU_Auto_ID desc limit 1";
        $check_sku = mysqli_query($link_db, $str_sku);
        $Max_CSKUID = mysqli_fetch_row($check_sku);
        $MCount = $Max_CSKUID[0] + 1;
        $S_Count = 0;
        if (isset($_POST['PT1']) != '') {
            if (intval($_POST['PT1']) == 101 || intval($_POST['PT1']) == 102) {
                $S_Count = 17;
                $PMatr_TName = "product_matrix";
            } else if (intval($_POST['PT1']) == 103 || intval($_POST['PT1']) == 104 || intval($_POST['PT1']) == 108 || intval($_POST['PT1']) == 117) {
                $S_Count = 20;
                $PMatr_TName = "product_matrix_b";
            } else if (intval($_POST['PT1']) == 0106 || intval($_POST['PT1']) == 105) {
                $S_Count = 16;
                $PMatr_TName = "product_matrix_h";
            } else if (intval($_POST['PT1']) == 1109 || intval($_POST['PT1']) == 1110 || intval($_POST['PT1']) == 1111 || intval($_POST['PT1']) == 1112 || intval($_POST['PT1']) == 1113) {
                $S_Count = 13;
                $PMatr_TName = "product_matrix_t";
            }
        }
        /* 開始寫入product_matrix */
        for ($S = 3; $S < $S_Count; $S++) {

            if (strlen($S) > 1) {
                $S = $S;
            } else {
                $S = "0" . $S;
            }
            $str_item = "SEL_PMT0" . $S;
            $str_item_M = "PMS_" . $S;

            if (isset($_POST[$str_item]) != "") {
                if (trim($_POST[$str_item]) != '' && trim($_POST[$str_item]) != 'Add') {
                    $str = "'" . $_POST[$str_item] . "',";
                } else {
                    $str = "'" . $_POST[$str_item_M] . "',";
                }
            }
            $str_s = $str_s . $str;
        }
        if ($str_s != "") {
            $str_sub01 = substr($str_s, 0, strlen($str_s) - 1);
        } else {
            $str_sub01 = "''";
        }
        if (isset($_POST['SEL_PMatrix']) != "") {
            if (trim($_POST['SEL_PMatrix']) != '') {
                $sstr = $_POST['SEL_PMatrix'] . ",'" . $_POST['SEL_PMODEL'] . "','" . $spec_mid . "'," . $str_sub01;
            } else {
                $sstr = "0,'" . $_POST['SEL_PMODEL'] . "','" . $spec_mid . "'," . $str_sub01;
            }
        } else {
            $sstr = "0,'" . $_POST['SEL_PMODEL'] . "','" . $spec_mid . "'," . $str_sub01;
        }

        $sstr1 = $_POST['SEL_PMatrix'] . ",'" . $_POST['SEL_PMODEL'] . "','" . $MCount . "'," . $str_s;

        $sstr_split = explode(",", $sstr1, -1);

        /* Check SKU 是否存在於 `product_matrix` */
        $str_chkMa = "select SKU from " . $PMatr_TName . " where `SKU`=" . $spec_mid;
        $cmd_chkMa = mysqli_query($link_db, $str_chkMa);
        $record_ck = mysqli_fetch_row($cmd_chkMa);

        if (empty($record_ck)) :

            $str_m = "select MatrixID FROM " . $PMatr_TName . " order by MatrixID desc limit 1";
            $check_m = mysqli_query($link_db, $str_m);
            $Max_PMaxtrixID = mysqli_fetch_row($check_m);
            $MMXCount = $Max_PMaxtrixID[0] + 1;

            $sqls = "";
            if (isset($_POST['PT1']) != '') {
                if (intval($_POST['PT1']) == 101 || intval($_POST['PT1']) == 102) {
                    $sqls = "INSERT INTO `product_matrix`(`MatrixID`,`SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `CPU_QPI`, `Chipset`, `PCIx`, `PCI`, `PCIe`, `Mem_Max`, `Mem_Type`, `IFeatures_A`, `IFeatures_G`, `IFeatures_N`, `IFeatures_R`, `Sr_Mgt`, `RHS_typ`, `UrlSite`, `IsShow`) VALUES (" . $MMXCount . ",$sstr,'','1')";
                } else if (intval($_POST['PT1']) == 103 || intval($_POST['PT1']) == 104 || intval($_POST['PT1']) == 108 || intval($_POST['PT1']) == 117) {
                    $sqls = "INSERT INTO `product_matrix_b`(`MatrixID`, `SocketR_NameID`, `ModelCode`, `SKU`, `Dim_H`, `Dim_W`, `Dim_D`, `Power_Supply`, `CPU_Series`, `Mem_Max`, `Mem_Type`, `HDD_Max`, `HDD_Type`, `HDD_HF`, `NIC_GbE`, `NIC_10GbE`, `PCIx`, `PCI`, `PCIe`, `Sr_Mgt`, `RHS_typ`, `UrlSite`, `IsShow`) VALUES (" . $MMXCount . ",$sstr,'','1')";
                } else if (intval($_POST['PT1']) == 0106 || intval($_POST['PT1']) == 105) {
                    $sqls = "INSERT INTO `product_matrix_h`(`MatrixID`, `SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `Dim_W`, `Dim_D`, `Chipset`, `Cache_Freq`, `Host_Interface`, `Int_Port`, `Ext_Port`, `SW_RAID`, `HW_RAID`, `Enhanced_RAID`, `Optional_BBU`, `RHS_typ`, `UrlSite`, `IsShow`) VALUES (" . $MMXCount . ",$sstr,'','1')";
                } else if (intval($_POST['PT1']) == 1109 || intval($_POST['PT1']) == 1110 || intval($_POST['PT1']) == 1111 || intval($_POST['PT1']) == 1112 || intval($_POST['PT1']) == 1113) {
                    $sqls = "INSERT INTO `product_matrix_t`(`MatrixID`, `SocketR_NameID`, `ModelCode`, `SKU`, `Chipset`, `UrlSite`, `IsShow`) VALUES (" . $MMXCount . ",$sstr,'','1')";
                }
            }
            $query = mysqli_query($link_db, $sqls);
        else :
            if (isset($_POST['PT1']) != '') {
                if (intval($_POST['PT1']) == 101 || intval($_POST['PT1']) == 102) {
                    $sql = "UPDATE `product_matrix` SET `SocketR_NameID`=$sstr_split[0],`ModelCode`=$sstr_split[1],`FormFactor`=$sstr_split[3],`CPU_QPI`=$sstr_split[4],`Chipset`=$sstr_split[5],`PCIx`=$sstr_split[6],`PCI`=$sstr_split[7],`PCIe`=$sstr_split[8],`Mem_Max`=$sstr_split[9],`Mem_Type`=$sstr_split[10],`IFeatures_A`=$sstr_split[11],`IFeatures_G`=$sstr_split[12],`IFeatures_N`=$sstr_split[13],`IFeatures_R`=$sstr_split[14],`Sr_Mgt`=$sstr_split[15],`RHS_typ`=$sstr_split[16],`UrlSite`='',`IsShow`='1' WHERE `SKU`=" . $spec_mid;
                } else if (intval($_POST['PT1']) == 103 || intval($_POST['PT1']) == 104 || intval($_POST['PT1']) == 108 || intval($_POST['PT1']) == 117) {
                    $sql = "UPDATE `product_matrix_b` SET `SocketR_NameID`=$sstr_split[0],`ModelCode`=$sstr_split[1],`Dim_H`=$sstr_split[3],`Dim_W`=$sstr_split[4],`Dim_D`=$sstr_split[5],`Power_Supply`=$sstr_split[6],`CPU_Series`=$sstr_split[7],`Mem_Max`=$sstr_split[8],`Mem_Type`=$sstr_split[9],`HDD_Max`=$sstr_split[10],`HDD_Type`=$sstr_split[11],`HDD_HF`=$sstr_split[12],`NIC_GbE`=$sstr_split[13],`NIC_10GbE`=$sstr_split[14],`PCIx`=$sstr_split[15],`PCI`=$sstr_split[16],`PCIe`=$sstr_split[17],`Sr_Mgt`=$sstr_split[18],`RHS_typ`=$sstr_split[19],`UrlSite`='',`IsShow`='1' WHERE `SKU`=" . $spec_mid;
                } else if (intval($_POST['PT1']) == 0106 || intval($_POST['PT1']) == 105) {
                    $sql = "UPDATE `product_matrix_h` SET `SocketR_NameID`=$sstr_split[0],`ModelCode`=$sstr_split[1],`FormFactor`=$sstr_split[3],`Dim_W`=$sstr_split[4],`Dim_D`=$sstr_split[5],`Chipset`=$sstr_split[6],`Cache_Freq`=$sstr_split[7],`Host_Interface`=$sstr_split[8],`Int_Port`=$sstr_split[9],`Ext_Port`=$sstr_split[10],`SW_RAID`=$sstr_split[11],`HW_RAID`=$sstr_split[12],`Enhanced_RAID`=$sstr_split[13],`Optional_BBU`=$sstr_split[14],`RHS_typ`=$sstr_split[15],`UrlSite`='',`IsShow`='1' WHERE `SKU`=" . $spec_mid;
                } else if (intval($_POST['PT1']) == 1109 || intval($_POST['PT1']) == 1110 || intval($_POST['PT1']) == 1111 || intval($_POST['PT1']) == 1112 || intval($_POST['PT1']) == 1113) {
                    $sql = "UPDATE `product_matrix_t` SET `SocketR_NameID`=$sstr_split[0],`ModelCode`=$sstr_split[1],`UrlSite`='',`IsShow`='1' WHERE `SKU`=" . $spec_mid;
                }
            }
            $query = mysqli_query($link_db, $sql);

        endif;
        /* 結束寫入product_matrix */

        if (isset($_POST['PT1']) != '') {
            $PT1 = trim($_POST['PT1']);
        } else {
            $PT1 = "";
        }
        if (isset($_POST['SEL_PMODEL']) != '') {
            $SEL_PMODEL = trim($_POST['SEL_PMODEL']);
        } else {
            $SEL_PMODEL = "";
        }
        if (isset($_POST['SKU_value']) != '') {
            $SKU_value = trim($_POST['SKU_value']);
        } else {
            $SKU_value = "";
        }
        if (isset($_POST['UPC_value']) != '') {
            $UPC_value = trim($_POST['UPC_value']);
        } else {
            $UPC_value = "";
        }
        if (isset($_POST['SEL_PN1']) != '') {
            $SEL_PNWork = trim($_POST['SEL_PN1']);
        } else {
            $SEL_PNWork = "";
        }
        if (isset($_POST['SEL_PN2']) != '') {
            $SEL_SAS = trim($_POST['SEL_PN2']);
        } else {
            $SEL_SAS = "";
        }
        if (isset($_POST['SEL_PN3']) != '') {
            $SEL_FFactor = trim($_POST['SEL_PN3']);
        } else {
            $SEL_FFactor = "";
        }
        if (isset($_POST['SEL_PN4']) != '') {
            $SEL_PRiser = trim($_POST['SEL_PN4']);
        } else {
            $SEL_PRiser = "";
        }
        if (isset($_POST['SEL_PN5']) != '') {
            $SEL_HDD_Bay = trim($_POST['SEL_PN5']);
        } else {
            $SEL_HDD_Bay = "";
        }
        if (isset($_POST['SEL_PN6']) != '') {
            $SEL_PSU = trim($_POST['SEL_PN6']);
        } else {
            $SEL_PSU = "";
        }
        if (isset($_POST['SEL_PN7']) != '') {
            $SEL_Host_IF = trim(htmlentities($_POST['SEL_PN7']));
        } else {
            $SEL_Host_IF = "";
        }
        if (isset($_POST['SEL_PN8']) != '') {
            $SEL_Conn_Type = trim($_POST['SEL_PN8']);
        } else {
            $SEL_Conn_Type = "";
        }
        if (isset($_POST['SEL_PN9']) != '') {
            $SEL_Conn_Qty = trim($_POST['SEL_PN9']);
        } else {
            $SEL_Conn_Qty = "";
        }
        if (isset($_POST['SEL_PN10']) != '') {
            $SEL_FAN = trim($_POST['SEL_PN10']);
        } else {
            $SEL_FAN = "";
        }
        if (isset($_POST['SEL_PN11']) != '') {
            $SEL_PCIe = trim($_POST['SEL_PN11']);
        } else {
            $SEL_PCIe = "";
        }
        if (isset($_POST['SEL_PN12']) != '') {
            $SEL_Chip = trim($_POST['SEL_PN12']);
        } else {
            $SEL_Chip = "";
        }
        if (isset($_POST['SEL_SKU_S']) != '') {
            $SEL_SKU_S = trim($_POST['SEL_SKU_S']);
        } else {
            $SEL_SKU_S = "";
        }
        if (isset($_POST['specEOL']) != '') {
            $specEOL = trim($_POST['specEOL']);
        } else {
            $specEOL = "";
        }

        if (isset($_POST['specBTO']) != '') {
            $specBTO = trim($_POST['specBTO']);
        } else {
            $specBTO = "";
        }
        if (isset($_POST['compareBox']) != '') {
            $compareBox = trim($_POST['compareBox']);
        } else {
            $compareBox = "";
        }
        if (isset($_POST['quoteBox']) != '') {
            $quoteBox = trim($_POST['quoteBox']);
        } else {
            $quoteBox = "";
        }


        if ($specEOL == '1') {
            $specEOL_1 = '1';
        } else if ($specEOL == '') {
            $specEOL_1 = '0';
        }
        if ($specBTO == '1') {
            $specBTO_1 = '1';
        } else if ($specBTO == '') {
            $specBTO_1 = '0';
        }
        if ($compareBox == '1') {
            $compareBox = '1';
        } else {
            $compareBox = '0';
        }
        if ($quoteBox == '1') {
            $quoteBox = '1';
        } else {
            $quoteBox = '0';
        }


        $SPECC_Sort_tr = trim($_POST['SPECC_Sort_tr']);
        $SPECTP_str = trim($_POST['SPECTP_str']);

        function getGUID()
        {
            if (function_exists('com_create_guid')) {
                return com_create_guid();
            } else {
                mt_srand((float)microtime() * 10000); //optional for php 4.2.0 and up.
                $charid = strtoupper(md5(uniqid(rand(), true)));
                $hyphen = chr(45); // "-"
                $uuid = chr(123) // "{"
                    . substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12)
                    . chr(125); // "}"
                return $uuid;
            }
        }

        $guid = getGUID();

        $guid = strtr($guid, '{', '');
        $guid = strtr($guid, '}', '');

        putenv("TZ=Asia/Taipei");
        $now = date("Y/m/d H:i:s");
        $str_lang = "";
        if (isset($_POST['aspecLang']) != '') {
            foreach ($_POST['aspecLang'] as $check_lang) {
                $str_lang = $str_lang . $check_lang . ",";
            }
        } else {
            $str_lang = "";
        }

        $note01m = $_POST['note01m'];

        if (isset($_POST['PT1']) != '') {

            if (intval($_POST['PT1']) == 101 || intval($_POST['PT1']) == 102) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`NetWorking`='$SEL_PNWork',`SAS`='$SEL_SAS',`FormFactor`='$SEL_FFactor',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `SYSTEMBOARDID` FROM `p_s_main_systemboards` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `SYSTEMBOARDID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `SYSTEMBOARDID` FROM `p_s_main_systemboards` WHERE 1 order by `SYSTEMBOARDID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_mbMaxtrixID = mysqli_fetch_row($cmd_count);
                    $MBMXCount = $Max_P_mbMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_s_main_systemboards`(`SYSTEMBOARDID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $MBMXCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 103 || intval($_POST['PT1']) == 104) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `SERVERID` FROM `p_b_main_serverbarebones` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `SERVERID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `SERVERID` FROM `p_b_main_serverbarebones` WHERE 1 order by `SERVERID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_bbMaxtrixID = mysqli_fetch_row($cmd_count);
                    $BBMXCount = $Max_P_bbMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_serverbarebones`(`SERVERID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $BBMXCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 107) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `PANELPCID` FROM `p_b_main_panelpc` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `PANELPCID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `PANELPCID` FROM `p_b_main_panelpc` WHERE 1 order by `PANELPCID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_pcMaxtrixID = mysqli_fetch_row($cmd_count);
                    $pcCount = $Max_P_pcMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_panelpc`(`PANELPCID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $pcCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 108) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `EMBEDDEDID` FROM `p_b_main_embedded` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `EMBEDDEDID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `EMBEDDEDID` FROM `p_b_main_embedded` WHERE 1 order by `EMBEDDEDID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_emMaxtrixID = mysqli_fetch_row($cmd_count);
                    $EMCount = $Max_P_emMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_embedded`(`EMBEDDEDID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $EMCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 109) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `INDUSTRIAMBID` FROM `p_b_main_industriamb` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `INDUSTRIAMBID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `INDUSTRIAMBID` FROM `p_b_main_industriamb` WHERE 1 order by `INDUSTRIAMBID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_inMaxtrixID = mysqli_fetch_row($cmd_count);
                    $INCount = $Max_P_inMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_industriamb`(`INDUSTRIAMBID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $INCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 110) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `OCPID` FROM `p_b_main_ocpserver` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `OCPID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `OCPID` FROM `p_b_main_ocpserver` WHERE 1 order by `OCPID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_pcMaxtrixID = mysqli_fetch_row($cmd_count);
                    $pcCount = $Max_P_pcMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_ocpserver`(`OCPID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $pcCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 111) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `OCPMezzID` FROM `p_b_main_ocpmezz` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `OCPMezzID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `OCPMezzID` FROM `p_b_main_ocpmezz` WHERE 1 order by `OCPMezzID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_pcMaxtrixID = mysqli_fetch_row($cmd_count);
                    $pcCount = $Max_P_pcMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_ocpmezz`(`OCPMezzID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $pcCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 112) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `JBODFID` FROM `p_b_main_jbodjbof` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `JBODFID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `JBODFID` FROM `p_b_main_jbodjbof` WHERE 1 order by `JBODFID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_pcMaxtrixID = mysqli_fetch_row($cmd_count);
                    $pcCount = $Max_P_pcMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_jbodjbof`(`JBODFID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $pcCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 113) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `OCPRACKID` FROM `p_b_main_ocprack` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `OCPRACKID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `OCPRACKID` FROM `p_b_main_ocprack` WHERE 1 order by `OCPRACKID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_pcMaxtrixID = mysqli_fetch_row($cmd_count);
                    $pcCount = $Max_P_pcMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_ocprack`(`OCPRACKID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $pcCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 114) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `POSID` FROM `p_b_main_pos` WHERE `MODELCODE`='$SEL_PMODEL' order by `POSID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `POSID` FROM `p_b_main_pos` WHERE 1 order by `POSID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_pcMaxtrixID = mysqli_fetch_row($cmd_count);
                    $pcCount = $Max_P_pcMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_pos`(`POSID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $pcCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 115) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `POSID` FROM `p_b_main_5G` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `5GID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `POSID` FROM `p_b_main_5G` WHERE 1 order by `5GID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_pcMaxtrixID = mysqli_fetch_row($cmd_count);
                    $pcCount = $Max_P_pcMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_5G`(`5GID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $pcCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            } else if (intval($_POST['PT1']) == 116) {
                $str_con_skus = "UPDATE `contents_product_skus` SET `SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`STATUS`=0,`upd_d`='$now',`upd_u`='1782',`ProductTypeID_SKU`=$PT1,`MODELDESCRIPT`='$note01m' WHERE `Product_SContents_Auto_ID`=" . $spec_mid;
                $str_skuu = "update `product_skus` set `ProductTypeID`=$PT1,`SKU`='$SKU_value',`MODELCODE`='$SEL_PMODEL',`Riser`='$SEL_PRiser',`HDD_Bay`='$SEL_HDD_Bay',`PSU`='$SEL_PSU',`UPCcode`='$UPC_value',`FAN`='$SEL_FAN',`IS_EOL`=$specEOL_1,`IS_BTO`=$specBTO_1,`Web_Disable`=$SEL_SKU_S,`upd_d`='$now',`upd_u`='1782',`slang`='$str_lang',`SKU_CategorySort`='$SPECC_Sort_tr',`SKU_Type`='$SPECTP_str',`MODELDESCRIPT`='$note01m',`COMPARE`='$compareBox',`REQUEST_QUOTE`='$quoteBox',`PCI-E_slot`='$SEL_PCIe' where `Product_SKU_Auto_ID`=" . $spec_mid;
                $str_mod = "SELECT `IntelDSGID` FROM `p_b_main_inteldsg` WHERE `MODELCODE`='" . $SEL_PMODEL . "' order by `IntelDSGID` desc";
                $cmd_mod = mysqli_query($link_db, $str_mod);
                $num = mysqli_num_rows($cmd_mod);
                if ($num == 0) {
                    $str_count = "SELECT `IntelDSGID` FROM `p_b_main_inteldsg` WHERE 1 order by `IntelDSGID` desc";
                    $cmd_count = mysqli_query($link_db, $str_count);
                    $Max_P_pcMaxtrixID = mysqli_fetch_row($cmd_count);
                    $pcCount = $Max_P_pcMaxtrixID[0] + 1;
                    $str_Imod = "INSERT INTO `p_b_main_inteldsg`(`IntelDSGID`, `MODELNAME`, `MODELCODE`,`LANG`,`STATUS`) value (" . $pcCount . ",'','" . $SEL_PMODEL . "','en-US','0')";
                    $cmd_Imod = mysqli_query($link_db, $str_Imod);
                }
            }
        }
        $cmd_skuu = mysqli_query($link_db, $str_skuu);
        $cmd_con_skus = mysqli_query($link_db, $str_con_skus);

        if (isset($_POST['aspectype']) != '') {
            foreach ($_POST['aspectype'] as $check_type) {

                $str_check = $check_type . "|";

                if (isset($_POST['aspecoption']) != '') {
                    foreach ($_POST['aspecoption'] as $check_option) {
                        if (preg_match("/" . $check_option . "/i", $str_check) != '') {

                            $str_result = strtr($check_option, $str_check, '');

                            $str_specvalues = "select Product_SKU_Auto_ID,SPECTypeID from `specvalues` where SPECTypeID=" . $check_type . " and Product_SKU_Auto_ID=" . $spec_mid;
                            $specvalues_cmd = mysqli_query($link_db, $str_specvalues);
                            $record_specvalues = mysqli_fetch_row($specvalues_cmd);
                            if (empty($record_specvalues)) :
                            else :
                                $str_chk = "select * from specvalues where instr(SPECValue,'" . $str_result . "')>0 and Product_SKU_Auto_ID=" . $spec_mid;
                                $cmd_chk = mysqli_query($link_db, $str_chk);
                                $record_chk = mysqli_fetch_row($cmd_chk);

                                if (empty($record_chk)) :
                                    $str_re = $str_result . ",";
                                    $str_sp1 = "update specvalues set `SPECValue`=concat(`SPECValue`,'" . $str_re . "') where SPECTypeID=" . $check_type . " and Product_SKU_Auto_ID=" . $spec_mid . ";";
                                //$cmd_sp1=mysqli_query($link_db,$str_sp1);
                                endif;

                            endif;
                            $Save_State = "ok";
                        }
                    }
                }
            }
        }

        //***** 2022.06.08 add ******
        $sel_partner = "SELECT * FROM partner_model WHERE SKU='" . $SKU_value . "'";
        $cmd_partner = mysqli_query($link_db, $sel_partner);
        $data_partner = mysqli_fetch_row($cmd_partner);
        if ($data_partner[0] != "") {
            $str_partner_model = "UPDATE partner_model SET `SKU`='" . $SKU_value . "',`Model`='" . $SEL_PMODEL . "', U_DATE='" . $now . "', Import_BE='1' WHERE ID='" . $data_partner[0] . "'";
            if (mysqli_query($link_db, $str_partner_model)) {
            } else {
                echo "<script>alert('partner_model Error (edit->update');self.location='default.php';</script>";
                exit();
            }
        } else {
            $str_partner_model = "INSERT INTO partner_model(ProductType, SKU, Model, Import_BE, C_DATE) VALUES ('" . $PT1 . "', '" . $SKU_value . "', '" . $SEL_PMODEL . "', '1', '" . $now . "')";
            if (mysqli_query($link_db, $str_partner_model)) {
            } else {
                echo "<script>alert('partner_model Error (edit->insert)');self.location='default.php';</script>";
                exit();
            }
        }

        //***** 2022.06.08 add end ******



        echo "<script>alert('Update Spec ok!');self.location='edit_spec.php?p_id=" . $spec_mid . "';</script>";
        exit();
    }
}

if (isset($_REQUEST['kinds']) == 'Categroies_set') {
    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
    mysqli_query($link_db, 'SET NAMES utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);

    $svalue = $_REQUEST['SPECCate_cid'];
    $sChk = $_REQUEST['SPECCate_Chk'];

    if ($sChk == 'true') {
        $sChk = 1;
    } else if ($sChk == 'false') {
        $sChk = '';
    }

    $str_c = "update SPECCategroies set IsShow='" . $sChk . "' where SPECCategoryID=" . $svalue;
    $Cresult = mysqli_query($link_db, $str_c);

    echo "<script>alert('Set SPECCategroies is Updated!');</script>";

    mysqli_close($link_db);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SPEC Creation Tool - Edit a SPEC</title>
    <link rel="stylesheet" type="text/css" href="../backend.css">

    <script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="../source/jquery.fancybox.js?v=2.0.6"></script>
    <link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.0.6" media="screen" />
    <link rel="stylesheet" type="text/css" href="../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
    <script type="text/javascript" src="../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
    <script type="text/javascript" src="../lib/hide_show.js"></script>

    <script type="text/javascript" src="jquery.cookie.js"></script>

    <script type="text/javascript">
        $(function() {

            $("#SEL_PMODEL").change(function() {
                if ($(this).val() == "Add") {
                    $("#model_add01").show();
                } else {
                    $("#model_add01").hide();
                }
            });

            $("#B_name01").click(function() {
                if ($(this).val() == "Edit") {
                    $("#brand_add01").show();
                } else {
                    $("#brand_add01").hide();
                }
            });

            $("#B_name02").click(function() {
                var MN = $("#brand_select").val();
                var MID = $("#ModelID").val();
                var S_model = $("#SEL_PMODEL").val();
                var skuvalue = $("#SKU_value").val();
                var PCateID = $("#PCateID").val();
                var url = "edit_models.php";
                if (MN != "") {
                    $("#MN_01").val(MN);
                    $("#brand_add01").hide();

                    $.ajax({
                        type: "post",
                        url: url,
                        dataType: "html",
                        data: {
                            MN,
                            MID,
                            S_model,
                            skuvalue,
                            PCateID
                        },
                        success: function(message) {
                            if (message == "refresh") {
                                window.location.reload(true);
                            } else {
                                alert(message);
                            }
                        }
                    });
                } else {
                    $("#MN_01").val("test");
                }
            });

            $("#SEL_PMT003").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show03").show();
                } else {
                    if ($("#SEL_PMT003").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_3').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_3').innerHTML = $("#SEL_PMT003").find("option:selected").text();
                    }
                    $("#PMT_Show03").hide();
                }
            });

            $("#SEL_PMT004").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show04").show();
                } else {
                    if ($("#SEL_PMT004").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_4').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_4').innerHTML = $("#SEL_PMT004").find("option:selected").text();
                    }
                    $("#PMT_Show04").hide();
                }
            });

            $("#SEL_PMT005").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show05").show();
                } else {
                    if ($("#SEL_PMT005").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_5').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_5').innerHTML = $("#SEL_PMT005").find("option:selected").text();
                    }
                    $("#PMT_Show05").hide();
                }
            });

            $("#SEL_PMT006").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show06").show();
                } else {
                    if ($("#SEL_PMT006").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_6').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_6').innerHTML = $("#SEL_PMT006").find("option:selected").text();
                    }
                    $("#PMT_Show06").hide();
                }
            });

            $("#SEL_PMT007").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show07").show();
                } else {
                    if ($("#SEL_PMT007").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_7').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_7').innerHTML = $("#SEL_PMT007").find("option:selected").text();
                    }
                    $("#PMT_Show07").hide();
                }
            });

            $("#SEL_PMT008").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show08").show();
                } else {
                    if ($("#SEL_PMT008").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_8').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_8').innerHTML = $("#SEL_PMT008").find("option:selected").text();
                    }
                    $("#PMT_Show08").hide();
                }
            });

            $("#SEL_PMT009").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show09").show();
                } else {
                    if ($("#SEL_PMT009").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_9').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_9').innerHTML = $("#SEL_PMT009").find("option:selected").text();
                    }
                    $("#PMT_Show09").hide();
                }
            });

            $("#SEL_PMT010").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show10").show();
                } else {
                    if ($("#SEL_PMT010").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_10').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_10').innerHTML = $("#SEL_PMT010").find("option:selected").text();
                    }
                    $("#PMT_Show10").hide();
                }
            });

            $("#SEL_PMT011").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show11").show();
                } else {
                    if ($("#SEL_PMT011").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_11').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_11').innerHTML = $("#SEL_PMT011").find("option:selected").text();
                    }
                    $("#PMT_Show11").hide();
                }
            });

            $("#SEL_PMT012").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show12").show();
                } else {
                    if ($("#SEL_PMT012").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_12').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_12').innerHTML = $("#SEL_PMT012").find("option:selected").text();
                    }
                    $("#PMT_Show12").hide();
                }
            });

            $("#SEL_PMT013").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show13").show();
                } else {
                    if ($("#SEL_PMT013").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_13').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_13').innerHTML = $("#SEL_PMT013").find("option:selected").text();
                    }
                    $("#PMT_Show13").hide();
                }
            });

            $("#SEL_PMT014").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show14").show();
                } else {
                    if ($("#SEL_PMT014").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_14').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_14').innerHTML = $("#SEL_PMT014").find("option:selected").text();
                    }
                    $("#PMT_Show14").hide();
                }
            });

            $("#SEL_PMT015").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show15").show();
                } else {
                    if ($("#SEL_PMT015").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_15').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_15').innerHTML = $("#SEL_PMT015").find("option:selected").text();
                    }
                    $("#PMT_Show15").hide();
                }
            });

            $("#SEL_PMT016").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show16").show();
                } else {
                    if ($("#SEL_PMT016").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_16').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_16').innerHTML = $("#SEL_PMT016").find("option:selected").text();
                    }
                    $("#PMT_Show16").hide();
                }
            });

            $("#SEL_PMT017").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show17").show();
                } else {
                    if ($("#SEL_PMT017").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_17').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_17').innerHTML = $("#SEL_PMT017").find("option:selected").text();
                    }
                    $("#PMT_Show17").hide();
                }
            });

            $("#SEL_PMT018").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show18").show();
                } else {
                    if ($("#SEL_PMT018").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_18').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_18').innerHTML = $("#SEL_PMT018").find("option:selected").text();
                    }
                    $("#PMT_Show18").hide();
                }
            });

            $("#SEL_PMT019").change(function() {
                if ($(this).val() == "Add") {
                    $("#PMT_Show19").show();
                } else {
                    if ($("#SEL_PMT019").find("option:selected").text() == '-- Select --') {
                        document.getElementById('alink_19').innerHTML = "Mod";
                    } else {
                        document.getElementById('alink_19').innerHTML = $("#SEL_PMT019").find("option:selected").text();
                    }
                    $("#PMT_Show19").hide();
                }
            });

        });
    </script>
    <script type="text/javascript">
        $(function() {
            $("#SEL_PN1").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add1").show();
                    $("#SSMN1_1").val("");
                } else {
                    $("#SKUPN_add1").hide();
                }
            });

            $("#SEL_PN2").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add2").show();
                    $("#SSMN1_2").val("");
                } else {
                    $("#SKUPN_add2").hide();
                }
            });

            $("#SEL_PN3").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add3").show();
                    $("#SSMN1_3").val("");
                } else {
                    $("#SKUPN_add3").hide();
                }
            });

            $("#SEL_PN4").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add4").show();
                    $("#SSMN1_4").val("");
                } else {
                    $("#SKUPN_add4").hide();
                }
            });

            $("#SEL_PN5").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add5").show();
                    $("#SSMN1_5").val("");
                } else {
                    $("#SKUPN_add5").hide();
                }
            });

            $("#SEL_PN6").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add6").show();
                    $("#SSMN1_6").val("");
                } else {
                    $("#SKUPN_add6").hide();
                }
            });

            $("#SEL_PN7").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add7").show();
                    $("#SSMN1_7").val("");
                } else {
                    $("#SKUPN_add7").hide();
                }
            });

            $("#SEL_PN8").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add8").show();
                    $("#SSMN1_8").val("");
                } else {
                    $("#SKUPN_add8").hide();
                }
            });

            $("#SEL_PN9").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add9").show();
                    $("#SSMN1_9").val("");
                } else {
                    $("#SKUPN_add9").hide();
                }
            });

            $("#SEL_PN10").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add10").show();
                    $("#SSMN1_10").val("");
                } else {
                    $("#SKUPN_add10").hide();
                }
            });

            $("#SEL_PN11").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add11").show();
                    $("#SSMN1_11").val("");
                } else {
                    $("#SKUPN_add11").hide();
                }
            });

            $("#SEL_PN12").change(function() {
                if ($(this).val() == "Add") {
                    $("#SKUPN_add12").show();
                    $("#SSMN1_12").val("");
                } else {
                    $("#SKUPN_add12").hide();
                }
            });
            //}
        });
    </script>

    <script>
        $(function() {

            $("#SSMNBtn1").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT1").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn2").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {} else {
                            $("#SubSKUs_MGT2").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn3").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {} else {
                            $("#SubSKUs_MGT3").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn4").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {} else {
                            $("#SubSKUs_MGT4").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn5").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT5").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn6").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT6").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn7").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT7").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn8").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT8").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn9").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT9").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn10").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT10").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn11").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT11").html(data);
                        }
                    }
                });
            });

            $("#SSMNBtn12").click(function() {
                var params = $('input').serialize();
                var url = "add_SubSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh_sub") {
                            //window.location.reload(true);
                        } else {
                            $("#SubSKUs_MGT12").html(data);
                        }
                    }
                });
            });

        });
    </script>


    <script type="text/javascript">
        $(function() {

            $("#MNBtn").click(function() {
                var params = $('input').serialize();
                var url = "add_models.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(data) {
                        if (data == "refresh") {
                            window.location.reload(true);
                        } else {
                            $("#Model_MGT").html(data);
                        }
                    }
                });
            });

        });
    </script>
    <script type="text/javascript">
        $(function() {

            $("#SKU_value").change(function() {
                var params = $('input').serialize();
                var url = "ValiSKU.php";

                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "html",
                    data: params,
                    success: function(msg) {
                        $("#divAccount").html(msg);
                    }
                });
            });


        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            /*
             *  Simple image gallery. Uses default settings
             */

            $('.fancybox').fancybox();

            /*
             *  Different effects
             */

            // Change title type, overlay opening speed and opacity
            $(".fancybox-effects-a").fancybox({
                helpers: {
                    title: {
                        type: 'outside'
                    },
                    overlay: {
                        speedIn: 500,
                        opacity: 0.95
                    }
                }
            });

            // Disable opening and closing animations, change title type
            $(".fancybox-effects-b").fancybox({
                openEffect: 'none',
                closeEffect: 'none',

                helpers: {
                    title: {
                        type: 'over'
                    }
                }
            });

            // Set custom style, close if clicked, change title type and overlay color
            $(".fancybox-effects-c").fancybox({
                wrapCSS: 'fancybox-custom',
                closeClick: true,

                helpers: {
                    title: {
                        type: 'inside'
                    },
                    overlay: {
                        css: {
                            'background-color': '#eee'
                        }
                    }
                }
            });

            // Remove padding, set opening and closing animations, close if clicked and disable overlay
            $(".fancybox-effects-d").fancybox({
                padding: 0,

                openEffect: 'elastic',
                openSpeed: 150,

                closeEffect: 'elastic',
                closeSpeed: 150,

                closeClick: true,

                helpers: {
                    overlay: null
                }
            });

            /*
             *  Button helper. Disable animations, hide close button, change title type and content
             */

            $('.fancybox-buttons').fancybox({
                openEffect: 'none',
                closeEffect: 'none',

                prevEffect: 'none',
                nextEffect: 'none',

                closeBtn: false,

                helpers: {
                    title: {
                        type: 'inside'
                    },
                    buttons: {}
                },

                afterLoad: function() {
                    this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
                }
            });


            /*
             *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
             */

            $('.fancybox-thumbs').fancybox({
                prevEffect: 'none',
                nextEffect: 'none',

                closeBtn: false,
                arrows: false,
                nextClick: true,

                helpers: {
                    thumbs: {
                        width: 50,
                        height: 50
                    }
                }
            });

            /*
             *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
             */
            $('.fancybox-media')
                .attr('rel', 'media-gallery')
                .fancybox({
                    openEffect: 'none',
                    closeEffect: 'none',
                    prevEffect: 'none',
                    nextEffect: 'none',

                    arrows: false,
                    helpers: {
                        media: {},
                        buttons: {}
                    }
                });

            /*
             *  Open manually
             */

            $("#fancybox-manual-a").click(function() {
                $.fancybox.open('1_b.jpg');
            });

            $("#fancybox-manual-b").click(function() {
                $.fancybox.open({
                    href: 'iframe.html',
                    type: 'iframe',
                    padding: 5
                });
            });

            $("#fancybox-manual-c").click(function() {
                $.fancybox.open([{
                    href: '1_b.jpg',
                    title: 'My title'
                }, {
                    href: '2_b.jpg',
                    title: '2nd title'
                }, {
                    href: '3_b.jpg'
                }], {
                    helpers: {
                        thumbs: {
                            width: 75,
                            height: 50
                        }
                    }
                });
            });


        });
    </script>

    <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>

    <script language="JavaScript">
        <?php
        for ($P = 1; $P < 18; $P++) {
            if (strlen($P) > 1) {
                $P = $P;
            } else {
                $P = "0" . $P;
            }
        ?>

            function show_PMA<?= $P ?>() {
                var s_value = '<?= $P ?>';
                $("#PMA_ADD" + s_value + "").show();
                single_SW(s_value);
            }

            function Close_PMA<?= $P ?>() {
                var s_value = '<?= $P ?>';
                $("#PMA_ADD" + s_value + "").hide();
            }
        <?php
        }
        ?>

        function single_SW(num) {
            var ck;
            for (ck = 1; ck < 18; ck++) {

                cks = ck.toString(); //數字轉字串

                if (cks.length > 1) {
                    cks = cks;
                } else {
                    cks = "0" + cks;
                }
                if (num == cks) {} else {
                    $("#PMA_ADD" + cks + "").hide();
                }

            }
        }

        function Add_Finish() {
            $("#submitbutton01").prop('disabled', true);
            $("#Previewbutton01").prop('disabled', false);
            $("#pdfbutton01").prop('disabled', false);
        }

        function MM_o(selObj) {
            window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value, "_self");
        }
    </script>
    <script type="text/javascript">
    </script>

    <script>
        <!--
        function check_id(speca_id, speca_name, icount) {
            if (confirm("確定要設定 此 Category 在 " + speca_name + " SPEC 的顯示或關閉嗎？")) {
                var checkItem = document.getElementsByName("checkall");
                self.location = "?kinds=Categroies_set&SPECCate_cid=" + speca_id + "&SPECCate_Chk=" + checkItem[icount - 1].checked;
            } else {
                alert("取消操作!");
            }

        }
        //
        -->
    </script>
    <script type="text/javascript">
        function SPEC_Check() {

            if (document.form1.SEL_PTYPE.value == "") {
                $("#PTYPE_error").html('<span class="w12red">(Required select a product type. )</span>');
                document.form1.SEL_PTYPE.focus();
                return false;
            }

            if (document.form1.PT1.value == "") {
                alert("Required select a product type.");
                document.form1.PT1.focus();
                return false;
            }

            if (document.form1.SEL_PMODEL.value == "" || document.form1.SEL_PMODEL.value == "Add") {
                $("#Model_error").html('<span class="w12red">(Required selection or create a model. )</span>');
                document.form1.SEL_PMODEL.focus();
                return false;
            }

            if (document.form1.SKU_value.value == "") {
                $("#Model_error").html('');
                $("#SKU_error").html('<span class="w12red">(Required field. )</span>');
                document.form1.SKU_value.focus();
                return false;
            }
            /*
            if(document.form1.SEL_PMatrix.value == "") {
            alert("Please select a Matrix Category.");
            document.form1.SEL_PMatrix.focus();
            return false;
            }
            */
            return true;
        }

        function Clear_Cookies_values() {
            var str_u;
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


        function Set_Cookies_values() {
            var str_u;

            if ($.cookie("SKU_value01") != null) {
                document.getElementById("SKU_value").value = $.cookie("SKU_value01");
            }
            if ($.cookie("UPC_value01") != null) {
                document.getElementById("UPC_value").value = $.cookie("UPC_value01");
            }
            if ($("#SEL_PN1").length > 0 && $.cookie("#SEL_PN1") != null) {
                document.getElementById("SEL_PN1").value = $.cookie("SEL_PN1");
            }
            if ($("#SEL_PN2").length > 0 && $.cookie("#SEL_PN2") != null) {
                document.getElementById("SEL_PN2").value = $.cookie("SEL_PN2");
            }
            if ($("#SEL_PN3").length > 0 && $.cookie("#SEL_PN3") != null) {
                document.getElementById("SEL_PN3").value = $.cookie("SEL_PN3");
            }
            if ($("#SEL_PN4").length > 0 && $.cookie("#SEL_PN4") != null) {
                document.getElementById("SEL_PN4").value = $.cookie("SEL_PN4");
            }
            if ($("#SEL_PN5").length > 0 && $.cookie("#SEL_PN5") != null) {
                document.getElementById("SEL_PN5").value = $.cookie("SEL_PN5");
            }
            if ($("#SEL_PN6").length > 0 && $.cookie("#SEL_PN6") != null) {
                document.getElementById("SEL_PN6").value = $.cookie("SEL_PN6");
            }
            if ($("#SEL_PN7").length > 0 && $.cookie("#SEL_PN7") != null) {
                document.getElementById("SEL_PN7").value = $.cookie("SEL_PN7");
            }
            if ($("#SEL_PN8").length > 0 && $.cookie("#SEL_PN8") != null) {
                document.getElementById("SEL_PN8").value = $.cookie("SEL_PN8");
            }
            if ($("#SEL_PN9").length > 0 && $.cookie("#SEL_PN9") != null) {
                document.getElementById("SEL_PN9").value = $.cookie("SEL_PN9");
            }
            if ($("#SEL_PN10").length > 0 && $.cookie("#SEL_PN10") != null) {
                document.getElementById("SEL_PN10").value = $.cookie("SEL_PN10");
            }
            if ($("#SEL_PN11").length > 0 && $.cookie("#SEL_PN11") != null) {
                document.getElementById("SEL_PN11").value = $.cookie("SEL_PN11");
            }


            for (str_u = 3; str_u < 20; str_u++) {
                str_u1 = str_u.toString();

                if (str_u1.length > 1) {

                    var str_checked = $.cookie("c_seVal" + str_u1);

                    for (i = 0; i < document.getElementById('SEL_PMT0' + str_u1).length; i++) {
                        if (document.getElementById('SEL_PMT0' + str_u1).options[i].text == str_checked) {
                            document.getElementById('SEL_PMT0' + str_u1).selectedIndex = i;

                            if (str_checked != "-- Select --") {
                                document.getElementById('alink_' + str_u1).innerHTML = str_checked;
                            }

                        }
                    }

                } else {
                    ch_k = "0" + str_u1;
                    var str_s = $.cookie("c_seVal" + ch_k);

                    for (ii = 0; ii < document.getElementById('SEL_PMT0' + ch_k).length; ii++) {
                        if (document.getElementById('SEL_PMT0' + ch_k).options[ii].text == str_s) {
                            document.getElementById('SEL_PMT0' + ch_k).selectedIndex = ii;

                            if (str_s != "-- Select --") {
                                document.getElementById('alink_' + str_u1).innerHTML = str_s;
                            }

                        }
                    }
                }

            }

        }

        function Add_Matrvalue(n, sku, pid) {
            var num;
            var chk_n;
            var str;
            var str_t;
            var str_mval;
            var str_sval;
            var str_uval;

            $.cookie("SKU_value01", $("#SKU_value").val());
            $.cookie("UPC_value01", $("#UPC_value").val());

            if ($("#SEL_PN1").length > 0) {
                $.cookie("SEL_PN1", $("#SEL_PN1").find("option:selected").val());
            }
            if ($("#SEL_PN2").length > 0) {
                $.cookie("SEL_PN2", $("#SEL_PN2").find("option:selected").val());
            }
            if ($("#SEL_PN3").length > 0) {
                $.cookie("SEL_PN3", $("#SEL_PN3").find("option:selected").val());
            }
            if ($("#SEL_PN4").length > 0) {
                $.cookie("SEL_PN4", $("#SEL_PN4").find("option:selected").val());
            }
            if ($("#SEL_PN5").length > 0) {
                $.cookie("SEL_PN5", $("#SEL_PN5").find("option:selected").val());
            }
            if ($("#SEL_PN6").length > 0) {
                $.cookie("SEL_PN6", $("#SEL_PN6").find("option:selected").val());
            }
            if ($("#SEL_PN7").length > 0) {
                $.cookie("SEL_PN7", $("#SEL_PN7").find("option:selected").val());
            }
            if ($("#SEL_PN8").length > 0) {
                $.cookie("SEL_PN8", $("#SEL_PN8").find("option:selected").val());
            }
            if ($("#SEL_PN9").length > 0) {
                $.cookie("SEL_PN9", $("#SEL_PN9").find("option:selected").val());
            }
            if ($("#SEL_PN10").length > 0) {
                $.cookie("SEL_PN10", $("#SEL_PN10").find("option:selected").val());
            }

            ns = n.toString();

            for (str_uval = 3; str_uval < 20; str_uval++) {
                if (ns == str_uval) {

                    str_si = str_uval.toString();
                    if (str_si.length > 1) {
                        $.cookie("c_seVal" + str_si, $("#PMS_" + str_si + "").val());
                    } else {
                        chk_ss = "0" + str_si;
                        $.cookie("c_seVal" + chk_ss, $("#PMS_" + chk_ss + "").val());
                    }

                } else {
                    str_i = str_uval.toString();
                    if (str_i.length > 1) {
                        $.cookie("c_seVal" + str_i, $("#SEL_PMT0" + str_i + "").find("option:selected").text());
                    } else {
                        chk_s = "0" + str_i;
                        $.cookie("c_seVal" + chk_s, $("#SEL_PMT0" + chk_s + "").find("option:selected").text());

                    }
                }
            }


            if (ns.length > 1) {
                str = $("#PMS_" + ns).val();
                str_t = $("#PMS_" + ns + "U").val();
            } else {
                chk_n = "0" + ns;
                str = $("#PMS_" + chk_n + "").val().toString();
                str = str.replace("+", "±");
                str_t = $("#PMS_" + chk_n + "U").val();
            }
            str_cate = $("#SEL_PMatrix").val();


            switch (n) {
                case 3:
                    if (pid == 101 || pid == 102) {
                        str_mval = 1;
                        str_sval = "";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 9;
                        str_sval = "H";
                    } else if (pid == 0106) {
                        str_mval = 1;
                        str_sval = "";
                    }
                    break;
                case 4:
                    if (pid == 101 || pid == 102) {
                        str_mval = 2;
                        str_sval = "";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 9;
                        str_sval = "W";
                    } else if (pid == 0106) {
                        str_mval = 9;
                        str_sval = "W";
                    }
                    break;
                case 5:
                    if (pid == 101 || pid == 102) {
                        str_mval = 3;
                        str_sval = "";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 9;
                        str_sval = "D";
                    } else if (pid == 0106) {
                        str_mval = 9;
                        str_sval = "D";
                    }
                    break;
                case 6:
                    if (pid == 101 || pid == 102) {
                        str_mval = 4;
                        str_sval = "PCI-X";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 10;
                        str_sval = "";
                    } else if (pid == 0106) {
                        str_mval = 3;
                        str_sval = "";
                    }
                    break;
                case 7:
                    if (pid == 101 || pid == 102) {
                        str_mval = 4;
                        str_sval = "PCI";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 11;
                        str_sval = "";
                    } else if (pid == 0106) {
                        str_mval = 14;
                        str_sval = "";
                    }
                    break;
                case 8:
                    if (pid == 101 || pid == 102) {
                        str_mval = 4;
                        str_sval = "PCIe";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 5;
                        str_sval = "Max.";
                    } else if (pid == 0106) {
                        str_mval = 15;
                        str_sval = "";
                    }
                    break;
                case 9:
                    if (pid == 101 || pid == 102) {
                        str_mval = 5;
                        str_sval = "Max.";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 5;
                        str_sval = "Type";
                    } else if (pid == 0106) {
                        str_mval = 16;
                        str_sval = "Int. Port";
                    }
                    break;
                case 10:
                    if (pid == 101 || pid == 102) {
                        str_mval = 5;
                        str_sval = "Type";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 12;
                        str_sval = "Max.";
                    } else if (pid == 0106) {
                        str_mval = 16;
                        str_sval = "Ext. Port (X)";
                    }
                    break;
                case 11:
                    str_mval = 6;
                    if (pid == 101 || pid == 102) {
                        str_sval = "Audio (A)";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 12;
                        str_sval = "Type";
                    } else if (pid == 0106) {
                        str_mval = 6;
                        str_sval = "S/W RAID (SR)";
                    }
                    break;
                case 12:
                    if (pid == 101 || pid == 102) {
                        str_mval = 6;
                        str_sval = "Video (G)";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 12;
                        str_sval = "H/F";
                    } else if (pid == 0106) {
                        str_mval = 6;
                        str_sval = "H/W RAID (HR)";
                    }
                    break;
                case 13:
                    if (pid == 101 || pid == 102) {
                        str_mval = 6;
                        str_sval = "LAN (N)";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 13;
                        str_sval = "GbE";
                    } else if (pid == 0106) {
                        str_mval = 6;
                        str_sval = "Enhanced RAID (E)";
                    }
                    break;
                case 14:
                    if (pid == 101 || pid == 102) {
                        str_mval = 6;
                        str_sval = "RAID (R)";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 13;
                        str_sval = "10GbE";
                    } else if (pid == 0106) {
                        str_mval = 17;
                        str_sval = "";
                    }
                    break;
                case 15:
                    if (pid == 101 || pid == 102) {
                        str_mval = 7;
                        str_sval = "Server Mgmt.";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 4;
                        str_sval = "PCI-X";
                    } else if (pid == 0106) {
                        str_mval = 8;
                        str_sval = "RoHS (Type)";
                    }
                    break;
                case 16:
                    if (pid == 101 || pid == 102) {
                        str_mval = 8;
                        str_sval = "RoHS (Type)";
                    } else if (pid == 103 || pid == 104) {
                        str_mval = 4;
                        str_sval = "PCI";
                    }
                    break;
                case 17:
                    if (pid == 103 || pid == 104) {
                        str_mval = 4;
                        str_sval = "PCIe";
                    }
                    break;
                case 18:
                    if (pid == 103 || pid == 104) {
                        str_mval = 7;
                        str_sval = "Server Mgmt.";
                    }
                    break;
                case 19:
                    if (pid == 103 || pid == 104) {
                        str_mval = 8;
                        str_sval = "RoHS (Type)";
                    }
                    break;
            }
            pms_num = n - 2;
            self.location = "?Mart_type=Add&str_val1=" + str + "&str_val2=" + str_mval + "&str_val3=" + str_sval + "&sku_id=" + sku + "&str_val4=" + pms_num + "&str_val5=" + str_t + "&str_val6=" + str_cate;
            return false;
        }
    </script>

</head>

<body>
    <a name="top"></a>
    <div>
        <div class="left">
            <h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1>
        </div>

        <div id="logout">Hi <b>
                <?php
                echo str_replace('@mic.com.tw', '', $_SESSION['user']);
                ?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
    </div>

    <div class="clear"></div>
    <?php
    include("./menu.php");
    ?>

    <div class="clear"></div>

    <div id="Search">
        <h2><a href="default.php">Product SPEC</a>&nbsp;&gt;&nbsp; Edit a SPEC </h2>
    </div>
    <?php
    if (isset($_REQUEST['p_id']) != '') {
        $p_SKU = $_REQUEST['p_id'];
    } else {
        $p_SKU = "";
    }

    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
    mysqli_query($link_db, 'SET NAMES utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);
    $str_sku_m = "select `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE`, `NetWorking`, `SAS`, `FormFactor`, `Riser`, `HDD_Bay`, `PSU`, `Host_IF`, `Conn_Type`, `Conn_Qty`, `UPCcode`, `FAN`, `IS_EOL`, `Web_Disable`, `GUID`, `crea_d`, `crea_u`, `upd_d`, `upd_u`, `slang`, `SKU_CategorySort`, `SKU_Type`, `MODELDESCRIPT`, `PCI-E_slot`, `Chip`, `IS_BTO`, `COMPARE`, `REQUEST_QUOTE` from product_skus where Product_SKU_Auto_ID=" . $p_SKU;
    $cmd_sku_m = mysqli_query($link_db, $str_sku_m);
    $record_sku_m = mysqli_fetch_row($cmd_sku_m);
    if (empty($record_sku_m)) :

    else :
        $SM0 = "";
        $SM1 = "";
        $SM2 = "";
        $SM3 = "";
        $SM4 = "";
        $SM5 = "";
        $SM6 = "";
        $SM7 = "";
        $SM8 = "";
        $SM9 = "";
        $SM10 = "";
        $SM11 = "";
        $SM12 = "";
        $SM13 = "";
        $SM14 = "";
        $SM15 = "";
        $SM0 = $record_sku_m[1];
        $SM1 = $record_sku_m[2];
        $SM2 = $record_sku_m[3];

        if ($SM0 == 101 || $SM0 == 102) {
            $SM3 = $record_sku_m[4];
            $SM4 = $record_sku_m[5];
            $SM5 = $record_sku_m[6];
        } else if ($SM0 == 103) {
            $SM3 = $record_sku_m[8];
            $SM4 = $record_sku_m[9];
            $SM5 = $record_sku_m[26];
        } else if ($SM0 == 104) {
            $SM3 = $record_sku_m[7];
            $SM4 = $record_sku_m[8];
            $SM5 = $record_sku_m[9];
        } else if ($SM0 == 105) {
            $SM3 = $record_sku_m[10];
            $SM4 = $record_sku_m[11];
            $SM5 = $record_sku_m[12];
        } else if ($SM0 == 0106) {
            $SM3 = $record_sku_m[10];
            $SM4 = $record_sku_m[11];
            $SM5 = $record_sku_m[12];
        } else if ($SM0 == 107) {
            $SM3 = $record_sku_m[8];
            $SM4 = $record_sku_m[9];
            $SM5 = $record_sku_m[14];
        } else if ($SM0 == 108) {
            $SM3 = $record_sku_m[8];
            $SM4 = $record_sku_m[9];
            if ($record_sku_m[26] != '') {
                $SM5 = $record_sku_m[26];
            } else {
                $SM5 = $record_sku_m[4];
            }
        } else if ($SM0 == 117) {
            $SM3 = $record_sku_m[8];
            $SM4 = $record_sku_m[9];
            $SM5 = $record_sku_m[14];
        } else if ($SM0 == 1109) {
            $SM3 = $record_sku_m[27];
            $SM4 = "";
            $SM5 = "";
        } else if ($SM0 == 1111) {
            $SM3 = $record_sku_m[10];
            $SM4 = $record_sku_m[11];
            $SM5 = $record_sku_m[12];
        } else if ($SM0 == 1112) {
            $SM3 = $record_sku_m[10];
            $SM4 = $record_sku_m[11];
            $SM5 = $record_sku_m[12];
        } else if ($SM0 == 1113) {
            $SM3 = $record_sku_m[10];
            $SM4 = $record_sku_m[11];
            $SM5 = $record_sku_m[12];
        }

        $SM6 = $record_sku_m[13];
        $SM7 = $record_sku_m[14];
        $SM8 = $record_sku_m[15];
        $SM9 = $record_sku_m[16];
        $SM10 = $record_sku_m[18];
        $SM11 = $record_sku_m[19];
        $SM12 = $record_sku_m[22];
        $SM13 = $record_sku_m[23];
        $SM14 = $record_sku_m[24];
        $SM15 = $record_sku_m[25];
        $SM16 = $record_sku_m[28];
        $compare = $record_sku_m[29];
        $quote = $record_sku_m[30];
    endif;
    ?>

    <div id="content">
        <br />
        <h3> Basic Settings:</h3>
        <hr class="style-four" />

        <p class="clear"></p>
        <?php
        $EPType_id = "";
        if (isset($_REQUEST['PType_id']) <> '') {
            $EPType_id = intval($_REQUEST['PType_id']);
        } else {
            $EPType_id = $SM0;
        }
        ?>
        <form id="form1" name="form1" method="post" action="?methods=update_spec" onsubmit="return SPEC_Check();">
            <input type="hidden" name="spec_mid" value="<?= $p_SKU; ?>">
            <table class="addspec">
                <tr>
                    <th>Product Type:</th>
                    <td>
                        <p>
                            <select id="SEL_PTYPE" name="SEL_PTYPE" onChange="MM_o(this)">
                                <?php
                                $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                                mysqli_query($link_db, 'SET NAMES utf8');
                                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                                //$select=mysqli_select_db($dataBase, $link_db);
                                $str_type = "select b.ProductTypeID,a.ProductCateID,a.ProductCateName from productcategories a inner join producttypes b on a.ProductCateName=b.ProductTypeName where b.ProductTypeID=" . $SM0;
                                $type_result = mysqli_query($link_db, $str_type);
                                list($ProductTypeID, $ProductCateID, $ProductCateName) = mysqli_fetch_row($type_result)
                                ?>
                                <option value="edit_spec.php?p_id=<?= $p_SKU ?>&PCate_id=<?= $ProductCateID ?>&PType_id=<?= $ProductTypeID ?>" <?php if ($EPType_id == $ProductTypeID || $SM0 == $ProductTypeID) {
                                                                                                                                                echo "selected";
                                                                                                                                            } ?>><?= $ProductCateName ?></option>
                                <?php
                                mysqli_close($link_db);
                                ?>
                            </select>
                        <div id="PTYPE_error"></div>
                        <?php
                        $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                        mysqli_query($link_db, 'SET NAMES utf8');
                        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                        //$select=mysqli_select_db($dataBase, $link_db);
                        $str_type = "select b.ProductTypeID,a.ProductCateID,a.ProductCateName from productcategories a inner join producttypes b on a.ProductCateName=b.ProductTypeName where b.ProductTypeID=" . $SM0;
                        $type_result = mysqli_query($link_db, $str_type);
                        list($ProductTypeID, $ProductCateID, $ProductCateName) = mysqli_fetch_row($type_result);

                        if (isset($_REQUEST['PCate_id']) <> '') {
                            $EPCate_id = intval($_REQUEST['PCate_id']);
                        } else {
                            $EPCate_id = $ProductCateID;
                        }
                        ?>
                        <input type="hidden" name="PT1" value="<?= $EPType_id; ?>">&nbsp;
                        </p>
                    </td>
                </tr>

                <tr style="background:#fcd2e4">
                    <th>Brand Name:</th>
                    <td>
                        <?php
                        $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                        mysqli_query($link_db, 'SET NAMES utf8');
                        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                        //$select=mysqli_select_db($dataBase, $link_db);
                        if (isset($_REQUEST['PCate_id']) <> '') {
                            $str_model = "select ModelName, ModelID from product_models where ProductCateID=" . intval($_REQUEST['PCate_id']) . " and ModelCode = '" . $SM2 . "' and SKU = '" . $SM1 . "' order by ModelCode";
                        } else {
                            $str_model = "select ModelName, ModelID from product_models where ProductCateID=" . $ProductCateID . " and ModelCode = '" . $SM2 . "' and SKU = '" . $SM1 . "' order by ModelCode";
                        }
                        //$str_bname = "Select BRANDNAME FROM brand_name where 1";
                        $model_result = mysqli_query($link_db, $str_model);
                        if (mysqli_num_rows($model_result) < 1) {
                            if (isset($_REQUEST['PCate_id']) <> '') {
                                $str_model = "select ModelName, ModelID from product_models where ProductCateID=" . intval($_REQUEST['PCate_id']) . " and ModelCode = '" . $SM2 . "' order by ModelCode";
                            } else {
                                $str_model = "select ModelName, ModelID from product_models where ProductCateID=" . $ProductCateID . " and ModelCode = '" . $SM2 . "' order by ModelCode";
                            }
                            $model_result = mysqli_query($link_db, $str_model);
                        }

                        $Model_code = mysqli_fetch_row($model_result);
                        ?>
                        <input type="text" id="MN_01" name="MN_01" disabled="true" style="background-color:#cccccc" value="<?= $Model_code[0]; ?>" />&nbsp;&nbsp;
                        <input type="hidden" id="ModelID" name="ModelID" value="<?= $Model_code[1] ?>">
                        <input type="hidden" id="PCateID" name="PCateID" value="<?= $ProductCateID ?>">
                        <input id="B_name01" name="B_name01" type="button" value="Edit">
                        <div id="brand_add01" style="display:none">Brand Name:
                            <select id="brand_select" name="brand_select">
                                <option selected="selected">Select from extisting: </option>
                                <?php
                                $str_bname = "Select BRANDNAME FROM brand_name where 1";
                                $bname_result1 = mysqli_query($link_db, $str_bname);
                                while (list($BRANDNAME) = mysqli_fetch_row($bname_result1)) {
                                ?>
                                    <option value="<?= $BRANDNAME; ?>"><?= $BRANDNAME; ?></option>
                                <?php
                                }
                                mysqli_close($link_db);
                                ?>
                            </select>
                            &nbsp;&nbsp;<input id="B_name02" type="button" value="OK">
                        </div>
                    </td>
                </tr>

                <tr style="background:#fcd2e4">
                    <th>Model:</th>
                    <td>
                        <div style="color:#c00; font-weight:bold">(** Be sure to add/edit after finishing "SPEC Settings".) </div>
                        <select id="SEL_PMODEL" name="SEL_PMODEL">
                            <option selected="selected">Select from extisting: </option>
                            <?php
                            ?>
                            <option value="Add">Add New</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            if (isset($_REQUEST['PCate_id']) <> '') {
                                $str_model = "select DISTINCT ModelCode from product_models where ProductCateID=" . intval($_REQUEST['PCate_id']) . " order by ModelCode";
                            } else {
                                $str_model = "select DISTINCT ModelCode from product_models where ProductCateID=" . $ProductCateID . " order by ModelCode";
                            }
                            $Model_result = mysqli_query($link_db, $str_model);
                            while (list($ModelCode, $SKU) = mysqli_fetch_row($Model_result)) {
                            ?>
                                <option value="<?= $ModelCode; ?>" <?php //if($SM2==$ModelCode) { echo "selected"; }
                                                                    ?><?php /*if($SM1==$SKU) { echo "selected"; } else*/ if ($SM2 == $ModelCode) {
                                                                                                                            echo "selected";
                                                                                                                        } ?>><?= $ModelCode; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp; <div id="model_add01" style="display:none">Model Code: <input type="text" name="MN_02" size="20"> <input type="hidden" name="MN_03" value="<?= $EPCate_id ?>"><input id="MNBtn" type="button" value="Done" /></div>
                        <div id="Model_MGT"></div>
                        <div id="Model_error"></div>
                        <div class="dropdown_box" id="example">
                            <input name="" type="text" size="30" value="" />&nbsp;&nbsp;<input name="" type="button" value="OK" /> &nbsp;&nbsp;<a href="" id="example-hide" class="hideLink" onclick="showHide('example');return false;">Cancel </a>
                        </div>
                    </td>
                </tr>

                <tr style="background:#fcd2e4">
                    <th>SKU:</th>
                    <td>
                        <div style="color:#c00; font-weight:bold">(** Be sure to add/edit after finishing "SPEC Settings".) </div>
                        <p><input id="SKU_value" name="SKU_value" type="text" size="30" value="<?= $SM1; ?>" />&nbsp;&nbsp;
                        <div id="divAccount"></div>
                        <div id="SKU_error"></div>
                        </p>
                        <p>UPC code: <input id="UPC_value" name="UPC_value" type="text" size="30" value="<?= $SM6; ?>" /></p>
                        <!--end of Grouping Conditions settings -->
                    </td>
                </tr>

            </table>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="clear"></p>

            <?php
            if (isset($_REQUEST['PType_id']) <> '') {
                $EPType_id = intval($_REQUEST['PType_id']);
            } else {
                $EPType_id = $SM0;
            }
            ?>
            <h3>SPEC Details:</h3>
            <hr class="style-four" />
            <p class="clear"></p>
            <br />
            <p class="clear"></p>

            <?php
            if ($EPType_id <> "") {
            ?>
                <table class="pro_spec_bk">
                    <thead>
                        <tr>
                            <th>Categories <a href="Categories_ESortable.php?SKU_id=<?= $p_SKU ?>&PType_id=<?= $EPType_id; ?>" class="fancybox fancybox.iframe">
                                    <font size="2">(Order)</font>
                                </a></th>
                            <th>Types / Options</th>
                        </tr>
                    </thead>

                    <?php
                    $data_SPEC = "";
                    $data_type_s = "";
                    $data_SPEC_cs = "";
                    $data_option_s = "";
                    $data_option_s = "";
                    $data_optionc_s = "";
                    $data_SPEC1 = "";
                    $data_spec_str = "";

                    $SPECType_numAll = "";
                    $SPECType_num = "";
                    $ParentSpec_va_all_Sub = "";
                    $ParentSpec_va_all_Thr = "";
                    $ParentSpec_va_all_ThrChk = "";

                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_type_sp = "select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=" . $EPType_id;
                    $type_result_sp = mysqli_query($link_db, $str_type_sp);
                    $data_pp = mysqli_fetch_row($type_result_sp);
                    mysqli_close($link_db);

                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_SPECCat_s = "select distinct b.SPECCategoryID from `specvalues` a inner join spectypes b on a.SPECTypeID=b.SPECTypeID where Product_SKU_Auto_ID=" . $p_SKU;
                    $SPECCat_result_s = mysqli_query($link_db, $str_SPECCat_s);
                    while ($data_scc = mysqli_fetch_row($SPECCat_result_s)) {
                        $data_SPEC .= $data_scc[0] . ",";
                    }
                    mysqli_close($link_db);

                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_type_s = "select a.SPECTypeID from `specvalues` a inner join spectypes b on a.SPECTypeID=b.SPECTypeID where a.SPECValue<>'' and Product_SKU_Auto_ID=" . $p_SKU;
                    $type_result_s = mysqli_query($link_db, $str_type_s);
                    while ($data_p = mysqli_fetch_row($type_result_s)) {
                        $data_type_s .= $data_p[0] . ",";
                    }
                    mysqli_close($link_db);

                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_SPECCat_cs = "select distinct SPECCategoryID from spectypes where (INSTR('" . $data_type_s . "',SPECTypeID)>0)";
                    $SPECCat_result_cs = mysqli_query($link_db, $str_SPECCat_s);
                    while ($data_sccs = mysqli_fetch_row($SPECCat_result_cs)) {
                        $data_SPEC_cs .= $data_sccs[0] . ",";
                    }
                    mysqli_close($link_db);

                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_option_s = "select SPECValue from `specvalues` where SPECValue<>'' and Product_SKU_Auto_ID=" . $p_SKU;
                    $option_result_s = mysqli_query($link_db, $str_option_s);
                    while ($data_opt = mysqli_fetch_row($option_result_s)) {
                        $data_option_s .= $data_opt[0] . ",";
                    }
                    mysqli_close($link_db);

                    $data_option_s = strtr($data_option_s, ',,', ',');

                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_optionc_s = "select SPECTypeID from `specvalues` where SPECValue<>'' and Product_SKU_Auto_ID=" . $p_SKU;
                    $optionc_result_s = mysqli_query($link_db, $str_optionc_s);
                    while ($data_optc = mysqli_fetch_row($optionc_result_s)) {

                        $data_optionc_s .= $data_optc[0] . ",";
                    }
                    mysqli_close($link_db);

                    $data_optionc_s = strtr($data_optionc_s, ',,', ',');

                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_SPECCat_1 = "select distinct SPECCategoryID from spectypes where INSTR('" . $data_optionc_s . "',SPECTypeID)>0";
                    $SPECCat_result_1 = mysqli_query($link_db, $str_SPECCat_1);
                    while ($data_scc1 = mysqli_fetch_row($SPECCat_result_1)) {
                        $data_SPEC1 .= $data_scc1[0] . ",";
                    }
                    mysqli_close($link_db);

                    /* 20140312 Create */
                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_type_s = "select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=" . $SM0;
                    $type_result_s = mysqli_query($link_db, $str_type_s);
                    $data_p = mysqli_fetch_row($type_result_s);
                    mysqli_close($link_db);
                    /* end */


                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);

                    if ($SM13 != '') {
                        $str_Cate = "select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where `SPECCategoryID` in (" . substr($SM13, 0, strlen($SM13) - 1) . ") order by FIELD(`SPECCategoryID`," . substr($SM13, 0, strlen($SM13) - 1) . ")"; //mysql in 排序 也可以按in裡面的順序來排序
                    } else {
                        $str_Cate = "select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where INSTR('," . $data_p[0] . "',concat(',',SPECCategoryID,','))>0 order by SPECCategorySort";
                    }
                    $Cateresult = mysqli_query($link_db, $str_Cate);
                    mysqli_query($link_db, 'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    while ($data_spec = mysqli_fetch_row($Cateresult)) {
                        $data_spec_str .= $data_spec[0] . ",";
                    ?>
                        <tbody>
                            <tr>
                                <!--name="CCateg_SPECCategoryID"-->
                                <td><a class="fancybox fancybox.iframe" href="elb_categories.php?p_id=<?= $p_SKU; ?>&PType_id=<?= $EPType_id; ?>"><?= $data_spec[1]; ?></a></td>
                                <td><a href="elb_types.php?SPCC_ID=<?= $data_spec[0]; ?>&PType_id=<?= $EPType_id; ?>&p_id=<?= $p_SKU; ?>" class="fancybox fancybox.iframe">[Edit]</a>
                                    <table id="OTypes_show<?= $ca; ?>" class="insidetable1">
                                        <?php
                                        $i1 = 0;
                                        $ParentSpec_va_all = "";
                                        $SPECTypeID_va_all = "";
                                        if (isset($_COOKIE["type_cookie" . $data_spec[0] . ""]) != '') {
                                            $str_GetParent = "select distinct ParentSpec from spectypes where SPECCategoryID=" . $data_spec[0] . " and (ParentSpec IS NOT NULL) and INSTR('" . $_COOKIE["type_cookie" . $data_spec[0] . ""] . "',SPECTypeID)>0";
                                            $GetParentresult = mysqli_query($link_db, $str_GetParent);
                                            $GetParentresultNum = mysqli_num_rows($GetParentresult);
                                            while (list($ParentSpec) = mysqli_fetch_row($GetParentresult)) {
                                                $ParentSpec_va_all .= $ParentSpec . ",";
                                            }
                                            if ($GetParentresultNum > 0) {
                                                $ParentSpec_va_all_Sub = $_COOKIE["type_cookie" . $data_spec[0] . ""];
                                            }

                                            $str_GetSType = "select SPECTypeID as SPECTypeID_va from spectypes where SPECCategoryID=" . $data_spec[0] . " and (ParentSpec IS NULL) and INSTR('" . $_COOKIE["type_cookie" . $data_spec[0] . ""] . "',SPECTypeID)>0";
                                            $GetSTyperesult = mysqli_query($link_db, $str_GetSType);
                                            while (list($SPECTypeID_va) = mysqli_fetch_row($GetSTyperesult)) {
                                                $SPECTypeID_va_all .= $SPECTypeID_va . ",";
                                            }
                                            $str_Types = "select * from spectypes where SPECCategoryID=" . $data_spec[0] . " and INSTR('" . $SPECTypeID_va_all . $ParentSpec_va_all . "',SPECTypeID)>0 order by `ParentSort`, `SPECTypeSort`";
                                        } else if ($SM14 <> '') {
                                            $str_GetParent1 = "select distinct ParentSpec from spectypes where SPECCategoryID=" . $data_spec[0] . " and (ParentSpec IS NOT NULL) and INSTR('" . $SM14 . "',SPECTypeID)>0";
                                            $GetParentresult1 = mysqli_query($link_db, $str_GetParent1);
                                            $GetParentresult1Num = mysqli_num_rows($GetParentresult1);
                                            while (list($ParentSpec) = mysqli_fetch_row($GetParentresult1)) {
                                                $ParentSpec_va_all .= $ParentSpec . ",";
                                            }
                                            if ($GetParentresult1Num > 0) {
                                                $ParentSpec_va_all_Sub = $SM14;
                                            }

                                            $str_GetSType1 = "select SPECTypeID as SPECTypeID_va from spectypes where SPECCategoryID=" . $data_spec[0] . " and (ParentSpec IS NULL) and INSTR('" . $SM14 . "',SPECTypeID)>0";
                                            $GetSTyperesult1 = mysqli_query($link_db, $str_GetSType1);
                                            while (list($SPECTypeID_va) = mysqli_fetch_row($GetSTyperesult1)) {
                                                $SPECTypeID_va_all .= $SPECTypeID_va . ",";
                                            }
                                            $str_Types = "select * from spectypes where SPECCategoryID=" . $data_spec[0] . " and INSTR('" . $SPECTypeID_va_all . $ParentSpec_va_all . "',SPECTypeID)>0 order by `ParentSort`, `SPECTypeSort`";
                                        } else {
                                            $str_Types = "select * from spectypes where SPECCategoryID=" . $data_spec[0] . " and INSTR('" . $data_p[1] . "',SPECTypeID)>0 order by `ParentSort`, `SPECTypeSort`";
                                        }
                                        $Typesresult = mysqli_query($link_db, $str_Types);
                                        $i1 = 0;
                                        while (list($SPECTypeID, $SPECCategoryID, $SPECTypeName, $WebOrder, $ParentSpec) = mysqli_fetch_row($Typesresult)) {
                                            $i1 = $i1 + 1;
                                            $SPECType_num .= $SPECTypeID . ",";
                                        ?>
                                            <tr>
                                                <td width="200">
                                                    <table class="insidetable1">
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                echo $SPECTypeName;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <table>
                                                                    <?php
                                                                    $SP_Pa = "";
                                                                    $str_Types_Pa = "select SPECTypeID from spectypes where SPECCategoryID=" . $data_spec[0] . " and (ParentSpec is NULL)";
                                                                    $Typesresult_Pa = mysqli_query($link_db, $str_Types_Pa);
                                                                    while ($Typesresult_PaData = mysqli_fetch_row($Typesresult_Pa)) {
                                                                        $SP_Pa .= $Typesresult_PaData[0] . ",";
                                                                    }

                                                                    if (isset($_COOKIE["type_cookie" . $data_spec[0] . ""]) != '') {
                                                                        $str_Types_sub = "select SPECTypeID,SPECTypeName,ParentSpec from spectypes where SPECCategoryID=" . $data_spec[0] . " and (INSTR('," . $_COOKIE["type_cookie" . $data_spec[0] . ""] . "',SPECTypeID)>0 and INSTR('," . $SP_Pa . "',ParentSpec)>0) order by SPECTypeSort";
                                                                    } else if ($SM14 != '') {
                                                                        $str_Types_sub = "select SPECTypeID,SPECTypeName,ParentSpec from spectypes where SPECCategoryID=" . $data_spec[0] . " and (INSTR('," . $SM14 . "',SPECTypeID)>0 and INSTR('," . $SP_Pa . "',ParentSpec)>0) order by SPECTypeSort";
                                                                    }
                                                                    //echo $str_Types_sub;
                                                                    if ($str_Types_sub != "") {
                                                                        $Typesresult_sub = mysqli_query($link_db, $str_Types_sub);
                                                                        while ($sub_sdate = mysqli_fetch_row($Typesresult_sub)) {

                                                                            if ($SPECTypeID == $sub_sdate[2]) {
                                                                                $ParentSpec_va_all_Thr .= $sub_sdate[0] . ",";
                                                                                if ($sub_sdate[2] != NULL) {
                                                                                    echo "<tr><td> " . $sub_sdate[1] . " </td></tr>";
                                                                                } else {
                                                                                    echo "<tr><td></td></tr>";
                                                                                }
                                                                            } else {
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php
                                                    $str_option_all = "";
                                                    $strr_option_all = "";
                                                    $strr_option = "";
                                                    $ii1 = 0;
                                                    $str_Types_sub = "select SPECTypeID,SPECCategoryID,SPECTypeName from spectypes where InputTypeID<3 and SPECCategoryID=" . $SPECCategoryID . " and ParentSpec=" . $SPECTypeID . " ORDER BY `SPECTypeSort` ASC";
                                                    $Typesresult_sub = mysqli_query($link_db, $str_Types_sub);
                                                    while ($Tdata = mysqli_fetch_row($Typesresult_sub)) {
                                                        $ii1 = $ii1 + 1;
                                                        if (isset($_COOKIE["type_cookie" . $data_spec[0] . ""]) != '') {
                                                            if (preg_match("/" . $Tdata[0] . "/i", $_COOKIE["type_cookie" . $data_spec[0] . ""]) != '') {

                                                                $str_option = "<input name='aspectype[]' type='checkbox' style='display:none' value='" . $Tdata[0] . "' checked />";
                                                                $str_option = $str_option . "<a href='elb_options.php?SPCT_ID=" . $Tdata[0] . "&p_id=" . $p_SKU . "' title='" . $Tdata[2] . "' class='fancybox fancybox.iframe' onclick=show(" . $i1 . ",'" . $Tdata[0] . "')>[Edit]</a>";

                                                                $strr_option = "<div id='divObj" . $i1 . "' display:'inline-block'>";
                                                                $j = 0;
                                                                $str_Optionss = "select SPECOptionID,SPECOptionValue from specoptions where SPECTypeID=" . $Tdata[0] . " and INSTR('" . $data_option_s . "',SPECOptionID)>0 order by SPECOptionSort";
                                                                $Optionsresults = mysqli_query($link_db, $str_Optionss);
                                                                if ($Optionsresults == true) {
                                                                    while (list($SPECOptionID, $SPECOptionValue) = mysqli_fetch_row($Optionsresults)) {
                                                                        $j = $j + 1;
                                                                        $strr_option .= "<input name='aspecoption[]' type='checkbox' style='display:none' value='" . $Tdata[0] . "|" . $SPECOptionID . "' checked />" . $SPECOptionValue . ",&nbsp;";

                                                                        if ($j % 8 == 0) {
                                                                            echo "<br />";
                                                                        }
                                                                    }
                                                                }
                                                                $strr_option .= $str_option;
                                                                $strr_option .= "</div>";
                                                                $str_option_all = $str_option_all . $strr_option;
                                                            }
                                                        } else {
                                                            if (preg_match("/" . $Tdata[0] . "/i", $SM14) != '') {

                                                                $str_option = "<input name='aspectype[]' type='checkbox' style='display:none' value='" . $Tdata[0] . "' checked />";
                                                                $str_option = $str_option . "<a href='elb_options.php?SPCT_ID=" . $Tdata[0] . "&p_id=" . $p_SKU . "' title='" . $Tdata[2] . "' class='fancybox fancybox.iframe' onclick=show(" . $i1 . ",'" . $Tdata[0] . "')>[Edit]</a>";

                                                                $strr_option = "<div id='divObj" . $i1 . "' display:'inline-block'>";
                                                                $j = 0;
                                                                $str_Optionss = "select SPECOptionID,SPECOptionValue from specoptions where SPECTypeID=" . $Tdata[0] . " and INSTR('" . $data_option_s . "',SPECOptionID)>0 order by SPECOptionSort";
                                                                $Optionsresults = mysqli_query($link_db, $str_Optionss);
                                                                if ($Optionsresults == true) {
                                                                    while (list($SPECOptionID, $SPECOptionValue) = mysqli_fetch_row($Optionsresults)) {
                                                                        $j = $j + 1;

                                                                        $strr_option .= "<input name='aspecoption[]' type='checkbox' style='display:none' value='" . $Tdata[0] . "|" . $SPECOptionID . "' checked />" . $SPECOptionValue . ",&nbsp;";

                                                                        if ($j % 8 == 0) {
                                                                            echo "<br />";
                                                                        }
                                                                    }
                                                                }
                                                                $strr_option .= $str_option;
                                                                $strr_option .= "</div>";
                                                                $str_option_all = $str_option_all . $strr_option;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($i1 % 3 == 0) {
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="left">
                                                        <?php
                                                        if ($str_option_all == '') {
                                                        ?>

                                                            <INPUT name="aspectype[]" type="checkbox" style="display:none" value="<?= $SPECTypeID; ?>" checked />

                                                            <?php
                                                            $str_option_all_str = "";
                                                            $str_Options_checkd = "select SPECOptionID,SPECTypeID,SPECOptionValue,IsShow FROM specoptions where SPECTypeID=" . $SPECTypeID . " order by SPECOptionSort";
                                                            $Optionsresult_checkd = mysqli_query($link_db, $str_Options_checkd);
                                                            $Options_data = mysqli_fetch_row($Optionsresult_checkd);
                                                            if (empty($Options_data)) :
                                                                echo "<A href=elb_options.php?SPCT_ID=" . $SPECTypeID . "&p_id=" . $p_SKU . " class='fancybox fancybox.iframe' onclick='show(" . $i1 . "," . $SPECTypeID . ")'>[Edit]</A>&nbsp;&nbsp;";

                                                            else :
                                                                echo "<A href=elb_options.php?SPCT_ID=" . $SPECTypeID . "&p_id=" . $p_SKU . " class='fancybox fancybox.iframe' onclick='show(" . $i1 . "," . $SPECTypeID . ")'>[Edit]</A>&nbsp;&nbsp;";
                                                            endif;
                                                            ?>

                                                        <?php
                                                        } else {
                                                            echo $str_option_all;
                                                        }
                                                        ?>
                                                    </div>

                                                    <?php
                                                    if ($strr_option_all == '') {
                                                    ?>
                                                        <div id="divObj<?= $i1; ?>" style="margin:0px; padding:0px" class="left">
                                                            <?php
                                                            $j = 0;
                                                            $str_Options = "select SPECOptionID,SPECOptionValue from specoptions where SPECTypeID=" . $SPECTypeID . " and INSTR('" . $data_option_s . "',SPECOptionID)>0 order by SPECOptionSort";
                                                            $Optionsresult = mysqli_query($link_db, $str_Options);
                                                            if ($Optionsresult == true) {
                                                                while (list($SPECOptionID, $SPECOptionValue) = mysqli_fetch_row($Optionsresult)) {
                                                                    $j = $j + 1;
                                                            ?>
                                                                    <input name="aspecoption[]" type="checkbox" style="display:none" value="<?= $SPECTypeID ?>|<?= $SPECOptionID; ?>" checked /><?= $SPECOptionValue; ?>,&nbsp;
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        <?php
                                                    }
                                                        ?>

                                                </td>
                                            </tr>
                                        <?php
                                        }

                                        ?>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    <?php
                        if (isset($SPECTypeID_va_all) != '' && isset($ParentSpec_va_all) != '') {
                            $SPECType_numAll .= $SPECTypeID_va_all . $ParentSpec_va_all;
                        } else {
                        }
                    }
                    mysqli_close($link_db);

                    ?>
                </table>
            <?php
            }

            $ParentSpec_va_all_Thr_Split = explode(",", $ParentSpec_va_all_Thr, -1);
            for ($p = 0; $p <= count($ParentSpec_va_all_Thr_Split) - 1; $p++) {
                if (strpos(',' . $ParentSpec_va_all_Sub, ',' . $ParentSpec_va_all_Thr_Split[$p] . ',') != '' || strpos(',' . $ParentSpec_va_all_Sub, ',' . $ParentSpec_va_all_Thr_Split[$p] . ',') === 0) {
                } else {
                    $ParentSpec_va_all_ThrChk .= $ParentSpec_va_all_Thr_Split[$p] . ",";
                }
            }
            ?>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="clear"></p>
            <h3>Product Matrix Table:</h3>
            SKU : <SELECT id="SEL_SKU_S" name="SEL_SKU_S">
                <OPTION value="0" <?php if (ord($SM9) == false) {
                                        echo "selected";
                                    } ?>>Enabled</OPTION>
                <OPTION value="1" <?php if (ord($SM9) == true) {
                                        echo "selected";
                                    } ?>>Disabled</OPTION>
            </select>
            <hr class="style-four" />
            <?php
            $PMX1 = "";
            $PMX2 = "";
            $PMX3 = "";
            $PMX4 = "";
            $PMX5 = "";
            $PMX6 = "";
            $PMX7 = "";
            $PMX8 = "";
            $PMX9 = "";
            $PMX10 = "";
            $PMX11 = "";
            $PMX12 = "";
            $PMX13 = "";
            $PMX14 = "";
            $PMX15 = "";
            $PMX16 = "";
            $PMX17 = "";
            $PMX18 = "";
            $PMX19 = "";
            $PMX20 = "";
            if ($EPType_id <> "") {

                if ($EPType_id == 101 || $EPType_id == 103) {
                    $type_style = "";
                    $type_style_buttom = "sub";


                    if ($EPType_id == 101) {
                        $PMat_TName = "product_matrix";
                        $Cvalues = "QPI";
                    } else if ($EPType_id == 103) {
                        $PMat_TName = "product_matrix_b";
                    }
                } else if ($EPType_id == 102 || $EPType_id == 104) {
                    $type_style = "main_A";
                    $type_style_buttom = "sub_A";

                    if ($EPType_id == 102) {
                        $PMat_TName = "product_matrix";
                        $Cvalues = "HT";
                    } else if ($EPType_id == 104) {
                        $PMat_TName = "product_matrix_b";
                    }
                } else if ($EPType_id == 0106) {
                    $type_style = "";
                    $type_style_buttom = "sub";

                    if ($EPType_id == 0106) {
                        $PMat_TName = "product_matrix_h";
                    }
                } else if ($EPType_id == 107 || $EPType_id == 105) {
                    $type_style = "";
                    $type_style_buttom = "sub";

                    if ($EPType_id == 107 || $EPType_id == 105) {
                        $PMat_TName = "product_matrix_b";
                    }
                } else if ($EPType_id == 108 || $EPType_id == 117) {
                    $type_style = "";
                    $type_style_buttom = "sub";

                    if ($EPType_id == 108 || $EPType_id == 117) {
                        $PMat_TName = "product_matrix_b";
                    }
                }

                $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                //$select=mysqli_select_db($dataBase, $link_db);
                $str_pmix_m = "";

                if ($EPType_id == 101 || $EPType_id == 102) {
                    $str_pmix_m = "select `MatrixID`, `SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `CPU_QPI`, `Chipset`, `PCIx`, `PCI`, `PCIe`, `Mem_Max`, `Mem_Type`, `IFeatures_A`, `IFeatures_G`, `IFeatures_N`, `IFeatures_R`, `Sr_Mgt`, `RHS_typ`, `UrlSite`, `IsShow` from " . $PMat_TName . " where SKU='" . $p_SKU . "' ";
                } else if ($EPType_id == 103 || $EPType_id == 104 || $EPType_id == 105 || $EPType_id == 108 || $EPType_id == 117) {
                    $str_pmix_m = "select `MatrixID`, `SocketR_NameID`, `ModelCode`, `SKU`, `Dim_H`, `Dim_W`, `Dim_D`, `Power_Supply`, `CPU_Series`, `Mem_Max`, `Mem_Type`, `HDD_Max`, `HDD_Type`, `HDD_HF`, `NIC_GbE`, `NIC_10GbE`, `PCIx`, `PCI`, `PCIe`, `Sr_Mgt`, `RHS_typ`, `UrlSite`, `IsShow` from " . $PMat_TName . " where SKU='" . $p_SKU . "' ";
                } else if ($EPType_id == 0106) {
                    $str_pmix_m = "select `MatrixID`, `SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `Dim_W`, `Dim_D`, `Chipset`, `Cache_Freq`, `Host_Interface`, `Int_Port`, `Ext_Port`, `SW_RAID`, `HW_RAID`, `Enhanced_RAID`, `Optional_BBU`, `RHS_typ`, `UrlSite`, `IsShow` from " . $PMat_TName . " where SKU='" . $p_SKU . "' ";
                } else if ($EPType_id == 107) {
                    $str_pmix_m = "select `MatrixID`, `SocketR_NameID`, `ModelCode`, `SKU`, `Dim_H`, `Dim_W`, `Dim_D`, `Power_Supply`, `CPU_Series`, `Mem_Max`, `Mem_Type`, `HDD_Max`, `HDD_Type`, `HDD_HF`, `NIC_GbE`, `NIC_10GbE`, `PCIx`, `PCI`, `PCIe`, `Sr_Mgt`, `RHS_typ`, `UrlSite`, `IsShow` from " . $PMat_TName . " where SKU='" . $p_SKU . "' ";
                }
                if ($str_pmix_m != '') {
                    $cmd_pmix_m = mysqli_query($link_db, $str_pmix_m);
                    $record_pmix_m = mysqli_fetch_row($cmd_pmix_m);

                    if (empty($record_pmix_m)) :

                    else :
                        $PMX1 = $record_pmix_m[1];
                        $PMX2 = $record_pmix_m[2];
                        $PMX3 = $record_pmix_m[3];
                        $PMX4 = $record_pmix_m[4];
                        $PMX5 = $record_pmix_m[5];
                        $PMX6 = $record_pmix_m[6];
                        $PMX7 = $record_pmix_m[7];
                        $PMX8 = $record_pmix_m[8];
                        $PMX9 = $record_pmix_m[9];
                        $PMX10 = $record_pmix_m[10];
                        $PMX11 = $record_pmix_m[11];
                        $PMX12 = $record_pmix_m[12];
                        $PMX13 = $record_pmix_m[13];
                        $PMX14 = $record_pmix_m[14];
                        $PMX15 = $record_pmix_m[15];
                        $PMX16 = $record_pmix_m[16];
                        $PMX17 = $record_pmix_m[17];

                        if ($EPType_id == 103 || $EPType_id == 104) {
                            $PMX18 = $record_pmix_m[18];
                            $PMX19 = $record_pmix_m[19];
                            $PMX20 = $record_pmix_m[20];
                        }

                    endif;
                }
                //}
            ?>
                <?php
                if (isset($_REQUEST['PMatrix_id']) != '') {
                    $PMatrix_id = intval($_REQUEST['PMatrix_id']);
                } else {
                    $PMatrix_id = "";
                }
                ?>
                <table class="addspec" style="display:none">
                    <tr>
                        <th>Matrix Category:</th>
                        <td>
                            <p>
                                <select id="SEL_PMatrix" name="SEL_PMatrix">
                                    <option selected="selected" value="">Select from extisting: </option>
                                    <?php
                                    $Mat = 0;
                                    $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                                    mysqli_query($link_db, 'SET NAMES utf8');
                                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                                    //$select=mysqli_select_db($dataBase, $link_db);
                                    $str_mat = "select * from product_matrix_categories where ProductTypeID=" . $EPType_id;
                                    $mat_result = mysqli_query($link_db, $str_mat);
                                    while (list($Product_Matrix_Cid, $ProductTypeID, $Page_Status, $Matrix_CategoryName, $IsStatus, $Matrix_SKUs) = mysqli_fetch_row($mat_result)) {
                                        $Mat = $Mat + 1;
                                    ?>
                                        <option value="<?= $Product_Matrix_Cid; ?>" <?php
                                                                                    if (isset($_SESSION['SEL_PMatrix01']) <> '') {

                                                                                        if ($Product_Matrix_Cid == $_SESSION['SEL_PMatrix01']) {
                                                                                            echo "selected";
                                                                                        }
                                                                                    } else {
                                                                                        if ($Product_Matrix_Cid == $PMatrix_id || $Product_Matrix_Cid == $PMX1) {
                                                                                            echo "selected";
                                                                                        } else {
                                                                                            if ($Mat == 1) {
                                                                                                echo "selected";
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>><?= $Matrix_CategoryName; ?></option>
                                    <?php
                                    }
                                    mysqli_close($link_db);
                                    ?>
                                </select>
                            </p>
                        </td>
                    </tr>
                </table>

                <table id="product_matrix" style="display:none">
                    <thead>
                        <?php
                        $P_Val = 0;
                        if ($EPType_id == 101 || $EPType_id == 102) {
                            $P_Val = 15;
                        ?>
                            <tr>
                                <th class="<?= $type_style; ?>" rowspan="2">Form Factor</th>
                                <th class="<?= $type_style; ?>" rowspan="2">CPU / <?= $Cvalues; ?></th>
                                <th class="<?= $type_style; ?>" rowspan="2">Chipset</th>
                                <th class="<?= $type_style; ?>" colspan="3">Exp. Slots</th>
                                <th class="<?= $type_style; ?>" colspan="2">Memory</th>
                                <th class="<?= $type_style; ?>" colspan="4">Integrated Features</th>
                                <th class="<?= $type_style; ?>" rowspan="2">Server Mgmt.</th>
                                <th class="<?= $type_style; ?>" rowspan="2">RoHS (Type)</th>
                            </tr>
                            <tr>
                                <th class="sub">PCI-X</th>
                                <th class="sub">PCI</th>
                                <th class="sub">PCIe</th>
                                <th class="sub">Max.</th>
                                <th class="sub">Type</th>
                                <th class="sub">Audio (A)</th>
                                <th class="sub">Video (G)</th>
                                <th class="sub">LAN (N)</th>
                                <th class="sub">RAID (R)</th>
                            </tr>
                        <?php
                        } else if ($EPType_id == 103 || $EPType_id == 104 || $EPType_id == 108 || $EPType_id == 117) {
                            $P_Val = 18;
                        ?>
                            <tr>
                                <th class="<?= $type_style; ?>" colspan="3">Dim. (inch)</th>
                                <th class="<?= $type_style; ?>" rowspan="2">Power Supply</th>
                                <th class="<?= $type_style; ?>" rowspan="2">CPU Series</th>
                                <th class="<?= $type_style; ?>" colspan="2">Memory</th>
                                <th class="<?= $type_style; ?>" colspan="3">HDD</th>
                                <th class="<?= $type_style; ?>" colspan="2">NIC</th>
                                <th class="<?= $type_style; ?>" colspan="3">Exp. Slots</th>
                                <th class="<?= $type_style; ?>" rowspan="2">Server Mgmt.</th>
                                <th class="<?= $type_style; ?>" rowspan="2">FF RoHS (Type)</th>
                            </tr>
                            <tr>
                                <th class="<?= $type_style_buttom; ?>">H</th>
                                <th class="<?= $type_style_buttom; ?>">W</th>
                                <th class="<?= $type_style_buttom; ?>">D</th>
                                <th class="<?= $type_style_buttom; ?>">Max.</th>
                                <th class="<?= $type_style_buttom; ?>">Type</th>
                                <th class="<?= $type_style_buttom; ?>">Max.</th>
                                <th class="<?= $type_style_buttom; ?>">Type</th>
                                <th class="<?= $type_style_buttom; ?>">H/F</th>
                                <th class="<?= $type_style_buttom; ?>">GbE</th>
                                <th class="<?= $type_style_buttom; ?>">10GbE</th>
                                <th class="<?= $type_style_buttom; ?>">PCI-X</th>
                                <th class="<?= $type_style_buttom; ?>">PCI</th>
                                <th class="<?= $type_style_buttom; ?>">PCIe</th>
                            </tr>
                        <?php
                        } else if ($EPType_id == 0106) {
                            $P_Val = 14;
                        ?>
                            <tr>
                                <th class="<?= $type_style; ?>" rowspan="2">Form Factor</th>
                                <th class="<?= $type_style; ?>" colspan="2">Dim. (inch)</th>
                                <th class="<?= $type_style; ?>" rowspan="2">Chipset</th>
                                <th class="<?= $type_style; ?>" rowspan="2">Cache Freq.</th>
                                <th class="<?= $type_style; ?>" rowspan="2">Host Interface</th>
                                <th class="<?= $type_style; ?>" colspan="2"># of Devices</th>
                                <th class="<?= $type_style; ?>" colspan="3">Integrated Features</th>
                                <th class="<?= $type_style; ?>" rowspan="2">Optional BBU</th>
                                <th class="<?= $type_style; ?>" rowspan="2">RoHS (Type)</th>
                            </tr>
                            <tr>
                                <th class="<?= $type_style_buttom; ?>">W</th>
                                <th class="<?= $type_style_buttom; ?>">D</th>
                                <th class="<?= $type_style_buttom; ?>">Int. Port</th>
                                <th class="<?= $type_style_buttom; ?>">Ext. Port(X)</th>
                                <th class="<?= $type_style_buttom; ?>">S/W RAID(SR)</th>
                                <th class="<?= $type_style_buttom; ?>">H/W RAID(HR)</th>
                                <th class="<?= $type_style_buttom; ?>">Enhanced RAID(E)</th>
                            </tr>
                        <?php
                        }
                        ?>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            for ($PI = 1; $PI < $P_Val; $PI++) {
                                if (strlen($PI) > 1) {
                                    $PI = $PI;
                                } else {
                                    $PI = "0" . $PI;
                                }

                                $PS = $PI + 3;
                                if ($PS == 4) {
                                    $PS_value = $PMX4;
                                } else if ($PS == 5) {
                                    $PS_value = $PMX5;
                                } else if ($PS == 6) {
                                    $PS_value = $PMX6;
                                } else if ($PS == 7) {
                                    $PS_value = $PMX7;
                                } else if ($PS == 8) {
                                    $PS_value = $PMX8;
                                } else if ($PS == 9) {
                                    $PS_value = $PMX9;
                                } else if ($PS == 10) {
                                    $PS_value = $PMX10;
                                } else if ($PS == 11) {
                                    $PS_value = $PMX11;
                                } else if ($PS == 12) {
                                    $PS_value = $PMX12;
                                } else if ($PS == 13) {
                                    $PS_value = $PMX13;
                                } else if ($PS == 14) {
                                    $PS_value = $PMX14;
                                } else if ($PS == 15) {
                                    $PS_value = $PMX15;
                                } else if ($PS == 16) {
                                    $PS_value = $PMX16;
                                } else if ($PS == 17) {
                                    $PS_value = $PMX17;
                                } else if ($PS == 18) {
                                    $PS_value = $PMX18;
                                } else if ($PS == 19) {
                                    $PS_value = $PMX19;
                                } else if ($PS == 20) {
                                    $PS_value = $PMX20;
                                }
                            ?>
                                <td><a id="alink_<?= (int)$PS - 1 ?>" href="#product_matrix" onClick="show_PMA<?= $PI; ?>();">
                                        <?php
                                        if ($PS_value <> '' && $PS_value <> 'NO') {

                                            $MPS = $PS - 3;
                                            if (strlen($MPS) > 1) {
                                                $MPS = $MPS;
                                            } else {
                                                $MPS = "0" . $MPS;
                                            }
                                            if (isset($_SESSION['p_seVal' . $MPS . '']) <> '') {

                                                echo $_SESSION['p_seVal' . $MPS . ''];
                                            } else {
                                                $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                                                mysqli_query($link_db, 'SET NAMES utf8');
                                                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                                                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                                                //$select=mysqli_select_db($dataBase, $link_db);

                                                $str_ms = "SELECT MValue_VName FROM `matrix_values` where MValue_id=" . $PS_value;
                                                $cmd_ms = mysqli_query($link_db, $str_ms);

                                                $data_ms = mysqli_fetch_row($cmd_ms);

                                                echo $data_ms[0];
                                            }
                                        } else if ($PS_value == 'NO') {
                                            echo "NO";
                                        } else {

                                            $MPS = $PS - 3;
                                            if (strlen($MPS) > 1) {
                                                $MPS = $MPS;
                                            } else {
                                                $MPS = "0" . $MPS;
                                            }

                                            if (isset($_SESSION['p_seVal' . $MPS . '']) <> '') {

                                                echo $_SESSION['p_seVal' . $MPS . ''];
                                            } else {
                                                echo "Mod";
                                            }
                                        }
                                        ?></a></td>
                            <?php
                            }
                            ?>
                        </tr>

                    </tbody>
                </table>
                <!--Click Add or edit 內容 會出現下面-->
                <br />
                <?php
                if ($EPType_id == 101 || $EPType_id == 102) {
                ?>
                    <div id="PMA_ADD01" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA01()"> [close] </a></div><!--end of close-->
                        <h4>Form Factor:</h4>
                        <select id="SEL_PMT003" name="SEL_PMT003">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal01']) != "") {

                                                    if ($_SESSION['p_seVal01'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX4 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m03 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=1 order by MValue_VName";
                            $m_result03 = mysqli_query($link_db, $str_m03);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result03)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal01']) != "") {

                                                                        if ($_SESSION['p_seVal01'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX4 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show03" style="display:none"><input type="text" id="PMS_03" name="PMS_03" size="20" value=""><br />Tooltips :<input id="PMS_03U" name="PMS_03U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(3,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD02" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA02()"> [close] </a></div><!--end of close-->
                        <h4>CPU / <?= $Cvalues; ?>:</h4>
                        <select id="SEL_PMT004" name="SEL_PMT004">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal02']) != "") {

                                                    if ($_SESSION['p_seVal02'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX5 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m04 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=2 order by MValue_VName";
                            $m_result04 = mysqli_query($link_db, $str_m04);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result04)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal02']) != "") {

                                                                        if ($_SESSION['p_seVal02'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX5 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show04" style="display:none"><input type="text" id="PMS_04" name="PMS_04" size="20" value=""><br />Tooltips :<input id="PMS_04U" name="PMS_04U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(4,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD03" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA03()"> [close] </a></div><!--end of close-->
                        <h4>Chipset:</h4>
                        <select id="SEL_PMT005" name="SEL_PMT005">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal03']) != "") {

                                                    if ($_SESSION['p_seVal03'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX6 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m05 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=3 order by MValue_VName";
                            $m_result05 = mysqli_query($link_db, $str_m05);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result05)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal03']) != "") {

                                                                        if ($_SESSION['p_seVal03'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX6 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show05" style="display:none"><input type="text" id="PMS_05" name="PMS_05" size="20" value=""><br />Tooltips :<input id="PMS_05U" name="PMS_05U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(5,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD04" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA04()"> [close] </a></div><!--end of close-->
                        <h4>Exp. Slots -> PCIx:</h4>
                        <select id="SEL_PMT006" name="SEL_PMT006">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal04']) != "") {

                                                    if ($_SESSION['p_seVal04'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX7 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m06="select distinct PCIx from product_matrix where PCIx<>'' order by PCIx";
                            $str_m06 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCI-X' order by MValue_VName";
                            $m_result06 = mysqli_query($link_db, $str_m06);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result06)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal04']) != "") {

                                                                        if ($_SESSION['p_seVal04'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX7 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX7; ?></font>-->
                        <div id="PMT_Show06" style="display:none"><input type="text" id="PMS_06" name="PMS_06" size="20" value=""><br />Tooltips :<input id="PMS_06U" name="PMS_06U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(6,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD05" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA05()"> [close] </a></div><!--end of close-->
                        <h4>Exp. Slots -> PCI:</h4>
                        <select id="SEL_PMT007" name="SEL_PMT007">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal05']) != "") {

                                                    if ($_SESSION['p_seVal05'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX8 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m07="select distinct PCI from product_matrix where PCI<>'' order by PCI";
                            $str_m07 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCI' order by MValue_VName";
                            $m_result07 = mysqli_query($link_db, $str_m07);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result07)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal05']) != "") {

                                                                        if ($_SESSION['p_seVal05'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX8 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX8; ?></font>-->
                        <div id="PMT_Show07" style="display:none"><input type="text" id="PMS_07" name="PMS_07" size="20" value=""><br />Tooltips :<input id="PMS_07U" name="PMS_07U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(7,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD06" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA06()"> [close] </a></div><!--end of close-->
                        <h4>Exp. Slots -> PCIe:</h4>
                        <select id="SEL_PMT008" name="SEL_PMT008">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal06']) != "") {

                                                    if ($_SESSION['p_seVal06'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX9 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m08="select distinct PCIe from product_matrix where PCIe<>'' order by PCIe";
                            $str_m08 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCIe' order by MValue_VName";
                            $m_result08 = mysqli_query($link_db, $str_m08);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result08)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal06']) != "") {

                                                                        if ($_SESSION['p_seVal06'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX9 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX9; ?></font>-->
                        <div id="PMT_Show08" style="display:none"><input type="text" id="PMS_08" name="PMS_08" size="20" value=""><br />Tooltips :<input id="PMS_08U" name="PMS_08U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(8,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD07" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA07()"> [close] </a></div><!--end of close-->
                        <h4>Memory -> Max.:</h4>
                        <select id="SEL_PMT009" name="SEL_PMT009">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal07']) != "") {

                                                    if ($_SESSION['p_seVal07'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX10 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m09="select distinct Mem_Max from product_matrix order by Mem_Max";
                            $str_m09 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=5 and MValue_SUBName='Max.' order by MValue_VName";
                            $m_result09 = mysqli_query($link_db, $str_m09);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result09)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal07']) != "") {

                                                                        if ($_SESSION['p_seVal07'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX10 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX10; ?></font>-->
                        <div id="PMT_Show09" style="display:none"><input type="text" id="PMS_09" name="PMS_09" size="20" value=""><br />Tooltips :<input id="PMS_09U" name="PMS_09U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(9,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD08" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA08()"> [close] </a></div><!--end of close-->
                        <h4>Memory -> Type:</h4>
                        <select id="SEL_PMT010" name="SEL_PMT010">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal08']) != "") {

                                                    if ($_SESSION['p_seVal08'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX11 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m10="select distinct Mem_Type from product_matrix order by Mem_Type";
                            $str_m10 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=5 and MValue_SUBName='Type' order by MValue_VName";
                            $m_result10 = mysqli_query($link_db, $str_m10);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result10)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal08']) != "") {

                                                                        if ($_SESSION['p_seVal08'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX11 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX11; ?></font>-->
                        <div id="PMT_Show10" style="display:none"><input type="text" id="PMS_10" name="PMS_10" size="20" value=""><br />Tooltips :<input id="PMS_10U" name="PMS_10U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(10,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD09" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA09()"> [close] </a></div><!--end of close-->
                        <h4>Integrated Features -> Audio (A):</h4>
                        <select id="SEL_PMT011" name="SEL_PMT011">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal09']) != "") {

                                                    if ($_SESSION['p_seVal09'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX12 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m11="select distinct IFeatures_A from product_matrix where IFeatures_A<>'' order by IFeatures_A";
                            $str_m11 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='Audio (A)' order by MValue_VName";
                            $m_result11 = mysqli_query($link_db, $str_m11);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result11)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal09']) != "") {

                                                                        if ($_SESSION['p_seVal09'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX12 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX12; ?></font>-->
                        <div id="PMT_Show11" style="display:none"><input type="text" id="PMS_11" name="PMS_11" size="20" value=""><br />Tooltips :<input id="PMS_11U" name="PMS_11U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(11,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD10" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA10()"> [close] </a></div><!--end of close-->
                        <h4>Integrated Features -> Video (G):</h4>
                        <select id="SEL_PMT012" name="SEL_PMT012">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal10']) != "") {

                                                    if ($_SESSION['p_seVal10'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX13 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m12="select distinct IFeatures_G from product_matrix order by IFeatures_G";
                            $str_m12 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='Video (G)' order by MValue_VName";
                            $m_result12 = mysqli_query($link_db, $str_m12);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result12)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal10']) != "") {

                                                                        if ($_SESSION['p_seVal10'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX13 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX13; ?></font>-->
                        <div id="PMT_Show12" style="display:none"><input type="text" id="PMS_12" name="PMS_12" size="20" value=""><br />Tooltips :<input id="PMS_12U" name="PMS_12U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(12,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD11" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA11()"> [close] </a></div><!--end of close-->
                        <h4>Integrated Features -> LAN (N):</h4>
                        <select id="SEL_PMT013" name="SEL_PMT013">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal11']) != "") {

                                                    if ($_SESSION['p_seVal11'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX14 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m13="select distinct IFeatures_N from product_matrix order by IFeatures_N";
                            $str_m13 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='LAN (N)' order by MValue_VName";
                            $m_result13 = mysqli_query($link_db, $str_m13);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result13)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal11']) != "") {

                                                                        if ($_SESSION['p_seVal11'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX14 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX14; ?></font>-->
                        <div id="PMT_Show13" style="display:none"><input type="text" id="PMS_13" name="PMS_13" size="20" value=""><br />Tooltips :<input id="PMS_13U" name="PMS_13U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(13,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD12" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA12()"> [close] </a></div><!--end of close-->
                        <h4>Integrated Features -> RAID (R):</h4>
                        <select id="SEL_PMT014" name="SEL_PMT014">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal12']) != "") {

                                                    if ($_SESSION['p_seVal12'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX15 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m14="select distinct IFeatures_R from product_matrix order by IFeatures_R";
                            $str_m14 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='RAID (R)' order by MValue_VName";
                            $m_result14 = mysqli_query($link_db, $str_m14);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result14)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal12']) != "") {

                                                                        if ($_SESSION['p_seVal12'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX15 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX15; ?></font>-->
                        <div id="PMT_Show14" style="display:none"><input type="text" id="PMS_14" name="PMS_14" size="20" value=""><br />Tooltips :<input id="PMS_14U" name="PMS_14U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(14,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD13" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA13()"> [close] </a></div><!--end of close-->
                        <h4>Server Mgmt.:</h4>
                        <select id="SEL_PMT015" name="SEL_PMT015">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal13']) != "") {

                                                    if ($_SESSION['p_seVal13'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX16 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m15="select distinct Sr_Mgt from product_matrix where Sr_Mgt<>'' order by Sr_Mgt";
                            $str_m15 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=7 and MValue_SUBName='Server Mgmt.' order by MValue_VName";
                            $m_result15 = mysqli_query($link_db, $str_m15);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result15)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal13']) != "") {

                                                                        if ($_SESSION['p_seVal13'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX16 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX16; ?></font>-->
                        <div id="PMT_Show15" style="display:none"><input type="text" id="PMS_15" name="PMS_15" size="20" value=""><br />Tooltips :<input id="PMS_15U" name="PMS_15U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(15,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD14" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA14()"> [close] </a></div><!--end of close-->
                        <h4>RoHS (Type):</h4>
                        <select id="SEL_PMT016" name="SEL_PMT016">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal14']) != "") {

                                                    if ($_SESSION['p_seVal14'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX17 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m16="select distinct RHS_typ from product_matrix order by RHS_typ";
                            $str_m16 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=8 and MValue_SUBName='RoHS (Type)' order by MValue_VName";
                            $m_result16 = mysqli_query($link_db, $str_m16);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result16)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal14']) != "") {

                                                                        if ($_SESSION['p_seVal14'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX17 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX17; ?></font>-->
                        <div id="PMT_Show16" style="display:none"><input type="text" id="PMS_16" name="PMS_16" size="20" value=""><br />Tooltips :<input id="PMS_16U" name="PMS_16U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(16,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                <?php
                } else if ($EPType_id == 103 || $EPType_id == 104) {
                ?>

                    <div id="PMA_ADD01" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA01()"> [close] </a></div><!--end of close-->
                        <h4>Dim. (inch) -> H:</h4>
                        <select id="SEL_PMT003" name="SEL_PMT003">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal01']) != "") {

                                                    if ($_SESSION['p_seVal01'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX4 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m03 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='H' order by MValue_VName";
                            $m_result03 = mysqli_query($link_db, $str_m03);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result03)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal01']) != "") {

                                                                        if ($_SESSION['p_seVal01'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX4 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX4; ?></font>-->
                        <div id="PMT_Show03" style="display:none"><input type="text" id="PMS_03" name="PMS_03" size="20" value=""><br />Tooltips :<input id="PMS_03U" name="PMS_03U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(3,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD02" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA02()"> [close] </a></div><!--end of close-->
                        <h4>Dim. (inch) -> W:</h4>
                        <select id="SEL_PMT004" name="SEL_PMT004">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal02']) != "") {

                                                    if ($_SESSION['p_seVal02'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX5 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m04 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='W' order by MValue_VName";
                            $m_result04 = mysqli_query($link_db, $str_m04);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result04)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal02']) != "") {

                                                                        if ($_SESSION['p_seVal02'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX5 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX5; ?></font>-->
                        <div id="PMT_Show04" style="display:none"><input type="text" id="PMS_04" name="PMS_04" size="20" value=""><br />Tooltips :<input id="PMS_04U" name="PMS_04U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(4,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD03" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA03()"> [close] </a></div><!--end of close-->
                        <h4>Dim. (inch) -> D:</h4>
                        <select id="SEL_PMT005" name="SEL_PMT005">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal03']) != "") {

                                                    if ($_SESSION['p_seVal03'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX6 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m05 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='D' order by MValue_VName";
                            $m_result05 = mysqli_query($link_db, $str_m05);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result05)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal03']) != "") {

                                                                        if ($_SESSION['p_seVal03'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX6 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX6; ?></font>-->
                        <div id="PMT_Show05" style="display:none"><input type="text" id="PMS_05" name="PMS_05" size="20" value=""><br />Tooltips :<input id="PMS_05U" name="PMS_05U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(5,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD04" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA04()"> [close] </a></div><!--end of close-->
                        <h4>Power Supply:</h4>
                        <select id="SEL_PMT006" name="SEL_PMT006">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal04']) != "") {

                                                    if ($_SESSION['p_seVal04'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX7 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            //$str_m06="select distinct PCIx from product_matrix where PCIx<>'' order by PCIx";
                            $str_m06 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=10 order by MValue_VName";
                            $m_result06 = mysqli_query($link_db, $str_m06);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result06)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal04']) != "") {

                                                                        if ($_SESSION['p_seVal04'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX7 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX7; ?></font>-->
                        <div id="PMT_Show06" style="display:none"><input type="text" id="PMS_06" name="PMS_06" size="20" value=""><br />Tooltips :<input id="PMS_06U" name="PMS_06U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(6,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD05" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA05()"> [close] </a></div><!--end of close-->
                        <h4>CPU Series:</h4>
                        <select id="SEL_PMT007" name="SEL_PMT007">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal05']) != "") {

                                                    if ($_SESSION['p_seVal05'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX8 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m07 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=11 order by MValue_VName";
                            $m_result07 = mysqli_query($link_db, $str_m07);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result07)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal05']) != "") {

                                                                        if ($_SESSION['p_seVal05'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX8 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX8; ?></font>-->
                        <div id="PMT_Show07" style="display:none"><input type="text" id="PMS_07" name="PMS_07" size="20" value=""><br />Tooltips :<input id="PMS_07U" name="PMS_07U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(7,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD06" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA06()"> [close] </a></div><!--end of close-->
                        <h4>Memory -> Max.:</h4>
                        <select id="SEL_PMT008" name="SEL_PMT008">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal06']) != "") {

                                                    if ($_SESSION['p_seVal06'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX9 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m08 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=5 and MValue_SUBName='Max.' order by MValue_VName";
                            $m_result08 = mysqli_query($link_db, $str_m08);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result08)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal06']) != "") {

                                                                        if ($_SESSION['p_seVal06'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX9 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX9; ?></font>-->
                        <div id="PMT_Show08" style="display:none"><input type="text" id="PMS_08" name="PMS_08" size="20" value=""><br />Tooltips :<input id="PMS_08U" name="PMS_08U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(8,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD07" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA07()"> [close] </a></div><!--end of close-->
                        <h4>Memory -> Type:</h4>
                        <select id="SEL_PMT009" name="SEL_PMT009">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal07']) != "") {

                                                    if ($_SESSION['p_seVal07'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX10 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m09 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=5 and MValue_SUBName='Type' order by MValue_VName";
                            $m_result09 = mysqli_query($link_db, $str_m09);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result09)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal07']) != "") {

                                                                        if ($_SESSION['p_seVal07'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX10 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX10; ?></font>-->
                        <div id="PMT_Show09" style="display:none"><input type="text" id="PMS_09" name="PMS_09" size="20" value=""><br />Tooltips :<input id="PMS_09U" name="PMS_09U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(9,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD08" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA08()"> [close] </a></div><!--end of close-->
                        <h4>HDD -> Max.:</h4>
                        <select id="SEL_PMT010" name="SEL_PMT010">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal08']) != "") {

                                                    if ($_SESSION['p_seVal08'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX11 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m10 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=12 and MValue_SUBName='Max.' order by MValue_VName";
                            $m_result10 = mysqli_query($link_db, $str_m10);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result10)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal08']) != "") {

                                                                        if ($_SESSION['p_seVal08'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX11 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX11; ?></font>-->
                        <div id="PMT_Show10" style="display:none"><input type="text" id="PMS_10" name="PMS_10" size="20" value=""><br />Tooltips :<input id="PMS_10U" name="PMS_10U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(10,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD09" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA09()"> [close] </a></div><!--end of close-->
                        <h4>HDD -> Type:</h4>
                        <select id="SEL_PMT011" name="SEL_PMT011">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal09']) != "") {

                                                    if ($_SESSION['p_seVal09'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX12 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m11 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=12 and MValue_SUBName='Type' order by MValue_VName";
                            $m_result11 = mysqli_query($link_db, $str_m11);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result11)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?
                                                                    if (isset($_SESSION['p_seVal09']) != "") {

                                                                        if ($_SESSION['p_seVal09'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX12 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp;<!--<font color=red><?= $PMX12; ?></font>-->
                        <div id="PMT_Show11" style="display:none"><input type="text" id="PMS_11" name="PMS_11" size="20" value=""><br />Tooltips :<input id="PMS_11U" name="PMS_11U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(11,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD10" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA10()"> [close] </a></div><!--end of close-->
                        <h4>HDD -> H/F:</h4>
                        <select id="SEL_PMT012" name="SEL_PMT012">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal10']) != "") {

                                                    if ($_SESSION['p_seVal10'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX13 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m12 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=12 and MValue_SUBName='H/F' order by MValue_VName";
                            $m_result12 = mysqli_query($link_db, $str_m12);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result12)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal10']) != "") {

                                                                        if ($_SESSION['p_seVal10'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX13 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show12" style="display:none"><input type="text" id="PMS_12" name="PMS_12" size="20" value=""><br />Tooltips :<input id="PMS_12U" name="PMS_12U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(12,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD11" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA11()"> [close] </a></div><!--end of close-->
                        <h4>NIC -> GbE:</h4>
                        <select id="SEL_PMT013" name="SEL_PMT013">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal11']) != "") {

                                                    if ($_SESSION['p_seVal11'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX14 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m13 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=13 and MValue_SUBName='GbE' order by MValue_VName";
                            $m_result13 = mysqli_query($link_db, $str_m13);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result13)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal11']) != "") {

                                                                        if ($_SESSION['p_seVal11'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX14 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show13" style="display:none"><input type="text" id="PMS_13" name="PMS_13" size="20" value=""><br />Tooltips :<input id="PMS_13U" name="PMS_13U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(13,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD12" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA12()"> [close] </a></div><!--end of close-->
                        <h4>NIC -> 10GbE:</h4>
                        <select id="SEL_PMT014" name="SEL_PMT014">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal12']) != "") {

                                                    if ($_SESSION['p_seVal12'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX15 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m14 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=13 and MValue_SUBName='10GbE' order by MValue_VName";
                            $m_result14 = mysqli_query($link_db, $str_m14);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result14)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal12']) != "") {

                                                                        if ($_SESSION['p_seVal12'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX15 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show14" style="display:none"><input type="text" id="PMS_14" name="PMS_14" size="20" value=""><br />Tooltips :<input id="PMS_14U" name="PMS_14U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(14,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD13" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA13()"> [close] </a></div><!--end of close-->
                        <h4>Exp. Slots -> PCIx:</h4>
                        <select id="SEL_PMT015" name="SEL_PMT015">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal13']) != "") {

                                                    if ($_SESSION['p_seVal13'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX16 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m15 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCI-X' order by MValue_VName";
                            $m_result15 = mysqli_query($link_db, $str_m15);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result15)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal13']) != "") {

                                                                        if ($_SESSION['p_seVal13'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX16 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show15" style="display:none"><input type="text" id="PMS_15" name="PMS_15" size="20" value=""><br />Tooltips :<input id="PMS_15U" name="PMS_15U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(15,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD14" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA14()"> [close] </a></div><!--end of close-->
                        <h4>Exp. Slots -> PCI:</h4>
                        <select id="SEL_PMT016" name="SEL_PMT016">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal14']) != "") {

                                                    if ($_SESSION['p_seVal14'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX17 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m16 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCI' order by MValue_VName";
                            $m_result16 = mysqli_query($link_db, $str_m16);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result16)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal14']) != "") {

                                                                        if ($_SESSION['p_seVal14'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX17 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show16" style="display:none"><input type="text" id="PMS_16" name="PMS_16" size="20" value=""><br />Tooltips :<input id="PMS_16U" name="PMS_16U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(16,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD15" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA15()"> [close] </a></div><!--end of close-->
                        <h4>Exp. Slots -> PCIe:</h4>
                        <select id="SEL_PMT017" name="SEL_PMT017">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal15']) != "") {

                                                    if ($_SESSION['p_seVal15'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX18 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m17 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=4 and MValue_SUBName='PCIe' order by MValue_VName";
                            $m_result17 = mysqli_query($link_db, $str_m17);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result17)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal15']) != "") {

                                                                        if ($_SESSION['p_seVal15'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX18 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show17" style="display:none"><input type="text" id="PMS_17" name="PMS_17" size="20" value=""><br />Tooltips :<input id="PMS_17U" name="PMS_17U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(17,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD16" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA16()"> [close] </a></div><!--end of close-->
                        <h4>Server Mgmt.:</h4>
                        <select id="SEL_PMT018" name="SEL_PMT018">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal16']) != "") {

                                                    if ($_SESSION['p_seVal16'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX19 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m18 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=7 and MValue_SUBName='Server Mgmt.' order by MValue_VName";
                            $m_result18 = mysqli_query($link_db, $str_m18);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result18)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal16']) != "") {

                                                                        if ($_SESSION['p_seVal16'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX19 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show18" style="display:none"><input type="text" id="PMS_18" name="PMS_18" size="20" value=""><br />Tooltips :<input id="PMS_18U" name="PMS_18U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(18,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>

                    <div id="PMA_ADD17" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA17()"> [close] </a></div><!--end of close-->
                        <h4>RoHS (Type):</h4>
                        <select id="SEL_PMT019" name="SEL_PMT019">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal17']) != "") {

                                                    if ($_SESSION['p_seVal17'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX20 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m19 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=8 and MValue_SUBName='RoHS (Type)' order by MValue_VName";
                            $m_result19 = mysqli_query($link_db, $str_m19);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result19)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal17']) != "") {

                                                                        if ($_SESSION['p_seVal17'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX20 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show19" style="display:none"><input type="text" id="PMS_19" name="PMS_19" size="20" value=""><br />Tooltips :<input id="PMS_19U" name="PMS_19U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(19,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                <?php
                } else if ($EPType_id == 0106) {
                ?>
                    <div id="PMA_ADD01" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA01()"> [close] </a></div><!--end of close-->
                        <h4>Form Factor:</h4>
                        <select id="SEL_PMT003" name="SEL_PMT003">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal01']) != "") {

                                                    if ($_SESSION['p_seVal01'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX4 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m03 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=1 order by MValue_VName";
                            $m_result03 = mysqli_query($link_db, $str_m03);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result03)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal01']) != "") {

                                                                        if ($_SESSION['p_seVal01'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX4 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>&nbsp; <div id="PMT_Show03" style="display:none"><input type="text" id="PMS_03" name="PMS_03" size="20" value=""><br />Tooltips :<input id="PMS_03U" name="PMS_03U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(3,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD02" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA02()"> [close] </a></div><!--end of close-->
                        <h4>Dim. (inch) -> W:</h4>
                        <select id="SEL_PMT004" name="SEL_PMT004">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal02']) != "") {

                                                    if ($_SESSION['p_seVal02'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX5 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m04 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='W' order by MValue_VName";
                            $m_result04 = mysqli_query($link_db, $str_m04);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result04)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal02']) != "") {

                                                                        if ($_SESSION['p_seVal02'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX5 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show04" style="display:none"><input type="text" id="PMS_04" name="PMS_04" size="20" value=""><br />Tooltips :<input id="PMS_04U" name="PMS_04U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(4,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD03" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA03()"> [close] </a></div><!--end of close-->
                        <h4>Dim. (inch) -> D:</h4>
                        <select id="SEL_PMT005" name="SEL_PMT005">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal03']) != "") {

                                                    if ($_SESSION['p_seVal03'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX6 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m05 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=9 and MValue_SUBName='D' order by MValue_VName";
                            $m_result05 = mysqli_query($link_db, $str_m05);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result05)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal03']) != "") {

                                                                        if ($_SESSION['p_seVal03'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX6 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show05" style="display:none"><input type="text" id="PMS_05" name="PMS_05" size="20" value=""><br />Tooltips :<input id="PMS_05U" name="PMS_05U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(5,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD04" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA04()"> [close] </a></div><!--end of close-->
                        <h4>Chipset:</h4>
                        <select id="SEL_PMT006" name="SEL_PMT006">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal04']) != "") {

                                                    if ($_SESSION['p_seVal04'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX7 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m06 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=3 order by MValue_VName";
                            $m_result06 = mysqli_query($link_db, $str_m06);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result06)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal04']) != "") {

                                                                        if ($_SESSION['p_seVal04'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX7 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show06" style="display:none"><input type="text" id="PMS_06" name="PMS_06" size="20" value=""><br />Tooltips :<input id=="PMS_06U" name="PMS_06U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(6,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD05" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA05()"> [close] </a></div><!--end of close-->
                        <h4>Cache Freq.:</h4>
                        <select id="SEL_PMT007" name="SEL_PMT007">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal05']) != "") {

                                                    if ($_SESSION['p_seVal05'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX8 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m07 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=14 order by MValue_VName";
                            $m_result07 = mysqli_query($link_db, $str_m07);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result07)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal05']) != "") {

                                                                        if ($_SESSION['p_seVal05'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX8 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show07" style="display:none"><input type="text" id="PMS_07" name="PMS_07" size="20" value=""><br />Tooltips :<input id="PMS_07U" name="PMS_07U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(7,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD06" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA06()"> [close] </a></div><!--end of close-->
                        <h4>Host Interface:</h4>
                        <select id="SEL_PMT008" name="SEL_PMT008">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal06']) != "") {

                                                    if ($_SESSION['p_seVal06'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX9 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m08 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=15 order by MValue_VName";
                            $m_result08 = mysqli_query($link_db, $str_m08);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result08)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal06']) != "") {

                                                                        if ($_SESSION['p_seVal06'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX9 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show08" style="display:none"><input type="text" id="PMS_08" name="PMS_08" size="20" value=""><br />Tooltips :<input id="PMS_08U" name="PMS_08U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(8,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD07" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA07()"> [close] </a></div><!--end of close-->
                        <h4># of Devices -> Int. Port:</h4>
                        <select id="SEL_PMT009" name="SEL_PMT009">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal07']) != "") {

                                                    if ($_SESSION['p_seVal07'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX10 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m09 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=16 and MValue_SUBName='Int. Port' order by MValue_VName";
                            $m_result09 = mysqli_query($link_db, $str_m09);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result09)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal07']) != "") {

                                                                        if ($_SESSION['p_seVal07'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX10 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show09" style="display:none"><input type="text" id="PMS_09" name="PMS_09" size="20" value=""><br />Tooltips :<input id="PMS_09U" name="PMS_09U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(9,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD08" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA08()"> [close] </a></div><!--end of close-->
                        <h4># of Devices -> Ext. Port (X):</h4>
                        <select id="SEL_PMT010" name="SEL_PMT010">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal08']) != "") {

                                                    if ($_SESSION['p_seVal08'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX11 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m10 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=16 and MValue_SUBName='Ext. Port (X)' order by MValue_VName";
                            $m_result10 = mysqli_query($link_db, $str_m10);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result10)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal08']) != "") {

                                                                        if ($_SESSION['p_seVal08'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX11 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show10" style="display:none"><input type="text" id="PMS_10" name="PMS_10" size="20" value=""><br />Tooltips :<input id="PMS_10U" name="PMS_10U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(10,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD09" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA09()"> [close] </a></div><!--end of close-->
                        <h4>Integrated Features -> S/W RAID (SR):</h4>
                        <select id="SEL_PMT011" name="SEL_PMT011">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal09']) != "") {

                                                    if ($_SESSION['p_seVal09'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX12 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m11 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='S/W RAID (SR)' order by MValue_VName";
                            $m_result11 = mysqli_query($link_db, $str_m11);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result11)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal09']) != "") {

                                                                        if ($_SESSION['p_seVal09'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX12 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show11" style="display:none"><input type="text" id="PMS_11" name="PMS_11" size="20" value=""><br />Tooltips :<input id="PMS_11U" name="PMS_11U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(11,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD10" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA10()"> [close] </a></div><!--end of close-->
                        <h4>Integrated Features -> H/W RAID (HR):</h4>
                        <select id="SEL_PMT012" name="SEL_PMT012">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal10']) != "") {

                                                    if ($_SESSION['p_seVal10'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX13 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m12 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='H/W RAID (HR)' order by MValue_VName";
                            $m_result12 = mysqli_query($link_db, $str_m12);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result12)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal10']) != "") {

                                                                        if ($_SESSION['p_seVal10'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX13 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show12" style="display:none"><input type="text" id="PMS_12" name="PMS_12" size="20" value=""><br />Tooltips :<input id="PMS_12U" name="PMS_12U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(12,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD11" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA11()"> [close] </a></div><!--end of close-->
                        <h4>Integrated Features -> Enhanced RAID (E):</h4>
                        <select id="SEL_PMT013" name="SEL_PMT013">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal11']) != "") {

                                                    if ($_SESSION['p_seVal11'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX14 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m13 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=6 and MValue_SUBName='Enhanced RAID (E)' order by MValue_VName";
                            $m_result13 = mysqli_query($link_db, $str_m13);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result13)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal11']) != "") {

                                                                        if ($_SESSION['p_seVal11'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX14 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show13" style="display:none"><input type="text" id="PMS_13" name="PMS_13" size="20" value=""><br />Tooltips :<input id="PMS_13U" name="PMS_13U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(13,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD12" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA12()"> [close] </a></div><!--end of close-->
                        <h4>Optional BBU:</h4>
                        <select id="SEL_PMT014" name="SEL_PMT014">
                            <option selected="selected" value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal12']) != "") {

                                                    if ($_SESSION['p_seVal12'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX15 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m14 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=17 order by MValue_VName";
                            $m_result14 = mysqli_query($link_db, $str_m14);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result14)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?php
                                                                    if (isset($_SESSION['p_seVal12']) != "") {

                                                                        if ($_SESSION['p_seVal12'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX15 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show14" style="display:none"><input type="text" id="PMS_14" name="PMS_14" size="20" value=""><br />Tooltips :<input id="PMS_14U" name="PMS_14U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(14,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                    <div id="PMA_ADD13" class="subsettings" style="display:none">
                        <!--Click close to close this subsettings div-->
                        <div class="right"><a href="#product_matrix" onClick="Close_PMA13()"> [close] </a></div><!--end of close-->
                        <h4>RoHS (Type):</h4>
                        <select id="SEL_PMT015" name="SEL_PMT015">
                            <option value="">-- Select --</option>
                            <option value="Add">Add New</option>
                            <option value="NO" <?php
                                                if (isset($_SESSION['p_seVal13']) != "") {

                                                    if ($_SESSION['p_seVal13'] == "NO") {
                                                        echo "selected";
                                                    }
                                                } else {

                                                    if ($PMX16 == "NO") {
                                                        echo "selected='selected'";
                                                    }
                                                }
                                                ?>>NO</option>
                            <?php
                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                            mysqli_query($link_db, 'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            $str_m15 = "SELECT MValue_id,MValue_VName FROM `matrix_values` where MValue_Mid=8 and MValue_SUBName='RoHS (Type)' order by MValue_VName";
                            $m_result15 = mysqli_query($link_db, $str_m15);
                            while (list($MValue_id, $MValue_VName) = mysqli_fetch_row($m_result15)) {
                            ?>
                                <option value="<?= $MValue_id; ?>" <?
                                                                    if (isset($_SESSION['p_seVal13']) != "") {

                                                                        if ($_SESSION['p_seVal13'] == $MValue_VName) {
                                                                            echo "selected";
                                                                        }
                                                                    } else {

                                                                        if ($PMX16 == $MValue_id) {
                                                                            echo "selected";
                                                                        }
                                                                    }
                                                                    ?>><?= $MValue_VName; ?></option>
                            <?php
                            }
                            mysqli_close($link_db);
                            ?>
                        </select>
                        <div id="PMT_Show15" style="display:none"><input type="text" id="PMS_15" name="PMS_15" size="20" value=""><br />Tooltips :<input id="PMS_15U" name="PMS_15U" type="text" size="20" value="" /><input type="button" value="Add New" onclick="Add_Matrvalue(15,<?= $p_SKU; ?>,<?= $EPType_id; ?>);"></div>
                    </div>
                <?php
                }
                ?>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p class="clear"></p>
                <h3>Grouping Settings:</h3>
                <hr class="style-four" />
                <p class="clear"></p>

                <!--Grouping Conditions settings -->

                <table class="pro_spec_bk">
                    <thead>
                        <tr>
                            <th colspan="2">Grouping Condition Settings:</th>
                        </tr>
                    </thead>


                    <?php
                    if ($EPType_id <> '') {
                        $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                        mysqli_query($link_db, 'SET NAMES utf8');
                        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                        //$select=mysqli_select_db($dataBase, $link_db);
                        $str_m = "select SKUs_Conditions from product_skus_categories where ProductTypeID=" . $EPType_id;
                        $cmd_m = mysqli_query($link_db, $str_m);
                        $m_result = mysqli_fetch_row($cmd_m);

                        $value_c = "";
                        if ($m_result == true) {

                            $MSKUs_id = explode(",", $m_result[0], -1);
                            $MSKUs_count = count($MSKUs_id); //總數量
                            $MSKUs_sid = array_unique($MSKUs_id);
                            $sid1 = isset($MSKUs_sid[0]);
                            $sid2 = isset($MSKUs_sid[1]);
                            $sid3 = isset($MSKUs_sid[2]);

                            foreach ($MSKUs_sid as $value_c) {
                    ?>
                                <tbody>
                                    <tr>
                                        <th style="width:100px">
                                            <?php
                                            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                                            mysqli_query($link_db, 'SET NAMES utf8');
                                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                                            //$select=mysqli_select_db($dataBase, $link_db);
                                            $str_CSKUs = "select SKUs_Mid,SKUs_MiName,IsShow from skus_mainsub where SKUs_Mid=" . $value_c;
                                            $CSKUsresult = mysqli_query($link_db, $str_CSKUs);
                                            $data_CSKUs = mysqli_fetch_row($CSKUsresult);
                                            ?>
                                            <input style="display:none" name="" type="checkbox" value="" <?php if ($data_CSKUs[2] == '1') {
                                                                                                                echo "checked";
                                                                                                            } ?> />
                                            <?php
                                            echo $data_CSKUs[1];
                                            ?>:
                                        </th>
                                        <td>
                                            <select id="SEL_PN<?= $data_CSKUs[0]; ?>" name="SEL_PN<?= $data_CSKUs[0]; ?>">
                                                <option selected="selected">Select...</option>
                                                <?php
                                                if ($EPType_id <> '') {
                                                ?>
                                                    <option value="Add">Add New</option>
                                                <?php
                                                }
                                                $SKUs_Mname01 = "";
                                                $u = 0;
                                                $str_sm1 = "";
                                                $str_sm2 = "";
                                                $str_sm3 = "";
                                                $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                                                mysqli_query($link_db, 'SET NAMES utf8');
                                                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                                                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

                                                //$select=mysqli_select_db($dataBase, $link_db);
                                                if (intval($data_CSKUs[0]) == 1) {
                                                    $str_nw = "select SKUs_Sid,SKUs_Mid,SKUs_Mname from skus_sublist where SKUs_Mid=" . intval($data_CSKUs[0]) . " and SKUs_Mname<>'N' and ProductTypeID=" . $EPType_id;
                                                } else {
                                                    $str_nw = "select SKUs_Sid,SKUs_Mid,SKUs_Mname from skus_sublist where SKUs_Mid=" . intval($data_CSKUs[0]) . " and ProductTypeID=" . $EPType_id;
                                                }
                                                $NW_result = mysqli_query($link_db, $str_nw);
                                                while ($ndb = mysqli_fetch_array($NW_result)) {
                                                    $u = $u + 1;
                                                    $SKUs_Mname01 = trim($ndb["SKUs_Mname"]);
                                                    if (trim($SM3) == trim($ndb["SKUs_Mname"]) && $sid1 == trim($ndb["SKUs_Mid"])) {
                                                        $str_sm1 = "selected";
                                                    } else {
                                                        $str_sm1 = "";
                                                    }
                                                    if (trim($SM4) == trim($ndb["SKUs_Mname"]) && $sid2 == trim($ndb["SKUs_Mid"])) {
                                                        $str_sm2 = "selected";
                                                    } else {
                                                        $str_sm2 = "";
                                                    }
                                                    if (trim($SM5) == trim($ndb["SKUs_Mname"]) && $sid3 == trim($ndb["SKUs_Mid"])) {
                                                        $str_sm3 = "selected";
                                                    } else {
                                                        $str_sm3 = "";
                                                    }
                                                ?>
                                                    <option value="<?= htmlspecialchars($ndb['SKUs_Mname'], ENT_QUOTES) ?>" <?php
                                                                                                                            echo $str_sm1;
                                                                                                                            echo $str_sm2;
                                                                                                                            echo $str_sm3;
                                                                                                                            ?>><?= htmlspecialchars_decode($ndb["SKUs_Mname"], ENT_QUOTES); ?> </option>
                                                <?php
                                                }

                                                $data_CKstr = $data_CKstr . $data_CSKUs[0] . ",";
                                                ?>
                                            </select>&nbsp;&nbsp;&nbsp;&nbsp; <div id="SKUPN_add<?= $data_CSKUs[0] ?>" style="display:none">Values: <input type="text" name="SSMN1_<?= $data_CSKUs[0] ?>" size="20" value=""> <input type="hidden" name="SSMN2_<?= $data_CSKUs[0] ?>" value="<?= $data_CSKUs[0]; ?>"><input type="hidden" name="SSMN3_<?= $data_CSKUs[0] ?>" value="<?= $EPType_id; ?>"><input type="hidden" id="SSMN4" name="SSMN4" value="<?= $data_CKstr; ?>"><input id="SSMNBtn<?= $data_CSKUs[0] ?>" name="SSMNBtn<?= $data_CSKUs[0] ?>" type="button" value="Done" />
                                                <div id="SubSKUs_MGT<?= $data_CSKUs[0]; ?>"></div>
                                            </div>
                                            <div class="dropdown_box">
                                                <input name="" type="text" size="30" value="" />&nbsp;&nbsp;<input name="" type="button" value="OK" /> &nbsp;&nbsp;<a href="">Cancel </a>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                    <?php
                            }
                        }
                        mysqli_close($link_db);
                    }
                    ?>

                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p class="clear"></p>
                <h3>Status Settings:</h3>
                <hr class="style-four" />
                <p class="clear"></p>
            <?php
            }
            ?>
            <p style="font-weight:bolder;display:none">Supported Language:
                <input name="aspecLang[]" type="checkbox" value="EN" <?php if (preg_match("/EN/i", $SM12) != '') {
                                                                            echo "checked";
                                                                        } ?> /> English &nbsp;&nbsp;
                <input name="aspecLang[]" type="checkbox" value="CN" <?php if (preg_match("/CN/i", $SM12) != '') {
                                                                            echo "checked";
                                                                        } ?> /> 簡中 &nbsp;&nbsp;
                <input name="aspecLang[]" type="checkbox" value="ZH" <?php if (preg_match("/ZH/i", $SM12) != '') {
                                                                            echo "checked";
                                                                        } ?> /> 繁中 &nbsp;&nbsp;
                <input name="aspecLang[]" type="checkbox" value="JP" <?php if (preg_match("/JP/i", $SM12) != '') {
                                                                            echo "checked";
                                                                        } ?> /> 日本語 &nbsp;&nbsp;
            </p>
            <p style="padding-left:145px; font-weight:bolder"><input name="specEOL" type="checkbox" value="1" <?php if ($SM8 == true) {
                                                                                                                    echo "checked";
                                                                                                                } ?> /> EOL</p>
            <p style="padding-left:145px; font-weight:bolder"><input name="specBTO" type="checkbox" value="1" <?php if ($SM16 == true) {
                                                                                                                    echo "checked";
                                                                                                                } ?> /> BTO</p>
            <p style="padding-left:145px; font-weight:bolder"><input name="compareBox" type="checkbox" value="1" <?php if ($compare == true) {
                                                                                                                        echo "checked";
                                                                                                                    } ?> /> Enable "COMPARE" button</p>
            <p style="padding-left:145px; font-weight:bolder"><input name="quoteBox" type="checkbox" value="1" <?php if ($quote == true) {
                                                                                                                    echo "checked";
                                                                                                                } ?> /> Enable "REQUEST QUOTE" button</p>
            <p class="clear"></p>
            <hr class="style-four" />
            <p class="clear"></p>

            <H3>SKU Note:</H3>
            <HR class="style-four" />
            <P class="clear"></P>
            <P style="padding-left:10px; font-weight:bolder"><textarea cols="30" id="note01m" name="note01m" rows="7"><?= $SM15; ?></textarea></p>
            <HR class="style-four" />
            <P class="clear"></P>
            <div>
                <div id="savebutton"><button name="submitbutton01" id="submitbutton01" style="width:60px; margin-right:10px" type="submit" class="button14 left">Save</button></div>
            </div>
            <input type="hidden" name="SPECC_Sort_tr" value="<?= $data_spec_str; ?>" readonly /><!--$SPECType_num.$ParentSpec_va_all_Thr;-->
            <textarea id="SPECTP_str" name="SPECTP_str" rows="6" cols="80" style="max-width: 250px; max-height: 250px;display:none">
<?php
echo $SPECType_num . $ParentSpec_va_all_Thr;
?></textarea>
        </form>
        <br>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p class="clear">&nbsp;</p>
        <div id="footer"> Copyright &copy; 2012 Company Co. All rights reserved.
            <div class="gotop" onClick="location='#top'">Top</div>
        </div>
</body>

</html>
<?php
if ($Save_State == "ok") {
    echo "<script language='Javascript'>Add_Finish();</script>\n";
}

if (isset($_REQUEST['get_cookies']) == "Yes") {
    echo "<script language='Javascript'>Set_Cookies_values();</script>\n";
}

for ($PP = 1; $PP < 15; $PP++) {
    if (strlen($PP) > 1) {
        $PP = $PP;
    } else {
        $PP = "0" . $PP;
    }

    if (isset($_REQUEST['p_PMA' . $PP]) != '') {
        $PPMA = $_REQUEST['p_PMA' . $PP];
        echo "<script language='Javascript'>show_PMA" . $PPMA . "();</script>\n";
        exit();
    }
}
?>