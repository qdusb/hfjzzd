<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id']<0?0:(int)$_GET['id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];

$listURL	="job_list.php?page=$page";
$editURL	="job_eidt.php?page=$page&id=$id";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SERVER['REQUEST_METHOD']=='POST'){
	$shownum	=(int)$_POST['shownum'];
	$title		=safe($_POST['title']);
	$dept		=safe($_POST['dept']);
	$amount		=safe($_POST['amount']);
	$deadline	=safe($_POST['deadline']);
	$city		=safe($_POST['city']);
	$kind		=safe($_POST['kind']);
	$pay		=safe($_POST['pay']);
	$phone		=safe($_POST['phone']);
	$content	=safe($_POST['content']);
	$state		=ToLimitLng($_POST['state'],0,2);

	//���
	if($title==""){
		$db->close();
		Warning("��д�Ĳ����д���");
	}
	$shownum=$shownum<1?$db->getMax("job","shownum","")+10:$shownum;

	if($id>0){
		$sql="update job set shownum=$shownum,title='$title',dept='$dept',amount='$amount',deadline='$deadline',city='$city',kind='$kind',pay='$pay',phone='$phone',content='$content',state=$state where id=$id";
	}else{
		$id=$db->getMax('job','id',"")+1;
		$sql="insert into job(id,shownum,title,dept,amount,deadline,city,kind,pay,phone,content,state) values($id,$shownum,'$title','$dept','$amount','$deadline','$city','$kind','$pay','$phone','$content',$state)";
	}
	//die($sql);
	$db->query($sql);
	$db->close();
	Redirect($listURL);
	
}else{
	if($id>0){
		$sql="select shownum,title,dept,amount,deadline,city,kind,pay,phone,content,state from job where id=$id";
		if($arr=$db->fetch_array($db->query($sql))){
			$shownum=$arr['shownum'];
			$title=$arr['title'];
			$dept=$arr['dept'];
			$amount=$arr['amount'];
			$deadline=$arr['deadline'];
			$city=$arr['city'];
			$kind=$arr['kind'];
			$pay=$arr['pay'];
			$phone=$arr['phone'];
			$content=$arr['content'];
			$state=$arr['state'];
		}else{
			$db->close();
			Warning("ָ���ļ�¼�Ų����ڣ�");
		}
	}else{
		$shownum=$db->getMax("job","shownum","")+10;		
		$state		= 1;
	}
		
	$db->close();
}
?>

<html>
	<head>
		<title></title>
		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>

		<script language="javascript">
			function check(form)
			{
				if (form.title.value == "")
				{
					alert("ְλ���Ʋ���Ϊ�գ�");
					form.title.focus();
					return false;
				}

				return true;
			}
		</script>
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; �߼����� -&gt; ��Ƹְλ</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="job_list.asp?page=1">[�����б�]</a>&nbsp;
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" class="editTable">
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">��Ƹְλ</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">���</td>
					<td class="editRightTd"><input name="shownum" type="text" id="shownum" value="<?php echo $shownum?>" size="10" maxlength="5"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">״̬</td>
					<td class="editRightTd">
						
							<input type="radio" name="state" value="0" <?php echo $state==0?"checked":"";?>> ����ʾ
							<input type="radio" name="state" value="1" <?php echo $state==1?"checked":"";?>> ��ʾ
						
					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">ְλ����</td>
					<td class="editRightTd"><input name="title" type="text" id="title" value="<?php echo $title?>" size="50" maxlength="50"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��Ƹ����</td>
					<td class="editRightTd"><input type="text" name="dept" size="50" maxlength="50" value="<?php echo $dept?>"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��Ƹ����</td>
					<td class="editRightTd"><input type="text" name="amount" value="<?php echo $amount?>" size="30" maxlength="30"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��ֹ����</td>
					<td class="editRightTd"><input type="text" name="deadline" value="<?php echo $deadline?>" size="30" maxlength="30"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">�����ص�</td>
					<td class="editRightTd"><input type="text" name="city" value="<?php echo $city?>" size="30" maxlength="30"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��������</td>
					<td class="editRightTd"><input type="text" name="kind" value="<?php echo $kind?>" size="30" maxlength="30"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">����˵��</td>
					<td class="editRightTd"><input type="text" name="pay" value="<?php echo $pay?>" size="30" maxlength="30"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��ϵ�绰</td>
					<td class="editRightTd"><input name="phone" type="text" id="phone" value="<?php echo $phone?>" size="50" maxlength="50"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��λҪ��</td>
					<td class="editRightTd">
						<textarea name="content" cols="70" rows="10" id="reply"><?php echo $content?></textarea>
					</td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd" colSpan="2">
						<input type="submit" value=" ȷ �� ">
						<input type="reset" value=" �� �� ">
					</td>
				</tr>

			</form>
		</table>

		<script language="javascript">
			document.form1.name.focus();
		</script>

	</body>
</html>