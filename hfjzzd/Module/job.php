<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}


$jobid=(int)$_GET['jobid'];
if($jobid>0){
if($_SERVER['REQUEST_METHOD']=='POST'){
	$username	=$_POST['username'];
	$sex		=$_POST['sex'];
	$age		=$_POST['age'];
	$phone		=$_POST['phone'];
	$address	=$_POST['address'];
	$email		=$_POST['email'];
	$resumes	=$_POST['resumes'];
	$appraise	=$_POST['appraise'];
	$addtime	=time();
	$id=$db->getMax('jobuser','id',"")+1;
	$sql="insert into jobuser values($id,$jobid,'$username','$sex','$age','$phone','$address','$email','$resumes','$appraise',$addtime)";
	if($db->query($sql)){
		echo "<script>alert('����ӦƸ��Ϣ�Ѿ��ύ����ȴ�������Ա���ģ�');location='job.php'</script>";
		exit;
	}else{
		die($sql);
	}

}
?>
<script language="javascript">
	function check_send(){
		if(document.jobform.username.value==""){
			alert("����������������");
			document.jobform.username.focus();
			return false;
		}
	
		if(document.jobform.age.value==""){
			alert("�������������䣡");
			document.jobform.age.focus();
			return false;
		}	
	
	
		if(document.jobform.phone.value==""){
			alert("���������ĵ绰��");
			document.jobform.phone.focus();
			return false;
		}		
	
		if(document.jobform.address.value==""){
			alert("���������ĵ�ַ��");
			document.jobform.address.focus();
			return false;
		}	
		
		if(document.jobform.email.value==""){
			alert("�������������䣡");
			document.jobform.email.focus();
			return false;
		}				
	
		if(document.jobform.resumes.value==""){
			alert("���������ĸ��˼�����");
			return false;
		}		
		
		if(document.jobform.appraise.value==""){
			alert("���������Ķ��Լ������ۣ�");
			return false;
		}	
	
	}

</script>
<br />
<table width="89%" border="0" cellspacing="1" cellpadding="0" align="center" class="editTable">
<form id="jobform" name="jobform" method="post" action="Job.php?jobid=<?php echo $jobid?>" onsubmit="return check_send()">
 <tr class="editTr">
    <td width="0" height="25" align="center" class="editLeftTd">�ա�����</td>
    <td width="0" height="25" class="editRightTd"><input name="username" type="text" id="username" size="41" />
      *</td>
  </tr>
  <tr class="editTr">
    <td width="0" height="25" align="center" class="editLeftTd">�ԡ�����</td>
    <td width="0" height="25" class="editRightTd"><select name="sex" id="sex">
        <option value="��" selected="selected">��</option>
        <option value="Ů">Ů</option>
      </select>
      </td>
  </tr>
  <tr class="editTr">
    <td width="0" height="25" align="center" class="editLeftTd">�ꡡ����</td>
    <td width="0" height="25" class="editRightTd"><input name="age" type="text" id="age" /></td>
  </tr>
  <tr class="editTr">
    <td width="0" height="25" align="center" class="editLeftTd">��ϵ�绰</td>
    <td width="0" height="25" class="editRightTd"><input name="phone" type="text" id="phone" />
*</td>
  </tr>
  <tr class="editTr">
    <td width="0" height="25" align="center" class="editLeftTd">��ϵ��ַ</td>
    <td width="0" height="25" class="editRightTd"><input name="address" type="text" id="address" size="41" />
*</td>
  </tr>
  <tr class="editTr">
    <td width="0" height="25" align="center" class="editLeftTd">��������</td>
    <td width="0" height="25" class="editRightTd"><input name="email" type="text" id="email" size="41" />
*</td>
  </tr>
  <tr class="editTr">
    <td width="0" height="25" align="center" class="editLeftTd">���˼���</td>
    <td width="0" height="25" class="editRightTd"><textarea name="resumes" cols="50" rows="6" id="resumes"></textarea>
*</td>
  </tr>
  <tr class="editTr">
    <td width="0" height="25" align="center" class="editLeftTd">��������</td>
    <td width="0" height="25" class="editRightTd"><textarea name="appraise" cols="50" rows="6" id="appraise"></textarea>
*</td>
  </tr>
  <tr class="editTr">
    <td width="0" height="25" class="editLeftTd">&nbsp;</td>
    <td width="0" height="25" class="editRightTd">
      <input type="submit" name="Submit" value="�ύ">
      <input type="reset" name="Submit2" value="����" />
    
    </td>
  </tr>
  </form>
</table>
<?php
}else{
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$listURL="?page=$page";
$pagesize=2;
$sql="select * from job where state>0 order by shownum asc";
  $pagestr=$db->page_1($sql,$page,$pagesize);
  $sql.="  limit ".(($page-1)*$pagesize).",$pagesize";
  $query=$db->query($sql);
  while($arr=$db->fetch_array($query)){
?>
<br />
<table width="89%" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td width="50%" height="22" align="left" valign="middle" bgcolor="#F6F6F6">��Ƹְλ:<?php echo $arr['title']?></td>
    <td width="50%" height="22" align="left" valign="middle" bgcolor="#F6F6F6">��������:<?php echo $arr['pay']?></td>
  </tr>
  <tr>
    <td width="50%" height="22" align="left" valign="middle" bgcolor="#FFFFFF">��Ƹ����:<?php echo $arr['dept']?></td>
    <td width="50%" height="22" align="left" valign="middle" bgcolor="#FFFFFF">��������:<?php echo $arr['kind']?></td>
  </tr>
  <tr>
    <td width="50%" height="22" align="left" valign="middle" bgcolor="#FFFFFF">��������:<?php echo $arr['city']?></td>
    <td width="50%" height="22" align="left" valign="middle" bgcolor="#FFFFFF">��Чʱ��:<?php echo $arr['deadline']?></td>
  </tr>
  <tr>
    <td width="50%" height="22" align="left" valign="middle" bgcolor="#FFFFFF">��Ҫ����:<?php echo $arr['amount']?></td>
    <td width="50%" height="22" align="left" valign="middle" bgcolor="#FFFFFF">��ϵ��ʽ:<?php echo $arr['phone']?></td>
  </tr>
  <tr>
    <td height="11" colspan="2" align="left" valign="middle" bgcolor="#FFFFFF">ְλҪ��:<?php echo $arr['content']?></td>
  </tr>
  <tr>
    <td height="10" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="10" align="right" valign="middle" bgcolor="#FFFFFF" style="padding-right:50px"><a href="job.php?jobid=<?php echo $arr['id']?>">��ҪӦƸ</a></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" valign="middle" bgcolor="#FFFFFF"></td>
  </tr>
</table>
<?
  }  
?>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td align="center"><?php echo $pagestr;?></td>
  </tr>
</table>
<?php
}
?>

