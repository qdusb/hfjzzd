<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');


//���ݿ�
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
$user=$_GET['user'];

if($_SESSION['is_hidden']!=true and $_SESSION['grade']!=1){
	Warning("��û��Ȩ�ޣ�");
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
		echo "<script>alert('����Ա���Ʋ���Ϊ��');history.back();</script>";
		exit;
	}
	if($pass1!=$pass2){
		echo "<script>alert('�����������벻һ��');history.back();</script>";
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
		echo "<script>alert('��ӹ���Ա�ɹ�');location.href='admin_list.php'</script>";
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
	echo "<script>alert('�༭�ɹ�');location.href='admin_list.php'</script>";
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
	echo "<script>alert('���û������ڣ�');location.href='admin_list.php'</script>";
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
<title>�ޱ����ĵ�</title>
<link href="images/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
  <tr class="position">
    <td class="position">��ǰλ��: �������� -&gt; �߼����� -&gt; ����Ա�б�</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" id="Main_menu">
  <tr>
    <td>[<a href="admin_list.php">�����б�</a>] </td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" id="mainTable">
    <tr >
      <td colspan="2">�༭����Ա</td>
    </tr>
    <tr class="editTr">
      <td width="12%" class="editLeftTd">����Ա�ʺ�</td>
      <td width="88%" class="editRightTd"><input name="username" type="text" id="username" value="<?php echo $username?>" size="50" /></td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">��¼����</td>
      <td class="editRightTd"><input name="pass1" type="password" id="pass1" size="50" /></td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">�ظ�����</td>
      <td class="editRightTd"><input name="pass2" type="password" id="pass2" size="50" /></td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">��ʵ����</td>
      <td class="editRightTd"><input name="realname" type="text" id="realname" value="<?php echo $realname?>" size="50" /></td>
    </tr>
	<tr class="editTr">
	  <td class="editLeftTd">���</td>
	  <td class="editRightTd"><input name="simplename" type="text" id="simplename" value="<?php echo $simplename?>" size="50" />
	    ����������ʾ</td>
    </tr>
	<tr class="editTr">
      <td class="editLeftTd">�ʺ�״̬</td>
      <td class="editRightTd"><input name="state" type="radio" value="0" <?php echo $state==0?"checked":"";?> />
        ����
          <input name="state" type="radio" value="1" <?php echo $state==1?"checked":"";?> />
          ����</td>
	</tr>
	<tr class="editTr">
	  <td class="editLeftTd">���ڲ���</td>
	  <td class="editRightTd">
	  <select name="dept_id" style="width:100px">
		<option value="0" selected>��ѡ����</option>	
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
      <td class="editLeftTd">����Ȩ��</td>
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
	  <strong>�߼�����</strong> <br>
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
      <td class="editLeftTd">����Ȩ��</td>
      <td class="editRightTd"><input name="sql[]" type="checkbox" id="sql[]" value="update" <?php foreach($sql_adv as $a)if(trim($a)=="update")echo "checked";?> />
      �޸�
        <input name="sql[]" type="checkbox" id="sql[]" value="insert" <?php foreach($sql_adv as $a)if(trim($a)=="insert")echo "checked";?>  />
        ���
        <input name="sql[]" type="checkbox" id="sql[]" value="delete" <?php foreach($sql_adv as $a)if(trim($a)=="delete")echo "checked";?> />
        ɾ��
        <input name="sql[]" type="checkbox" id="sql[]" value="shenhe" <?php foreach($sql_adv as $a)if(trim($a)=="shenhe")echo "checked";?> />
        ���</td>
	</tr>
    <tr class="editFooterTr">
      <td class="editFooterTd">&nbsp;</td>
      <td class="editFooterTd"><input type="submit" name="Submit" value="ȷ������" class="submit"/>
&nbsp;&nbsp;
<input type="reset" name="Submit2" value="ȡ������" class="submit"/></td>
    </tr>
  </table>
</form>
</body>
</html>
