<?php
define('IN_EKMENG',TRUE);
require_once('./common.inc.php');
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


//ɾ���û�
if($_GET['action']=='del' && $_GET['user']!=''){
	$username=$_GET['user'];
	$sql="delete from admininfo where username='$username'";	
	if($db->query($sql)){
		$sql="delete from admin_login where username='$username'";	
		if($db->query($sql)){
			isok('<li>ɾ���û��ɹ�<li>ɾ���û���־�ɹ�','admin_manage.php');
		}else{
			Warning('<li>ɾ���û��ɹ�<li>ɾ���û���־ʧ��','admin_manage.php');
		}
	}else{
		Warning('<li>ɾ���û�ʧ��<li>ɾ���û���־ʧ��','admin_manage.php');
	}
}

//�����û�
if($_GET['action']=='lock' && $_GET['user']!=''){
	$username=$_GET['user'];
	$sql="select state from admininfo where username='$username'";	
	if($arr=$db->fetch_array($db->query($sql))){				
		$state=(int)$arr['state']==0?1:0;		
		$sql="update admininfo set state=$state where username='$username'";	
		
		if($db->query($sql)){		
			isok('<li>�����û��ɹ�','admin_manage.php');		
		}else{
			Warning('<li>�����û�ʧ��','admin_manage.php');
		}
	}else{
		Warning('<li>���û�������<li>��ѡ����Ӧ�Ĳ����û�','admin_manage.php');
	}
}

//�����־
if($_GET['action']=='clslog'){
		$sql="delete from admin_login";
		if($db->query($sql)){		
			isok('<li>�����־�ɹ�','admin_manage.php');		
		}else{
			Warning('<li>�����־ʧ��','admin_manage.php');
		}
}

//ע���û�
if($_GET['action']=='logout'){
@session_start();
@session_destroy();
echo "<script>window.top.location.href='login.php'</script>";
exit();
}
?>