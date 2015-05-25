<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$sec_id=(int)$_GET['sec_id'];
$third_id=(int)$_GET['third_id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$pagesize=15;

if($sec_id<1){
	Warning("û��ָ����������ID�ţ�");
}


$baseURL	="info_list.php";
$listURL	="info_list.php?sec_id=$sec_id&third_id=$third_id&page=$page";
$editURL	="info_edit.php?sec_id=$sec_id&third_id=$third_id&page=$page";
$listsURL	="info_list_list.php?sec_id=$sec_id&third_id=$third_id&page=$page";



//���ݿ�
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

//��������
$sql="select big_id,sec_name,third_state,info_state from sec_class where id=$sec_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_id			=$arr['big_id'];
	$sec_name		=$arr['sec_name'];
	$sec_third_state=$arr['third_state'];
	$info_state		=$arr['info_state'];
}else{
	$db->close();
	Warning("ָ���Ķ������಻���ڣ�");
}

$sql="select * from big_class where id=$big_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_name		=	$arr['typename'];

	$hasViews		=	$arr['hasViews'];
	$hasHot			=	$arr['hasHot'];
	$hasKeyword		=	$arr['hasKeyword'];
	$hasState		=	$arr['hasState'];

	$hassmaPic		=	$arr['hassmaPic'];
	$hasbigPic		=	$arr['hasbigPic'];
	$hasFile		=	$arr['hasFile'];

	$hasIntro		=	$arr['hasIntro'];
	$hasContent		=	$arr['hasContent'];
	$hasWebsite		=	$arr['hasWebsite'];

	$hasAuthor		=	$arr['hasAuthor'];
	$hasSource		=	$arr['hasSource'];
	$hasPublishdate	=	$arr['hasPublishdate'];	
	$comments		=	$arr['comments'];	

}else{
	$db->close();
	Warning("ָ���ļ�¼�����ڣ�");
}


//��������
if($sec_third_state=="YES"){
	
	if($third_id>0){
		$sql="select third_name from third_class where id=$third_id and sec_id=$sec_id";
		if($arr=$db->fetch_array($db->query($sql))){
			$third_name=$arr['third_name'];
		}else{			
			$db->close();
			Warning("ָ�����������಻���ڣ�");
		}
	}else{
		$sql="select id,third_name from third_class where sec_id=$sec_id order by shownum asc";
		
		if($arr=$db->fetch_array($db->query($sql))){
			$third_id=$arr['id'];
			$third_name=$arr['third_name'];
		}else{
			$db->close();
			Warning("û���������࣬���Ƚ�����");
		}
	}
}


//ɾ��

if($_SERVER['REQUEST_METHOD']=='POST'){
	$action=$_POST['action'];
	$state=ToLimitLng($_POST['state'],0,4);
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
				if($db->getCount("info", "*", "id=$id and sec_id=$sec_id")!=1){
					$db->close();
					Warning("�Ƿ�������");
				}

				//ɾ���ļ�
				//$sql="select file_path from files where table_name='info' and table_id=$id";
				//$query=$db->query($sql);
				//while($arr=mysql_fetch_array($query)){
					//ɾ���ļ�����
				//	$file='../uploadfile/'.$arr['file_path'];
				//	if(file_exists($file)){
				//		unlink($file);
				//	}
					//ִ��ɾ��
				//}
				//ִ��ɾ��
				//$sql="delete from files where table_name='info' and table_id=$id";
				//$db->query($sql);
				$sql="update info set state=-1 where id=$id and sec_id=$sec_id";
				$db->query($sql);
				//$sql="delete from info where id=$id and sec_id=$sec_id";
				//$db->query($sql);
			}
				
		}		
	}elseif($action=="state"){
		for($i=0;$i<count($ids);$i++){
			$id=(int)(trim($ids[$i]));
			if($id>0){
				if($db->getCount("info", "*", "id=$id and sec_id=$sec_id")!=1){
					$db->close();
					Warning("�Ƿ�������");
				}
				$sql="update info set state=$state where id=$id";				
				$db->query($sql);
			}
		}
		$db->close();
		Redirect($listURL);			
	}elseif($action=="sh"){
		if(!@in_array('shenhe', $_SESSION['sql_adv']) && $_SESSION['sql_adv']!='all')
		{
			echo "<script>alert('��û�д����Ȩ��!');history.back();</script>";
			exit;
		}
		
		for($i=0;$i<count($ids);$i++){			
			$id=(int)(trim($ids[$i]));
			if($id>0){
				//��鵱ǰ׼��ɾ������Ϣ�Ƿ����ڵ�ǰ��������				
				if($db->getCount("info", "*", "id=$id and sec_id=$sec_id")!=1){
					$db->close();
					Warning("�Ƿ�������");
				}
				if($db->getCount("info", "*", "shenhe=1 and id=$id")==0){
					$sql="update info set shenhe=1,shuser='".$_SESSION['realname']."' where id=$id and sec_id=$sec_id";
					$db->query($sql);
				}
				
			}				
		}	
	}
	elseif($action == "data_dump")
	{
		if($_REQUEST['ids'])
		{			
			$filename = 'dumpsql/'.date('YmdHis').'.sql';
			foreach($_REQUEST['ids'] as $key => $val)
			{
				$sql = "select title, big_id, website, pic, content,state,publishdate, modify_time from info where id=$val";
				$arr=$db->fetch_array($db->query($sql));
				$arr['big_id'] = 9999;
				$dumpsql = "insert into info(title, big_id, website, pic, content,state,publishdate, modify_time) values('".implode('\', \'', $arr)."');\r\n";
				error_log($dumpsql, 3, $filename);
			}
		}
		header("location: $filename\n");
		exit;
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
				<td class="position">��ǰλ��: �������� -&gt; <?php echo $big_name?> -&gt; <?php echo $sec_name?> -&gt; ��Ϣ</td>
			</tr>
		</table>
		<form name="form1" action="<?php echo $listURL?>" method="post" style="margin:0px">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
				<input type="hidden" name="action" value="">

			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;					
					<?php
					if($_SESSION['sql_adv']=='all' || @in_array('insert', $_SESSION['sql_adv']))
					{
					?>
					<a href="<?php echo $editURL?>">[����]</a>&nbsp;
					<?php
					}
					?>
					<a href="javascript:reverseCheck(document.form1.ids);">[����ѡ��]</a>&nbsp;					
					<a href="javascript:if(delCheck(document.form1.ids)) {document.form1.action.value = 'del';document.form1.submit();}">[ɾ��]</a>&nbsp;
					
					<?php
					if($hasState){				
					?>					
						<select name="state" onChange="if(stateCheck(document.form1.ids)) {document.form1.action.value = 'state';document.form1.submit();}">
							<option value="-1">����״̬Ϊ</option>
							<option value="0">����ʾ</option>
							<option value="1">����</option>
							<option value="2">�ö�</option>
							<option value="3">���ö�</option>
							<option value="4">ͷ��</option>
						</select>
					<?php }?>

					<?php
					//��������
					if($sec_third_state=="YES"){
						
					?>
						<select name="third_id" onChange="window.location='<?php echo $baseURL?>?sec_id=<?php echo $sec_id?>&third_id=' + this.value;" class="submit">
							<?php
								$sql="select id,third_name from third_class where sec_id=$sec_id order by shownum asc";
								$query=$db->query($sql);
								while($arr=mysql_fetch_array($query)){
							?>
								<option value="<?php echo $arr['id']?>" <?php echo $third_id==$arr['id']?"selected":""?>><?php echo $arr['third_name']?></option>
							<?php }?>
							
						</select>
					<?php
					}
					?>
					
					<?php
					//��ҳsql
					$pagesql="select info.id,info.shownum,info.title,info.state,info.hot,info.pic,shenhe,shuser,info.files,info.views,info.adduser from info";
					if($sec_third_state=="YES"){
						$pagesql.=" where info.third_id=$third_id and info.state>=0";		
					}else{
						$pagesql.=" where info.sec_id=$sec_id and info.state>=0";
					}
					
					$pagesql.=" order by state desc,shownum desc";
					$pagestr=$db->page_1($pagesql,$page,$pagesize);
					?>

				</td>
				<td align="right">
					<?php echo $pagestr;?>
				</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td width="0" align="center"><input name="sh" type="hidden" id="sh"></td>
				<td width="0" align="center"><strong>���</strong></td>
				<td width="0" align="center"><strong>����</strong></td>
				<td width="0" align="center"><strong>����</strong></td>
				
				<?php
				if($hasViews){				
				?>				
					<td width="0" align="center"><strong>���</strong></td>
				<?php }?>				
				<?php
				if($hasState){				
				?>				
					<td width="0" align="center"><strong>״̬</strong></td>
				<?php }?>
				
				<?php
				if($hasHot){				
				?>				
					<td width="0" align="center">֤��</td>
				    
			        <?php }?>
				
				<?php
				if($hassmaPic){				
				?>				
					<td width="0" align="center"><strong>Сͼ</strong></td>
				<?php }?>			
				
				<?php
				if($hasbigPic){				
				?>				
					<td width="0" align="center"><strong>��ͼ</strong></td>
				<?php }?>
				
				<?php
				if($hasFile){				
				?>				
					<td width="0" align="center"><strong>����</strong></td>
			    <?php }?>
		
				<?php
				if($comments){				
				?>				
				    <td width="0" align="center"><strong>����</strong></td>
			    <?php }?>		
			</tr>
			<?php 			
			
			$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";
		
			$query=$db->query($pagesql);
			while($arr=mysql_fetch_array($query)){
			?>			
				<tr >
					<td width="0" align="center">
						
							<input type="checkbox" name="ids[]" id="ids" value="<?php echo $arr['id']?>">					</td>

					<td width="0" align="center"><?php echo $arr['shownum']?></td>

					<td width="0" align="left">
						
							<a href="<?php echo $editURL?>&id=<?php echo $arr['id']?>"><?php echo $arr['title']?></a></td>

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
									case	2:	echo "<font color='#FF9900'>�ö�</font>";	break;
									case	3:	echo "<font color='#FF3300'>���ö�</font>";	break;
									case	4:	echo "<font color='#FF3300'>ͷ��</font>";	break;
									default  :	echo "<font color='#FF0000'>����</font>";	break;
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
								$sql="select table_name from files where table_name='info' and table_id=".$arr['id']." and file_falg='flash'";
								if($img=$db->fetch_array($db->query($sql))){
							?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=flash&file_falg=flash">��</a>
							<?php }else{?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=flash&file_falg=flash">��</a>
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
				
			

			<tr>
			  <td colspan="18" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="39%" align="left">
				<?php 
				if(@in_array('shenhe', $_SESSION['sql_adv']) || $_SESSION['sql_adv']=='all'){?>
				<input type="button" name="Submit" class="submit" value="�������" onClick="javascript:if(shCheck(document.form1.ids)) {document.form1.action.value = 'sh';document.form1.submit();}">
				<?php }?></td>
                    <td width="61%" align="right" valign="middle"><?php echo $pagestr;?></td>
                  </tr>
                </table></td>
		    </tr>
		</table>
</form>
	</body>
</html>