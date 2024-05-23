                  <?php
                    // 連線資料庫
                    header("Cache-Control: no-store, no-cache, must-revalidate");
                    header("Cache-Control: post-check=0, pre-check=0", false);
                    header('Content-Type: text/html; charset=utf-8');

                    session_start();
                    if (empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])) {
                        echo "<script language='JavaScript'>location='../../login.php'</script>";
                        exit();
                    }

                    require "../../config.php";

                    // 建立連線
                    $conn = new mysqli($db_host, $db_user, $db_pwd, $dataBase);
                    // 檢查連線是否成功
                    if ($conn->connect_error) {
                        die('資料庫連線錯誤: ' . $conn->connect_error);
                    }
                    // 設置字符集編碼
                    $conn->query('SET NAMES utf8mb4');
                    // 設置時區
                    $conn->query('SET time_zone = "+8:00"');

                    $Type = isset($_GET['type']) ? trim($_GET['type']) : '';
                    $input = isset($_GET['input']) ? trim($_GET['input']) : '';
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

                    // 一頁顯示 10 筆
                    $per_page = 10;
                    // 計算偏移量
                    $offset = ($currentPage - 1) * $per_page;

                    // 去資料庫撈出總共有幾筆資料
                    $countSql = "SELECT COUNT(*) AS total FROM dsg_accessory";
                    if (!empty($input) && !empty($Type)) {
                        if (!strpos($countSql, 'WHERE')) {
                            $countSql .= " WHERE ";
                        } else {
                            $countSql .= " AND ";
                        }
                        // 使用 $Type 的值判斷欄位
                        $countSql .= " (dsg_accessory.$Type LIKE '%$input%')";
                    }

                    // 紀錄數量查詢
                    $countResult = $conn->query($countSql);
                    if ($countResult && $countRow = $countResult->fetch_assoc()) {
                        $total_count = $countRow['total'];
                    } else {
                        $total_count = 0;
                    }
                    //總頁數
                    $total_pages = ceil($total_count / $per_page);


                    $sql = "SELECT * FROM dsg_accessory ";
                    if (!empty($input) && !empty($Type)) {
                        if (strpos($sql, 'WHERE') === false) {
                            $sql .= " WHERE ";
                        } else {
                            $sql .= " AND ";
                        }

                        // 使用 $Type 的值判斷欄位
                        $sql .= " (dsg_accessory.$Type LIKE '%$input%' )";
                    }
                    $sql .= " ORDER BY DATE DESC LIMIT $offset, $per_page";
                    $result = $conn->query($sql);

                    ?>

                  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                  <html xmlns="http://www.w3.org/1999/xhtml">
                  <head>
                      <title>Website Contents Management - Products Management - Contents: Modules - Accessory management </title>
                      <link rel=stylesheet type="text/css" href="../../backend.css">

                      <script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
                      <script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
                      <script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
                      <link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
                      <link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
                      <script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
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
                  </head>
                  <body>
                      <a name="top"></a>
                      <div>
                          <div class="left">
                              <h1>&nbsp;&nbsp;MCT Website Backends - MDSG PCN Management</h1>
                          </div>

                          <div id="logout">Hi <?= str_replace("@mic.com.tw", "", $_SESSION['user']); ?> <a href="../logo.php">Log out &gt;&gt;</a></div>
                      </div>

                      <div class="clear"></div>
                      <div id="menu">
                          <ul>
                              <li><a href="../default.php">Products</a>

                              </li>
                              <li> <a href="../modules.php">Contents</a>
                                  <ul>
                                      <li><a href="../modules.php">Modules</a></li>
                                  </ul>
                              </li>
                              <li><a href="../newsletter.php">Newsletters</a>
                                  <ul>
                                      <li><a href="../subscribe.php">Subscription</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </div>

                      <div class="clear"></div>

                      <div id="Search">
                          <h2>Contents &nbsp;&gt;&nbsp; <a href="../modules.php">Modules</a> &nbsp;&gt;&nbsp; Accessory management</h2>
                      </div>
                      <div id="content">

                          <br />

                          <h3>Accessory List:</h3>

                          <div class="pagination left">
                              <p>
                                  <select id="selectvalue">
                                      <option value="mm_number" selected>MM#</option>
                                      <option value="product_code">Product Code</option>
                                      <!--<option value="">Description</option>-->
                                  </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input id="input" name="" type="text" size="30" value="" />
                                  <input name="" type="button" value="Search" onclick="Filter()" />
                              </p>

                              <p>Total: <span class="w14bblue"><?php echo $total_count; ?></span> records &nbsp;&nbsp;| &nbsp;&nbsp;<input name="" type="text" size="1" value="10" /> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;<select name="" onchange="window.location.href = 'accessory_mgt.php?page=' + this.value;">
                                      <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                                          <option value='<?php echo $page; ?>&type=<?php echo $Type; ?>&input=<?php echo $input; ?>' <?php if ($currentPage == $page) echo "selected"; ?>><?php echo $page; ?>
                                          </option>
                                      <?php endfor; ?>
                                  </select></p>
                          </div>

                          <table class="list_table">
                              <tr>
                                  <th>MM#</th>
                                  <th>Product code</th>
                                  <th><a class="fancybox fancybox.iframe" href="lb_accessory_type.php" /><img src="../../images/icon_edit.png" alt="Edit" />Accessory Type</a></th>
                                  <th>Description</th>
                                  <th>Products</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>
                                      <div class="button14" style="width:50px;" onclick="AA()">Add</div>
                                  </th>
                              </tr>
                              <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                      <tr>
                                          <td><?php echo $row['mm_number']; ?></td>
                                          <td><?php echo $row['product_code']; ?></td>
                                          <td><?php
                                                $accessory_ids = explode(",", $row['accessory_type']);
                                                $names = array();
                                                foreach ($accessory_ids as $id) {
                                                    if (!empty($id)) {
                                                        // 查询 accessory_type 表中对应 ID 的 Name
                                                        $sql = "SELECT Name FROM accessory_type WHERE ID = $id";
                                                        $result_name = $conn->query($sql);
                                                        if ($result_name && $result_name->num_rows > 0) {
                                                            $row_name = $result_name->fetch_assoc();
                                                            $names[] = $row_name['Name'];
                                                        }
                                                    }
                                                }
                                                echo implode(", ", $names);
                                                ?>
                                          </td>
                                          <td><?php echo $row['description']; ?></td>
                                          <td><?php echo $row['products_models']; ?></td>
                                          <td><?php echo $row['DATE']; ?></td>
                                          <td>
                                              <?php
                                                if (isset($row['status'])) {
                                                    $status = ($row['status'] == 1) ? "Online" : "Offline";
                                                    echo $status;
                                                } else {
                                                    echo "Status not available";
                                                }
                                                ?>
                                          </td>
                                          <td>
                                              <a href="?type=<?php echo urlencode($Type); ?>&type=<?php echo urlencode($Type); ?>&input=<?php echo urlencode($input); ?>&id=<?php echo $row['ID']; ?>" id="BB">Edit</a>
                                              &nbsp;&nbsp;
                                              <a href="?type=<?php echo urlencode($Type); ?>&input=<?php echo urlencode($input); ?>&act=del&id=<?php echo $row['ID']; ?>" onclick="return confirm('確定要刪除嗎？')">Del</a>
                                          </td>
                                      </tr>
                              <?php
                                    }
                                    mysqli_free_result($result);
                                } else {
                                    echo "<tr><td colspan='8'>No data</td></tr>";
                                }
                                ?>
                          </table>
                          <?php
                            // 刪除
                            if (isset($_GET['act']) && $_GET['act'] == 'del' && isset($_GET['id'])) {
                                $id = $_GET['id'];
                                // 執行刪除操作
                                $sql2 = "DELETE FROM dsg_accessory WHERE ID = '$id'";

                                if ($conn->query($sql2) === TRUE) {
                                    echo "<script>window.location.href = 'accessory_mgt.php?type=" . urlencode($Type) . "&input=" . urlencode($input) . "';</script>";
                                    exit();
                                } else {
                                    echo "Error: " . $sql2 . "<br>" . $conn->error;
                                }
                            }
                            ?>
                          <p style="color:#0F0">- List順序: 新至舊</p>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
                          <p class="clear">&nbsp;</p>
                          <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $mm1 = $_POST["mm"];
                                $mm = mysqli_real_escape_string($conn, $mm1);//能讓雙引號 單引號 反協號 加到資料庫
                                $code1 = $_POST["product"];
                                $code = mysqli_real_escape_string($conn, $code1);
                                $date = $_POST["date"];
                                //Accessory Type
                                if (isset($_POST["type"]) && is_array($_POST["type"])) {
                                    $type = implode(",", $_POST["type"]);
                                } else {
                                    $type = ''; // 或者任何您認為合適的默認值
                                }
                                if (isset($_POST["val"])) {
                                    $val = $_POST["val"];
                                } else {
                                }
                                if (isset($_POST["vall"])) {
                                    $vall = $_POST["vall"];
                                } else {
                                }

                                $description1 = $_POST["description"];
                                $description = mysqli_real_escape_string($conn, $description1);
                                $status = $_POST["status"];
                                date_default_timezone_set('Asia/Taipei');
                                $c_date = date("Y-m-d H:i:s"); // 創建時間
                                $U_date = date("Y-m-d H:i:s"); // 更新時間
                                // 如果存在 GET 有 id
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    $sql = "UPDATE dsg_accessory SET mm_number='$mm', product_code='$code', Date='$date', accessory_type='$type', products_models='$vall', description ='$description',status='$status', U_DATE= '$U_date' WHERE ID='$id'";
                                    // 執行更新 SQL 查询
                                    if ($conn->query($sql) === TRUE) {
                                        // 如果查詢成功
                                        echo "<script>alert('修正成功！');</script>";
                                        echo "<script>window.location.replace('accessory_mgt.php');</script>";
                                        exit();
                                    } else {
                                        // 如果查询失敗
                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                    }
                                } else {
                                    // 否則
                                    $sql = "INSERT INTO dsg_accessory (mm_number, product_code, Date, accessory_type, products_models, description, status, C_DATE) VALUES ('$mm', '$code', '$date', '$type', '$val', '$description','$status', '$c_date')";
                                    if ($conn->query($sql) === TRUE) {
                                        echo "<script>alert('新增成功！');</script>";
                                        echo "<script>window.location.replace('accessory_mgt.php');</script>";
                                        exit();
                                    } else {
                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                    }
                                }
                            }
                            ?>
                          <div id="aa" class="subsettings" style="display: none;">
                              <h1>Add an Accessory</h1>
                              <div class="right"><a href="#" onclick="javascript:location.href='accessory_mgt.php'">[close]</a></div>

                              <form id="myForm1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                  <table class="addspec">
                                      <tr>
                                          <th>MM#</th>
                                          <td><input name="mm" type="text" size="40" value="" /></td>
                                      </tr>
                                      <tr>
                                          <th>Product code</th>
                                          <td><input name="product" type="text" size="40" value="" /></td>
                                      </tr>
                                      <tr>
                                          <th>Date</th>
                                          <td><input type="date" name="date" size="40" value="" /></td>
                                      </tr>
                                      <tr>
                                          <th>Accessory Type</th>
                                          <td>
                                              <?php
                                                $sql = "SELECT * FROM accessory_type";
                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                      <input type="checkbox" name="type[]" value="<?php echo $row['ID']; ?>"> <?php echo $row['Name']; ?>&nbsp;&nbsp;
                                              <?php
                                                    }
                                                } else {
                                                    echo "<td>No accessory types found</td>";
                                                }
                                                ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <th>Products</th>
                                          <td>
                                              <div class="button14 " style="width:60px;">
                                                  <a class="fancybox fancybox.iframe" href="../lb_supported_pros_accessory.php" style="color:#ffffff">Edit</a>
                                              </div>

                                              <textarea id="val" name="val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
                                          </td>
                                      </tr>
                                      <tr>
                                          <th>Description</th>
                                          <td><textarea name="description" rows="6" cols="50" style="max-width: 300px; max-height: 300px;"></textarea></td>
                                      </tr>
                                      <tr>
                                          <th>Status:</th>
                                          <td>
                                              <select id="status" name="status">
                                                  <option value="1" selected>Online</option>
                                                  <option value="0">Offline</option>
                                              </select>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="2">
                                              <input name="submit" type="submit" value="Done" />
                                              <input name="" type="button" value="Cancel" onclick="javascript:location.href='accessory_mgt.php'" />
                                              <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
                                          </td>
                                      </tr>
                                  </table>
                              </form>
                          </div>
                          <!-- Edit      Edit         Edit           Edit 		  -->
                          <?php if (!empty($_GET['id'])) : //f12

                                if (isset($_GET['id'])) {
                                    // 从 GET 请求中获取 id
                                    $id = $_GET['id'];

                                    $result = $conn->query("SELECT * FROM dsg_accessory WHERE ID = '$id'");
                                    if ($result && $result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                    } else {
                                        // 如果未找到
                                    }
                                }
                            ?>
                              <div id="bb" class="subsettings" style="display: none;">
                                  <h1>Edit an Accessory</h1>
                                  <div class="right"><a href="#" onclick="javascript:location.href='accessory_mgt.php'">[close]</a></div>

                                  <form id="myForm2" method="post" action="">

                                      <table class="addspec">
                                          <tr>
                                              <th>MM#</th>
                                              <td><input name="mm" type="text" size="40" value="<?php echo $row['mm_number']; ?>" /></td>
                                          </tr>
                                          <tr>
                                              <th>Product code</th>
                                              <td><input name="product" type="text" size="40" value="<?php echo $row['product_code']; ?>" /></td>
                                          </tr>
                                          <tr>
                                              <th>Date</th>
                                              <td><input type="date" name="date" size="40" value="<?php echo $row['DATE']; ?>" /></td>
                                          </tr>
                                          <tr>
                                              <th>Accessory Type</th>
                                              <td>
                                                  <?php
                                                    // 获取 dsg_accessory 表中的 accessory_type 值
                                                    $dsg_accessory_types = explode(",", $row['accessory_type']);

                                                    $sql = "SELECT * FROM accessory_type";
                                                    $result = $conn->query($sql);

                                                    if ($result && $result->num_rows > 0) {
                                                        while ($roww = $result->fetch_assoc()) {
                                                            //  檢查 accessory_type 是否在 dsg_accessory 中存在
                                                            $checked = in_array($roww['ID'], $dsg_accessory_types) ? 'checked' : '';
                                                    ?>
                                                          <input type="checkbox" name="type[]" value="<?php echo $roww['ID']; ?>" <?php echo $checked; ?>> <?php echo $roww['Name']; ?>&nbsp;&nbsp;
                                                  <?php
                                                        }
                                                    } else {
                                                        echo "<td>No accessory types found</td>";
                                                    }
                                                    $conn->close();
                                                    ?>
                                              </td>
                                          </tr>
                                          <tr>
                                              <th>Products</th>
                                              <td>
                                                  <div class="button14 " style="width:60px;">
                                                      <a class="fancybox fancybox.iframe" href="../elb_supported_pros_accessory.php?models=<?php echo $row['products_models']; ?>" style="color:#ffffff">Edit</a>
                                                  </div>
                                                  <textarea id="vall" name="vall" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?php echo $row['products_models']; ?></textarea>
                                              </td>
                                          </tr>
                                          <tr>
                                              <th>Description</th>
                                              <td><textarea name="description" rows="6" cols="50" style="max-width: 300px; max-height: 300px;"><?php echo $row['description']; ?></textarea></td>
                                          </tr>
                                          <tr>
                                              <th>Status:</th>
                                              <td>
                                                  <select id="status" name="status">
                                                      <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>>Online</option>
                                                      <option value="0" <?php if ($row['status'] == 0) echo 'selected'; ?>>Offline</option>
                                                  </select>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="2">
                                                  <input name="submit" type="submit" value="Done" />
                                                  <input name="" type="button" value="Cancel" onclick="javascript:location.href='accessory_mgt.php'" />
                                                  <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
                                              </td>
                                          </tr>
                                      </table>
                                  </form>
                              </div>
                          <?php endif;    ?>

                          <p class="clear">&nbsp;</p>
                      </div>
                      <div id="footer"> Copyright &copy; 2014 Company Co. All rights reserved.
                          <div class="gotop" onClick="location='#top'">Top</div>
                      </div>

                      <script>
                          function AA() {
                              const subSettings = document.querySelector('.subsettings');
                              subSettings.style.display = 'block';
                              $("#bb").hide();
                          }
                          $(document).ready(function() {
                              $("#BB").click(function() {
                                  //EDIT ID=BB
                              });

                              // 显示 #bb 元素的函数
                              function show_edit() {
                                  $("#bb").show();
                                  //TABLE
                              }

                              // 有ID調用show_edit()
                              <?php
                                if (isset($_REQUEST['id']) && $_REQUEST['id'] !== '') {
                                    echo "show_edit();";
                                }
                                ?>
                          });

                          function Filter() {
                              let select = document.getElementById("selectvalue").value.trim();
                              let input = document.getElementById("input").value.trim();

                              let url = "accessory_mgt.php?type=" + encodeURIComponent(select) + "&input=" + encodeURIComponent(input);
                              window.location.href = url;
                          }
                      </script>

                  </body>

                  </html>