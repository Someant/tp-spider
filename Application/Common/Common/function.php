<?php

if(! function_exists('sendMail')){

    function sendMail($to, $title, $content, $isHtml = false, $from_name = '') {
        $cacheName = 'mail_content_to_'.$to.'_'.md5($content);

        if (S($cacheName)){
            return true;
        }

        Vendor('phpmailer.PHPMailerAutoload');

        $mail = new PHPMailer;

        $mail->SMTPDebug = C('SMTP_CONFIG.MAIL_DEBUG');                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->CharSet = C('SMTP_CONFIG.MAIL_CHARSET');
        $mail->Host = C('SMTP_CONFIG.MAIL_HOST');  // Specify main and backup SMTP servers
        $mail->SMTPAuth = C('SMTP_CONFIG.MAIL_SMTPAUTH');                               // Enable SMTP authentication
        $mail->Username = C('SMTP_CONFIG.MAIL_USERNAME');                 // SMTP username
        $mail->Password = C('SMTP_CONFIG.MAIL_PASSWORD');                           // SMTP password
        $mail->SMTPSecure = C('SMTP_CONFIG.MAIL_SMTPSecure');                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = C('SMTP_CONFIG.MAIL_PORT');                                    // TCP port to connect to

        if (empty($from_name)){
            $from_name = C('SMTP_CONFIG.MAIL_FROMNAME');
        }

        $mail->setFrom(C('SMTP_CONFIG.MAIL_FROM'), $from_name);
        $mail->addAddress($to);     // Add a recipient
        $mail->Subject = $title;

        if($isHtml){
            //$mail->msgHTML(file_get_contents(VENDOR_PATH.'phpmailer/example/index.html'), dirname(__FILE__));
            $mail->msgHTML($content, dirname(__FILE__));
        }else{
            $mail->Body    = $content;
        }

        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if($mail->send()){
            S($cacheName,$content,1800);
            return true;
        }
        sendMessageToMe($title.'邮件发送失败');
        return false;
    }

}

if(! function_exists('sendMailToDeveloper')){

    function sendMailToDeveloper($title,$message, $isHtml = false, $from_name = '')
    {
        foreach (C('DEVELOPER_MAILING_LIST') as $item){
            \Spider\Queues\Helper::addMailJob($item, $title, $message, $isHtml, $from_name);
        }
    }

}

if(! function_exists('addMyLog')){

    function addMyLog($msg, $file_name){
        $file_path = __DIR__ . '/../../Runtime/';

        if(count(explode('error',$file_name))>1){
            //sendMailToDeveloper('[异常]：'.$file_name,$msg);
        }

        error_log(date('m-d H:i:s') . '    :     ' . $msg . "\n", 3, $file_path . $file_name . '_' . date('Y-m-d') . '.log');
    }

}

if(! function_exists('postByCurl')){

    function postByCurl($target_url, $post_data, $default_timeout_sec = 30){
        $start_time_ms = microtime(true);
        $post_fields = is_array($post_data)?http_build_query($post_data):$post_data;
        $cp = curl_init();
        curl_setopt($cp, CURLOPT_URL, $target_url);
        curl_setopt($cp, CURLOPT_HEADER, false);
        curl_setopt($cp, CURLOPT_POST, true);
        curl_setopt($cp, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($cp, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cp, CURLOPT_TIMEOUT, $default_timeout_sec);

        $curl_result = curl_exec($cp);
        addMyLog('curl result from url:' . $target_url . "\n" . 'result:' . $curl_result . "\n" . ' post data:' . print_r($post_data, true), 'hp_curl');

        if (curl_errno($cp)) {
            addMyLog('curl result from url:' . $target_url . "\n" . 'result:' . $curl_result . "\n" . ' post data:' . print_r($post_data, true), 'hp_curl_err');
            addMyLog('curl error:' . $target_url . '===errorno:' . curl_errno($cp) . '===error msg:' . curl_error($cp), 'hp_curl_err');
        }

        curl_close($cp);
        addMyLog('curl begin by time: ' . $start_time_ms, 'hp_time');
        addMyLog('curl end by time: ' . microtime(true) . '=========' . $start_time_ms, 'hp_time');
        addMyLog('curl use: ' . $start_time_ms . '=========' . (microtime(true) - $start_time_ms), 'hp_time');
        return $curl_result;
    }

}

if (! function_exists('pregDomain')){

    function pregDomain($url)
    {
        preg_match('/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}/',$url,$matches);
        return $matches[1];
    }

}