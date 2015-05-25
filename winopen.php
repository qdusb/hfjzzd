<?php
@session_start();
define("IN_EKMENG",true);
//----------------------Header.inc.php包含文件开始-------------------
//包含文件
require_once("configs.inc.php");
require_once(ROOT_PATH.'./Include/dbconn.inc.php');
require_once(ROOT_PATH.'./Include/function.inc.php');
require_once(ROOT_PATH.'./Include/module.inc.php');
//数据库
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
$id=$_GET['id'];
$sql="select file_name,file_content,file_width,file_height from advert where file_state>0 and id=$id";
$arr=$db->fetch_array($db->query($sql))
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $arr['file_name']?></title>
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<table width="<?php echo $arr['file_width']?>" height="<?php echo $arr['file_height']?>" border="0" cellpadding="0" cellspacing="0" style="line-height:22px; padding:5px">
  <tr>
    <td valign="top"><?php echo $arr['file_content']?></td>
  </tr>
</table>
</body>
</html>