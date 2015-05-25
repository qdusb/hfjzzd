<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}

$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$listURL="?page=$page";
?>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>


 
 <?php

if($_SERVER['REQUEST_METHOD']=='POST'){
	$title		=	$_POST['title'];
	$username	=	$_POST['username'];
	$tel		=	$_POST['tel'];
	$mails		=	$_POST['mails'];
	$content	=	$_POST['content'];
	if(!ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $mails))
    {
        echo "<script>alert('电子邮件不正确');location.href='message.php';</script>";
		return false;
    }
	if(!preg_match("/^1(3|5)\d{9}$/",$tel))
	{
		echo "<script>alert('手机号码不正确');location.href='message.php';</script>";
		return false;
	}
	else
	{
	$id=$db->getMax('message','id')+1;
	$sql="insert into message(id,title,adduser,phone,mails,content,create_time) values($id,'$title','$username','$tel','$mails','$content',".time().")";
	$db->query($sql);
		echo "<script>alert('留言成功!谢谢你对本站的支持!');location.href='index.php';</script>";
		exit();
	
}}
?>
<script language="javascript">
	function check(form)
	{
		if (form.title.value == "")
		{
			alert("请输入留言标题！");
			form.title.focus();
			return false; 
		}
		if (form.username.value == "")
		{
			alert("请输入您的姓名！");
			form.username.focus();
			return false;
		}
		if (form.content.value == "")
		{
			alert("请输入留言内容！");
			form.content.focus();
			return false;
		}
		//验证手机号码
		 if(form.tel.length == 0  || form.tel.value == "")
        {
           alert('请输入手机号码！');
           document.form.tel.focus();
           return false;
        } 
		//验证电子邮箱   
		if(document.form1.mails.value.length!=0)  {  
    if (document.form1.mails.value.charAt(0)=="." ||          
         document.form1.mails.value.charAt(0)=="@"||         
         document.form1.mails.value.indexOf('@', 0) == -1 ||   
         document.form1.mails.value.indexOf('.', 0) == -1 ||   
         document.form1.mails.value.lastIndexOf("@")==document.form1.mails.value.length-1 ||   
         document.form1.mails.value.lastIndexOf(".")==document.form1.mails.value.length-1)  
     {  
      alert("Email地址格式不正确！");  
      document.form1.mails.focus();  
      return false;  
      }  
   }else  
  {  
   alert("Email不能为空！");  
   document.form1.mails.focus();  
   return false;  
   }  				
	}
</script>
<table width="100%" border="0" align="right" cellpadding="5" cellspacing="1" style="margin:0px 0px 0px 0px;background:#f7f7f7;">
<form id="form1" name="form1" method="post" action="" onsubmit="return check(this);">
    <tr>
      <td width="518" height="43" align="right">留言标题：</td>
      <td width="753"><input name="title" type="text" id="title" size="50" class="book" />
      *</td>
    </tr>
    <tr>
      <td height="40" align="right">您的姓名：</td>
      <td><input name="username" type="text" id="username" size="30" class="book"  />
      *</td>
    </tr>
    <tr>
      <td height="41" align="right">联系电话：</td>
      <td><input name="tel" type="text" id="tel" size="30" class="book"  /></td>
    </tr>
    <tr>
      <td height="52" align="right">您的邮箱：</td>
      <td><input name="mails" type="text" id="mails" size="50" class="book"  /></td>
    </tr>
    <tr>
      <td height="150" align="right">留言内容：</td>
      <td><textarea name="content" cols="50" rows="8" id="content" class="book" ></textarea>
      *</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input type="submit" value=" 发送 " style="height:22px;line-height:18px;">&nbsp; <input type="reset" value=" 重填 " style="height:22px;line-height:18px;">	  </td>
    </tr>
</form>
</table>
