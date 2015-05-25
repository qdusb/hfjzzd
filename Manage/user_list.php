<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$big_id=(int)$_GET['big_id'];

if($big_id<0){
	Warning("<li>没有指定一级分类");
}

$listURL	= "user_list.php";
$editURL	= "user_edit.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


//删除
if($id>0){
	//检查当前准备删除的分类,是否属于当前一级分类
	if($db->getCount('userinfo',"*","user_id=$id")!=1){
		$db->close();
		Warning("非法操作！");
	}


	//删除相关联的文件与图片

	//
	$sql="delete from userinfo where user_id=$id";
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
				<td class="position">当前位置: 管理中心 -&gt; 生日列表</td>
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
				<td>姓名</td>
				<td>生日</td>
				<?php
				if($big_sec_pic){
				?>
				<?php
				}
				?>
				
				<td>删除</td>
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
					<td><a href="<?php echo $listURL."?id=".$arr['user_id']?>" onClick="return del('<?php echo $arr['username']?>');">删除</a></td>
				</tr>
			<?php
			}?>			

			<tr class="listFooterTr">
				<td colspan="8"></td>
			</tr>
		</table>

	</body>
</html>