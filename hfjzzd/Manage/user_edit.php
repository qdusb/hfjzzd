<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];


$listURL="user_list.php";
$editURL="user_edit.php?id=$id";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


if($_SERVER['REQUEST_METHOD']=='POST'){
	$username	= substr($_POST['username'],0,50);
	$birthday	= substr($_POST['birthday'],0,50);
	
	//���

	if($username==""){
		Warning("��д�Ĳ����д���");
	}
	
	if($birthday==""){
		Warning("��д�Ĳ����д���");
	}
	
	//����

	if($id>0){
		if($db->getCount("userinfo","*","user_id=$id")<>1){
			$db->connclose();
			Warning("�Ƿ�������");
		}

		$sql = "update userinfo set username='$username',birthday='$birthday' where user_id=$id";
	}else{
		if($db->getMax("userinfo", "user_id", "")<1){
			$id=$big_id*1000+1;
		}else{
			$id=$db->getMax("userinfo", "user_id", "")+1;
		}

		if($db->getCount("userinfo", "*", "user_id=$id")>0){
			$db->close();
			Warning("����Ŀ�µĶ��������Ѿ��ﵽ��������ޣ���������µķ����ˣ�");
		}

		$sql="insert into userinfo(username,birthday) values('$username','$birthday')";
	}

	
	if($db->query($sql)){
		Redirect($listURL);
	}else{
		Redirect($editURL);
	}

}else{
	if($id>0){
		$sql="select * from userinfo where user_id=$id";
		if($arr=$db->fetch_array($db->query($sql))){			
			$username	=$arr['username'];
			$birthday	=$arr['birthday'];
		}else{
			$db->connclose();
			Warning("ָ���ļ�¼�Ų�����");
		}
		
	}else{


		
	}
	
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
				if (!/^[0-9]*$/.exec(form.sortnum.value))
				{
					alert("�������ֻ��ʹ�����֣�");
					form.sortnum.focus();
					return false;
				}

				if (form.name.value == "")
				{
					alert("�������Ʋ���Ϊ�գ�");
					form.name.focus();
					return false;
				}

				return true;
			}
		</script>
	</head>

	<body onLoad="document.form1.sec_name.focus();">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; ��������޸�</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[�����б�]</a>&nbsp;
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="3">&nbsp;</td>
				</tr>

				<tr class="editTr">
					<td width="20%" class="editLeftTd">����</td>
					<td colspan="2" class="editRightTd">
						<input name="username" type="text" id="username" value="<?php echo $username?>" size="50" maxlength="50">					</td>
				</tr>
				<tr class="editTr">
				  <td class="editLeftTd">����</td>
				  <td colspan="2" class="editRightTd"><input name="birthday" type="text" id="birthday" value="<?php echo $birthday?>" size="50" maxlength="50"></td>
			  </tr>

				<?php
				if($big_third_state=="custom"){
				?>

				<?php
				}
				if($big_info_state=="custom"){
				?>
				<?php
				}
				?>
				<?php
				if($big_sec_cont){
				?>
				<?php
				}	
				?>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td colspan="2" class="editFooterTd"><input name="submit" type="submit" value=" ȷ �� " class="submit">
                      <input name="reset" type="reset" value=" �� �� " class="submit"></td>
				</tr>
			</form>
		</table>
	</body>
</html>