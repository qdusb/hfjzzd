<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
/**************
** �Զ��庯�� **
***************/

//��ת��������Ϣ��ʾҳ
//@param:msg	������Ϣ
//@param:url	��ת��ҳ��,����򷵻���һҳ
function Warning($msg,$url='')
{	$msg=urlencode($msg);
	header("location: Warning.php?msg=$msg&url=$url");
	exit();
}
//��ת����ȷ��Ϣ��ʾҳ
//@param:msg	������Ϣ
//@param:url	��ת��ҳ��,����򷵻���һҳ
function isok($msg,$url='')
{	$msg=urlencode($msg);
	@header("location: isok.php?msg=$msg&url=$url");
	exit();
}

//�����Ź���
function safe($str){	
	return Trim($str)	;
}
//�ַ�������
//@param:str	�ַ���
function md5str($str){
	return md5(md5(base64_encode($str)));
}
//�����Ź��ǣ�����sql��䡣



//�����ַ�����ȡ
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

//ת��ҳ��,��֮ǰ�������κ�������
Function Redirect($url){
	Header("location: $url");
	exit();
}

//JSת��ҳ��
Function JSRedirect($url){
	echo "<script>top.location.href='$url';</script>";
	exit();
}


//�滻��ʾHTML
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