<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$big_id=(int)$_GET['big_id'];

if($big_id<0){
	Warning("<li>û��ָ��һ������");
}

$listURL	= "user_list.php";
$editURL	= "user_edit.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


//ɾ��
if($id>0){
	//��鵱ǰ׼��ɾ���ķ���,�Ƿ����ڵ�ǰһ������
	if($db->getCount('userinfo',"*","user_id=$id")!=1){
		$db->close();
		Warning("�Ƿ�������");
	}


	//ɾ����������ļ���ͼƬ

	//
	$sql="delete from userinfo where user_id=$id";
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
				<td class="position">��ǰλ��: �������� -&gt; �����б�</td>
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
				<td>����</td>
				<td>����</td>
				<?php
				if($big_sec_pic){
				?>
				<?php
				}
				?>
				
				<td>ɾ��</td>
			</tr>

			<?php
			$sql = "select user_id, birthday, username from userinfo order by user_id asc";
			$query=$db->query($sql);
			while($arr=mysql_fetch_array($query)){
				$i++;
				$css=$i%2==0?"listAlternatingTr":"listTr";
			?>
				<tr class="<?php echo $css;?>">
					<td><?php echo $arr['user_id'];?></td>
					<td><a href="<?php echo $editURL."?id=".$arr['user_id'];?>"><?php echo $arr['username']?></a></td>
					<td><?php echo $arr['birthday'];?></td>
					<?php
					if($big_sec_pic){
					?>
				  <?php
					}
					?>
					<td><a href="<?php echo $listURL."?id=".$arr['user_id']?>" onClick="return del('<?php echo $arr['username']?>');">ɾ��</a></td>
				</tr>
			<?php
			}?>			

			<tr class="listFooterTr">
				<td colspan="8"></td>
			</tr>
		</table>

	</body>
</html>