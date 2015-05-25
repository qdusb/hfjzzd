<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$big_id=(int)$_GET['big_id'];

if($big_id<0){
	Warning("<li>û��ָ��һ������");
}

$listURL	= "sec_class_list.php?big_id=$big_id";
$editURL	= "sec_class_edit.php?big_id=$big_id";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$sql = "select typename,sec_class, sec_cont, sec_pic, third_state, info_state from big_class where id=$big_id";

if($arr=$db->fetch_array($db->query ($sql))){
	$big_typename			= $arr['typename'];
	$big_sec_class			= $arr['sec_class'];
	$big_sec_cont			= $arr['sec_cont'];
	$big_sec_pic			= $arr['sec_pic'];
	$big_third_state		= $arr['third_state'];
	$big_info_state			= $arr['info_state'];	
}else{
	$db->close();
	Warning("ָ����һ�����಻���ڣ�");	
}
//Ȩ�޼��
if($_SESSION['is_hidden']<>true and $big_sec_class=="deny"){
	$db->close();
	Warning("�Ƿ�������");
}

//ɾ��
if($id>0){
	//��鵱ǰ׼��ɾ���ķ���,�Ƿ����ڵ�ǰһ������
	if($db->getCount('sec_class',"*","id=$id and big_id=$big_id")!=1){
		$db->close();
		Warning("�Ƿ�������");
	}

	if($db->getCount('info',"*","sec_id=$id")>0){
		$db->close();
		Warning("�˷�������¼����ݣ�����ɾ�����¼����ݣ�");
	}

	if($db->getCount('third_class',"*","sec_id=$id")>0){
		$db->close();
		Warning("�˷�������¼����࣬����ɾ�����¼����࣡");
	}

	if($db->getCount('third_class',"*","sec_id=$id")>0){
		$db->close();
		Warning("�˷�������¼����࣬����ɾ�����¼����࣡");
	}

	//ɾ����������ļ���ͼƬ

	//
	$sql="delete from sec_class where id=$id";
	if($db->query($sql)){
		$db->close();
		Redirect($listURL);
	}else{
		Warning("ɾ����¼ʧ�ܣ�");
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
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; <?php echo $big_typename?> -&gt; ��������</td>
		    </tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;
					<a href="<?php echo $editURL?>">[����]</a>&nbsp;
				</td>
			</tr>
	</table>

			
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td>���</td>
				<td>��������</td>
				<td>��������</td>
				<td>��¼״̬</td>
				<?php
				if($big_sec_pic){
				?>
				<td>ͼƬ</td>
				<?php
				}
				?>
				
				<td>ɾ��</td>
			</tr>

			<?php
			$sql = "select id, shownum, sec_name, third_state, info_state, pic from sec_class where big_id=$big_id order by shownum asc";
			$query=$db->query($sql);
			while($arr=mysql_fetch_array($query)){
				$i++;
				$css=$i%2==0?"listAlternatingTr":"listTr";
			?>
				<tr class="<?php echo $css;?>">
					<td><?php echo $arr['shownum'];?></td>
					<td><a href="<?php echo $editURL."&id=".$arr['id'];?>"><?php echo $arr['sec_name']?></a></td>
					<td>
						<?php
							if($arr['third_state']=="NO"){
								echo "��";
							}else{
								$third_sum=$db->getCount("third_class","*","sec_id=".$arr['id']." and big_id=$big_id");
								if($third_sum){
									echo '<a href="third_class_list.php?big_id='.$big_id.'&sec_id='.$arr['id'].'"><font color="#FF0000">��['.$third_sum.']</font></a>';
								}else{
									echo '<a href="third_class_list.php?big_id='.$big_id.'&sec_id='.$arr['id'].'"><font color="#FF0000">��</font></a>';
								}
								
							}						
													
						?>
					</td>
					<td>
						<?php				
							switch($arr['info_state']){
								case "list"		:	echo "�б�";break;
								case "pic"		:	echo "ͼƬ�б�";break;
								case "content"	:	echo "��һ����";break;
								Default			:	echo "<font color='#FF0000'>����</font>";break;
							}								
						?>
					</td>
					<?php
					if($big_sec_pic){
					?>
					<td>
							��[3]
							��
							</a>
				  </td>
					<?php
					}
					?>
					<td><a href="<?php echo $listURL."&id=".$arr['id']?>" onClick="return del('<?php echo $arr['sec_name']?>');">ɾ��</a></td>
				</tr>
			<?php
			}?>			

			<tr class="listFooterTr">
				<td colspan="10"></td>
			</tr>
		</table>

	</body>
</html>