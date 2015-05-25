<?php
@session_start();
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


  $sql="select * from admininfo where `username`='".$_SESSION['username']."'";

  $query=$db->query($sql);
  if($arr=$db->fetch_array($query)){
  	$create_time=$arr['create_time'];
	$login_sum	=$arr['login_sum'];
	$modify_time=$arr['modify_time'];
  }
?>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="-1000">
		<link href="Inc/body.css" rel="stylesheet" type="text/css">
	</head>

	<body> 

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="28"> 
				<td background="images/title_bg1.jpg">&nbsp;当前位置: 管理中心</td>
			</tr>
			<tr> 
				<td bgcolor="#B1CEEF" height="1"></td>
			</tr>
			<tr height="20"> 
				<td background="images/shadow_bg.jpg"></td>
			</tr>
		</table>


		<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="100">
				<td align="center" width="100"><img src="images/admin_p.gif" width="90" height="100"></td>
				<td width="60">&nbsp;</td>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100">
						<tr>
							<td>当前时间：<?php echo date("Y-m-d h:i")?></td>
						</tr>
						<tr>
							<td style="font-size:16px;font-weight:bold;"><?php echo $_SESSION['realname']?></td>
						</tr>
						<tr>
							<td>欢迎进入网站管理中心！</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3" height="10"></td>
			</tr>
		</table>



			<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
				  <td>&nbsp;</td>
				</tr>
			</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="20">
				<td></td>
			</tr>
			<tr height="22">
				<td background="images/title_bg2.jpg" align="center" style="PADDING-LEFT:20px;FONT-WEIGHT:bold;COLOR:#ffffff">您的相关信息</td>
			</tr>
			<tr height="12" bgcolor="#ECF4FC">
				<td></td>
			</tr>
			<tr height="20">
				<td></td>
			</tr>
		</table>

		<table width="95%" border="0" cellspacing="0" cellpadding="2" align="center">
			<tr>
				<td width="100" height="22" align="right">登陆帐号：</td>
			  <td height="22" style="color:#880000;"><?php echo $_SESSION['username']?></td>
			</tr>
			<tr>
				<td height="22" align="right">真实姓名：</td>
			  <td height="22" style="color:#880000;"><?php echo $_SESSION['realname']?></td>
			</tr>
			<tr>
				<td height="22" align="right">注册时间：</td>
			  <td height="22" style="color:#880000;"><?php echo date("Y-m-d h:i:s",$create_time)?></td>
			</tr>
			<tr>
				<td height="22" align="right">登陆次数：</td>
			  <td height="22" style="color:#880000;"><?php echo $login_sum?></td>
			</tr>
			<tr>
				<td height="22" align="right">修改时间：</td>
			  <td height="22" style="color:#880000;"><?php echo date("Y-m-d h:i:s",$modify_time)?></td>
			</tr>
			<tr>
				<td height="22" align="right">IP地址：</td>
			  <td height="22" style="color:#880000;"><?php echo $_SERVER["REMOTE_ADDR"]; ?></td>
			</tr>
			<tr>
				<td height="22" align="right">身份过期：</td>
			  <td height="22" style="color:#880000;">30 分钟</td>
			</tr>
	</table>

	</body>
</html>