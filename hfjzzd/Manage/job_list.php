<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];

$listURL="job_list.php?page=$page";
$editURL="job_edit.php?page=$page";
$pagesize=20;

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($id>0){

	$sql="delete from job where id=$id";
	$db->query($sql);
	
	$sql="delete from jobuser where job_id=$id";
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

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; 高级管理 -&gt; 招聘职位</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[刷新列表]</a>&nbsp;
					<a href="<?php echo $editURL?>">[增加]</a>&nbsp;
				</td>
				<td width="500" align="right">
				<?php
					$sql="select id,shownum,title,dept,deadline,state from job order by shownum asc";
					$pageStr=$db->page_1($sql,$page,$pagesize);
					echo $pageStr;
				?>					
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="listTable">
			<tr class="listHeaderTr">
				<td width="0">序号</td>
				<td width="0">职位名称</td>
				<td width="0">招聘部门</td>
				<td width="0">截止时间</td>
				<td width="0">状态</td>
				<td width="0">查看</td>
				<td width="0">删除</td>
			</tr>
				<?php
				$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
				$query=$db->query($sql);
				while($arr=$db->fetch_array($query)){
					$css=$i++%2==0?"listTr":"listAlternatingTr";			
			?>			
				<tr class="listTr">
					<td width="0"><?php echo $arr['shownum']?></td>
					<td width="0"><?php echo $arr['title']?></td>
					<td width="0"><?php echo $arr['dept']?></td>
					<td width="0"><?php echo $arr['deadline']?></td>
					<td width="0">
						显示					</td>
					<td width="0"><a href="<?php echo $editURL?>&id=<?php echo $arr['id']?>">编辑</a>&nbsp;|&nbsp;<a href="jobuser.php?job_id=<?php echo $arr['id']?>">应聘信息(<?php echo $db->getcount("jobuser","job_id","job_id=".$arr["id"]."")?>)</a></td>
					<td width="0"><a href="<?php echo $listURL?>&id=<?php echo $arr['id']?>" onClick="return del('<?php echo $arr['title']?>');">删除</a></td>
				</tr>
			<?php }?>
			<tr class="listFooterTr">
				<td colspan="10">[第1页 共1页 共4条记录]&nbsp;&nbsp;[首页]&nbsp;[上页]&nbsp;[下页]&nbsp;[末页]&nbsp;</td>
			</tr>
	</table>

	</body>
</html>