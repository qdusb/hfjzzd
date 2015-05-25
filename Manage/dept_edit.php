<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];

$listURL="dept_list.php";
$editURL="dept_edit.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);



if($_SERVER['REQUEST_METHOD']=='POST'){
	$shownum	= (int)$_POST['shownum'];
	$dept_name	= substr($_POST['dept_name'],0,50);
	

	//检查

	if($dept_name==""){
		Warning("填写的参数有错误！");
	}
	
	if($shownum<1){
		$shownum=$db->getMax("sec_class", "shownum", "")+10;
	}

	//保存

	if($id>0){
		if($db->getCount("dept","*","id=$id")<>1){
			$db->connclose();
			Warning("非法操作！");
		}
		$sql = "update dept set shownum=$shownum,dept_name='$dept_name' where id=$id";
	}else{
		$id=$db->getMax("dept", "id", "")+1;
		$sql="insert into `dept`(id,shownum,dept_name) values($id,$shownum,'$dept_name')";
	}


	if($db->query($sql)){
		Redirect($listURL);
	}else{
		Redirect($editURL);
	}

}else{
	if($id>0){
		$sql="select shownum,dept_name from dept where id=$id";
		if($arr=$db->fetch_array($db->query($sql))){			
			$dept_name	=$arr['dept_name'];
			$shownum	=$arr['shownum'];
		}else{
			$db->connclose();
			Warning("指定的记录号不存在");
		}
		
	}else{

		$shownum=$db->getMax("dept", "shownum", "")+10;
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
				if (!/^[0-9]*$/.exec(form.shownum.value))
				{
					alert("分类序号只能使用数字！");
					form.shownum.focus();
					return false;
				}

				if (form.dept_name.value == "")
				{
					alert("部门名称不能为空！");
					form.dept_name.focus();
					return false;
				}

				return true;
			}
		</script>
	</head>

	<body onLoad="document.form1.dept_name.focus();">

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
					<td class="editHeaderTd" colSpan="2">二级分类</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">分类序号</td>
					<td class="editRightTd">
						<input type="text" name="shownum" value="<?php echo $shownum?>" size="10" maxlength="6">					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">分类名称</td>
					<td class="editRightTd">
						<input name="dept_name" type="text" id="dept_name" value="<?php echo $dept_name?>" size="50" maxlength="50">					</td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" value=" 确 定 " class="submit">
                      <input name="reset" type="reset" value=" 重 填 " class="submit"></td>
				</tr>
			</form>
		</table>
	</body>
</html>