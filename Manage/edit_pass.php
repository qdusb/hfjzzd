<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

session_start();
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$sql="select username,passwd,realname from admininfo where username='".$_SESSION['username']."'";
if($arr=$db->fetch_array($db->query($sql))){
	$username=$arr['username'];
	$passwd=$arr['passwd'];
	$realname=$arr['realname'];

}else{
	$db->close();
	Redirect("logout.php?action=logout");
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	$oldpass=$_POST['oldpass'];
	$newpass=$_POST['newpass'];

	if($oldpass=="" || $newpass==""){
		$db->close();
		Warning("������д��������");
	}

	if(strlen($newpass)<8){
		$db->close();
		Warning("�����볤��С��8λ��");
	}
	
	$sql="select username from admininfo where username='$username' and passwd='".md5str($oldpass)."'";
	if(!$arr=$db->fetch_array($db->query($sql))){		
		$db->close();
		Warning("ԭʼ���벻��ȷ!");
	}

	$sql="update admininfo set passwd='".md5str($newpass)."',modify_time='".time()."' where username='$username'";
	$db->query($sql);
	$db->close();
	echo "<script>alert('�����޸ĳɹ�!');location.href='edit_pass.php'</script>";
	exit();
	
}

?>

<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="-1000">

		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>

		<script language="javascript">
			function check(form)
			{
				if (form.oldpass.value == "")
				{
					alert("ԭ���벻��Ϊ�գ�");
					form.oldpass.focus();
					return false;
				}

				if (form.newpass.value == "")
				{
					alert("��½���벻��Ϊ�գ�");
					form.newpass.focus();
					return false;
				}

				if (form.newpass.value.length < 8)
				{
					alert("���볤�Ȳ�������8λ��");
					form.newpass.focus();
					return false;
				}

				if (form.newpass.value == "xgxian")
				{
					alert("���벻�ܺ��ʺ���ͬ��");
					form.newpass.focus();
					return false;
				}

				if (form.newpass.value == form.oldpass.value)
				{
					alert("�����벻�ܺ�ԭ������ͬ��");
					form.newpass.focus();
					return false;
				}

				if (/^[0-9]*$/.exec(form.newpass.value))
				{
					alert("���벻��ֻʹ�����֣���������֡�Ӣ����ĸ�����������ɣ�");
					form.newpass.focus();
					return false;
				}

				if (form.newpass2.value != form.newpass.value)
				{
					alert("������������벻һ�£�");
					form.newpass2.focus();
					return false;
				}
				return true;
			}
		</script>
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; ���˹��� -&gt; �޸Ŀ���</td>
			</tr>
		</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
				<tr>
					<td colSpan="2">�޸Ŀ���</td>
				</tr>
				<tr>
					<td width="17%" class="editLeftTd">��½�ʺ�</td>
					<td width="83%" class="editRightTd"><?php echo $username?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��ʵ����</td>
					<td class="editRightTd"><?php echo $realname?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">ԭ����</td>
					<td class="editRightTd"><input type="password" name="oldpass" value="" size="30" maxlength="20"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">������</td>
					<td class="editRightTd"><input type="password" name="newpass" value="" size="30" maxlength="20"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">ȷ��������</td>
					<td class="editRightTd"><input type="password" name="newpass2" value="" size="30" maxlength="20"></td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" value=" ȷ �� ">
                      <input name="reset" type="reset" value=" �� �� "></td>
				</tr>
			</form>
		</table>

		<script language="javascript">
			document.form1.oldpass.focus();
		</script>

	</body>
</html>