<?php
@session_start();
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');
$sec_id=(int)$_GET['sec_id'];
$third_id=(int)$_GET['third_id'];
$page=(int)$_GET['page']<1?1:$_GET['page'];
$pagesize=15;
$listURL	="counter.php?page=$page";
//���ݿ�
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
if($_GET['action']=='delete'){
$db->query("delete from counter");
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
		<script language="javascript" src="js/common.js"></script>
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr class="position"> 
				<td class="position">&nbsp;&nbsp;��ǰλ��: �������� -&gt; �߼����� -&gt; ����ͳ��</td>
			</tr>
		</table>
		<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;
					<a href="<?php echo $listURL?>&action=delete" onClick="return confirm('ȷ����շ��ʼ�¼�� ?');">[��շ��ʼ�¼]</a>&nbsp;
		<?php
		//��ҳsql
		$pagesql="select * from counter order by id desc";
		$pagestr=$db->page_1($pagesql,$page,$pagesize);
		$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";
		$query=$db->query($pagesql);
		?></td>
				<td width="500" align="right"><?php echo $pagestr;?></td>
			</tr>
	</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="listTable">
			<tr  class="listHeaderTr">
				<td width="0" height="20">���</td>
				<td width="0" height="20">��Դ</td>
				<td width="0" height="20">IP��ַ</td>
				<td width="0" height="20">����ʱ��</td>
			</tr>



		<?php
		while($arr=$db->fetch_array($query)){
				$id      = $arr['id'];
				$refet 	 = $arr['refet'];
				$ip 	 = $arr['ip'];
				$dt		 = $arr['dt'];
		?>

				<tr>
					<td width="0" height="20" align="center" bgcolor="#FFFFFF"><?php echo $id?></td>
					<td width="0" height="20" align="center" bgcolor="#FFFFFF">
					<?php
					echo $refet==""?"�����ֱ������":"<a href=$refet target=\"_blank\">".$refet."</a>";
					?>					</td>
					<td width="0" height="20" align="center" bgcolor="#FFFFFF"><?php echo $ip?></td>
					<td width="0" height="20" align="center" bgcolor="#FFFFFF"><?php echo $dt?></td>
				</tr>


			<?php
			}
			?>

			 <tr class="listFooterTr">
				<td height="20" colspan="10"><?php echo $pagestr?></td>
			</tr>
	</table>

	</body>
</html>