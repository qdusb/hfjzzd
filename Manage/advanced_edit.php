<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id		= (int)$_GET['id'];
$listURL	= "advanced_list.php";
$editURL	= "advanced_edit.php?id=$id" ;

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SERVER['REQUEST_METHOD']=='POST'){
	$shownum		=(int)$_POST['shownum'];
	$name			=$_POST['name'];
	$tag			=$_POST['tag'];
	$default_file	=$_POST['default_file'];
	$state			=ToLimitLng($_POST['state'],0,1);
	
	//检查
	if($name=="" or $default_file==""){
		Warning("填写的参数有错误！");
	}
	if($shownum<1){
		$shownum=$db->getMax("advanced","shownum")+10;
	}
	
	//保存
	if($id>0){		
		$sql="update advanced set shownum=$shownum,name='$name',default_file='$default_file',tag='$tag',state=$state where id=$id";
	}else{
		if($db->getCount("advanced","*","name='$name'")>0){
			$db->close();
			Warning("功能名称重复！");
		}
		$id=$db->getMax("advanced","id")+1;
		$sql="insert into advanced values($id,$shownum,'$name','$default_file',$state,'$tag')";
	}
	
	$db->query($sql);
	Redirect($listURL);
}else{
	if($id>0){
		$sql="select * from advanced where id=$id";
		if($arr=$db->fetch_array($db->query($sql))){
			$shownum		=$arr['shownum'];
			$name			=$arr['name'];
			$tag			=$arr['tag'];
			$default_file	=$arr['default_file'];
			$state			=$arr['state'];
		}else{
			$db->close();
			Warning("指定的记录号不存在");
		}
	}else{
		$shownum	=$db->getMax("advanced", "shownum")+10;
		$state		=	1;
	}
	$db->close();	
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
			function check(form)
			{
				if (!/^[0-9]*$/.exec(form.sortnum.value))
				{
					alert("序号只能使用数字！");
					form.sortnum.focus();
					return false;
				}

				if (form.name.value == "")
				{
					alert("功能名称不能为空！");
					form.name.focus();
					return false;
				}

				if (form.default_file.value == "")
				{
					alert("默认文件不能为空！");
					form.default_file.focus();
					return false;
				}
				return true;
			}
		</script>
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; 隐藏管理 -&gt; 高级功能管理</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="advanced_list.asp">[返回列表]</a>&nbsp;
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">高级功能管理</td>
				</tr>

				<tr class="editTr">
					<td class="editLeftTd">序号</td>
					<td class="editRightTd">
						<input type="text" name="shownum" value="<?php echo $shownum?>" size="10" maxlength="4"></td>
				</tr>
				<tr class="editTr">
				  <td class="editLeftTd">标识</td>
				  <td class="editRightTd"><input name="tag" type="text" id="tag" value="<?php echo $tag?>"></td>
			  </tr>
				<tr class="editTr">
					<td class="editLeftTd">状态</td>
					<td class="editRightTd">
						<input type="radio" name="state" value="1" <?php echo $state==1?"checked":""?>> 显示
						<input type="radio" name="state" value="0"  <?php echo $state==0?"checked":""?>> 不显示					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">功能名称</td>
					<td class="editRightTd">
						<input type="text" name="name" value="<?php echo $name?>" size="50" maxlength="50">					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">首页文件</td>
					<td class="editRightTd">
						<input type="text" name="default_file" value="<?php echo $default_file?>" size="50" maxlength="50">					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">说明</td>
					<td class="editRightTd">
						添加或编辑时请确定首页文件是否存在!					</td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" value=" 确 定 ">
                      <input name="reset" type="reset" value=" 重 填 "></td>
				</tr>
			</form>
		</table>


		<script language="javascript">
			document.form1.name.focus();
		</script>


	</body>
</html>