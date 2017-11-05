<?php
return [
    'SMTP_CONFIG' => [
        // 配置邮件发送服务器
        'MAIL_HOST' => 'smtp.163.com',//smtp服务器的名称
        'MAIL_SMTPAUTH' => true, //启用smtp认证
        'MAIL_PORT' => 994,
        'MAIL_SMTPSecure' => 'ssl',
        'MAIL_USERNAME' => 'aihaijin@163.com',//你的邮箱名
        'MAIL_FROM' => 'aihaijin@163.com',//发件人地址
        'MAIL_FROMNAME'=>' Log',//发件人姓名
        'MAIL_PASSWORD' => 'xxxxx',//邮箱密码
        'MAIL_CHARSET' => 'UTF-8',//设置邮件编码
        'MAIL_ISHTML' => true, // 是否HTML格式邮件
        'MAIL_DEBUG' => 0
    ],
];