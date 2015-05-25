<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
/**************
** 自定义函数 **
***************/

//跳转到错误信息显示页
//@param:msg	警告信息
//@param:url	跳转的页面,如空则返回上一页
function Warning($msg,$url='')
{	$msg=urlencode($msg);
	header("location: Warning.php?msg=$msg&url=$url");
	exit();
}
//跳转到正确信息显示页
//@param:msg	警告信息
//@param:url	跳转的页面,如空则返回上一页
function isok($msg,$url='')
{	$msg=urlencode($msg);
	@header("location: isok.php?msg=$msg&url=$url");
	exit();
}

//单引号过虑
function safe($str){	
	return Trim($str)	;
}
//字符串加密
//@param:str	字符串
function md5str($str){
	return md5(md5(base64_encode($str)));
}
//单引号过虑，用于sql语句。

function cnhtml($str){
	//$str=str_replace("<p>"),"",$str);
	$str=str_replace("<p>",'',$str);	
	$str=str_replace("</p>",'',$str);	
	$str=str_replace("<br>",'',$str);	
	$str=str_replace("&nbsp;",'',$str);	
	return $str;
}

//汉字字符串截取
function cnsubstr($string,$length){ 
	if($length>=strlen($string))	return $string;	
		for($i=0; $i<$length; $i++)
           if (ord($string[$i]) > 128) $i++; 			
     return substr($string,0,$i).'..';		 
}
function cnsubstr_c($string,$length){ 
	$string=cnhtml(strip_tags($string));
	if($length>=strlen($string))	return $string;	
		for($i=0; $i<$length; $i++)
           if (ord($string[$i]) > 128) $i++; 			
     return substr($string,0,$i).'..';		 
}

//
Function ToLimitLng($number,$min,$max){
	$number=(int)$number;
	$number=$number<$min?$min:$number;
	$number=$number>$max?$max:$number;
	return $number;
}

//转向页面,在之前不能有任何输出语句
Function Redirect($url){
	Header("location: $url");
	exit();
}

//JS转向页面
Function JSRedirect($url){
	echo "<script>top.location.href='$url';</script>";
	exit();
}


//替换显示HTML
function asc($str){
	$str=str_replace(chr(10),'<br>',$str);

	return $str;
}
?>