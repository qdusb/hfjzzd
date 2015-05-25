<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

//if($_SESSION['is_hidden']!=true){
//	header("location: logout.php?action=logout");
//	exit();
//}

$action	= $_GET['action'];
$id		= (int)$_GET['id'];

$listURL	= "big_class_list.php";
$editURL	= "big_class_edit.php?action=".$action."&id=".$id;

$db= new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SERVER['REQUEST_METHOD']=='POST'){
	$id				= (int)$_POST['id'];	
	$shownum		= (int)$_POST['shownum'];
	$name			= $_POST['name'];
	

	$sec_class		=$_POST['sec_class'];
	$sec_cont		=ToLimitLng($_POST['sec_cont'],0,1);
	$sec_pic		=ToLimitLng($_POST['sec_pic'],0,1);
	$third_state	=$_POST['third_state'];
	$info_state		=$_POST['info_state'];

	$hasViews		=ToLimitLng($_POST['hasViews'],0,1);
	$hasHot			=ToLimitLng($_POST['hasHot'],0,1);
	$hasKeyword		=ToLimitLng($_POST['hasKeyword'],0,1);
	$hasState		=ToLimitLng($_POST['hasState'],0,1);

	$hassmaPic		=ToLimitLng($_POST['hassmaPic'],0,1);
	$hasbigPic		=ToLimitLng($_POST['hasbigPic'],0,1);
	$hasFile		=ToLimitLng($_POST['hasFile'],0,1);

	$hasIntro		=ToLimitLng($_POST['hasIntro'],0,1);
	$hasContent		=ToLimitLng($_POST['hasContent'],0,1);
	$hasWebsite		=ToLimitLng($_POST['hasWebsite'],0,1);

	$hasAuthor		=ToLimitLng($_POST['hasAuthor'],0,1);
	$hasSource		=ToLimitLng($_POST['hasSource'],0,1);
	$hasPublishdate	=ToLimitLng($_POST['hasPublishdate'],0,1);
	$comments		=ToLimitLng($_POST['comments'],0,1);
	

	//���
	if ($id < 1 or $name == ""){
		Warning("��д�Ĳ����д���");
	}
	if($shownum<1){
		$shownum=$db->getMax('big_class','shownum')+10;
	}

	if($sec_class!='allow' && $sec_class!='deny'){
		Warning("��д�Ĳ����д���");
	}
	
	if($third_state!='YES' && $third_state!='NO' && $third_state!="custom"){
		Warning("3��д�Ĳ����д���");
	}

	if($info_state!='list' && $info_state!='pic' && $info_state!="content" && $info_state!="custom"){
		Warning("4��д�Ĳ����д���");
	}	

	//����
	if($action=='modify'){
		$sql="update big_class set shownum=$shownum,typename='$name',sec_class='$sec_class',sec_cont=$sec_cont,sec_pic=$sec_pic,third_state='$third_state',info_state='$info_state',hasViews=$hasViews,hasHot=$hasHot,hasKeyword=$hasKeyword,hassmaPic=$hassmaPic,hasbigPic=$hasbigPic,hasFile=$hasFile,hasIntro=$hasIntro,hasContent=$hasContent,hasWebsite=$hasWebsite,hasAuthor=$hasAuthor,hasSource=$hasSource,hasPublishdate=$hasPublishdate,hasState=$hasState,comments=$comments  where id=".(int)$_GET['id'];
	}else{
		if($db->getCount('big_class','*',"id=$id")>0){
			Warning("<li>�˷���ID���Ѿ���ʹ�ã���ѡ��������ID�ţ�");
		}			
		$sql="insert into big_class values($id,$shownum,'$name','$sec_class',$sec_cont,$sec_pic,'$third_state','$info_state',$hasViews,$hasHot,$hasKeyword,$hassmaPic,$hasbigPic,$hasFile,$hasIntro,$hasContent,$hasWebsite,$hasAuthor,$hasSource,$hasPublishdate,$hasState,$comments)";
	}
	
	$db->query($sql);
	Redirect($listURL);	
}else{
	if($action=="modify"){
		if($id<1){
			Warning("<li>û��ָ����¼��");
		}

		$sql="select * from big_class where id=$id";
		if($arr=$db->fetch_array($db->query($sql))){
			$id				=$arr['id'];
			$shownum		=$arr['shownum'];
			$name			=$arr['typename'];

			$sec_class		=$arr['sec_class'];
			$sec_cont		=$arr['sec_cont'];
			$sec_pic		=$arr['sec_pic'];
			$third_state	=$arr['third_state'];
			$info_state		=$arr['info_state'];

			$hasViews		=$arr['hasViews'];
			$hasHot			=$arr['hasHot'];
			$hasKeyword		=$arr['hasKeyword'];
			$hasState		=$arr['hasState'];

			$hassmaPic		=$arr['hassmaPic'];
			$hasbigPic		=$arr['hasbigPic'];
			$hasFile		=$arr['hasFile'];

			$hasIntro		=$arr['hasIntro'];
			$hasContent		=$arr['hasContent'];
			$hasWebsite		=$arr['hasWebsite'];

			$hasAuthor		=$arr['hasAuthor'];
			$hasSource		=$arr['hasSource'];
			$hasPublishdate	=$arr['hasPublishdate'];
			$comments		=$arr['comments'];

		}else{
			Warning("<li>ָ����¼�Ų�����");
		}

	}else{
		$id				= $db->getMax("big_class", "id") + 1;
		$shownum		= $db->getMax("big_class", "shownum") + 10;
		$sec_class		= "allow";
		$third_state	= "NO";
		$info_state		= "list";
	}
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
		check_frame("default.php");
			function check(form)
			{
				if (!/^[0-9]*$/.exec(form.shownum.value))
				{
					alert("�������ֻ��ʹ�����֣�");
					form.shownum.focus();
					return false;
				}

				if (!/^[1-9]{1}[0-9]?$/.exec(form.id.value))
				{
					alert("����ID��ֻ��ʹ�����֣�����Ҫ����1-2λ��");
					form.id.focus();
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

	<body document.form1.name.focus();>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position">
				<td class="position">��ǰλ��: �������� -&gt; ���ع��� -&gt; �༭/�༭ ��Ϣ����</td>
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
			<form name="form1" action="" method="post" onSubmit="return check(this);">

				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">һ������</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">����ID��</td>
					<td class="editRightTd">
						<input name="id" type="text" id="id" value="<?php echo $id?>" size="10" maxlength="6">					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">�������</td>
					<td class="editRightTd">
						<input name="shownum" type="text" id="shownum" value="<?php echo $shownum?>" size="10" maxlength="2" >					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��������</td>
					<td class="editRightTd">
						<input type="text" name="name" value="<?php echo $name?>" id="name"  size="50" maxlength="50">					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��������</td>
					<td class="editRightTd">
						<input type="radio" name="sec_class" value="allow" <?php echo $sec_class=="allow"?"checked":"";?>> 
						����
						<input type="radio" name="sec_class" value="deny" <?php echo $sec_class=="deny"?"checked":"";?>> 
						�ܾ�
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input name="sec_cont" type="checkbox" id="sec_cont" value="1" <?php echo $sec_cont==0?"":"checked";?>> 
						IP����
						<input name="sec_pic" type="checkbox" id="sec_pic" value="1" <?php echo $sec_pic==0?"":"checked";?>> 
						��ͼƬ					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��������</td>
					<td class="editRightTd">
						<input type="radio" name="third_state" value="NO" <?php echo $third_state=="NO"?"checked":"";?>> 
						��
						<input type="radio" name="third_state" value="YES"  <?php echo $third_state=="YES"?"checked":"";?>> 
						��
						<input type="radio" name="third_state" value="custom"  <?php echo $third_state=="custom"?"checked":"";?>> �Զ���					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��¼״̬</td>
					<td class="editRightTd">
						<input type="radio" name="info_state" value="list"  <?php echo $info_state=="list"?"checked":"";?>> �б�
						<input type="radio" name="info_state" value="pic"   <?php echo $info_state=="pic"?"checked":"";?>> ͼƬ�б�
						<input type="radio" name="info_state" value="content"  <?php echo $info_state=="content"?"checked":"";?> > ����
						<input type="radio" name="info_state" value="custom"  <?php echo $info_state=="custom"?"checked":"";?> > �Զ���					</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">��¼����</td>
				  <td class="editRightTd">

						<input type="checkbox" name="hasViews" value="1" <?php echo $hasViews==0?"":"checked";?>> �������
						<input type="checkbox" name="hasHot" value="1"  <?php echo $hasHot==0?"":"checked";?>> �ȵ��־					
						<input type="checkbox" name="hasKeyword" value="1"  <?php echo $hasKeyword==0?"":"checked";?>> 
						�� �� ��
						<input type="checkbox" name="hasState" value="1"  <?php echo $hasState==0?"":"checked";?>> ��ʾ״̬<br>

						<input name="hassmaPic" type="checkbox" id="hassmaPic" value="1"  <?php echo $hassmaPic==0?"":"checked";?>> ͼƬ�ϴ�
						<input name="hasbigPic" type="checkbox" id="hasbigPic" value="1"  <?php echo $hasbigPic==0?"":"checked";?>> �Ŵ�ͼƬ
						<input type="checkbox" name="hasFile" value="1"  <?php echo $hasFile==0?"":"checked";?>> �����ϴ�
						<input name="comments" type="checkbox" id="comments" value="1"  <?php echo $comments==0?"":"checked";?>>
��������<br>

						<input type="checkbox" name="hasIntro" value="1"  <?php echo $hasIntro==0?"":"checked";?>> ��Ҫ����
						<input type="checkbox" name="hasContent" value="1"  <?php echo $hasContent==0?"":"checked";?>> ��ϸ����				
						<input type="checkbox" name="hasWebsite" value="1"  <?php echo $hasWebsite==0?"":"checked";?>> ���ӵ�ַ<br>

						<input type="checkbox" name="hasAuthor" value="1"  <?php echo $hasAuthor==0?"":"checked";?>> ��������
						<input type="checkbox" name="hasSource" value="1"  <?php echo $hasSource==0?"":"checked";?>> ������Դ
						<input type="checkbox" name="hasPublishdate" value="1"  <?php echo $hasPublishdate==0?"":"checked";?>> ����ʱ��				  </td>
				</tr>
				<tr class="editFooterTr">
					<td class="editLeftTd">ע������</td>
					<td class="editRightTd">
						1���༭ʱ�޸�ID��Ч��<br>
						2���޸���������״̬��ֵ����Ҫ���±༭�˷����µĶ������ࡣ<br>
						3���޸ļ�¼״̬��ֵ����Ҫ���±༭�˷����µĶ����������ࡣ<br>					</td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" class="submit" value=" ȷ �� ">
                      <input name="reset" type="reset" class="submit" value=" �� �� "></td>
				</tr>
			</form>
		</table>


		<script language="javascript">
			document.form1.name.focus();
		</script>


	</body>
</html>