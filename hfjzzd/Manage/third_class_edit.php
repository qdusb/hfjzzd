<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$sec_id=(int)$_GET['sec_id'];

if($sec_id<1){
	Warning("没有指定的二级分类！");
}

$listURL	= "third_class_list.php?sec_id=$sec_id";
$editURL	= "third_class_edit.php?sec_id=$sec_id&id=$id";

//数据库操作开始
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$sql="select big_id,sec_name,third_state,info_state from sec_class where id=$sec_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_id				=	$arr['big_id'];
	$sec_name			=	$arr['sec_name'];
	$sec_third_state	=	$arr['third_state'];
	$sec_info_state		=	$arr['info_state'];
}else{
	$db->close();
	Warning("指定的二级分类不存在！");
}


if($sec_third_state=="NO"){
	$db->close();
	Warning("指定的二级分类不允许包含三级分类！");
}

$sql="select typename,third_state,info_state from big_class where id=$big_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_name		=	$arr['typename'];
	$big_third_state=	$arr['third_state'];
	$big_info_state	=	$arr['info_state'];
}else{
	$db->close();
	Warning("指定的一级分类不存在！");
}

if($big_third_state=="NO"){
	$db->close();
	Warning("指定的一级分类不允许包含三级分类！");
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	$shownum	=(int)$_POST['shownum'];
	$name		=$_POST['name'];
	
	if($big_info_state<>"custom"){
		$info_state=$big_info_state;
	}else{
		$info_state=$_POST['info_state'];
	}

	//检查

	if($name==""){
		$db->close();
		Warning("填写的参数有错误！");
	}
	
	$shownum<1?$shownum=$db->getMax("third_class","shownum","sec_id=$sec_id")+10:$shownum;

	if($info_state<>"list" && $info_state<>"pic" && $info_state<>"content"){
		$db->close();
		Warning("填写的参数有错误！");
	}
	
	//保存
	if($id>0){
		if($db->getCount("third_class","*","id=$id and sec_id=$sec_id")<>1){
			$db->close();
			Warning("非法操作！");
		}

		$sql="update third_class set shownum=$shownum,third_name='$name',info_state='$info_state' where id=$id";
	}else{
		$id=$db->getMax("third_class","id")+1;
		$sql="insert into third_class values($id,$big_id,$sec_id,$shownum,'$name','$info_state')";
	}
	

	if($db->query($sql)){
		Redirect($listURL);
	}else{
		Warning("<li>编辑分类失败",$editURL);
	}	
	
}else{
	if($id>0){
		$sql="select shownum,third_name,info_state from third_class where id=$id and sec_id=$sec_id";
		if($arr=$db->fetch_array($db->query($sql))){
			$shownum	=$arr['shownum'];
			$name		=$arr['third_name'];
			$info_state	=$arr['info_state'];			
		}else{
			$db->close();
			Warning("指定的记录号不存在");
		}
	}else{
		$shownum=$db->getMax("third_class", "shownum", "sec_id=$sec_id")+10;

		if($big_info_state=="custom"){
			$info_state="list";
		}else{
			$info_state=$sec_info_state;
		}
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
					alert("分类序号只能使用数字！");
					form.sortnum.focus();
					return false;
				}

				if (form.name.value == "")
				{
					alert("分类名称不能为空！");
					form.name.focus();
					return false;
				}

				return true;
			}
		</script>
	</head>

	<body onLoad="document.form1.name.focus();">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; <?php echo $big_name?> -&gt; <?php echo $sec_name?> -&gt; 三级分类</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[返回列表]</a>&nbsp;
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="<?php echo $editURL?>" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">三级分类</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">分类序号</td>
					<td class="editRightTd">
						<input name="shownum" type="text" id="shownum" value="<?php echo $shownum?>" size="10" maxlength="6">
					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">分类名称</td>
					<td class="editRightTd">
						<input type="text" name="name" value="<?php echo $name?>" size="50" maxlength="50">
					</td>
				</tr>

				<?php
					if($big_info_state=="custom"){	
					
				?>
					<tr class="editTr">
						<td class="editLeftTd">记录状态</td>
						<td class="editRightTd">
							<input type="radio" name="info_state" value="list" <?php echo $info_state=="list"?"checked":""?>> 列表
							<input type="radio" name="info_state" value="pic" <?php echo $info_state=="pic"?"checked":""?> > 图片列表
							<input type="radio" name="info_state" value="content" <?php echo $info_state=="content"?"checked":""?> > 内容							
						</td>
					</tr>				
				<?php
				}?>

				<tr class="editFooterTr">
					<td class="editFooterTd" colSpan="2">
						<input type="submit" value=" 确 定 ">
						<input type="reset" value=" 重 填 ">
					</td>
				</tr>

			</form>
		</table>
	</body>
</html>