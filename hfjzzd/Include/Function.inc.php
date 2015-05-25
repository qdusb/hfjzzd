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



//汉字字符串截取
function cnsubstr($string,$length){ 
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



class astrictIP
{
	var $startip	=	null;
	var $endip		=	null;
	
	function __construct($startip,$endip='')
	{
		$this->astrictIP($startip,$endip);
    }

	function astrictIP($startip,$endip='')
	{
		$this->startip = $startip;
		$this->endip = $endip;
	}

	function checkIP($flag = true)
	{
		if($flag)
		{
			return ($this->numIP($this->get_client_ip())>=$this->numIP($this->startip) && $this->numIP($this->get_client_ip())<=$this->numIP($this->endip));
		}
		else
		{
			return ($this->numIP($this->get_client_ip())<=$this->numIP($this->startip) || $this->numIP($this->get_client_ip())>=$this->numIP($this->endip));
		}
	}

	function numIP($ip)
	{
		$tip = explode('.',$ip);
		$tip = intval($tip[0])*256*256*256+intval($tip[1])*256*256+intval($tip[2])*256+intval($tip[3])-1;
		return $tip;

	}

	function makeIP($num)
	{
		$tip = array();
		$tip[0] = intval($num/256/256/256);
		$tip[1] = intval(($num-$tip[0]*256*256*256)/256/256);
		$tip[2] = intval(($num-$tip[0]*256*256*256-$tip[1]*256*256)/256);
		$tip[3] = intval(($num-$tip[0]*256*256*256-$tip[1]*256*256-$tip[2]*256) % 256)+1;
		return implode('.',$tip);
	}

	function get_client_ip(){
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return($ip);
    }
}
?>