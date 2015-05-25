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
//数据库
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
				<td class="position">&nbsp;&nbsp;当前位置: 管理中心 -&gt; 高级管理 -&gt; 访问统计</td>
			</tr>
		</table>
		<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
		
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[刷新列表]</a>&nbsp;
					<a href="<?php echo $listURL?>&action=delete" onClick="return confirm('确定清空访问记录吗 ?');">[清空访问记录]</a>&nbsp;
		<?php
		//分页sql
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
				<td width="0" height="20">序号</td>
				<td width="0" height="20">来源</td>
				<td width="0" height="20">IP地址</td>
				<td width="0" height="20">访问时间</td>
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
					echo $refet==""?"浏览器直接输入":"<a href=$refet target=\"_blank\">".$refet."</a>";
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