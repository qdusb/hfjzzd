<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	$title		=	$_POST['title'];
	$username	=	$_POST['username'];
	$tel		=	$_POST['tel'];
	$mails		=	$_POST['mails'];
	$content	=	$_POST['content'];
	
	$id=$db->getMax('message','id')+1;
	$sql="insert into message(id,title,adduser,phone,mails,content,create_time) values($id,'$title','$username','$tel','$mails','$content',".time().")";
	$db->query($sql);
		echo "<script>alert('���Գɹ�!лл��Ա�վ��֧��!');location.href='service.php';</script>";
		exit();
	
}
?>
<script language="javascript">
	function check(form)
	{
		if (form.title.value == "")
		{
			alert("���������Ա��⣡");
			form.title.focus();
			return false; 
		}
		if (form.username.value == "")
		{
			alert("����������������");
			form.username.focus();
			return false;
		}
		if (form.content.value == "")
		{
			alert("�������������ݣ�");
			form.content.focus();
			return false;
		}
	}
</script>
<table width="345" height="178" border="0" align="center" cellpadding="0" cellspacing="1">
<form id="form1" name="form1" method="post" action="" onsubmit="return check(this);">
    <tr>
      <td height="22" align="center">���Ա��⣺</td>
      <td height="22" align="left"><input name="title" type="text" id="title" size="30" class="book" /></td>
    </tr>
    <tr>
      <td height="22" align="center">����������</td>
      <td height="22" align="left"><input name="username" type="text" id="username" size="30" class="book"  /></td>
    </tr>
    <tr>
      <td height="22" align="center">�������ݣ�</td>
      <td height="22" align="left"><textarea name="content" cols="30" rows="4" id="content" class="book" ></textarea></td>
    </tr>
    <tr>
      <td height="22" align="center">&nbsp;</td>
      <td height="22" align="left">
	  <input type="submit" value=" ���� " style="height:22px;line-height:18px;">&nbsp; <input type="reset" value=" ���� " style="height:22px;line-height:18px;">	  </td>
    </tr>
</form>
</table>
