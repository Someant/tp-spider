<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH',__DIR__.'/Application/');

//ini_set('display_startup_errors',0);    //php启动错误信息
//error_reporting(E_ALL ^ E_NOTICE);                    //打印出所有的 错误信息
require __DIR__.'/vendor/autoload.php';
// 引入ThinkPHP入口文件
require __DIR__.'/ThinkPHP/ThinkPHP.php';


// 亲^_^ 后面不需要任何代码了 就是如此简单
//require './vendor/autoload.php';
//require './ThinkPHP/Library/vendor/phpmailer/PHPMailerAutoload.php';