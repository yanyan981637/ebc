<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['act'])!=''){
  
  if(trim($_REQUEST['act'])=='del'){
  if(isset($_REQUEST['d_id'])!=''){
    $d_id01=intval($_REQUEST['d_id']);
    $str_del="Delete FROM `sp_hdd` where `ID`=".$d_id01;
	$del_cmd=mysqli_query($link_db,$str_del);
	echo "<script language='Javascript'>alert('delete the Data !');self.location='support_hdd.php';</script>";
	exit();
  }
  }
  
}

if(isset($_REQUEST['kinds'])!=''){
if(trim($_REQUEST['kinds'])=='update_suphdd'){
  if(isset($_POST['m_id'])!=''){
  $m_id=intval($_POST['m_id']);
  }else{
  $m_id="";
  }
  if(isset($_POST['M1'])!=''){
  $M1=trim($_POST['M1']);
  }else{
  $M1="";
  }
  if(isset($_POST['MN1'])!=''){
  $MN1=htmlspecialchars($_POST['MN1'], ENT_QUOTES);
  }else{
  $MN1="";
  }
  if(isset($_POST['TY1'])!=''){
  $TY1=trim($_POST['TY1']);
  }else{
  $TY1="";
  }
  if(isset($_POST['SZ1'])!=''){
  $SZ1=htmlspecialchars($_POST['SZ1'], ENT_QUOTES);
  }else{
  $SZ1="";
  }
  if(isset($_POST['CP1'])!=''){
  $CP1=trim($_POST['CP1']);
  }else{
  $CP1="";
  }
  if(isset($_POST['IR1'])!=''){
  $IR1=trim($_POST['IR1']);
  }else{
  $IR1="";
  }
  if(isset($_POST['n01'])!=''){
  $n01=trim($_POST['n01']);
  }else{
  $n01="";
  }
  if(isset($_POST['relProd_valM'])!=''){
  $relProd_valM=trim($_POST['relProd_valM']);
  }else{
  $relProd_valM="";
  }
  if(isset($_POST['status01'])!=''){
  $status01=trim($_POST['status01']);
  }else{
  $status01="";
  }
  
  putenv("TZ=Asia/Taipei");
  $now=date("Y/m/d H:i:s");
  
  $upd_str="UPDATE `sp_hdd` SET `VENDER_NAME`='".$M1."',`HDD_SIZE`='".$SZ1."',`NOTE`='".$n01."',`HDD_TYPE`='".$TY1."',`HDD_CAPACITY`='".$CP1."',`HDD_BUS`='".$IR1."',`LANG`='en-US',`MODEL`='".$relProd_valM."',`UPDATE_USER`='webmaster',`UPDATE_DATE`='$now',`STATUS`='".$status01."',`MODEL_NAME`='".$MN1."' WHERE `ID`=".$m_id;
  $upd_cmd=mysqli_query($link_db,$upd_str);
  echo "<script>alert('Update the Data!');window.location.href='support_hdd.php'</script>";
  exit();
}

if(trim($_REQUEST['kinds'])=='add_suphdd'){

$str_new="SELECT `ID` FROM `sp_hdd` order by `ID` desc limit 1";
$new_cmd=mysqli_query($link_db,$str_new);
$MCount=mysqli_fetch_row($new_cmd);
$NCount=$MCount[0]+1;

  if(isset($_POST['M1A'])!=''){
  $M1A=trim($_POST['M1A']);
  }else{
  $M1A="";
  }
  if(isset($_POST['MN1A'])!=''){
  $MN1A=htmlspecialchars($_POST['MN1A'], ENT_QUOTES);
  }else{
  $MN1A="";
  }
  if(isset($_POST['TY1A'])!=''){
  $TY1A=trim($_POST['TY1A']);
  }else{
  $TY1A="";
  }
  if(isset($_POST['SZ1A'])!=''){
  $SZ1A=trim($_POST['SZ1A']);
  }else{
  $SZ1A="";
  }
  if(isset($_POST['CP1A'])!=''){
  $CP1A=trim($_POST['CP1A']);
  }else{
  $CP1A="";
  }
  if(isset($_POST['IR1A'])!=''){
  $IR1A=trim($_POST['IR1A']);
  }else{
  $IR1A="";
  }
  if(isset($_POST['n01A'])!=''){
  $n01A=trim($_POST['n01A']);
  }else{
  $n01A="";
  }
  if(isset($_POST['relProd_val'])!=''){
  $relProd_val=trim($_POST['relProd_val']);
  }else{
  $relProd_val="";
  }
  if(isset($_POST['status01A'])!=''){
  $status01A=trim($_POST['status01A']);
  }else{
  $status01A="";
  }
  
  putenv("TZ=Asia/Taipei");
  $now=date("Y/m/d H:i:s");
  
  $str_inst="INSERT INTO `sp_hdd`(`ID`, `VENDER_NAME`, `HDD_SIZE`, `NOTE`, `HDD_TYPE`, `HDD_CAPACITY`, `HDD_BUS`, `LANG`, `MODEL`, `UPDATE_USER`,`UPDATE_DATE`, `STATUS`, `MODEL_NAME`) VALUES (".$NCount.",'".$M1A."','".$SZ1A."','".$n01A."','".$TY1A."','".$CP1A."','".$IR1A."','en-US','".$relProd_val."','webmaster','$now','".$status01A."','".$MN1A."')";
  $inst_cmd=mysqli_query($link_db,$str_inst);
  echo "<script>alert('AddNew a Data!');window.location.href='support_hdd.php'</script>";
  exit();
}
}

if(isset($_REQUEST['sear'])!=''){
if(trim($_REQUEST['sear'])=='ok'){
  
  if(isset($_REQUEST['s_search'])<>''){
   
   $s_search=trim($_REQUEST['s_search']);
   if(isset($_REQUEST['sTY1'])!=''){
   $sTY1=trim($_REQUEST['sTY1']);
   }else{
   $sTY1="";
   }
   if(isset($_REQUEST['sM1'])!=''){
   $sM1=trim($_REQUEST['sM1']);
   }else{
   $sM1="";
   }
   if(isset($_REQUEST['sSZ1'])!=''){
   $sSZ1=trim($_REQUEST['sSZ1']);
   }else{
   $sSZ1="";
   }
   if(isset($_REQUEST['sCP1'])!=''){
   $sCP1=trim($_REQUEST['sCP1']);
   }else{
   $sCP1="";
   }
   if(isset($_REQUEST['sIR1'])!=''){
   $sIR1=trim($_REQUEST['sIR1']);
   }else{
   $sIR1="";
   }
   
     if($sTY1<>''){
	   
	   if($sM1<>''){
	   
	     if($sSZ1<>''){
		 
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str1="SELECT count(*) FROM `sp_hdd` a INNER JOIN `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE INNER JOIN `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity INNER JOIN `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."'";
			 }
		   
		   }else{
		     
			 if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and a.MODEL_NAME='".$s_search."'";
			 }
			 
		   }
		 
		 }else{
		   
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."'";
			 }
			 
		   }else{
		   
		     if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and a.MODEL_NAME='".$s_search."'";
			 }
		   
		   }
		   
		 }
	   
	   }else{
	     
		 if($sSZ1<>''){
		    
		   if($sCP1<>''){
		      
			  if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."'";
			  }		   
		      
		   }else{
		   
		      if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and a.MODEL_NAME='".$s_search."'";
			  }

		   }
		   
		 }else{
		   
		   if($sCP1<>''){
		   
		      if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."'";
			  }
		   
		   }else{
			  
			  if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			  }else{
			   $str1="select count(*) from `sp_hdd` a where a.HDD_TYPE='".$sTY1."' and a.MODEL_NAME='".$s_search."'";
			  }
		   
		   }
		   
		 }
		 
	   }
	   
	 }else{
	   
	   if($sM1<>''){
	   
	     if($sSZ1<>''){
		 
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str1="SELECT count(*) FROM `sp_hdd` a INNER JOIN `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE INNER JOIN `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity INNER JOIN `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."'";
			 }
		   
		   }else{
		     
			 if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and a.MODEL_NAME='".$s_search."'";
			 }
			 
		   }
		 
		 }else{
		   
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity where a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."'";
			 }
			 
		   }else{
		   
		     if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and a.MODEL_NAME='".$s_search."'";
			 }
		   
		   }
		   
		 }
	   
	   }else{
	     
		 if($sSZ1<>''){
		    
		   if($sCP1<>''){
		      
			  if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."'";
			  }		   
		      
		   }else{
		   
		      if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and a.MODEL_NAME='".$s_search."'";
			  }

		   }
		   
		 }else{
		   
		   if($sCP1<>''){
		   
		      if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."'";
			  }
		   
		   }else{
			  
			  if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."'";
			  }else{
			   if($sM1!=''){
			     $str1="select count(*) from `sp_hdd` a where a.VENDER_NAME='".$sM1."' and a.MODEL_NAME='".$s_search."'";
			   }else{
			     $str1="select count(*) from `sp_hdd` a where a.MODEL_NAME like '%".$s_search."%'";
			   }
			  }
		   
		   }
		   
		 }
		 
	   }
	 
	 }
  
  }else{
      
   if(isset($_REQUEST['sTY1'])!=''){
   $sTY1=trim($_REQUEST['sTY1']);
   }else{
   $sTY1="";
   }
   if(isset($_REQUEST['sM1'])!=''){
   $sM1=trim($_REQUEST['sM1']);
   }else{
   $sM1="";
   }
   if(isset($_REQUEST['sSZ1'])!=''){
   $sSZ1=trim($_REQUEST['sSZ1']);
   }else{
   $sSZ1="";
   }
   if(isset($_REQUEST['sCP1'])!=''){
   $sCP1=trim($_REQUEST['sCP1']);
   }else{
   $sCP1="";
   }
   if(isset($_REQUEST['sIR1'])!=''){
   $sIR1=trim($_REQUEST['sIR1']);
   }else{
   $sIR1="";
   }
     
	 if($sTY1<>''){
	   
	   if($sM1<>''){
	   
	     if($sSZ1<>''){
		 
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str1="SELECT count(*) FROM `sp_hdd` a INNER JOIN `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE INNER JOIN `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity INNER JOIN `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1;
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1;
			 }
		   
		   }else{
		     
			 if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and d.ID=".$sIR1;
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1;
			 }
			 
		   }
		 
		 }else{
		   
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and d.ID=".$sIR1;
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1;
			 }
			 
		   }else{
		   
		     if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and d.ID=".$sIR1;
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."'";
			 }
		   
		   }
		   
		 }
	   
	   }else{
	     
		 if($sSZ1<>''){
		    
		   if($sCP1<>''){
		      
			  if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1;
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and c.ID=".$sCP1;
			  }		   
		      
		   }else{
		   
		      if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and d.ID=".$sIR1;
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1;
			  }

		   }
		   
		 }else{
		   
		   if($sCP1<>''){
		   
		      if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and c.ID=".$sCP1." and d.ID=".$sIR1;
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and c.ID=".$sCP1;
			  }
		   
		   }else{
			  
			  if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and d.ID=".$sIR1;
			  }else{
			   $str1="select count(*) from `sp_hdd` a where a.HDD_TYPE='".$sTY1."'";
			  }
		   
		   }
		   
		 }
		 
	   }
	   
	 }else{
	   
	   if($sM1<>''){
	   
	     if($sSZ1<>''){
		 
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str1="SELECT count(*) FROM `sp_hdd` a INNER JOIN `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE INNER JOIN `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity INNER JOIN `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1;
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1;
			 }
		   
		   }else{
		     
			 if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and d.ID=".$sIR1;
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1;
			 }
			 
		   }
		 
		 }else{
		   
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and d.ID=".$sIR1;
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity where a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1;
			 }
			 
		   }else{
		   
		     if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and d.ID=".$sIR1;
			 }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."'";
			 }
		   
		   }
		   
		 }
	   
	   }else{
	     
		 if($sSZ1<>''){
		    
		   if($sCP1<>''){
		      
			  if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1;
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and c.ID=".$sCP1;
			  }		   
		      
		   }else{
		   
		      if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and d.ID=".$sIR1;
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1;
			  }

		   }
		   
		 }else{
		   
		   if($sCP1<>''){
		   
		      if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where c.ID=".$sCP1." and d.ID=".$sIR1;
			  }else{
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where c.ID=".$sCP1;
			  }
		   
		   }else{
			  
			  if($sIR1<>''){
			   $str1="select count(*) from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where d.ID=".$sIR1;
			  }else{
			   //$str1="select count(*) from `sp_hdd` a where a.VENDER_NAME='".$sM1."'";
			   $str1="select count(*) from `sp_hdd` a";
			  }
		   
		   }
		   
		 }
		 
	   }
	 
	 }
  }
}
}else{
  $str1="select count(*) from `sp_hdd`";
}

$list1=mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - HDD/SSD Lists</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css.css" />

	<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
	<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
	<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
	<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
	<script language="javascript">
	function MM_o(selObj){
       window.open(document.getElementById('suphdd_page').options[document.getElementById('suphdd_page').selectedIndex].value,"_self");
    }
	
	function search_value(){
	 var sty1,sm1,ssz1,scp1,sir1,st1,sty01,sm01,ssz01,scp01,sir01,st01
	 sty1=document.getElementById('sTY1').value;
	 sm1=document.getElementById('sM1').value;
	 ssz1=document.getElementById('sSZ1').value;
	 scp1=document.getElementById('sCP1').value;
	 sir1=document.getElementById('sIR1').value;	
	 st1=document.getElementById('sear_txt').value;
	
	 if(sty1!=""){
	 sty01="&sTY1=" + sty1;
	 }else{
	 sty01="";
	 }	 
	 if(sm1!=""){
	 sm01="&sM1=" + sm1;
	 }else{
	 sm01="";
	 }
	 if(ssz1!=""){
	 ssz01="&sSZ1=" + ssz1;
	 }else{
	 ssz01="";
	 }
	 if(scp1!=""){
	 scp01="&sCP1=" + scp1;
	 }else{
	 scp01="";
	 }
	 if(sir1!=""){
	 sir01="&sIR1=" + sir1;
	 }else{
	 sir01="";
	 }
	 if(st1!=""){
	 st01="&s_search=" + st1;
	 }else{
	 st01="";
	 }
	 self.location = "?sear=ok" + sty01 + sm01 + ssz01 + scp01 + sir01 + st01;
    
	
	 return false;
    }
	
	function doEnter(event){
    var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
     if (keyCodeEntered == 13){
     //alert(keyCodeEntered);
     search_value();     
     }
    }
	
	function add_show(){
	 $('#sphdd_add').show();
	 $('#sphdd_edit').hide();
	}
	
	function hiden_show(){
	 self.location='support_hdd.php';
	}
	
	function hiden_edit(){
	 self.location='support_hdd.php';
	}
	
	function show_edit(){
	 $('#sphdd_add').hide();
	 $('#sphdd_edit').show();
	}
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
					title : {
						type : 'outside'
					},
					overlay : {
						speedIn : 500,
						opacity : 0.95
					}
				}
			});

			// Disable opening and closing animations, change title type
			$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background-color' : '#eee'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});


			/*
			 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
			 */

			$('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
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
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
			});

			$("#fancybox-manual-c").click(function() {
				$.fancybox.open([
					{
						href : '1_b.jpg',
						title : 'My title'
					}, {
						href : '2_b.jpg',
						title : '2nd title'
					}, {
						href : '3_b.jpg'
					}
				], {
					helpers : {
						thumbs : {
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
<div >
<div class="left"><h1>&nbsp;&nbsp;TYAN Website Backends - Website Contents Management - Contents: HDD/SSD Lists</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
//  menu
include("../../menu.php");
//  menu end
?>
<div class="clear"></div>

<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; HDD/SSD Lists</h2> 
</div>

<div id="content">
<br />
<div class="right">| &nbsp;<a href="support_module.php" />Support Lists management</a>&nbsp; | &nbsp;<a href="support_memory.php" />Memory Lists</a>&nbsp; | &nbsp;</div>
<br />
<p class="clear">&nbsp;</p>
<h3>HDD/SSD Lists:&nbsp;&nbsp;<a class="fancybox fancybox.iframe" href="lb_hdd_description.html" /><img src="../../images/icon_edit.png" alt="Edit" /></a></h3>

<div class="pagination left">
<form id="form3" name="form3" method="post" action="support_hdd.php?sear=ok">
<p>
<select id="sTY1" name="sTY1">
<option value="" selected>Type</option>
<?php
$str_t1="SELECT `ID`, `HDDTYPE` FROM `c_sp_hdd_type`";
$t1_result=mysqli_query($link_db,$str_t1);
while($t1_data=mysqli_fetch_row($t1_result)){
?>
<option value="<?=$t1_data[1];?>"><?=$t1_data[1];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<select id="sM1" name="sM1">
<option value="" selected>Vendor</option>
<?php
$str_m1="SELECT `ID`, `MODULEVENDER` FROM `c_sp_hdd_modulevender` order by `MODULEVENDER`";
$m1_result=mysqli_query($link_db,$str_m1);
while($m1_data=mysqli_fetch_row($m1_result)){
?>
<option value="<?=$m1_data[0];?>"><?=$m1_data[1];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<select id="sSZ1" name="sSZ1">
<option value="" selected>Size</option>
<?php
$str_s1="SELECT `ID`, `HDDSIZE`, `DESCRIPTION`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `c_sp_hdd_size` order by `HDDSIZE`";
$s1_result=mysqli_query($link_db,$str_s1);
while($s1_data=mysqli_fetch_row($s1_result)){
?>
<option value="<?=$s1_data[0];?>"><?=$s1_data[2];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<select id="sCP1" name="sCP1">
<option value="" selected>Capacity</option>
<?php
$str_c1="SELECT `ID`, `Capacity` FROM `c_sp_hdd_capacity`";
$c1_result=mysqli_query($link_db,$str_c1);
while($c1_data=mysqli_fetch_row($c1_result)){
?>
<option value="<?=$c1_data[0];?>"><?=$c1_data[1];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<select id="sIR1" name="sIR1">
<option value="" selected>Interface</option>
<?php
$str_r1="SELECT `ID`, `Interface` FROM `c_sp_hdd_interface`";
$r1_result=mysqli_query($link_db,$str_r1);
while($r1_data=mysqli_fetch_row($r1_result)){
?>
<option value="<?=$r1_data[0];?>"><?=$r1_data[1];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<input id="sear_txt" name="sear_txt" type="text" size="20" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" />  <span style="color:#0F0">**Key word search: "Model Name" & "Compatible Products" 欄位 </span> </p>
</form>
<p>Total: <span class="w14bblue"><?=$public_count;?></span> records </p>
</div>

<table class="list_table">
  <tr>
 	<th>*Type <a class="fancybox fancybox.iframe" href="lb_hddssd_type.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th> 
    <th >*Vendor <a class="fancybox fancybox.iframe" href="lb_hddssd_vender.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th>
	<th>*Model Name </th>
	<th>*Size <a class="fancybox fancybox.iframe" href="lb_hddssd_size.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th>
	<th>*Capacity <a class="fancybox fancybox.iframe" href="lb_hddssd_capacity.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th>
	<th>*Interface  <a class="fancybox fancybox.iframe" href="lb_hddssd_bus.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th>
	<th>*Status</th>
	<th>Compatible Products</th>
	<th><div class="button14" ><a href="#sphdd_add" style="width:50px;" onClick="add_show();">Add</a></div></th>
  </tr>
  <?php
      if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=intval($_REQUEST['page']);
      }
      
      if(empty($page))$page="1";
      
      $read_num="10";
      $start_num=$read_num*($page-1);
	  
      
if(isset($_REQUEST['sear'])!=''){
  if(trim($_REQUEST['sear'])=='ok'){
   $sTY1="";$sM1="";$sSZ1="";$sCP1="";
   
   if(isset($_REQUEST['sTY1'])!=''){
   $sTY1=trim($_REQUEST['sTY1']);
   }else{
   $sTY1="";
   }
   if(isset($_REQUEST['sM1'])!=''){
   $sM1=trim($_REQUEST['sM1']);
   }else{
   $sM1="";
   }
   if(isset($_REQUEST['sSZ1'])!=''){
   $sSZ1=trim($_REQUEST['sSZ1']);
   }else{
   $sSZ1="";
   }
   if(isset($_REQUEST['sCP1'])!=''){
   $sCP1=trim($_REQUEST['sCP1']);
   }else{
   $sCP1="";
   }
   if(isset($_REQUEST['sIR1'])!=''){
   $sIR1=trim($_REQUEST['sIR1']);
   }else{
   $sIR1="";
   }
  
  if(isset($_REQUEST['s_search'])!=''){
   $s_search=trim($_REQUEST['s_search']);
     if($sTY1<>''){
	   
	   if($sM1<>''){
	   
	     if($sSZ1<>''){
		 
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str="SELECT a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME FROM `sp_hdd` a INNER JOIN `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE INNER JOIN `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity INNER JOIN `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
		   
		   }else{
		     
			 if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
			 
		   }
		 
		 }else{
		   
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
			 
		   }else{
		   
		     if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
		   
		   }
		   
		 }
	   
	   }else{
	     
		 if($sSZ1<>''){
		    
		   if($sCP1<>''){
		      
			  if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }		   
		      
		   }else{
		   
		      if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }

		   }
		   
		 }else{
		   
		   if($sCP1<>''){
		   
		      if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }
		   
		   }else{
			  
			  if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a where a.HDD_TYPE='".$sTY1."' and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }
		   
		   }
		   
		 }
		 
	   }
	   
	 }else{
	   
	   if($sM1<>''){
	   
	     if($sSZ1<>''){
		 
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str="SELECT a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME FROM `sp_hdd` a INNER JOIN `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE INNER JOIN `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity INNER JOIN `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
		   
		   }else{
		     
			 if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
			 
		   }
		 
		 }else{
		   
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity where a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
			 
		   }else{
		   
		     if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
		   
		   }
		   
		 }
	   
	   }else{
	     
		 if($sSZ1<>''){
		    
		   if($sCP1<>''){
		      
			  if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }		   
		      
		   }else{
		   
		      if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }

		   }
		   
		 }else{
		   
		   if($sCP1<>''){
		   
		      if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where c.ID=".$sCP1." and d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where c.ID=".$sCP1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }
		   
		   }else{
			  
			  if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where d.ID=".$sIR1." and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   if($sM1!=''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a where a.VENDER_NAME='".$sM1."' and a.MODEL_NAME='".$s_search."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			   }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a where a.MODEL_NAME like '%".$s_search."%' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			   }
			  }
		   
		   }
		   
		 }
		 
	   }
	 
	 }
  
  }else{   

     
	 if($sTY1<>''){
	   
	   if($sM1<>''){
	   
	     if($sSZ1<>''){
		 
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str="SELECT a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME FROM `sp_hdd` a INNER JOIN `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE INNER JOIN `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity INNER JOIN `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
		   
		   }else{
		     
			 if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
			 
		   }
		 
		 }else{
		   
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
			 
		   }else{
		   
		     if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
		   
		   }
		   
		 }
	   
	   }else{
	     
		 if($sSZ1<>''){
		    
		   if($sCP1<>''){
		      
			  if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }		   
		      
		   }else{
		   
		      if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and b.ID=".$sSZ1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }

		   }
		   
		 }else{
		   
		   if($sCP1<>''){
		   
		      if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and c.ID=".$sCP1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and c.ID=".$sCP1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }
		   
		   }else{
			  
			  if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a where a.HDD_TYPE='".$sTY1."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }
		   
		   }
		   
		 }
		 
	   }
	   
	 }else{
	   
	   if($sM1<>''){
	   
	     if($sSZ1<>''){
		 
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str="SELECT a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME FROM `sp_hdd` a INNER JOIN `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE INNER JOIN `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity INNER JOIN `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and c.ID=".$sCP1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
		   
		   }else{
		     
			 if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and b.ID=".$sSZ1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
			 
		   }
		 
		 }else{
		   
		   if($sCP1<>''){
		     
			 if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity where a.VENDER_NAME='".$sM1."' and c.ID=".$sCP1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
			 
		   }else{
		   
		     if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where a.HDD_TYPE='".$sTY1."' and a.VENDER_NAME='".$sM1."' order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			 }
		   
		   }
		   
		 }
	   
	   }else{
	     
		 if($sSZ1<>''){
		    
		   if($sCP1<>''){
		      
			  if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and c.ID=".$sCP1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and c.ID=".$sCP1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }		   
		      
		   }else{
		   
		      if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_size` b on a.HDD_SIZE=b.HDDSIZE inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where b.ID=".$sSZ1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }

		   }
		   
		 }else{
		   
		   if($sCP1<>''){
		   
		      if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where c.ID=".$sCP1." and d.ID=".$sIR1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_capacity` c on a.HDD_CAPACITY=c.Capacity inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where c.ID=".$sCP1." order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }
		   
		   }else{
			  
			  if($sIR1<>''){
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a inner join `c_sp_hdd_interface` d on a.HDD_BUS=d.Interface where d.ID=".$sIR1." limit $start_num,$read_num;";
			  }else{
			   $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a order by a.UPDATE_DATE desc limit $start_num,$read_num;";
			  }
		   
		   }
		   
		 }
		 
	   }
	 
	 }
  }
}
}else{
  $str="select a.ID,a.VENDER_NAME,a.HDD_SIZE,a.NOTE,a.HDD_TYPE,a.HDD_CAPACITY,a.HDD_BUS,a.LANG,a.MODEL,a.UPDATE_USER,a.UPDATE_DATE,a.STATUS,a.MODEL_NAME from `sp_hdd` a order by a.UPDATE_DATE desc limit $start_num,$read_num;";
}

	  $result=mysqli_query($link_db,$str);
	  $i=0;
      while(list($ID, $VENDER_NAME, $HDD_SIZE, $NOTE, $HDD_TYPE, $HDD_CAPACITY, $HDD_BUS, $LANG, $MODEL, $UPDATE_USER, $UPDATE_DATE, $STATUS, $MODEL_NAME)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
	<td><?=$HDD_TYPE;?></td>
    <td><?php
	$str_vend="SELECT `ID`, `MODULEVENDER` FROM `c_sp_hdd_modulevender` where `ID`=".$VENDER_NAME." order by `MODULEVENDER`";
	$vend_cmd=mysqli_query($link_db,$str_vend);
	$vend_data=mysqli_fetch_row($vend_cmd);
	echo $vend_data[1];
	?></td>
	<td ><?=$MODEL_NAME;?></td>
	<td ><?=$HDD_SIZE;?></td>
	<td ><?=$HDD_CAPACITY;?></td>
	<td ><?=$HDD_BUS;?></td>
	<td >
	<?php
	if($STATUS=='1'){
	echo "Enabled";
	}else if($STATUS=='0'){
	echo "Disabled";
	}
	?>
	</td>
	<td><div class="div1">
	<?php
	$MODEL_split=explode(',',$MODEL,-1);
	$j=0;
	for($i=0;$i<=count($MODEL_split)-1;$i++){
	 $j=$j+1;
	 if($j%3==0){
	 $br="<br />";
	 }else{
	 $br="";
	 }
	 echo $MODEL_split[$i].",".$br;
	}
	?>
	</div></td>
	<td ><a href="support_hdd.php?mid=<?=$ID;?> #sphdd_edit">Edit</a>&nbsp;&nbsp;<a href="support_hdd.php?act=del&d_id=<?=$ID;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
  </tr>
  <?php
      }
  ?>
  <tr>
    <td colspan="9">
    <?php
        $all_page=ceil($public_count/$read_num);
        $pageSize=$page;
		$total=$all_page;
		pageft($total,$pageSize,1,0,0,15);       
    ?>
    </td>
  </tr>
</table>
<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="suphdd_page" name="suphdd_page" onChange="MM_o(this)">
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?>
</div>
  <P style="color:#0F0">
  - 資料由舊系統dump: http://www.tyan.com/TYANWEBMGT/support_hdd.aspx<br>
  - "Status" 決定這個 HDD/SSD 是否會出現在被套用的 SKU page 上的 "Support HDD/SSD Lists" 中 <br >
- "Compatible Products"只列最新的三筆 SKU <br>- click "Del" 要popup a confirmation window to proceed<br >
    - * 表可sorting<br >- List順序:新至舊
  </p>
<p class="clear">&nbsp;</p>

<!--Click Edit and add -->							
<div id="sphdd_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_suphdd" onsubmit="return Final_Check();">
<h1>Add a HDD/SSD:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_show();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>HDD/SSD Vendor:  </th>
<td>
<select id="M1A" name="M1A">
<option value="" selected>Select</option>
<?php
$str_m1A="SELECT `ID`, `MODULEVENDER` FROM `c_sp_hdd_modulevender` order by `MODULEVENDER`";
$m1A_result=mysqli_query($link_db,$str_m1A);
while($m1A_data=mysqli_fetch_row($m1A_result)){
?>
<option value="<?=$m1A_data[0];?>"><?=$m1A_data[1];?></option>
<?php
}
?>
</select>
</td>
<tr>
<th>Model Name: </th>
<td><input id="MN1A" name="MN1A" type="text" size="30" value="" /></td>
</tr>
</tr>
<tr>
<th>HDD/SSD Type:</th>
<td>
<select id="TY1A" name="TY1A">
<option value="" selected>Select</option>
<?php
$str_t1A="SELECT `ID`, `HDDTYPE` FROM `c_sp_hdd_type`";
$t1A_result=mysqli_query($link_db,$str_t1A);
while($t1A_data=mysqli_fetch_row($t1A_result)){
?>
<option value="<?=$t1A_data[1];?>"><?=$t1A_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>HDD/SSD Size: </th>
<td>
<select id="SZ1A" name="SZ1A">
<option value="" selected>Select</option>
<?php
$str_s1A="SELECT `ID`, `HDDSIZE`, `DESCRIPTION`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `c_sp_hdd_size` order by `HDDSIZE`";
$s1A_result=mysqli_query($link_db,$str_s1A);
while($s1A_data=mysqli_fetch_row($s1A_result)){
?>
<option value="<?=htmlspecialchars($s1A_data[1], ENT_QUOTES);?>"><?=$s1A_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>HDD/SSD Capacity: </th>
<td>
<select id="CP1A" name="CP1A">
<option value="" selected>Select</option>
<?php
$str_c1A="SELECT `ID`, `Capacity` FROM `c_sp_hdd_capacity`";
$c1A_result=mysqli_query($link_db,$str_c1A);
while($c1A_data=mysqli_fetch_row($c1A_result)){
?>
<option value="<?=$c1A_data[1];?>"><?=$c1A_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>HDD/SSD Interface: </th>
<td>
<select id="IR1A" name="IR1A">
<option value="" selected>Select</option>
<?php
$str_r1A="SELECT `ID`, `Interface` FROM `c_sp_hdd_interface`";
$r1A_result=mysqli_query($link_db,$str_r1A);
while($r1A_data=mysqli_fetch_row($r1A_result)){
?>
<option value="<?=$r1A_data[1];?>"><?=$r1A_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Note: </th>
<td><textarea cols="100" id="n01A" name="n01A" rows="10"></textarea></td>
</tr>
<tr>
<th>Compatible Products:</th>
<td> <div class="button14 " style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_supported_pros.php" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
 <p><span id="relProd"></span></p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr>
<th>Status:</th>
<td><select id="status01A" name="status01A"><option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select><span style="color:#0F0">預設Enabled</span>
</td>
</tr>
<tr><td colspan="2">
<input name="b2" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="c2" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:self.location='support_hdd.php'" />  <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check(){
 if(document.form1.M1A.value==''){
 alert('Required select HDD/SSD Vendor!');
 document.form1.M1A.focus();
 return false;
 }
 if(document.form1.MN1A.value==''){
 alert('Required Input Model Name!');
 document.form1.MN1A.focus();
 return false;
 }
 if(document.form1.TY1A.value==''){
 alert('Required select HDD/SSD Type!');
 document.form1.TY1A.focus();
 return false;
 }
 if(document.form1.SZ1A.value==''){
 alert('Required select HDD/SSD Size!');
 document.form1.SZ1A.focus();
 return false;
 }
 if(document.form1.CP1A.value==''){
 alert('Required select HDD/SSD Capacity!');
 document.form1.CP1A.focus();
 return false;
 }
 if(document.form1.IR1A.value==''){
 alert('Required select HDD/SSD Interface!');
 document.form1.IR1A.focus();
 return false;
 }
 if(document.form1.relProd_val.value == ""){
 alert("Required Input a Related Products!");
 document.form1.relProd_val.focus();
 return false;
 }
 return true;
}
</script>
</div>
<?php
if(isset($_REQUEST['mid'])!=''){
  $mid01=intval($_REQUEST['mid']);
  $str_m="SELECT `ID`, `VENDER_NAME`, `HDD_SIZE`, `NOTE`, `HDD_TYPE`, `HDD_CAPACITY`, `HDD_BUS`, `LANG`, `MODEL`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`, `MODEL_NAME` FROM `sp_hdd` where `ID`=".$mid01;
  $m_cmd=mysqli_query($link_db,$str_m);
  $m_data=mysqli_fetch_row($m_cmd);
?>
<div id="sphdd_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=update_suphdd" onsubmit="return MFinal_Check();">
<h1>Edit a HDD/SSD:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>HDD/SSD Vendor:  </th>
<td>
<select id="M1" name="M1">
<option value="">Select</option>
<?php
$str_m1M="SELECT `ID`, `MODULEVENDER` FROM `c_sp_hdd_modulevender` order by `MODULEVENDER`";
$m1M_result=mysqli_query($link_db,$str_m1M);
while($m1M_data=mysqli_fetch_row($m1M_result)){
?>
<option value="<?=$m1M_data[0];?>" <?php if($m_data[1]==$m1M_data[0]){ echo "selected"; } ?>><?=$m1M_data[1];?></option>
<?php
}
?>
</select>
</td>
<tr>
<th>Model Name: </th>
<td><input id="MN1" name="MN1" type="text" size="30" value="<?=$m_data[12];?>" /></td>
</tr>
</tr>
<tr>
<th>HDD/SSD Type:</th>
<td>
<select id="TY1" name="TY1">
<option value="">Select</option>
<?php
$str_t1M="SELECT `ID`, `HDDTYPE` FROM `c_sp_hdd_type`";
$t1M_result=mysqli_query($link_db,$str_t1M);
while($t1M_data=mysqli_fetch_row($t1M_result)){
?>
<option value="<?=$t1M_data[1];?>" <?php if($m_data[4]==$t1M_data[1]){ echo "selected"; } ?>><?=$t1M_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>HDD/SSD Size: </th>
<td>
<select id="SZ1" name="SZ1">
<option value="">Select</option>
<?php
$str_s1M="SELECT `ID`, `HDDSIZE`, `DESCRIPTION`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `c_sp_hdd_size` order by `HDDSIZE`";
$s1M_result=mysqli_query($link_db,$str_s1M);
while($s1M_data=mysqli_fetch_row($s1M_result)){
?>
<option value="<?=$s1M_data[1];?>" <?php if(htmlspecialchars($m_data[2], ENT_QUOTES)==htmlspecialchars($s1M_data[1], ENT_QUOTES)){ echo "selected"; } ?>><?=$s1M_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>HDD/SSD Capacity: </th>
<td>
<select id="CP1" name="CP1">
<option value="">Select</option>
<?php
$str_c1M="SELECT `ID`, `Capacity` FROM `c_sp_hdd_capacity`";
$c1M_result=mysqli_query($link_db,$str_c1M);
while($c1M_data=mysqli_fetch_row($c1M_result)){
?>
<option value="<?=$c1M_data[1];?>" <?php if($m_data[5]==$c1M_data[1]){ echo "selected"; } ?>><?=$c1M_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>HDD/SSD Interface: </th>
<td>
<select id="IR1" name="IR1">
<option value="">Select</option>
<?php
$str_r1M="SELECT `ID`, `Interface` FROM `c_sp_hdd_interface`";
$r1M_result=mysqli_query($link_db,$str_r1M);
while($r1M_data=mysqli_fetch_row($r1M_result)){
?>
<option value="<?=$r1M_data[1];?>" <?php if($m_data[6]==$r1M_data[1]){ echo "selected"; } ?>><?=$r1M_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Note: </th>
<td><textarea cols="100" id="n01" name="n01" rows="10"><?=$m_data[3];?></textarea></td>
</tr>
<tr>
<th>Compatible Products:</th>
<td> <div class="button14 " style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_hddlist_pros.php?cid=<?=$m_data[0];?>" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$m_data[8];?></textarea>
 <p><span id="relProd"></span></p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr>
<th>Status:</th>
<td><select id="status01" name="status01"><option value="1" <?php if($m_data[11]=='1'){ echo "selected"; } ?>>Enabled</option><option value="0" <? if($m_data[11]=='0'){ echo "selected"; } ?>>Disabled</option></select><span style="color:#0F0">預設Enabled</span>
</td>
</tr>
<tr><td colspan="2">
<input id="m_id" name="m_id" type="hidden" value="<?=$m_data[0];?>"><input name="b3" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="c3" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:self.location='support_hdd.php'" />  <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function MFinal_Check(){
 if(document.form2.M1.value==''){
 alert('Required select HDD/SSD Vendor!');
 document.form2.M1.focus();
 return false;
 }
 if(document.form2.MN1.value==''){
 alert('Required Input Model Name!');
 document.form2.MN1.focus();
 return false;
 }
 if(document.form2.TY1.value==''){
 alert('Required select HDD/SSD Type!');
 document.form2.TY1.focus();
 return false;
 }
 if(document.form2.SZ1.value==''){
 alert('Required select HDD/SSD Size!');
 document.form2.SZ1.focus();
 return false;
 }
 if(document.form2.CP1.value==''){
 alert('Required select HDD/SSD Capacity!');
 document.form2.CP1.focus();
 return false;
 }
 if(document.form2.IR1.value==''){
 alert('Required select HDD/SSD Interface!');
 document.form2.IR1.focus();
 return false;
 }
 if(document.form2.relProd_valM.value == ''){
 alert("Required Input a Related Products!");
 document.form2.relProd_valM.focus();
 return false;
 }
 return true;
}
</script>
</div>
<?php
}
?>

</div>
<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>

<script src="../ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'n01A', {
    });
</script>
<script>
  CKEDITOR.replace( 'n01', {
    });
</script>
</body>
</html>
<?php
if(isset($_REQUEST['mid'])!=''){
  echo "<script>show_edit();</script>\n";
  exit();
}
?>