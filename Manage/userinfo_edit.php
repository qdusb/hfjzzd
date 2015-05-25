<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$user_id=(int)$_GET['user_id'];


$listURL="userinfo_list.php";
$editURL="userinfo_edit.php?user_id=$user_id";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SESSION['is_hidden']!=true && $big_sec_class<>"allow"){
	Warning("非法操作！");
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	$birthday	= $_POST['birthday'];
	$username	= substr($_POST['username'],0,50);
	

	//检查

	if($birthday==""){
		Warning("填写的参数有错误！");
	}
	if($username==""){
		Warning("填写的参数有错误！");
	}

	//保存

	if($id>0){
		if($db->getCount("userinfo","*","user_id=$user_id")<>1){
			$db->connclose();
			Warning("非法操作！");
		}

		$sql = "update userinfo set username='$username',birthday='$birthday' where user_id=$user_id";
	}else{

		$sql="insert into userinfo values('$username','$birthday')";
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


				if (form.username.value == "")
				{
					alert("姓名不能为空！");
					form.username.focus();
					return false;
				}
				if (form.birthday.value == "")
				{
					alert("生日不能为空！");
					form.birthday.focus();
					return false;
				}				

				return true;
			}
		</script>
	</head>

	<body onLoad="document.form1.sec_name.focus();">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; 人员信息修改 -&gt; 二级分类</td>
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
					<td class="editHeaderTd" colSpan="3">人员信息修改</td>
				</tr>
				
				<tr class="editTr">
					<td width="20%" class="editLeftTd">姓名</td>
					<td colspan="2" class="editRightTd">
						<input name="username" type="text" id="username" value="<?php echo $username?>" size="50" maxlength="50">					</td>
				</tr>

				<?php
				if($big_third_state=="custom"){
				?>				
				<tr class="editTr">
					<td class="editLeftTd">生日</td>
					<td colspan="2" class="editRightTd"><input name="birthday" type="text" id="birthday" value="<?php echo $birthday?>" size="50" maxlength="50"></td>
				</tr>

				<?php
				}
				if($big_info_state=="custom"){
				?>
				<tr class="editTr">
					<td class="editLeftTd">&nbsp;</td>
					<td colspan="2" class="editRightTd">&nbsp;</td>
				</tr>
				<?php
				}
				?>
				<?php
				if($big_sec_cont){
				?>
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