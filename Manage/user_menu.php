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
<li class="explode">管理员设置</li>
	<ul>
 	<?php
		$sql="select id,default_file,name from advanced where state>0 and tag='管理员设置' order by shownum asc";
		$query=$db->query($sql);
		while($arr=mysql_fetch_array($query)){
		
		if($_SESSION['m_adv']=='all' || @in_array($arr['id'], $_SESSION['m_adv'])){
	?>		
		<li class="menuItem"><a href="<?php echo $arr['default_file']?>" target="main-frame"><?php echo $arr['name']?></a></li>
	<?php
		}
	}
	?>
	</ul>
	<li class="explode">个人管理</li>
	<ul>
	<li class="menuItem"><a href="edit_pass.php" target="main-frame">密码修改</a></li>
	<li class="menuItem"><a href="logout.php?action=logout" target="main-frame">退出管理</a></li>
	</ul>

 </ul>  
</div>


</body>
</html>
