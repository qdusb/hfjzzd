<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$id=(int)$_GET['id'];

$listURL="message_list.php?page=$page";
$viewURL="message_view.asp?page=$page&id=$id";

if($id<1){
	Warning("û��ָ����Ҫ�ļ�¼��!");
}

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SERVER['REQUEST_METHOD']=='POST'){
	$reply=$_POST['reply'];
	$reply_time=time();
	$state	=ToLimitLng($_POST['state'],1,3);
	
	$sql="update message set reply='$reply',reply_time=$reply_time,state=$state where id=$id";
	$db->query($sql);
	$db->close();
	Redirect($listURL);
	
}else{

$sql="select * from message where id=$id";
	if($arr=$db->fetch_array($db->query($sql))){	
		$title=$arr['title'];
		$adduser=$arr['adduser'];
		$phone=$arr['phone'];
		$mails=$arr['mails'];
		$content=$arr['content'];
		$dezhi=$arr['dezhi'];
		$create_time=$arr['create_time'];
		$reply=$arr['reply'];
		$reply_time=$arr['reply_time']<1?time():$arr['reply_time'];
		$state=$arr['state'];
		
		if($state==0){
			$sql="update message set state=1 where id=$id";
			$db->query;
			$state=2;
		}
		$db->close();
	}else{
		$db->close();
		Warning("ָ���ļ�¼�Ų�����!");
	}
}
?>

<html>
	<head>
		<title></title>
		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>

		
	    <style type="text/css">
<!--
.STYLE2 {color: #3300FF}
-->
        </style>
</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"  id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; �߼����� -&gt; ���Բ�</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[�����б�]</a>&nbsp;
				</td>
			</tr>
	</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
			<tr class="editHeaderTr">
				<td class="editHeaderTd" colSpan="2">���Ʋ�</td>
			</tr>
			<tr class="editTr">
				<td width="15%" height="29" class="editLeftTd">���</td>
				<td width="85%" class="editRightTd"><?php echo $id?></td>
			</tr>
			<tr class="editTr">
				<td class="editLeftTd">���ƺ���</td>
				<td class="editRightTd">
				 ��<span class="STYLE2"><?php echo $adduser?></span>��</td>
			</tr>
			<tr class="editTr">
				<td class="editLeftTd">��ϵ��ʽ</td>
				<td class="editRightTd"><?php echo $phone?></td>
			</tr>
			<tr class="editTr">
				<td class="editLeftTd">��Ҫ����</td>
				<td class="editRightTd"><?php echo $content?></td>
			</tr>
			<tr>
				<td colspan="2"></td>
			</tr>
			<tr class="editFooterTr">
				<td class="editFooterTd" colSpan="2">
					<input type="submit" value="ȷ�� "></td>
			</tr>
			</form>
		</table>

	</body>
</html>