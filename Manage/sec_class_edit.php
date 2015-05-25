<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$big_id=(int)$_GET['big_id'];

if($big_id<1){
	Warning("没有指定的一级分类！");
}

$listURL="sec_class_list.php?big_id=$big_id";
$editURL="sec_class_edit.php?big_id=$big_id&id=$id";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$sql = "select typename, sec_class, sec_cont, sec_pic, third_state, info_state from big_class where id=$big_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_typename		= $arr['typename'];
	$big_sec_class		= $arr['sec_class'];
	$big_sec_cont		= $arr['sec_cont'];
	$big_sec_pic		= $arr['sec_pic'];
	$big_third_state	= $arr['third_state'];
	$big_info_state		= $arr['info_state'];
}else{
	$db->connclose();
	Warning("指定的一级分类不存在！");
}

if($_SESSION['is_hidden']!=true && $big_sec_class<>"allow"){
	Warning("非法操作！");
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	$shownum	= (int)$_POST['shownum'];
	$sec_name	= substr($_POST['sec_name'],0,50);
	
	if($big_third_state<>"custom"){
		$third_state=$big_third_state;
	}else{
		$third_state=$_POST['third_state'];
	}
	
	if($big_info_state<>"custom"){
		$info_state=$big_info_state;
	}else{
		$info_state=$_POST['info_state'];
	}

	if($big_sec_cont){
		$ipstart=$_POST['ipstart'];
	}else{
		$ipstart="";
	}
	
	//检查

	if($sec_name==""){
		Warning("填写的参数有错误！");
	}
	
	if($shownum<1){
		$shownum=$db->getMax("sec_class", "shownum", "big_id=$big_id")+10;
	}
	if($third_state!="NO" && $third_state!="YES"){
		Warning("填写的参数有错误！");
	}
	
	if($info_state!="list" && $info_state!="pic" && $info_state!="content" && $info_state!="pic"){
		Warning("填写的参数有错误！");
	}

	//保存

	if($id>0){
		if($db->getCount("sec_class","*","id=$id and big_id=$big_id")<>1){
			$db->connclose();
			Warning("非法操作！");
		}

		$sql = "update sec_class set shownum=$shownum,sec_name='$sec_name',third_state='$third_state',info_state='$info_state',ipstart='$ipstart' where id=$id";
	}else{
		if($db->getMax("sec_class", "id", "big_id=$big_id")<1){
			$id=$big_id*1000+1;
		}else{
			$id=$db->getMax("sec_class", "id", "big_id=$big_id")+1;
		}

		if($db->getCount("sec_class", "*", "id=$id")>0){
			$db->close();
			Warning("此栏目下的二级分类已经达到允许的上限，不能添加新的分类了！");
		}

		$sql="insert into sec_class(id,big_id,shownum,sec_name,third_state,info_state,ipstart) values($id,$big_id,$shownum,'$sec_name','$third_state','$info_state','$ipstart')";
	}

	
	if($db->query($sql)){
		Redirect($listURL);
	}else{
		Redirect($editURL);
	}

}else{
	if($id>0){
		$sql="select shownum,sec_name,third_state,info_state,ipstart from sec_class where id=$id and big_id=$big_id";
		if($arr=$db->fetch_array($db->query($sql))){			
			$sec_name	=$arr['sec_name'];
			$shownum	=$arr['shownum'];
			$third_state=$arr['third_state'];
			$info_state	=$arr['info_state'];
			$ipstart	=$arr['ipstart'];					
		}else{
			$db->connclose();
			Warning("指定的记录号不存在");
		}
		
	}else{

		$shownum=$db->getMax("sec_class", "shownum", "big_id=$big_id")+10;
		if($big_third_state=="custom"){
			$third_state="NO";
		}else{
			$third_state=$big_third_state;
		}

		if($big_info_state=="custom"){
			$info_state="list";
		}else{
			$info_state=$big_info_state;
		}		
		
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

	<body onLoad="document.form1.sec_name.focus();">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; <?php echo $typename;?> -&gt; 二级分类</td>
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
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="3">二级分类</td>
				</tr>
				<tr class="editTr">
					<td width="20%" class="editLeftTd">分类序号</td>
					<td colspan="2" class="editRightTd">
						<input type="text" name="shownum" value="<?php echo $shownum?>" size="10" maxlength="6">					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">分类名称</td>
					<td colspan="2" class="editRightTd">
						<input type="text" name="sec_name" value="<?php echo $sec_name?>" size="50" maxlength="50">					</td>
				</tr>

				<?php
				if($big_third_state=="custom"){
				?>				
				<tr class="editTr">
					<td class="editLeftTd">三级分类</td>
					<td colspan="2" class="editRightTd">
						<input type="radio" name="third_state" value="NO" <?php echo $third_state=="NO"?"checked":""?>> 无
							<input type="radio" name="third_state" value="YES" <?php echo $third_state=="YES"?"checked":""?>> 有					</td>
				</tr>

				<?php
				}
				if($big_info_state=="custom"){
				?>
				<tr class="editTr">
					<td class="editLeftTd">记录状态</td>
					<td colspan="2" class="editRightTd">
					<input type="radio" name="info_state" value="list"  <?php echo $info_state=="list"?"checked":""?>> 列表
					<input type="radio" name="info_state" value="pic"  <?php echo $info_state=="pic"?"checked":""?>> 图片列表
					<input type="radio" name="info_state" value="content"  <?php echo $info_state=="content"?"checked":""?>> 内容					</td>
				</tr>
				<?php
				}
				?>
				<?php
				if($big_sec_cont){
				?>
				<tr class="editTr">
						<td class="editLeftTd">IP限制<br>
						  {IP内访问网页}</td>
				  <td width="22%" class="editRightTd">
<textarea name="ipstart" cols="35" rows="6" id="ipstart"><?php echo $ipstart?></textarea></td>
			      <td width="58%" class="editRightTd">请输入IP段如：<br>
			        58.14.0.0-58.25.255.255<br>
			        58.30.0.0-58.63.255.255<br>
			        58.66.0.0-58.67.255.255<br>
		          58.82.0.0-58.83.255.255</td>
			  </tr>
				<?php
				}	
				?>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td colspan="2" class="editFooterTd"><input name="submit" type="submit" value=" 确 定 " class="submit">
                      <input name="reset" type="reset" value=" 重 填 " class="submit"></td>
				</tr>
			</form>
		</table>
	</body>
</html>