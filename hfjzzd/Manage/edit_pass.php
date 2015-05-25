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
		Warning("资料填写不完整！");
	}

	if(strlen($newpass)<8){
		$db->close();
		Warning("新密码长度小于8位！");
	}
	
	$sql="select username from admininfo where username='$username' and passwd='".md5str($oldpass)."'";
	if(!$arr=$db->fetch_array($db->query($sql))){		
		$db->close();
		Warning("原始密码不正确!");
	}

	$sql="update admininfo set passwd='".md5str($newpass)."',modify_time='".time()."' where username='$username'";
	$db->query($sql);
	$db->close();
	echo "<script>alert('密码修改成功!');location.href='edit_pass.php'</script>";
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
					alert("原密码不能为空！");
					form.oldpass.focus();
					return false;
				}

				if (form.newpass.value == "")
				{
					alert("登陆密码不能为空！");
					form.newpass.focus();
					return false;
				}

				if (form.newpass.value.length < 8)
				{
					alert("密码长度不能少于8位！");
					form.newpass.focus();
					return false;
				}

				if (form.newpass.value == "xgxian")
				{
					alert("密码不能和帐号相同！");
					form.newpass.focus();
					return false;
				}

				if (form.newpass.value == form.oldpass.value)
				{
					alert("新密码不能和原密码相同！");
					form.newpass.focus();
					return false;
				}

				if (/^[0-9]*$/.exec(form.newpass.value))
				{
					alert("密码不能只使用数字！最好由数字、英文字母和特殊符号组成！");
					form.newpass.focus();
					return false;
				}

				if (form.newpass2.value != form.newpass.value)
				{
					alert("两次输入的密码不一致！");
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
				<td class="position">当前位置: 管理中心 -&gt; 个人管理 -&gt; 修改口令</td>
			</tr>
		</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
				<tr>
					<td colSpan="2">修改口令</td>
				</tr>
				<tr>
					<td width="17%" class="editLeftTd">登陆帐号</td>
					<td width="83%" class="editRightTd"><?php echo $username?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">真实姓名</td>
					<td class="editRightTd"><?php echo $realname?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">原密码</td>
					<td class="editRightTd"><input type="password" name="oldpass" value="" size="30" maxlength="20"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">新密码</td>
					<td class="editRightTd"><input type="password" name="newpass" value="" size="30" maxlength="20"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">确认新密码</td>
					<td class="editRightTd"><input type="password" name="newpass2" value="" size="30" maxlength="20"></td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" value=" 确 定 ">
                      <input name="reset" type="reset" value=" 重 填 "></td>
				</tr>
			</form>
		</table>

		<script language="javascript">
			document.form1.oldpass.focus();
		</script>

	</body>
</html>