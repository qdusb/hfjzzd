<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$pagesize=1;


$id		=$_GET['id'];
$job_id	=$_GET['job_id'];
$listURL="jobuser.php?job_id=$job_id&page=$page";

if($id>0 and $_GET['action']=='del'){
	$sql="delete from jobuser where id=$id";
	$db->query($sql);
	$db->close();
	Redirect($listURL);
}
?>

<html>
	<head>
		<title></title>
		<link href="images/default.css" rel="stylesheet" type="text/css">

	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; �߼����� -&gt; ӦƸ��Ա</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="jobuser.php?id=<?php echo $id?>">[ˢ���б�]</a>&nbsp;				</td>
			</tr>
		</table>

<?php
if($job_id!=""){
		//$sql="select * from jobuser where id=$id limit ".(($page-1)*$pagesize).",$pagesize";
		$pagesql="select * from jobuser where job_id=$job_id order by id desc";
		$pagestr=$db->page_1($pagesql,$page,$pagesize);
		$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";
		$query=$db->query($pagesql);
		while($arr=$db->fetch_array($query)){
			$id			=$arr['id'];
			
			$username	=$arr['username'];
			$sex		=$arr['sex'];
			$age		=$arr['age'];
			$phone		=$arr['phone'];
			$email		=$arr['email'];
			$address	=$arr['address'];
			$resumes	=$arr['resumes'];
			$appraise	=$arr['appraise'];
			$addtime	=$arr['addtime'];
?>
		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" class="editTable">		
				<tr class="editHeaderTr">
					<td class="editHeaderTd">��Ƹְλ</td>
				    <td align="right" class="editHeaderTd"><span style="padding-right:50px"><a href="?action=del&job_id=<?php echo job_id?>&id=<?php echo $id?>">ɾ����Ϣ</a></span></td>
				</tr>
				<tr class="editTr">
					<td width="150" class="editLeftTd">���</td>
					<td class="editRightTd"><?php echo $id?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">����</td>
					<td class="editRightTd"><?php echo $username?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">�Ա�</td>
					<td class="editRightTd"><?php echo $sex?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">����</td>
					<td class="editRightTd"><?php echo $age?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��ϵ�绰</td>
					<td class="editRightTd"><?php echo $phone?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��ϵ��ַ</td>
					<td class="editRightTd"><?php echo $address?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��������</td>
					<td class="editRightTd"><?php echo $email?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">���˼���</td>
					<td class="editRightTd"><?php echo $resumes?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��������</td>
					<td class="editRightTd"><?php echo $appraise?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">ӦƸʱ��</td>
					<td class="editRightTd"><?php echo date("Y-m-d",$addtime)?></td>
			    </tr>
				
		</table>
	
<?php
}
?>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B1CEEE">
  <tr class="editHeaderTr">
    <td align="center" bgcolor="#FFFFFF"><?php echo $pagestr;?></td>
  </tr>
</table>
<?php
$db->close();
}
?>
	</body>
</html>