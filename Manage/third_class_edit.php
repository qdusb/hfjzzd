<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$sec_id=(int)$_GET['sec_id'];

if($sec_id<1){
	Warning("û��ָ���Ķ������࣡");
}

$listURL	= "third_class_list.php?sec_id=$sec_id";
$editURL	= "third_class_edit.php?sec_id=$sec_id&id=$id";

//���ݿ������ʼ
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$sql="select big_id,sec_name,third_state,info_state from sec_class where id=$sec_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_id				=	$arr['big_id'];
	$sec_name			=	$arr['sec_name'];
	$sec_third_state	=	$arr['third_state'];
	$sec_info_state		=	$arr['info_state'];
}else{
	$db->close();
	Warning("ָ���Ķ������಻���ڣ�");
}


if($sec_third_state=="NO"){
	$db->close();
	Warning("ָ���Ķ������಻��������������࣡");
}

$sql="select typename,third_state,info_state from big_class where id=$big_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_name		=	$arr['typename'];
	$big_third_state=	$arr['third_state'];
	$big_info_state	=	$arr['info_state'];
}else{
	$db->close();
	Warning("ָ����һ�����಻���ڣ�");
}

if($big_third_state=="NO"){
	$db->close();
	Warning("ָ����һ�����಻��������������࣡");
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	$shownum	=(int)$_POST['shownum'];
	$name		=$_POST['name'];
	
	if($big_info_state<>"custom"){
		$info_state=$big_info_state;
	}else{
		$info_state=$_POST['info_state'];
	}

	//���

	if($name==""){
		$db->close();
		Warning("��д�Ĳ����д���");
	}
	
	$shownum<1?$shownum=$db->getMax("third_class","shownum","sec_id=$sec_id")+10:$shownum;

	if($info_state<>"list" && $info_state<>"pic" && $info_state<>"content"){
		$db->close();
		Warning("��д�Ĳ����д���");
	}
	
	//����
	if($id>0){
		if($db->getCount("third_class","*","id=$id and sec_id=$sec_id")<>1){
			$db->close();
			Warning("�Ƿ�������");
		}

		$sql="update third_class set shownum=$shownum,third_name='$name',info_state='$info_state' where id=$id";
	}else{
		$id=$db->getMax("third_class","id")+1;
		$sql="insert into third_class values($id,$big_id,$sec_id,$shownum,'$name','$info_state')";
	}
	

	if($db->query($sql)){
		Redirect($listURL);
	}else{
		Warning("<li>�༭����ʧ��",$editURL);
	}	
	
}else{
	if($id>0){
		$sql="select shownum,third_name,info_state from third_class where id=$id and sec_id=$sec_id";
		if($arr=$db->fetch_array($db->query($sql))){
			$shownum	=$arr['shownum'];
			$name		=$arr['third_name'];
			$info_state	=$arr['info_state'];			
		}else{
			$db->close();
			Warning("ָ���ļ�¼�Ų�����");
		}
	}else{
		$shownum=$db->getMax("third_class", "shownum", "sec_id=$sec_id")+10;

		if($big_info_state=="custom"){
			$info_state="list";
		}else{
			$info_state=$sec_info_state;
		}
	}
	$db->close();	
}

?>

<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="-1000">

		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>

		<script language="javascript">
			function check(form)
			{
				if (!/^[0-9]*$/.exec(form.sortnum.value))
				{
					alert("�������ֻ��ʹ�����֣�");
					form.sortnum.focus();
					return false;
				}

				if (form.name.value == "")
				{
					alert("�������Ʋ���Ϊ�գ�");
					form.name.focus();
					return false;
				}

				return true;
			}
		</script>
	</head>

	<body onLoad="document.form1.name.focus();">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; <?php echo $big_name?> -&gt; <?php echo $sec_name?> -&gt; ��������</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[�����б�]</a>&nbsp;
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="<?php echo $editURL?>" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">��������</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">�������</td>
					<td class="editRightTd">
						<input name="shownum" type="text" id="shownum" value="<?php echo $shownum?>" size="10" maxlength="6">
					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��������</td>
					<td class="editRightTd">
						<input type="text" name="name" value="<?php echo $name?>" size="50" maxlength="50">
					</td>
				</tr>

				<?php
					if($big_info_state=="custom"){	
					
				?>
					<tr class="editTr">
						<td class="editLeftTd">��¼״̬</td>
						<td class="editRightTd">
							<input type="radio" name="info_state" value="list" <?php echo $info_state=="list"?"checked":""?>> �б�
							<input type="radio" name="info_state" value="pic" <?php echo $info_state=="pic"?"checked":""?> > ͼƬ�б�
							<input type="radio" name="info_state" value="content" <?php echo $info_state=="content"?"checked":""?> > ����							
						</td>
					</tr>				
				<?php
				}?>

				<tr class="editFooterTr">
					<td class="editFooterTd" colSpan="2">
						<input type="submit" value=" ȷ �� ">
						<input type="reset" value=" �� �� ">
					</td>
				</tr>

			</form>
		</table>
	</body>
</html>