<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

//if($_SESSION['is_hidden']!=true){
//	header("location: logout.php?action=logout");
//	exit();
//}

$id		=(int)$_GET['id'];


$listURL	= "big_class_list.php";
$editURL	= "big_class_edit.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($id>0){
	if($db->getCount('sec_class','*',"big_id=$id")>0){
		Warning("<li>�˷�������¼����࣬����ɾ�����¼����࣡");
	}
	
	$sql="delete from big_class where id=$id";

	if($db->query($sql)){
		isok('<li>ɾ������ɹ�');
	}else{
		Warning("<li>ɾ������ʧ��",$listURL);
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
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; ���ع��� -&gt; ��Ϣ�������</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="big_class_list.php">[ˢ���б�]</a>&nbsp;
					<a href="<?php echo $editURL?>?action=add">[����]</a>&nbsp;
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td>ID��</td>
				<td>���</td>
				<td>��������</td>
				<td>��������</td>
				<td>��������</td>
				<td>��¼״̬</td>
				<td>ɾ��</td>
			</tr>
			<?php
			$sql = "select id, shownum, typename, sec_class, third_state, info_state from big_class order by shownum asc";
			$query=$db->query($sql);
			while($arr=mysql_fetch_array($query)){
				$i++;
				$css=$i%2==0?"listAlternatingTr":"listTr";
			?>			
				<tr class="<?php echo $css?>">
					<td><?php echo $arr['id']?></td>
					<td><?php echo $arr['shownum']?></td>
					<td><a href="big_class_edit.php?action=modify&id=<?php echo $arr['id']?>"><?php echo $arr['typename']?></a></td>
					<td>
						<?
							switch($arr['sec_class']){
								case "allow":
									echo "����";
								break;
								case "deny":
									echo "�ܾ�";
								break;
								Default:
									echo "<font color='#FF0000'>����</font>";
								break;
							}
						?>
					</td>
					<td>
						<?
							switch($arr['third_state']){
								case "NO":
									echo "��";
								break;
								case "YES":
									echo "��";
								break;
								case "custom":
									echo "�Զ���";
								break;
								Default:
									echo "<font color='#FF0000'>����</font>";
								break;
							}
						?>
					</td>
					<td>
						<?
							switch($arr['info_state']){
								case "list":
									echo "�����б�";
								break;
								case "pic":
									echo "ͼƬ�б�";
								break;
								case "content":
									echo "��һ����";
								break;
								case "custom":
									echo "�Զ���";
								break;
								Default:
									echo "<font color='#FF0000'>����</font>";
								break;
							}
						?>
					</td>
					<td><a href="?id=<?php echo $arr['id']?>" onClick="return del('<?php echo $arr['typename']?>');">ɾ��</a></td>
				</tr>
			<?php
			}	
			?>
				
			<tr class="listFooterTr">
				<td colspan="10"></td>
			</tr>
		</table>

	</body>
</html>