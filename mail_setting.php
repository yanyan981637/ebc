<?php
function mail_setting(
    $mail_host,
    $mail_port = '25',
    $mail_user = null,
    $mail_pwd = null,
    $mail_from,
    $mail_from_name,
    $mail_to = null,
    $mail_to_name = null,
    $mail_subject,
    $mail_content,
    $fail_back = true
) {
    $instance = new PHPMailer(); //建立新物件
    // Enable verbose debug output, 3 is debug mode
    $instance->SMTPDebug = 0;

    $instance->CharSet = 'UTF-8';
    $instance->Encoding = 'base64';
    $instance->isSMTP();
    $instance->Host = $mail_host;

    if ($mail_port == '25') {
        $instance->SMTPAuth = false;
    } else {
        $instance->SMTPAuth = true;
        $instance->Username = $mail_user;
        $instance->Password = $mail_pwd;
        $instance->SMTPSecure = 'tls';
    }

    $instance->Port = $mail_port;
    $instance->From = $mail_from;
    $instance->FromName = $mail_from_name;

    $instance->Subject = $mail_subject;
    $instance->Body = $mail_content;
    $instance->isHTML(true);

    $instance->SMTPAutoTLS = false;

    if ($fail_back) {
        $instance->AddAddress('tony.wei@mitacmdt.com', 'tony.wei (魏東明 - MDT)');
        $instance->AddAddress('ling.huang@mitacmdt.com', 'ling.huang (黃苑菱 - MDT)');
        $instance->AddAddress('yanyan.lin@mitacmdt.com', 'yanyan.lin (林彥廷 - MDT)');
    } else {
        $instance->AddAddress($mail_to, $mail_to_name);
    }

    return $instance;
}
