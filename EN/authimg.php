<?php
$CaptchaString = "";	//驗證碼文字
$CaptchaLength = 6;		//驗證碼長度

//產生數字驗證碼
for($i=0; $i < $CaptchaLength; $i++){
	// $number=$arr[rand(0,36)];
	$CaptchaString = $CaptchaString.rand(0,9);
}
session_start();
$_SESSION['Checknum'] = $CaptchaString;	//驗證碼存入SESSION內
ob_clean();
Header("Content-type: image/PNG");	//宣告輸出為PNG影像
$CaptchaWidth = 55;					//驗證碼影像寬度
$CaptchaHeight = 15;				//驗證碼影像高度

//建立影像
$Captcha = ImageCreate($CaptchaWidth, $CaptchaHeight);
//設定背景顏色，範例是紅色
$BackgroundColor = ImageColorAllocate($Captcha, 206, 223, 220);
//設定文字顏色，範例是黑色
$FontColor = ImageColorAllocate($Captcha, 0, 0, 0);
//影像填滿背景顏色
ImageFill($Captcha, 0, 0, $BackgroundColor);
//影像畫上驗證碼
ImageString($Captcha, 20, 0, 0, $_SESSION['Checknum'] , $FontColor);
//隨機畫上200個點，做為雜訊用
for($i = 0; $i < 150; $i++) {
	Imagesetpixel($Captcha, rand() % $CaptchaWidth , rand() % $CaptchaHeight , $FontColor);
}
//輸出驗證碼影像
ImagePNG($Captcha);
ImageDestroy($Captcha);

?>