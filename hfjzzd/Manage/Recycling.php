<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$big_id=(int)$_GET['big_id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$pagesize=15;



$baseURL	="Recycling.php";
$listURL	="Recycling.php";
$editURL	="Recycling.php";
$listsURL	="Recycling.php";



//���ݿ�
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
//ɾ��

if($_SERVER['REQUEST_METHOD']=='POST'){
	$action=$_POST['action'];
	$state=$_POST['state'];
	$ids=$_POST['ids'];

	if($ids==""){
		$db->close();
		Warning("û��ѡ���¼��");
	}	
	if($action=="del"){
		
		if($_SESSION['sql_adv']!='all' && !@in_array('delete', $_SESSION['sql_adv']))
		{
			echo "<script>alert('��û��ɾ��Ȩ��!');history.back();</script>";
			exit;
		}	
		
		for($i=0;$i<count($ids);$i++){			
			$id=(int)(trim($ids[$i]));
			if($id>0){
				//��鵱ǰ׼��ɾ������Ϣ�Ƿ����ڵ�ǰ��������				
				if($db->getCount("info", "*", "id=$id")!=1){
					$db->close();
					Warning("�Ƿ�������");
				}

				//ɾ���ļ�
				$sql="select file_path from files where table_name='info' and table_id=$id";
				$query=$db->query($sql);
				while($arr=mysql_fetch_array($query)){
					//ɾ���ļ�����
					$file='../uploadfile/'.$arr['file_path'];
					if(file_exists($file)){
						unlink($file);
					}
					//ִ��ɾ��
				}
				//ִ��ɾ��
				$sql="delete from files where table_name='info' and table_id=$id";
				$db->query($sql);
				$sql="delete from info where id=$id";
				$db->query($sql);
			}
				
		}
		
		
		
		
	}elseif($action="state"){
		for($i=0;$i<count($ids);$i++){
			$id=(int)(trim($ids[$i]));
			if($id>0){
				if($db->getCount("info", "*", "id=$id")!=1){
					$db->close();
					Warning("�Ƿ�������");
				}
				$sql="update info set state=$state where id=$id";				
				$db->query($sql);
			}
		}
		$db->close();
		Redirect($listURL);			
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
		//����Ƿ�ѡ������Ŀ������ʾ�Ƿ�����ѡ�е���Ŀ��״̬
		check_frame("default.php");
		function stateCheck(obj)
		{
			var hasChecked = false;
			if (!obj)
			{
				document.form1.state.options[0].selected = true;
				return false;
			}

			if (obj.length)
			{
				for (i = 0; i < obj.length; i++)
				{
					if (obj[i].checked)
					{
						hasChecked = true;
						break;
					}
				}
			}
			else
			{
				hasChecked = obj.checked;
			}

			if (!hasChecked)
			{
				alert('����ѡ��׼������״̬�ļ�¼');
				document.form1.state.options[0].selected = true;
				return false;
			}
			else
			{
				if (document.form1.state.options[document.form1.state.selectedIndex].value == "-1")
				{
					alert('��ѡ��״̬');
					return false;
				}

				
				return true;
			}
		}
		</script>

	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: �������� -&gt; ����վ </td>
			</tr>
		</table>

			<form name="form1" action="<?php echo $listURL?>" method="post">
		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
				<input type="hidden" name="action" value="">

			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;					
					<?php					
					if(!($info_state=="content" && $db->getCount("info","*","big_id=$big_id and sec_id=$sec_id and third_id=$third_id")>0)){
					?>
					<a href="<?php echo $editURL?>">[����]</a>&nbsp;
					<?php
					}
					?>
					<a href="javascript:reverseCheck(document.form1.ids);">[����ѡ��]</a>&nbsp;					
					<a href="javascript:if(delCheck(document.form1.ids)) {document.form1.action.value = 'del';document.form1.submit();}">[ɾ��]</a>&nbsp;
					<select name="state" onChange="if(stateCheck(document.form1.ids)) {document.form1.action.value = 'state';document.form1.submit();}">
							<option value="-1">����״̬Ϊ</option>
							<option value="0">����ʾ</option>
							<option value="1">����</option>
							<option value="2">�ö�</option>
							<option value="3">���ö�</option>
				  </select>
					<?php
					//��ҳsql
					$pagesql="select info.id,info.shownum,info.title,info.state,info.hot,info.pic,info.files,info.views,info.adduser from info where info.state=-1 ";

					
					$pagesql.=" order by shownum desc";
					$pagestr=$db->page_1($pagesql,$page,$pagesize);
					?>			  </td>
				<td align="right">
					<?php echo $pagestr;?>
				</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td width="0" align="center"></td>
				<td width="0" align="center">���</td>
				<td width="0" align="center">����</td>
				<td width="0" align="center">����</td>
				<?php
				if($hasViews){				
				?>				
					<td width="0" align="center">���</td>
				<?php }?>				
				<?php
				if($hasState){				
				?>				
					<td width="0" align="center">״̬</td>
				<?php }?>
				
				<?php
				if($hasHot){				
				?>				
					<td width="0" align="center">�ȵ�</td>
				<?php }?>
				
				<?php
				if($hassmaPic){				
				?>				
					<td width="0" align="center">Сͼ</td>
				<?php }?>			
				
				<?php
				if($hasbigPic){				
				?>				
					<td width="0" align="center">��ͼ</td>
				<?php }?>
				
				<?php
				if($hasFile){				
				?>				
					<td width="0" align="center">����</td>
			    <?php }?>
		
				<?php
				if($comments){				
				?>				
				    <td width="0" align="center">����</td>
			    <?php }?>		
		
		
			</tr>
			<?php 			
			
			$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";
		
			$query=$db->query($pagesql);
			while($arr=mysql_fetch_array($query)){
				$css=$i++ % 2	==0?"listTr":"listAlternatingTr";				
			
			
			
			
			?>			
				<tr class="<?php echo $css;?>">
					<td width="0" align="center">
						
							<input type="checkbox" name="ids[]" id="ids" value="<?php echo $arr['id']?>">					</td>

					<td width="0" align="center"><?php echo $arr['shownum']?></td>

					<td width="0" align="left"><?php echo $arr['title']?></td>

					<td width="0" align="center"><?php echo $arr['adduser']?></td>
					
					<?php
					if($hasViews){				
					?>
						<td width="0" align="center"><?php echo $arr['views']?></td>
					<?php }?>
					<?php
					if($hasState){				
					?>
						<td width="0" align="center">
							<?php
								switch($arr['state']){
									case	0:	echo "<font color='#0066FF'>����ʾ</font>";	break;
									case	1:	echo "����";	break;
									case	2:	echo "<font color='#FF9900'>��Ʒ</font>";	break;
									case	3:	echo "<font color='#FF3300'>�Ƽ�</font>";	break;
									default  :	echo "<font color='#FF0000'>����վ</font>";	break;
								}
							?>						</td>
					<?php }?>
					<?php
					if($hasHot){				
					?>
						<td width="0" align="center">
							<?php echo $arr['hot']>0?"<font color='#FF6600'>��</font>":"��"?>						</td>
					<?php }?>
					<?php
					if($hassmaPic){				
					?>
						<td width="0" align="center">
							<?php
								$sql="select table_name from files where table_name='info' and table_id=".$arr['id']." and file_falg='sma'";
								if($img=$db->fetch_array($db->query($sql))){
							?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=image&file_falg=sma">
							��</a>
							<?php }else{?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=image&file_falg=sma">��</a>
							<?php }?>						</td>
					<?php }?>
					<?php
					if($hasbigPic){				
					?>
						<td width="0" align="center">
							
							<?php
								$sql="select table_name from files where table_name='info' and table_id=".$arr['id']." and file_falg='big'";
								if($img=$db->fetch_array($db->query($sql))){
							?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=image&file_falg=big">��</a>
							<?php }else{?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=image&file_falg=big">��</a>
							<?php }?>						</td>
					<?php }?>
					<?php
					if($hasFile){				
					?>
						<td width="0" align="center">
							
								<?php
								$sql="select table_name from files where table_name='info' and table_id=".$arr['id']." and file_falg='file'";
								if($img=$db->fetch_array($db->query($sql))){
							?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=file&file_falg=big">��</a>
							<?php }else{?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=file&file_falg=big">��</a>
							<?php }?>							</td>
					   <?php }?>
					   
				<?php
				if($comments){				
				?>	
					   
				<td width="0" align="center"><a href="comment
				s.php?id=<?php echo $arr['id']?>&sec_id=<?php echo $sec_id?>">����(<?php echo $db->getcount("commentary","id","infoid={$arr['id']}")?>)</a></td>
				
				
				<?php }?>					   
				
				</tr>
			<?php }?>
				
			

			<tr class="listFooterTr">
				<td colspan="16" align="center">
					<?php echo $pagestr;?></td>
			</tr>

			
		</table>
</form>
	</body>
</html>