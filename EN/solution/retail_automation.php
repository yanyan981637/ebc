<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
if (strpos(trim(getenv('REQUEST_URI')), "script") != '' || strpos(trim(getenv('REQUEST_URI')), ".php") != '') {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /404.htm");
    exit;
}
error_reporting(0);
require "../../config.php";
$link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase) or die("Could not connect: " . mysqli_error());
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
if ($_COOKIE["status"] == "") {
    //$s_cookie="";
} else {
    $s_cookie = $_COOKIE['status'];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name='author' content='MiTAC Digital Technology'>
    <meta name="company" content="MiTAC Digital Technology">
    <meta name="description" content="MiTAC's retail automation offers AI solutions for self-service system, display system, POS system of kiosk, signage, hospitality, ATM, vending machine, TV wall">
    <meta property="og:type" content="website" />
    <meta property="og:description" content="MiTAC's retail automation offers AI solutions for self-service system, display system, POS system of kiosk, signage, hospitality, ATM, vending machine, TV wall" />
    <meta property="og:title" content="Retail Automation | MiTAC Digital Technology" />
    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <!-- Stylesheets
    ============================================= -->
    <link rel="stylesheet" href="/css1/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="/css1/style.css" type="text/css" />
    <link rel="stylesheet" href="/css1/swiper.css" type="text/css" />
    <link rel="stylesheet" href="/css1/dark.css" type="text/css" />
    <link rel="stylesheet" href="/css1/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="/css1/animate.css" type="text/css" />
    <link rel="stylesheet" href="/css1/magnific-popup.css" type="text/css" />
    <link rel="stylesheet" href="/css1/custom.css" type="text/css" />
    <link rel="stylesheet" href="/css1/kiosks.css" type="text/css" />
    <link rel="stylesheet" href="/css1/stylesheet1.css" type="text/css" />
    <style>
        .card-solution {
            margin-top: 3rem;
            margin-right: -10px;
            border-radius: 0px;
            background-color: rgba(0, 66, 138, 0.8);
            color: #00428a;
            box-shadow: 10px 10px 20px rgba(104, 104, 104, 0.5),
                -10px -10px 20px rgba(0, 0, 0, 0.5);
            color: #ffffff;
            padding: 2rem 1.5rem;
        }

        .card-solution a {
            color: #ffffff
        }

        .card-solution a:hover {
            color: #479cf9
        }

        .course-card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            margin: 2rem 0;
            background-color: #ffffff;
            padding: 0
        }

        .heading-block::after {
            border-top: 2px solid #a1a1a1;
        }

        .h4-1 {
            border-bottom: 2px solid #dcdcdc;
            line-height: 200%;
            font-weight: 600
        }

        .bg-dark-blue {
            background-color: #0D47A1;
            border: 1px solid #0D47A1
        }

        .bg-dark-blue h1 {
            color: #ffffff;
            padding: 1.6rem 1rem 0rem
        }

        .white {
            color: #ffffff
        }

        .title-1 h2 {
            font-weight: 300;
            line-height: 2rem;
            letter-spacing: 2px !important;
            color: #626262;
            display: inline;
        }

        :root {
            --color1: #08c5db;
            --color2: #3966c7;
            --color3: #167ff5;
        }

        .gradient-underline {
            background-image: -webkit-linear-gradient(280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62%);
            background-image: -o-linear-gradient(280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62%);
            background-image: linear-gradient(280deg, var(--color1) 12.08%, var(--color2) 53.53%, var(--color3) 95.62%);
            background-repeat: no-repeat;
            background-size: 100% 0.3em;
            background-position: 0 110%;
        }

        .gradient-underline a {
            color: #167ff5
        }

        .gradient-underline a:hover {
            color: #08c5db
        }
    </style>
    <script src="/js1/jquery.js"></script>
    <!-- Document Title
    ============================================= -->
    <title>Retail Automation | MiTAC Digital Technology</title>
    <?php
    //************ google analytics ************
    if ($s_cookie != 2) {
        include_once("analyticstracking.php");
    }
    ?>
</head>

<body class="stretched">
    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">
        <!--Header logo & global top menu-->
        <?php
        include("../../top1.htm");
        ?>
        <!--end Header logo & global top menu-->
        <!-- Slider
        ============================================= -->
        <div class="section lazy mt-0 p-0" data-bg="/EN/solution/images/RA-main-1.jpg" style="background-color:#f8f8f8; background-position: center center; background-repeat: no-repeat; background-size: cover;">
            <div class="container-fluid mt-5 mb-5">
                <div class="row g-0">
                    <div class="col-lg-1">&nbsp;</div>
                    <div class="col-lg-9 p-5">
                        <div class="row justify-content-between align-items-center">
                            <div class="col  ls1 dark  mb-5 mb-md-0 py-5">
                                <h2 class="display-4 text-white" style="font-weight: 600;" data-animate="backInLeft">Retail Automation</h2>
                                <p class="mb-5 text-white" style="line-height:1.2rem; font-weight: 100;  font-size:1rem" data-animate="backInLeft">
                                    With the implementation of check-out free stores in our daily lives, artificial intelligence is transforming the retail industry. Sometimes people seek emotional nourishment from purchasing, not just because of the lack of material. To satisfy these needs throughout the shopping journey, a retailer with millions of customers must make product recommendations based on each person's unique shopping needs based on their historical visits. Through the use of self-service applications such as interactive devices, multimedia equipment, etc., visitors can build on their own purchasing experience and easily have access to customized service.<br /><br />
                                    MiTAC target each customer individually, allowing retailers to convert a high percentage of visitors into long-term, high-value customers. Loyalty, as well as sales will increase, improving brand engagement and growth.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card-solution" data-animate="backInRight">
                            <br />
                            <div class="heading-block center">
                                <h4><a href="#stories">Success Stories:</a></h4>
                            </div>
                            <ul class="iconlist">
                                <li><i class="icon-line-chevrons-right"></i> <a href="#FA-5" />Hospitality in Restaurant</a></li>
                                <li><i class="icon-line-chevrons-right"></i> <a href="#FA-1" />Smart Vending Machine</a></li>
                                <li><i class="icon-line-chevrons-right"></i> <a href="#FA-2" />Compact Digital Signage Solution</a></li>
                                <li><i class="icon-line-chevrons-right"></i> <a href="#FA-3" />Interactive Kiosk / Hospitality</a></li>
                                <li><i class="icon-line-chevrons-right"></i> <a href="#FA-4" />Smart Charging Station for Stores</a></li>
                                <li><i class="icon-line-chevrons-right"></i> <a href="#FA-6" />Interactive Kiosk/ Self-ordering</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shape-divider" data-shape="wave-4" data-position="bottom" data-height="150"></div>
        </div>
        <!--end Slider
        ============================================= -->
        <div class="container-fluid m-0 border-0" style="padding: 80px 0;">
            <div class="container clearfix mt-3 mb-3 center">
                <img src="/EN/solution/images/retail_automation-2.jpg" class="img-fluid" alt="Retail Automation" />
            </div>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
            <div class="container clearfix mt-3 mb-3">
                <h2 class="center">Self Service System</h2>
                <div class="row mt-2">
                    <div class="col-md-7">
                        <h4 class="center h4-1">Kiosk</h4>
                        <div class="row">
                            <div class="col-sm-4 center p-1"><br /><a href="/IndustrialPanelPC_D210-11KS_D210-11KS" /><img src="/EN/solution/images/RA_Kiosk_D210-g.jpg" class="img-fluid" alt="D210" /></a>
                                <h4><a href="/IndustrialPanelPC_D210-11KS_D210-11KS" />D210</a></h4>
                            </div>
                            <div class="col-sm-4 center p-1"><br /><a href="/EmbeddedSystem_E600_E600" /><img src="/EN/solution/images/IT_E600-g.jpg" class="img-fluid" alt="E600" /></a>
                                <h4><a href="/EmbeddedSystem_E600_E600" />E600</a></h4>
                            </div>
                            <div class="col-sm-4 center p-1"><br /><a href="/EN/products/standard-kiosks/#K32F" /><img src="/EN/solution/images/Kiosk_K32F-g.jpg" class="img-fluid" alt="Kiosk K32F" /></a>
                                <h4><a href="/EN/products/standard-kiosks/#K32F" />K32F</h4></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4 class="center h4-1">ATM</h4>
                        <div class="row">
                            <div class="col-sm-6 center p-1"><br /><a href="/IndustrialPanelPC_P150-11KS_P150-11KS" /><img src="/EN/solution/images/RA_ATM_P150-g.jpg" class="img-fluid" alt="P150" /></a>
                                <h4><a href="/IndustrialPanelPC_P150-11KS_P150-11KS" />P150</a></h4>
                            </div>
                            <div class="col-sm-6 center p-1"><br /><a href="/IndustrialMotherboard_PH13FEI_PH13FEI" /><img src="/EN/solution/images/RA_ATM_PH13FEI-g.jpg" class="img-fluid" alt="PH13FEI" /></a>
                                <h4><a href="/IndustrialMotherboard_PH13FEI_PH13FEI" target="aa" />PH13FEI</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row  mt-6">
                    <div class="col-md-3">
                        <h4 class="center h4-1">Hospitality</h4>
                        <div class="row">
                            <div class="col-sm-12 center p-1"><br /><img src="/EN/solution/images/RA_Hospitality_M6070-g.jpg" class="img-fluid" alt="M6070" />
                                <h4>M6070</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4 class="center h4-1">Vending Machine</h4>
                        <div class="row">
                            <div class="col-sm-4 center p-1"><br /><a href="/EmbeddedSystem_MB1-10AP_MB1-10AP" /><img src="/EN/solution/images/RA_VM_MB1-g.jpg" class="img-fluid" alt="MB1" /></a>
                                <h4><a href="/EmbeddedSystem_MB1-10AP_MB1-10AP" />MB1</a></h4>
                            </div>
                            <div class="col-sm-4 center p-1"><br /><a href="/EmbeddedSystem_ME1-118T_ME1-118T" /><img src="/EN/solution/images/RA_AC_ME1-g.jpg" class="img-fluid" alt="ME1" /></a>
                                <h4><a href="/EmbeddedSystem_ME1-118T_ME1-118T" />ME1</a></h4>
                            </div>
                            <div class="col-sm-4 center p-1"><br /><a href="/IndustrialMotherboard_PD10AS_PD10AS" /><img src="/EN/solution/images/RA_VM_PD10AS-g.jpg" class="img-fluid" alt="PD10AS" /></a>
                                <h4><a href="/IndustrialMotherboard_PD10AS_PD10AS" />PD10AS</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0;">
            <div class="container clearfix mt-3 mb-3">
                <h2 class="center">Point of Sales System</h2>
                <div class="row mt-2">
                    <div class="col-md-1"></div>
                    <div class="col-md-6">
                        <h4 class="center h4-1">Retail POS</h4>
                        <div class="row">
                            <div class="col-sm-6 center p-1"><br /><a href="/IndustrialPanelPC_D151-11KS_D151-11KS" /><img src="/EN/solution/images/RA_RPOS_D151.jpg" class="img-fluid" alt="D151" /></a>
                                <h4><a href="/IndustrialPanelPC_D151-11KS_D151-11KS" />D151</a></h4>
                            </div>
                            <div class="col-sm-6 center p-1"><br /><a href="/IndustrialMotherboard_PH12FEI_PH12FEI" /><img src="/EN/solution/images/RA_RPOS_PH12FEI.jpg" class="img-fluid" alt="PH12FEI" /></a>
                                <h4><a href="/IndustrialMotherboard_PH12FEI_PH12FEI" />PH12FEI</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4 class="center h4-1">Mobile POS</h4>
                        <div class="row">
                            <div class="col-sm-12 center p-1"><br /><a href="/POS_Cappuccino_Cappuccino" /><img src="/EN/solution/images/RA_MPOS_Cappuccino.jpg" class="img-fluid" alt="Cappuccino" /></a>
                                <h4><a href="/POS_Cappuccino_Cappuccino" />Cappuccino</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
            <div class="container clearfix mt-3 mb-3">
                <h2 class="center">Display System</h2>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <h4 class="center h4-1">TV wall</h4>
                        <div class="row">
                            <div class="col-sm-6 center p-1"><br /><a href="/IndustrialMotherboard_PH10CMU_PH10CMU" /><img src="/EN/solution/images/FA_MC_PH10CMU-g.jpg" class="img-fluid" alt="PH10CMU" /></a>
                                <h4><a href="/IndustrialMotherboard_PH10CMU_PH10CMU" />PH10CMU</a></h4>
                            </div>
                            <div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_E500_E500" /><img src="/EN/solution/images/RA_TVwall_E500.jpg" class="img-fluid" alt="E500" /></a>
                                <h4><a href="/EmbeddedSystem_E500_E500" />E500</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="center h4-1">Signage</h4>
                        <div class="row">
                            <div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" /><img src="/EN/solution/images/FA_AGV_MP1-g.jpg" class="img-fluid" alt="MP1" /></a>
                                <h4><a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" />MP1</a></h4>
                            </div>
                            <div class="col-sm-6 center p-1"><br /><a href="/EmbeddedSystem_E310_E310" /><img src="/EN/solution/images/IT_E310.jpg" class="img-fluid" alt="E310" /></a>
                                <h4><a href="/EmbeddedSystem_E310_E310" />E310</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mb-3">&nbsp;</p>
                <a name="stories"></a>
                <p class="mb-3">&nbsp;</p>
            </div>
        </div>
        <a name="FA-5"></a>
        <div class="container-fluid m-0 bg-dark-blue">
            <h1 class="center">Success Stories - Retail Automation</h1>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
            <div class="container clearfix">
                <div class="heading-block center">
                    <h2>Hospitality in Restaurant</h2>
                    <span></span>
                </div>
                <div class="center title-1">
                    <h2 class="gradient-underline">Solutions: <a href="/POS_Cappuccino_Cappuccino" />Cappuccino Tablet</a> + Docking Station</span></h2>
                </div>
                <div class="row mt-6 mb-6">
                    <div class="col-lg-6 mt-4"><img src="/EN/solution/images/FA_Hospitality-in-Restaurant-1.jpg" alt="Hospitality in Restaurant" class="img-fluid mb-4">
                        <ul class="leftmargin-sm">
                            <li>The lightest 11.6" rugged tablet &lt; 900g</li>
                            <li>Dual OS compatibility with Windows® 10 IoT and Linux CentOS7</li>
                            <li>Crystal clear display with 2K resolution</li>
                            <li>Trouble-free scanning with built-in Honeywell software decoder</li>
                            <li>Featured with WiFi/BT and rich I/O connections for display monitor, cash drawer, thermal receipt printer, and payment terminal </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img src="/EN/solution/images/FA_Hospitality-in-Restaurant-2.png" alt="Hospitality in Restaurant" class="img-fluid mt-2">
                    </div>
                </div>
                <p class="mb-4">&nbsp;</p>
                <a name="FA-1"></a>
            </div>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0;">
            <div class="container clearfix">
                <div class="heading-block center">
                    <h2>Smart Vending Machine</h2>
                    <span></span>
                </div>
                <div class="center title-1">
                    <h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MB1-10AP_MB1-10AP" />MB1-10AP</a> /
                        <a href="/EmbeddedSystem_S310-11KS_S310-11KS" />S310-11KS</a> / <a href="/EmbeddedSystem_S300-10AS_S300-10AS" />S300-10AS</a>
                    </h2>
                </div>
                <div class="row mt-6 mb-6">
                    <div class="col-lg-6 mt-4"><img src="/EN/solution/images/FA_Smart_Vending_Machine_v1.jpg" alt="Smart Vending Machine" class="img-fluid mb-4">
                        <ul class="leftmargin-sm">
                            <li>Provide rich I/O connections in both serial and USB ports for expansion devices</li>
                            <li>Featured with HDMI and DP dual display ports for high resolution application</li>
                            <li>LAN/WLAN (optional) for internet connection for customer analysis and immediate feedback</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img src="/EN/solution/images/FA_Smart_Vending_Machine_v2.png" alt="Smart Vending Machine" class="img-fluid mt-2">
                    </div>
                </div>
                <p class="mb-4">&nbsp;</p>
                <a name="FA-2"></a>
            </div>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
            <div class="container clearfix">
                <div class="heading-block center">
                    <h2>Compact Digital Signage Solution</h2>
                    <span></span>
                </div>
                <div class="center title-1">
                    <h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_MP1-11TGS_MP1-11TGS" />MP1-11TGS</a></h2>
                </div>
                <div class="row mt-6 mb-6">
                    <div class="col-lg-6 mt-4">
                        <img src="/EN/solution/images/FA_Digital_Signage_v1.jpg" alt="Compact Digital Signage Solution" class="img-fluid mb-4">
                        <ul class="leftmargin-sm">
                            <li>High performance slim embedded system powered by Intel Kaby Lake Core-i Processor</li>
                            <li>Features with high resolution 4K HDMI & 4K DisplayPort for multi-display</li>
                            <li>LAN/WLAN (optional) for internet connection and data control</li>
                            <li>USB ports connectivity for facial recognition via cameras</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img src="/EN/solution/images/FA_Digital_Signage_202201.png" alt="Compact Digital Signage Solution" class="img-fluid mt-2">
                    </div>
                </div>
                <p class="mb-4">&nbsp;</p>
                <a name="FA-3"></a>
            </div>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0; ">
            <div class="container clearfix">
                <div class="heading-block center">
                    <h2>Interactive Kiosk / Hospitality</h2>
                    <span></span>
                </div>
                <div class="center title-1">
                    <h2 class="gradient-underline">Solutions: <a href="/IndustrialPanelPC_D210-11KS_D210-11KS" />D210</a> / <a href="/IndustrialPanelPC_D151-11KS_D151-11KS" />D151</a></h2>
                </div>
                <div class="row mt-6 mb-6">
                    <div class="col-lg-6 mt-4">
                        <img src="/EN/solution/images/FA_Hospitality_v1.jpg" alt="Interactive Kiosk / Hospitality" class="img-fluid mb-4">
                        <ul class="leftmargin-sm">
                            <li>Support multiple easy-attached mounting modules via USB ports</li>
                            <li>IP65 rated multi-touch front panel </li>
                            <li>Optional agile WLAN for area information and data transfer </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img src="/EN/solution/images/FA_Hospitality_v2.png" alt="Interactive Kiosk / Hospitality" class="img-fluid mt-2">
                    </div>
                </div>
                <div class="divider divider-sm divider-center"><i class="icon-bullhorn1"></i></div>
                <div class="row mt-6 mb-6">
                    <div class="title-1">
                        <h2>Press Release</h2>
                    </div>
                    <div class="col-lg-3">
                        <div class="course-card">
                            <a href="/en-US@Self-service_Kiosks_in_fuel_station~PRDetail"><img class="card-img-top" src="/images/pressroom_pic/Self-service_Kiosks_PR.jpg" alt="Self-service Kiosks in fuel station"></a>
                            <div class="card-body">
                                <h4 class="card-title fw-bold mb-2"><a href="/en-US@Self-service_Kiosks_in_fuel_station~PRDetail">Self-service Kiosks in fuel station</a></h4>
                                <p class="mb-2 card-title-sub fw-normal "><a href="/en-US@Self-service_Kiosks_in_fuel_station~PRDetail" class="text-black-50">2020/04/08</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3"></div>
                </div>
                <p class="mb-4">&nbsp;</p>
                <a name="FA-4"></a>
            </div>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0; background:#f8f8f8;">
            <div class="container clearfix">
                <div class="heading-block center">
                    <h2>Smart Charging Station for Stores</h2>
                    <span></span>
                </div>
                <div class="center title-1">
                    <h2 class="gradient-underline">Solutions: <a href="/EmbeddedSystem_E220_E220" />E220</a> / <a href="/EmbeddedSystem_E230_E230" />E230</a></h2>
                </div>
                <div class="row mt-6 mb-6">
                    <div class="col-lg-6 mt-4">
                        <img src="/EN/solution/images/FA_Charging_Station_v1.jpg" alt="Smart Charging Station for Stores" class="img-fluid mb-4">
                        <ul class="leftmargin-sm">
                            <li>Provide rich I/O connectivity in both serial and USB ports (2 x COM + 6 x USB)</li>
                            <li>Feature with dual display interface for multi-kiosk application</li>
                            <li>Optional WLAN feature for more IoT Kiosk applications</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img src="/EN/solution/images/FA_Charging_Station_v2.png" alt="Smart Charging Station for Stores" class="img-fluid mt-2">
                    </div>
                </div>
                <p class="mb-4">&nbsp;</p>
                <a name="FA-6"></a>
            </div>
        </div>
        <div class="container-fluid m-0 border-0" style="padding: 80px 0;">
            <div class="container clearfix">
                <div class="heading-block center">
                    <h2>Interactive Kiosk/ Self-ordering</h2>
                    <span></span>
                </div>
                <div class="center title-1">
                    <h2 class="gradient-underline">Solutions: <a href="/EN/products/standard-kiosks/#K32F" />K32F</a></h2>
                </div>
                <div class="row mt-6 mb-6">
                    <div class="col-lg-6 mt-4">
                        <img src="/EN/solution/images/RA_Kiosk_1.jpg" alt="Interactive Kiosk/ Self-ordering" class="img-fluid mb-4">
                        <ul class="leftmargin-sm">
                            <li>Replacing conventional manual operation by MiFace facial biometric recognition</li>
                            <li>Enabling personalized recommendation on customer's ordering selection by AI-driven solution </li>
                            <li>Encouraging more incentives on approaching interactive kiosk in post COVID-19 by MiAirtouch™</li>
                            <li>Allowing business users conscious of any real-time operation performance by BI Dashboard Analytics</li>
                            <li>Getting ready on most of Kiosk peripherals in terms of UPOS driver</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img src="/EN/solution/images/RA_Kiosk_2.png" alt="Interactive Kiosk/ Self-ordering" class="img-fluid mt-2">
                    </div>
                </div>
                <p class="mb-4">&nbsp;</p>
            </div>
        </div>
        <!-- FOOTER -->
        <?php
        include("../../foot1.htm");
        ?>
        <!-- FOOTER end -->
    </div><!-- #wrapper end -->
    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-line-arrow-up"></div>
    <!-- JavaScripts
    ============================================= -->
    <script src="/js1/plugins.min.js"></script>
    <!-- Footer Scripts
    ============================================= -->
    <script src="/js1/functions.js"></script>
    <!-- ADD-ONS JS FILES -->
    <script src="/js1/top.js"></script>
</body>

</html>