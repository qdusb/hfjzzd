<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


$id		 = (int)$_GET['id'];
$editURL = 'adver_edit.php?id='.$id;
$listURL = 'adver_list.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
	$file_name		= substr($_POST['file_name'],0,100);
	$file_content	= $_POST['file_content'];
	$file_width		= substr($_POST['file_width'],0,100);
	$file_height	= substr($_POST['file_height'],0,100);
	$file_order		= (int)substr($_POST['file_order'],0,100);
	$file_state		= substr($_POST['file_state'],0,100);
	$file_top 		= substr($_POST['file_top'],0,100);
	$file_left		= substr($_POST['file_left'],0,100);
	//检查
	if($file_name=="" ){
		$db->close();
		Warning("填写的内容有错误！");
	}

	if($id>0){
		$sql="update advert set file_name='$file_name',file_content='$file_content',file_width='$file_width',file_height='$file_height',file_order=$file_order,file_state=$file_state,file_time='".time()."',file_left='$file_left',file_top='$file_top' where id=$id";
	
	}else{
		
		$sql="insert into advert(file_name,file_content,file_width,file_height,file_order,file_state,file_time,file_left,file_top) values('$file_name','$file_content','$file_width','$file_height',$file_order,$file_state,".time().",'$file_left','$file_top')";
	}

	//die($sql);
	if($db->query($sql)){
		Redirect($listURL);
	}else{
		Warning("编辑信息失败!");
	}	
	
}else{
	if($id>0){
		//查询记录
		$sql="select * from advert where id=$id";
		if($arr=$db->fetch_array($db->query($sql))){

			$id                 =   $arr['id'];
			$file_name			=	$arr['file_name'];
			$file_content		=	$arr['file_content'];
			$file_width			=	$arr['file_width'];
			$file_height		=	$arr['file_height'];
			$file_left			=	$arr['file_left'];
			$file_top			=	$arr['file_top'];
			$file_order			=	(int)$arr['file_order'];
			$file_state			=	(int)$arr['file_state'];

		}else{
			$db->close();
			Warning("指定的记录不存在！");
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
				if (form.file_name.value == "")
				{
					alert("请输入广告名称！");
					form.file_name.focus();
					return false;
				}

				

				return true;
			}
		</script>
	</head>

	<body onLoad="document.form1.title.focus();">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心  -&gt; 弹窗管理</td>
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
					<td class="editHeaderTd" colSpan="2">新增/编辑</td>
				</tr>
						<tr class="editTr">
					<td width="14%" class="editLeftTd">广告名称</td>
					<td width="86%" class="editRightTd"><input type="text" value="<?php echo $file_name?>" name="file_name" size="50" maxlength="100"></td>
				</tr>
	
		
					<tr class="editTr">
						<td class="editLeftTd">排序</td>
						<td class="editRightTd"><input name="file_order" type="text" id="file_order" value="<?php echo (int)$file_order?>" size="16" maxlength="50"></td>
					</tr>
					<tr class="editTr">
					  <td class="editLeftTd">位置<span class="editRightTd"> 左</span>/<span class="editRightTd">上</span></td>
					  <td class="editRightTd"><input name="file_left" type="text" id="file_left" size="5" value=<?php echo $file_left?>>
					    -
					      <input name="file_top" type="text" id="file_top" size="5" value=<?php echo $file_top?>>
  px</td>
			  </tr>
			
			
					<tr class="editTr">
						<td class="editLeftTd">宽*高</td>
						<td class="editRightTd"><input name="file_width" type="text" id="file_width" size="5" value=<?php echo $file_width?>>
					    *
					    <input name="file_height" type="text" id="file_height" size="5" value=<?php echo $file_height?>></td>
					</tr>
					<tr class="editTr">
                      <td class="editLeftTd">状态</td>
					  <td class="editRightTd">
				<input name="file_state" type="radio" value="1" <?php echo $file_state==1?"checked":""?>>
					    显示
				<input type="radio" name="file_state" value="0" <?php echo $file_state==0?"checked":""?>>
					    不显示 </td>
			  </tr>
					<tr class="editTr">
					  <td class="editLeftTd">内容</td>
					  <td class="editRightTd">
					  <input type="hidden" name="file_content" value="<?php echo htmlspecialchars($file_content)?>">
					<IFRAME ID="eWebEditor_content" name="content_new" style="border:#D0D0C8 1px solid" SRC="./phpeditor/ewebeditor.htm?id=file_content&style=light&show=easy" FRAMEBORDER="0" SCROLLING="no" WIDTH="100%" HEIGHT="500"></IFRAME>					  </td>
			  </tr>
					<tr class="editTr">
					  <td class="editLeftTd">&nbsp;</td>
					  <td class="editRightTd">1、位置 左：弹出窗口居居浏览器左边**像素 上： 弹出窗口居浏览器上方**像素<br>
				      2、<span class="editLeftTd">宽*高</span> &nbsp;：是指弹出窗口的高度和宽度，可自由设定</td>
			  </tr>
			
			
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" value=" 确 定 ">
                      <input name="reset" type="reset" value=" 重 填 "></td>
				</tr>
			</form>
		</table>
</body>
</html>