<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id']<0?0:(int)$_GET['id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];

$listURL="worker.php?page=$page";
$editURL="worker_edit.php?page=$page&id=$id";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SERVER['REQUEST_METHOD']=='POST'){
	$phone			=	safe($_POST['phone']);
	$realname		=	safe($_POST['realname']);
	$birthday		=	safe($_POST['birthday']);
	
	if($birthday)
	{
		$birthday = explode('-',$birthday);
		$birthday = mktime(0,0,0,$birthday[1],$birthday[2],$birthday[0]);
	}
	else
	{
		$birthday = 0;
	}

	//���
	if($realname==""){
		$db->close();
		Warning("��д�Ĳ����д���");
	}

	if($id>0){
		$sql="update workers set phone='$phone',realname='$realname',birthday=$birthday where id=$id";
	}else{
		$sql="insert into workers(phone,realname,birthday) values('$phone','$realname',$birthday)";
	}
	
	$db->query($sql);
	$db->close();
	Redirect($listURL);
	
}else{
	if($id>0){
		$sql="select * from workers where id=$id";
		if($arr=$db->fetch_array($db->query($sql))){
			$phone=$arr['phone'];
			$realname=$arr['realname'];
			$birthday=$arr['birthday'];
		}else{
			$db->close();
			Warning("ָ���ļ�¼�Ų����ڣ�");
		}
	}else{
		$state		= 1;
	}
		
	$db->close();
}
?>

<html>
	<head>
		<title></title>
		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>

		<script language="javascript">
			function check(form)
			{
				if (form.title.value == "")
				{
					alert("ְλ���Ʋ���Ϊ�գ�");
					form.title.focus();
					return false;
				}

				return true;
			}
		</script>
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; ��Ա��Ϣ</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="job_list.asp?page=1">[�����б�]</a>&nbsp;
				</td>
			</tr>
	</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">��Ա��Ϣ</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��Ա����</td>
					<td class="editRightTd"><input name="realname" type="text" id="realname" value="<?=$realname?>" size="30" maxlength="30"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��������</td>
					<td class="editRightTd"><input name="birthday" type="text" id="birthday" value="<?php if($birthday){echo date('Y-m-d',$birthday);}?>" size="30" maxlength="30"></td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" value=" ȷ �� ">
                      <input name="reset" type="reset" value=" �� �� "></td>
				</tr>
			</form>
		</table>

		<script language="javascript">
			document.form1.wid.focus();
		</script>

	</body>
</html>