<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');
$user=$_GET['user'];

//���ݿ�
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
if($_SESSION['is_hidden']!=true and $_SESSION['grade']!=1){
	Warning("��û��Ȩ�ޣ�");
exit;
}
if($user!=""){
/*
	$sql_adv=explode(":",$_SESSION['sql_adv']);	
				$a =true;
				foreach($sql_adv as $b){
					if(trim($b)=="delete")$a=false;
				}
				if($a){
					echo "<script>alert('��û�д�ɾ��Ȩ��!');history.back();</script>";
					exit;
				} 
*/	
	if($_SESSION['username']==$user){
		Warning("�㲻��ɾ�Լ���");
		exit;
	}
	
	$sql="delete from admininfo where username='$user'";
	$db->query($sql);
	echo "<script>location.href='admin_list.php'</script>";
	exit();
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
    <td>[<a href="admin_list.php">ˢ���б�</a>] [<a href="admin_edit.php">��ӹ���Ա</a>] </td>
  </tr>
</table>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="1" id="mainTable">
  <tr id="title">
    <td>����Ա����</td>
    <td>��ʵ����</td>
    <td>���ڲ���</td>
    <td>����ʱ��</td>
    <td>״̬</td>
    <td width="160">����</td>
  </tr>
  <?php
  $sql="select * from admininfo order by dept_id asc,create_time asc";
  $query=$db->query($sql);
  while($arr=$db->fetch_array($query)){
  $css=$i++%2==0?"listTr":"listAlternatingTr";
  ?>
  <tr class="<?php echo $css?>">
    <td class="listTr"><a href="admin_edit.php?user=<?php echo $arr['username']?>"><?php echo $arr['username']?></a></td>
    <td class="listTr"><?php echo $arr['realname']?></td>
    <td class="listTr">
	<?php
	if($dept_name=$db->GetField("dept","dept_name","id=".intval($arr['dept_id']))){
		echo $dept_name;
	}else{
		echo "<span style='color:#999999'>δѡ��</span>";
	}
	?>
	</td>
    <td class="listTr"><?php echo date('Y-m-d H:i:s',$arr['create_time']+8*3600)?></td>
    <td class="listTr">
	<?php
	switch((int)$arr['state']){
		case 0:echo "����";break;
		default : echo "<font color=#ff0000>����</font>";break;
	}
	?>	</td>
    <td class="listTr"><a href="admin_edit.php?user=<?php echo $arr['username']?>">�༭</a>|<a href="?user=<?php echo $arr['username']?>">ɾ��</a> </td>
  </tr>
  <?php }?>
  <tr class="listFooterTr">
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
</body>
</html>