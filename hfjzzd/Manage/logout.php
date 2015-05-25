<?php
define('IN_EKMENG',TRUE);
require_once('./common.inc.php');
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


//删除用户
if($_GET['action']=='del' && $_GET['user']!=''){
	$username=$_GET['user'];
	$sql="delete from admininfo where username='$username'";	
	if($db->query($sql)){
		$sql="delete from admin_login where username='$username'";	
		if($db->query($sql)){
			isok('<li>删除用户成功<li>删除用户日志成功','admin_manage.php');
		}else{
			Warning('<li>删除用户成功<li>删除用户日志失败','admin_manage.php');
		}
	}else{
		Warning('<li>删除用户失败<li>删除用户日志失败','admin_manage.php');
	}
}

//锁定用户
if($_GET['action']=='lock' && $_GET['user']!=''){
	$username=$_GET['user'];
	$sql="select state from admininfo where username='$username'";	
	if($arr=$db->fetch_array($db->query($sql))){				
		$state=(int)$arr['state']==0?1:0;		
		$sql="update admininfo set state=$state where username='$username'";	
		
		if($db->query($sql)){		
			isok('<li>操作用户成功','admin_manage.php');		
		}else{
			Warning('<li>操作用户失败','admin_manage.php');
		}
	}else{
		Warning('<li>此用户不存在<li>请选择相应的操作用户','admin_manage.php');
	}
}

//清除日志
if($_GET['action']=='clslog'){
		$sql="delete from admin_login";
		if($db->query($sql)){		
			isok('<li>清除日志成功','admin_manage.php');		
		}else{
			Warning('<li>清除日志失败','admin_manage.php');
		}
}

//注销用户
if($_GET['action']=='logout'){
@session_start();
@session_destroy();
echo "<script>window.top.location.href='login.php'</script>";
exit();
}
?>