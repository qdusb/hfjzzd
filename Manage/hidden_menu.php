<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>黄山太平农村商业银行网站管理系统</title>
<style type="text/css">
body{background: #80BDCB;margin: 0px;padding: 0px;color: #192E32; font-size:12px;}
#mainDiv{border: 1px solid #345C65;padding: 5px;margin: 5px;background: #FFF;}
#mainDiv ul{padding: 0;margin: 0;list-style-type: none;color: #335B64;}
#mainDiv li{padding-left: 16px;line-height: 16px;cursor: hand;cursor: pointer;}
.explode{background: url(images/menu_minus.gif) no-repeat 0px 3px;font-weight: bold;}
.collapse{background: url(images/menu_plus.gif) no-repeat 0px 3px;font-weight: bold;}
.menuItem {background:url(images/menu_arrow.gif) no-repeat 0px 3px;font-weight:normal;}
a{color: #335B64;text-decoration: none;}
a:hover {color: #EB8A3D;text-decoration: underline;}
</style>
</head>
<body>
<div id="mainDiv">
<ul>
<li class="explode">隐藏分类管理</li>
	<ul>
		<li class="menuItem"><a href="big_class_list.php" target="main-frame">信息分类管理</a></li>
		<li class="menuItem"><a href="Advanced_list.php" target="main-frame">高级菜单管理</a></li>
	</ul>
	<li class="explode">数据库管理</li>
	<ul>
	<li class="menuItem"><a href="info_list.php?sec_id=111" target="main-frame">数据库备份</a></li>
	<li class="menuItem"><a href="info_list.php?sec_id=111" target="main-frame">数据库优化</a></li>
	<li class="menuItem"><a href="info_list.php?sec_id=111" target="main-frame">网站信息导入</a></li>
	<li class="menuItem"><a href="info_list.php?sec_id=111" target="main-frame">网站信息导出</a></li>
	</ul>
 </ul>  
</div>


</body>
</html>
