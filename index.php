<?php
/**
*  index.php Jong 
* 
* @copyright			(C) 2024-2025 Jong 
* @license				QQ:3865176
* @lastmodify			2024-11-14 
*/
//目录分隔符
define('DS', DIRECTORY_SEPARATOR);
 //PHPCMS根目录
define('PATHS', dirname(__FILE__).DS);

//debug
define('APP_DEBUG', true);
include 'debug/debug.class.php';


include PATHS.'/app/Base.php';
base::app();


if(defined('APP_DEBUG')&&APP_DEBUG){
					
 if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
	 // ajax 请求的处理方式就不输出调试了,避免json格式错误 
   }else{
	 debug::message(); 
	 }
 }