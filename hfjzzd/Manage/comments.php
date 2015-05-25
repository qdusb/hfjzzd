<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id		=(int)$_GET['id'];
$sec_id	=(int)$_GET['sec_id'];
$commid	=intval($_GET["commid"]);
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];

$pagesize=5;

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$sql="select sec_name from sec_class where id=$sec_id";
if($arr=$db->fetch_array($db->query($sql))){
	$sec_name		=$arr['sec_name'];
}else{
	$db->close();
	Warning("指定的二级分类不存在！");
}

$sql="select title from info where id=$id";
if($arr=$db->fetch_array($db->query($sql))){
	$title		=$arr['title'];
}else{
	$db->close();
	Warning("该信息已不存在！");
}



$baseURL	="info_list.php?sec_id=$sec_id";
$listURL	="comments.php?id=$id&sec_id=$sec_id";

//数据库


if(!$db->getcount("commentary","id","infoid=$id")){
	Warning("该信息还没有任何人进行评论！");
}
//删除

if($_GET['action']=="del" && $commid>0){
	$sql="delete from commentary where id=$commid";
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

		<script language="javascript">
		//检查是否选择了条目，并提示是否设置选中的条目的状态
		check_frame("default.php");
		</script>

	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; <?php echo $sec_name?> -&gt; <?php echo $title?> </td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
				<a href="<?php echo $listURL?>">[刷新列表]</a>&nbsp;<a href="<?php echo $baseURL?>">[返回列表]</a></td>
				<td align="right">
				</td>
			</tr>
		</table>

						<?php
						
						$pagesql="select * from commentary where infoid=$id order by id desc";
							
							$pagestr=$db->page_1($pagesql,$page,$pagesize);
							$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";
							$query=$db->query($pagesql);
							
							while($arr=$db->fetch_array($query)){
						?>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="listTable" style="margin-top:5PX">
                          <tr class="listHeaderTr">
                            <td height="20" align="left" style="padding-left:10px"><table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
							<tr>
							<td width="90%"><strong>网友评论</strong>：
							  <?php  echo $arr['title']?></td>
							<td width="10%" align="center"><a href="<?php echo $listURL?>&action=del&commid=<?php echo $arr['id']?>"  onClick="return del('编号为 <?php echo $arr['id'];?> 的评论');">删除</a></td>
							</tr>
							</table
							
							
							></td>
                          </tr>
                          <tr class="listTr1">
                            <td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:40px;padding-top:5px;">
							<?php echo nl2br($arr['content'])?>							</td>
                          </tr>

                          <tr >
                            <td height="22" align="left" bgcolor="#F5FAFE" style="padding-left:15px"><span style="color:#C0C0C0">时间：					
							<?php
							 echo date("Y-m-d h:i:s",$arr['createtime']+3600*8)
							 ?>&nbsp;&nbsp;来自：<?php 
							 echo $arr['createip'];
							 ?>
&nbsp;&nbsp;编号：<?php echo $arr['id']?></span>							</td>
                          </tr>
    </table>
						
						<?php
						}
						?>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="listTable" style="margin-top:3px">
          <tr height="30" class="listFooterTr">
            <td align="center"><?php echo $pagestr;?> </td>
            </tr>
        </table>
	</body>
</html>