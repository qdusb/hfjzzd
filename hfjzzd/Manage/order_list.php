<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');


$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$pagesize=15;
$id=(int)$_GET['id'];

$listURL="order_list.php?page=$page";
$viewURL="order_list.php?page=$page";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($id>0){
	$sql="delete from `order` where id=$id";
	$db->query($sql);
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

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; �߼����� -&gt; ������ѯ</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<form name="form1" action="" method="post">
			
			<tr height="30">
				<td>
					<a href="message_list.php">[ˢ���б�]</a>&nbsp;
				</td>
				<td width="500" align="right">
				<?php
					$sql="select id,prod_name,puser,tel,content,create_time,state from `order` order by id desc";
					$pagestr=$db->page_1($sql,$page,$pagesize);
					echo $pagestr;			
					?>						
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" class="listTable">
			<tr class="listHeaderTr">
				<td width="60">���</td>
				<td width="240">������Ʒ</td>
				<td>˵��</td>
				<td width="160">�µ�ʱ��</td>
				<td width="80">������</td>
				<td width="140">��ϵ�绰</td>
				<td width="40">ɾ��</td>
			</tr>
			<?php
			$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){
			$css=$i++%2==0?"listTr":"listAlternatingTr";
			?>
						<tr class="<?php echo $css?>">
				<td width="60"><?php echo $arr['id']?></td>
				<td align="left"> <font color="#996600"><?php echo $arr['prod_name']?></td>
				<td align="left"><?php echo $arr['content']?></td>
				<td><?php echo date('Y-m-d H:i:s',$arr['create_time']+8*3600)?></td>
				<td>
				<?php echo $arr['puser']?>				</td>
				<td><?php echo $arr['tel']?></td>
				<td width="40"><a href="<?php echo $listURL?>&id=<?php echo $arr['id']?>" onClick="return del('���Ϊ <?php echo $arr['id']?> �Ķ���');">ɾ��</a></td>
			</tr>
			<?php }?>
					
						<tr class="listFooterTr">
				<td colspan="10"><?php echo $pagestr;?></td>
			</tr>
	</table>

	</body>
</html>