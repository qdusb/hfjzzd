<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');


$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$pagesize=15;
$id=(int)$_GET['id'];

$listURL="message_list.php?page=$page";
$viewURL="message_view.php?page=$page";
$pageURL="message_list.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($id>0){
	$sql="delete from message where id=$id";
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

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; 高级管理 -&gt; 留言簿</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="<?php echo $pageURL?>">[刷新列表]</a>&nbsp;
				</td>
				<td width="500" align="right">
					<?php
					$sql="select id,title,adduser,content,create_time,state from message order by id desc";
					$pagestr=$db->page_1($sql,$page,$pagesize);
					echo $pagestr;			
					?>						
				</td>
			</tr>
	</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" id="mainTable">
			<tr id="title">
				<td width="60">序号</td>
				<td>称呼</td>
				<td width="160">定制时间</td>
				<td width="50">状态</td>
				<td width="40">查看</td>
				<td width="40">删除</td>
			</tr>
			<?php
			$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){
			$css=$i++%2==0?"listTr":"listAlternatingTr";
			?>
			<tr class="<?php echo $css;?>">
				<td width="60"><?php echo $arr['id']?></td>
				<td align="left"> <font color="#996600"><a href="<?php echo $viewURL?>&id=<?php echo $arr["id"]?>">【<?php echo $arr['adduser']?>】</a></font></td>
				<td><?php echo date('Y-m-d H:i:s',($arr['create_time']+8*3600))?></td>
				<td width="50">
				<?php
				switch($arr['state']){
					case 0:	echo "<font color='#FF6600'>未查看</font>"; break;
					case 1:	echo "<font color='#0066FF'>不显示</font>";	break;
					case 2:	echo "显示"; break;
					case 3:	echo "<font color='#FF3300'>推荐</font>"; break;
					default:	echo "<font color='#FF0000'>错误</font>"; break;
				}
				?>				</td>
				<td width="40"><a href="<?php echo $viewURL?>&id=<?php echo $arr["id"]?>">查看</a></td>
				<td width="40"><a href="<?php echo $listURL?>&id=<?php echo $arr["id"]?>" onClick="return del('编号为 <?php echo $arr['id'];?> 的留言');">删除</a></td>
			</tr>
			<?php }?>
			<tr class="listFooterTr">
				<td colspan="9"><?php echo $pagestr;?></td>
			</tr>
	</table>

	</body>
</html>