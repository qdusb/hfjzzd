<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');


$listURL="web_config.php";
$viewURL="web_config.asp";


$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SERVER['REQUEST_METHOD']=='POST'){
	$web_title	=$_POST['web_title'];
	$web_note	=$_POST['web_note'];
	$web_keywords	=$_POST['web_keywords'];
	$web_footer	=$_POST['web_footer'];
	
	$sql="update web_config set web_title='$web_title',web_keywords='$web_keywords',web_note='$web_note',web_footer='$web_footer'";
	$db->query($sql);
	$db->close();
	Redirect($listURL);
	
}else{

$sql="select web_title,web_keywords,web_note,web_footer from web_config";
	if($arr=$db->fetch_array($db->query($sql))){	
	
		$web_title=$arr['web_title'];
		$web_note=$arr['web_note'];
		$web_keywords=$arr['web_keywords'];
		$web_footer=$arr['web_footer'];
		$db->close();
	}
}
?>

<html>
	<head>
		<title></title>
		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>

		
	    <style type="text/css">
<!--
.STYLE2 {color: #3300FF}
-->
        </style>
</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; 高级管理 -&gt; 留言簿</td>
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
			<tr class="editTr">
				<td width="17%" height="19" class="editLeftTd">网站标题(Title)</td>
			  <td width="83%" height="19" class="editRightTd"><input name="web_title" type="text" id="web_title" size="65" value="<?php echo $web_title?>"></td>
			</tr>
			<tr class="editTr">
			  <td height="9" class="editLeftTd">网站关键词(KeyWords)</td>
			  <td height="9" class="editRightTd"><input name="web_keywords" type="text" id="web_keywords" size="65" value="<?php echo $web_keywords?>"></td>
			  </tr>
			<tr class="editTr">
			  <td height="10" class="editLeftTd"><span class="editRightTd">网站描述(Description)</span></td>
			  <td height="10" class="editRightTd"><textarea name="web_note" cols="60" rows="6" id="web_note"><?php echo $web_note?></textarea></td>
			</tr>
			<tr class="editTr">
				<td height="40" class="editLeftTd">版权信息(Footer)</td>
			  <td height="40" class="editRightTd"> <input type="hidden" name="web_footer" value="<?php echo htmlspecialchars($web_footer)?>">
			  <IFRAME ID="eWebEditor_content" name="content_new" style="border:#D0D0C8 1px solid" SRC="./phpeditor/ewebeditor.htm?id=web_footer&style=light&show=easy" FRAMEBORDER="0" SCROLLING="no" WIDTH="100%" HEIGHT="250"></IFRAME></td>
			</tr>
			<tr class="editFooterTr">
				<td class="editFooterTd">&nbsp;</td>
			    <td class="editFooterTd"><input name="submit" type="submit" value=" 保 存  " class="submit">
                  <input name="reset" type="reset" value=" 重 填 " class="submit"></td>
			</tr>
			</form>
	</table>
	</body>
</html>