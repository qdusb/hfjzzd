<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');


//数据库
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
$user=$_GET['user'];

if($_SESSION['is_hidden']!=true and $_SESSION['grade']!=1){
	Warning("你没有权限！");
exit;
}


if($_SERVER['REQUEST_METHOD']=="POST"){
	$username=$_POST['username'];
	$dept_id=$_POST['dept_id'];
	$pass1=$_POST['pass1'];
	$pass2=$_POST['pass2'];
	$realname=$_POST['realname'];
	$simplename=$_POST['simplename'];
	$state=$_POST['state'];
	$adv=$_POST['adv'];
	$sql=$_POST['sql'];
	$m_adv=$_POST['m_adv'];
	
	if($username==""){
		echo "<script>alert('管理员名称不能为空');history.back();</script>";
		exit;
	}
	if($pass1!=$pass2){
		echo "<script>alert('二次密码输入不一致');history.back();</script>";
		exit;
	}
	$pass=md5str($pass1);
	if(is_array($adv))
	$adv=implode(":",$adv);
	if(is_array($sql))
	$sql=implode(":",$sql);
	if(is_array($m_adv))
	$m_adv=implode(":",$m_adv);
	
	if($user==""){
		$sql="insert into admininfo(username,passwd,realname,grade,state,create_time,modify_time,login_sum,admin_adv,sql_adv,module_adv,dept_id,simplename) values('$username','$pass','$realname',2,$state,'".time()."','".time()."',0,'$adv','$sql','$m_adv',$dept_id,'$simplename')";
		$db->query($sql);
		echo "<script>alert('添加管理员成功');location.href='admin_list.php'</script>";
		exit;
		
	}else{
		
		if($_POST['pass1']!=""){
			$sql="update admininfo set username='$username',passwd='$pass',realname='$realname',state=$state,admin_adv='$adv',modify_time='".time()."',module_adv='$m_adv',sql_adv='$sql',dept_id=$dept_id,simplename='$simplename' where username='$user'";
			$sql2="update info set dept_id=$dept_id where adduser='$username'";

		}else{
			$sql="update admininfo set username='$username',realname='$realname',state=$state,admin_adv='$adv',modify_time='".time()."',module_adv='$m_adv',sql_adv='$sql',dept_id=$dept_id,simplename='$simplename' where username='$user'";
			$sql2="update info set dept_id=$dept_id where adduser='$username'";
		
		}
	
	}
	$db->query($sql);
	$db->query($sql2);
	echo "<script>alert('编辑成功');location.href='admin_list.php'</script>";
	exit;
}

if($user!=""){
	$sql="select * from admininfo where username='$user'";
	if($arr=$db->fetch_array($db->query($sql))){
		$username=$arr['username'];
		$realname=$arr['realname'];
		$simplename=$arr['simplename'];
		$state=$arr['state'];
		$adv=explode(":",$arr['admin_adv']);
		$sql_adv=explode(":",$arr['sql_adv']);	
		$m_adv=explode(":",$arr['module_adv']);	
		$dept_id	=$arr['dept_id'];
		
	}else{
	echo "<script>alert('此用户不存在！');location.href='admin_list.php'</script>";
	exit;	
	}
}else{
	$adv=array();
	$sql_adv=array();
	$m_adv=array();
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
<link href="images/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
  <tr class="position">
    <td class="position">当前位置: 管理中心 -&gt; 高级管理 -&gt; 管理员列表</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" id="Main_menu">
  <tr>
    <td>[<a href="admin_list.php">返回列表</a>] </td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" id="mainTable">
    <tr >
      <td colspan="2">编辑管理员</td>
    </tr>
    <tr class="editTr">
      <td width="12%" class="editLeftTd">管理员帐号</td>
      <td width="88%" class="editRightTd"><input name="username" type="text" id="username" value="<?php echo $username?>" size="50" /></td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">登录密码</td>
      <td class="editRightTd"><input name="pass1" type="password" id="pass1" size="50" /></td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">重复密码</td>
      <td class="editRightTd"><input name="pass2" type="password" id="pass2" size="50" /></td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">真实姓名</td>
      <td class="editRightTd"><input name="realname" type="text" id="realname" value="<?php echo $realname?>" size="50" /></td>
    </tr>
	<tr class="editTr">
	  <td class="editLeftTd">简称</td>
	  <td class="editRightTd"><input name="simplename" type="text" id="simplename" value="<?php echo $simplename?>" size="50" />
	    用于排名显示</td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">帐号状态</td>
      <td class="editRightTd"><input name="state" type="radio" value="0" <?php echo $state==0?"checked":"";?> />
        正常
          <input name="state" type="radio" value="1" <?php echo $state==1?"checked":"";?> />
          锁定</td>
	</tr>
	<tr class="editTr">
	  <td class="editLeftTd">所在部门</td>
	  <td class="editRightTd">
	  <select name="dept_id" style="width:100px">
		<option value="0" selected>请选择部门</option>	
			<?php
			$sql = "select id, shownum, dept_name from dept order by shownum asc";
			$query=$db->query($sql);
			while($arr=mysql_fetch_array($query)){
			?>
			<option value="<?php echo $arr['id']?>" <?php echo $dept_id==$arr['id']?"selected":""?>><?php echo $arr['dept_name']?></option>
			<?php
			}
			?>
		</select>	</td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">管理权限</td>
      <td class="editRightTd">
	  <?php
	  $sql="select * from big_class";
	  $query=$db->query($sql);
	  while($arr=$db->fetch_array($query)){
	  	echo "<b>".$arr['typename']."</b><br>";
		
		$sql="select * from sec_class where big_id=".$arr['id'];
		$sec_q=$db->query($sql);
		while($sec_arr=$db->fetch_array($sec_q)){
		$sec="";
			foreach($adv as $a)
				if(trim($a)==$sec_arr['id'])
				$sec="checked";
			echo '<input name="adv[]" type="checkbox" id="adv[]" value="'.$sec_arr['id'].'" '.$sec.' />'.$sec_arr['sec_name']."&nbsp;&nbsp;&nbsp;";		
			
		}
		echo "<br><br>";
	  }
	  ?>
	  <strong>高级管理</strong> <br>
	  <?php
	  $sql="select * from advanced where state>0";
	  $query=$db->query($sql);
	  while($arr=$db->fetch_array($query)){	
		$sec="";
			foreach($m_adv as $a)
				if(trim($a)==$arr['id'])
				$sec="checked";
			echo '<input name="m_adv[]" type="checkbox" id="m_adv[]" value="'.$arr['id'].'" '.$sec.' />'.$arr['name']."&nbsp;&nbsp;&nbsp;";		
			
		}		
	  
	  ?>	  </td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">操作权限</td>
      <td class="editRightTd"><input name="sql[]" type="checkbox" id="sql[]" value="update" <?php foreach($sql_adv as $a)if(trim($a)=="update")echo "checked";?> />
      修改
        <input name="sql[]" type="checkbox" id="sql[]" value="insert" <?php foreach($sql_adv as $a)if(trim($a)=="insert")echo "checked";?>  />
        添加
        <input name="sql[]" type="checkbox" id="sql[]" value="delete" <?php foreach($sql_adv as $a)if(trim($a)=="delete")echo "checked";?> />
        删除
        <input name="sql[]" type="checkbox" id="sql[]" value="shenhe" <?php foreach($sql_adv as $a)if(trim($a)=="shenhe")echo "checked";?> />
        审核</td>
	</tr>
    <tr class="editFooterTr">
      <td class="editFooterTd">&nbsp;</td>
      <td class="editFooterTd"><input type="submit" name="Submit" value="确定保存" class="submit"/>
&nbsp;&nbsp;
<input type="reset" name="Submit2" value="取消重来" class="submit"/></td>
    </tr>
  </table>
</form>
</body>
</html>
