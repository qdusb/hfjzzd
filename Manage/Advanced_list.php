<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id		= (int)$_GET['id'];
$listURL	= "advanced_list.php";
$editURL	= "advanced_edit.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($id>0){
	$sql="delete from advanced where id=$id";
	$db->query($sql);
	Redirect($listURL);
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
				<td class="position">��ǰλ��: �������� -&gt; ���ع��� -&gt; �߼����ܹ���</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;
					<a href="<?php echo $editURL?>">[����]</a>&nbsp;
				</td>
				<td width="500" align="right">
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td>ID��</td>
				<td>���</td>
				<td>��������</td>
				<td>��ҳ�ļ�</td>
				<td>��ʶ</td>
				<td>״̬</td>
				<td>ɾ��</td>
			</tr>
			<?php
			$sql="select id,shownum,name,tag,default_file,state from advanced order by tag asc,shownum asc";
			$query=$db->query ($sql);
			while ($arr=mysql_fetch_array($query)){
				$css=$i++%2==0?"listTr":"listAlternatingTr";
			?>			
				<tr class="<?php echo $css?>">
					<td><?php echo $arr['id'];?></td>
					<td><?php echo $arr['shownum'];?></td>
					<td><a href="<?php echo $editURL;?>?id=<?php echo $arr['id'];?>"><?php echo $arr['name'];?></a></td>
					<td><?php echo $arr['default_file'];?></td>
					<td><?php echo $arr['tag'];?></td>
					<td>
						<?php
							switch((int)$arr['state']){
								case 0	:	echo "<font color='#FF6600'>����ʾ</font>";	break;
								case 1	:	echo "��ʾ";								break;
								default	:	echo "<font color='#FF0000'>����</font>";	break;
							}
						?>					</td>
					<td><a href="<?php echo $listURL;?>?id=<?php echo $arr['id'];?>" onClick="return del('<?php echo $arr['name'];?>');">ɾ��</a></td>
				</tr>
			
			<?php }?>

			<tr class="listFooterTr">
				<td colspan="11"></td>
			</tr>
		</table>

	</body>
</html>