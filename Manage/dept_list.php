<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$big_id=(int)$_GET['big_id'];

if($big_id<0){
	Warning("<li>û��ָ��һ������");
}

$listURL	= "dept_list.php";
$editURL	= "dept_edit.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


//Ȩ�޼��
if($_SESSION['is_hidden']<>true and $big_sec_class=="deny"){
	$db->close();
	Warning("�Ƿ�������");
}

//ɾ��
if($id>0){
	//��鵱ǰ׼��ɾ���ķ���,�Ƿ����ڵ�ǰһ������

	//if($db->getCount('third_class',"*","sec_id=$id")>0){
	//	$db->close();
	//	Warning("�˷�������¼����࣬����ɾ�����¼����࣡");
	//}

	//ɾ����������ļ���ͼƬ

	//
	$sql="delete from dept where id=$id";
	if($db->query($sql)){
		$db->close();
		Redirect($listURL);
	}else{
		Warning("ɾ����¼ʧ�ܣ�");
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
				<td class="position">��ǰλ��: �������� -&gt; <?php echo $big_typename?> -&gt; ��������</td>
		    </tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;
					<a href="<?php echo $editURL?>">[����]</a>&nbsp;
				</td>
			</tr>
	</table>

			
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td>���</td>
				<td>��������</td>
				<td>ɾ��</td>
			</tr>

			<?php
			$sql = "select id, shownum, dept_name from dept order by shownum asc";
			$query=$db->query($sql);
			while($arr=mysql_fetch_array($query)){
				$i++;
				$css=$i%2==0?"listAlternatingTr":"listTr";
			?>
				<tr class="<?php echo $css;?>">
					<td><?php echo $arr['shownum'];?></td>
					<td><a href="<?php echo $editURL."?id=".$arr['id'];?>"><?php echo $arr['dept_name']?></a></td>

					<td><a href="<?php echo $listURL."?id=".$arr['id']?>" onClick="return del('<?php echo $arr['dept_name']?>');">ɾ��</a></td>
				</tr>
			<?php
			}?>			

			<tr class="listFooterTr">
				<td colspan="10"></td>
			</tr>
		</table>

	</body>
</html>