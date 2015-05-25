<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>安徽美庆信息技术有限公司-网站管理系统</title>
<style type="text/css">
body{background: #80BDCB;margin: 0px;padding: 0px;color: #192E32; font-size:12px;}
#mainDiv{border: 1px solid #345C65;padding: 5px;margin: 5px;background: #FFF;}
#mainDiv ul{padding: 0;margin: 0;list-style-type: none;color: #335B64; line-height:16px}
.explode{background: url(images/menu_minus.gif) no-repeat 0px 3px;font-weight: bold; padding-left:13px}
.menuItem {background:url(images/menu_arrow.gif) no-repeat 0px 3px;font-weight:normal; padding-left:13px; margin-left:12px}


a{color: #335B64;text-decoration: none;}
a:hover {color: #EB8A3D;text-decoration: underline;}
</style>
</head>
<body>
<div id="mainDiv">
<ul>
	<?php
	$sql="select id, typename, sec_class from big_class order by shownum asc";
	$query=$db->query($sql);
	while($arr=mysql_fetch_array($query)){
	if($_SESSION['base_adv'] == 'all' || @in_array($arr['id'], $_SESSION['base_adv']))
	{
	?>
	<li class="explode"><?php echo $arr['typename']?></li>
		<?php
			$sql="select id,sec_name from sec_class where big_id=".$arr['id']." order by shownum asc";
			$sec_rs=$db->query($sql);
			while($sec_arr=mysql_fetch_array($sec_rs)){
			if($_SESSION['sec_adv'] == 'all' || @in_array($sec_arr['id'], $_SESSION['sec_adv']))
			{
		?>
		<li class="menuItem"><a href="info_list.php?sec_id=<?php echo $sec_arr['id']?>" target="main-frame"><?php echo $sec_arr['sec_name']?></a></li>
		
		<?php
			}
		}
		if($_SESSION['base_adv'] == 'all' && $_SESSION['sec_adv'] == 'all')
		{
		?>
		<li class="menuItem"><a href="sec_class_list.php?big_id=<?php echo $arr['id']?>" target="main-frame">分类管理</a></li>
		<?php
		}
		?>
	<?php
	}
	}
	?>
	
	<li class="explode">高级管理栏目</li>
	<ul>
<?php
		$sql="select id,default_file,name from advanced where state>0 and tag='信息管理' order by shownum asc";
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
  

	
	
  </ul>
</div>
</body>
</html>
