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

function cnhtml($str){
	//$str=str_replace("<p>"),"",$str);
	$str=str_replace("<p>",'',$str);	
	$str=str_replace("</p>",'',$str);	
	$str=str_replace("<br>",'',$str);	
	$str=str_replace("&nbsp;",'',$str);	
	return $str;
}

//�����ַ�����ȡ
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
?>