<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$big_id=(int)$_GET['big_id'];
$sec_id=(int)$_GET['sec_id'];

if($big_id<0 || $sec_id<0){
	Warning("<li>û��ָ�����ϼ����࣡");
}

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($sec_id>0){
	$sql="select big_id,sec_name,third_state from sec_class where id=$sec_id";
	if($arr=$db->fetch_array($db->query($sql))){
		$big_id				=$arr['big_id'];
		$sec_name			=$arr['sec_name'];
		$sec_third_state	=$arr['third_state'];
	}else{
		$db->close();
		Warning("ָ���Ķ������಻���ڣ�");
	}

	if($sec_third_state=="NO"){
		$db->close();
		Warning("ָ���Ķ������಻��������������࣡");
	}

	$sql="select typename,third_state from big_class where id=$big_id";
	if($arr=$db->fetch_array($db->query($sql))){
		$big_name			=$arr['typename'];
		$big_third_state	=$arr['third_state'];
	}else{
		$db->close();
		Warning("ָ����һ�����಻���ڣ�");
	}
	
	if($big_third_state=="NO"){
		$db->close();
		Warning("ָ����һ�����಻��������������࣡");
	}

}else{
	$sql="select typename,third_state from big_class where id=$big_id";
	
	if($arr=$db->fetch_array($db->query($sql))){
		$$big_name			=$arr['typename'];
		$big_third_state	=$arr['third_state'];
	}else{
		$db->close();
		Warning("ָ����һ�����಻���ڣ�");
	}

	if($big_third_state=="NO"){
		$db->close();
		Warning("ָ����һ�����಻��������������࣡");
	}

	$sql="select id,sec_name,third_state from sec_class where big_id=$big_id and third_state<>'NO' order by shownum asc limit 0,1";

	if($arr=$db->fetch_array($db->query($sql))){
		$big_id				=$arr['big_id'];
		$sec_name			=$arr['sec_name'];
		$sec_third_state	=$arr['third_state'];
	}else{
		$db->close();
		Warning("û�н����������࣬���ߵ�ǰ�Ķ������������������������࣡");
	}
	
}



$baseURL		= "third_class_list.php";
$listURL		= "third_class_list.php?big_id=$big_id&sec_id=$sec_id";
$editURL		= "third_class_edit.php?big_id=$big_id&sec_id=$sec_id";
//ɾ��

if($id>0){
	if($db->getCount("third_class","*","id=$id and sec_id=$sec_id")<>1){
		$db->close();
		Warning("�Ƿ�������");
	}

	if($db->getCount("info","*","third_id=$id")>0){
		$db->close();
		Warning("�˷�������¼����ݣ�����ɾ�����¼����ݣ�");
	}

	$sql="delete from third_class where id=$id";

	if($db->query($sql)){
		isok('<li>ɾ������ɹ�');
	}else{
		Warning("<li>ɾ������ʧ��",$listURL);
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
				<td class="position">��ǰλ��: �������� -&gt; <?php echo $big_name?> -&gt; <?php echo $sec_name?> -&gt; ��������</td>
			</tr>
		</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;
					<a href="<?php echo $editURL?>">[����]</a>&nbsp;
					

					<select name="second_id" onChange="window.location='<?php echo $baseURL?>?sec_id='+this.value;">	
								<?php
								$sql="select id,sec_name from sec_class where big_id=$big_id and third_state<>'NO' order by shownum asc";
								$query=$db->query($sql);
								while($arr=$db->fetch_array($query)){
								?>
								<option value="<?php echo $arr['id']?>" <?php echo $sec_id==$arr['id']?"selected":"";?>><?php echo $arr['sec_name']?></option>	
								<?php
								}?>
								
					</select>

				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr class="listHeaderTr">
				<td>���</td>
				<td>��������</td>
				<td>��¼״̬</td>
				<td>ɾ��</td>
			</tr>
				
				<?php
				$sql="select id,shownum,third_name,info_state from third_class where sec_id=$sec_id order by shownum asc";
				$rs=$db->query($sql);
				while($arr=mysql_fetch_array($rs)){
					$css=$i++%2==0?"listTr":"listAlternatingTr";			
				?>
			
				<tr class="<?php echo $css?>">
					<td><?php echo $arr['shownum']?></td>
					<td><a href="<?php echo $editURL."&id=".$arr['id']?>"><?php echo $arr['third_name']?></a></td>
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
					<td><a href="<?php echo $listURL."&id=".$arr['id']?>" onClick="return del('<?php echo $arr['third_name']?>');">ɾ��</a></td>
				</tr>
				<?php
				}?>			
				
			<tr class="listFooterTr">
				<td colspan="10"></td>
			</tr>
		</table>

	</body>
</html>