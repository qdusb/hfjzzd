<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$big_id=(int)$_GET['big_id'];

if($big_id<0){
	Warning("<li>没有指定一级分类");
}

$listURL	= "dept_list.php";
$editURL	= "dept_edit.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


//权限检查
if($_SESSION['is_hidden']<>true and $big_sec_class=="deny"){
	$db->close();
	Warning("非法操作！");
}

//删除
if($id>0){
	//检查当前准备删除的分类,是否属于当前一级分类

	//if($db->getCount('third_class',"*","sec_id=$id")>0){
	//	$db->close();
	//	Warning("此分类包含下级分类，请先删除其下级分类！");
	//}

	//删除相关联的文件与图片

	//
	$sql="delete from dept where id=$id";
	if($db->query($sql)){
		$db->close();
		Redirect($listURL);
	}else{
		Warning("删除记录失败！");
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
				<td class="position">当前位置: 管理中心 -&gt; <?php echo $big_typename?> -&gt; 二级分类</td>
		    </tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[刷新列表]</a>&nbsp;
					<a href="<?php echo $editURL?>">[增加]</a>&nbsp;
				</td>
			</tr>
	</table>

			
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td>序号</td>
				<td>分类名称</td>
				<td>删除</td>
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

					<td><a href="<?php echo $listURL."?id=".$arr['id']?>" onClick="return del('<?php echo $arr['dept_name']?>');">删除</a></td>
				</tr>
			<?php
			}?>			

			<tr class="listFooterTr">
				<td colspan="10"></td>
			</tr>
		</table>

	</body>
</html>