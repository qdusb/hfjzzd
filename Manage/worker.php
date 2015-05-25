<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];

$listURL="worker.php?page=$page";
$editURL="worker_edit.php?page=$page";
$pagesize=20;

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($id>0){

	$sql="delete from workers where id=$id";
	$db->query($sql);
		
	$db->close();
	Redirect($listURL);
}
?>

<html>
	<head>
		<title></title>
		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>
	</head>
	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; ְ����Ϣ</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;
					<a href="<?php echo $editURL?>">[����]</a>&nbsp;
				</td>
				<td width="500" align="right">
				<?php
					$sql="select * from workers order by id asc";
					$pageStr=$db->page_1($sql,$page,$pagesize);
					echo $pageStr;
				?>					
				</td>
			</tr>
	</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td width="0">��Ա����</td>
				
				<td width="0">��������</td>
			    <td width="-1">����</td>
			</tr>
				<?php
				$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
				$query=$db->query($sql);
				while($arr=$db->fetch_array($query)){
					$css=$i++%2==0?"listTr":"listAlternatingTr";			
			?>			
				<tr class="listTr">
					<td width="0"><?=$arr['realname']?></td>
					<td width="0"><?php if($arr['birthday']){echo date('Y-m-d',$arr['birthday']);}?></td>
				    <td width="-1"><a href="<?=$editURL?>&id=<?=$arr['id']?>">�༭</a> | <a href="<?=$listURL?>&id=<?=$arr['id']?>" onClick="return del('<?=$arr['realname']?>');">ɾ��</a></td>
				</tr>
			<?php }?>
			<tr class="listFooterTr">
				<td colspan="5"><?php echo $pageStr;?></td>
			</tr>
	</table>

	</body>
</html>