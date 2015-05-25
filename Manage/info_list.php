<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$sec_id=(int)$_GET['sec_id'];
$third_id=(int)$_GET['third_id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];
$pagesize=15;

if($sec_id<1){
	Warning("没有指定二级分类ID号！");
}


$baseURL	="info_list.php";
$listURL	="info_list.php?sec_id=$sec_id&third_id=$third_id&page=$page";
$editURL	="info_edit.php?sec_id=$sec_id&third_id=$third_id&page=$page";
$listsURL	="info_list_list.php?sec_id=$sec_id&third_id=$third_id&page=$page";



//数据库
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

//二级分类
$sql="select big_id,sec_name,third_state,info_state from sec_class where id=$sec_id";
if($arr=$db->fetch_array($db->query($sql))){
	$big_id			=$arr['big_id'];
	$sec_name		=$arr['sec_name'];
	$sec_third_state=$arr['third_state'];
	$info_state		=$arr['info_state'];
}else{
	$db->close();
	Warning("指定的二级分类不存在！");
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
	Warning("指定的记录不存在！");
}


//三级分类
if($sec_third_state=="YES"){
	
	if($third_id>0){
		$sql="select third_name from third_class where id=$third_id and sec_id=$sec_id";
		if($arr=$db->fetch_array($db->query($sql))){
			$third_name=$arr['third_name'];
		}else{			
			$db->close();
			Warning("指定的三级分类不存在！");
		}
	}else{
		$sql="select id,third_name from third_class where sec_id=$sec_id order by shownum asc";
		
		if($arr=$db->fetch_array($db->query($sql))){
			$third_id=$arr['id'];
			$third_name=$arr['third_name'];
		}else{
			$db->close();
			Warning("没有三级分类，请先建立！");
		}
	}
}


//删除

if($_SERVER['REQUEST_METHOD']=='POST'){
	$action=$_POST['action'];
	$state=ToLimitLng($_POST['state'],0,4);
	$ids=$_POST['ids'];

	if($ids==""){
		$db->close();
		Warning("没有选择记录！");
	}	
	if($action=="del"){
		
		if($_SESSION['sql_adv']!='all' && !@in_array('delete', $_SESSION['sql_adv']))
		{
			echo "<script>alert('您没有删除权限!');history.back();</script>";
			exit;
		}
			
		for($i=0;$i<count($ids);$i++){			
			$id=(int)(trim($ids[$i]));
			if($id>0){
				//检查当前准备删除的信息是否属于当前二级分类				
				if($db->getCount("info", "*", "id=$id and sec_id=$sec_id")!=1){
					$db->close();
					Warning("非法操作！");
				}

				//删除文件
				//$sql="select file_path from files where table_name='info' and table_id=$id";
				//$query=$db->query($sql);
				//while($arr=mysql_fetch_array($query)){
					//删除文件程序
				//	$file='../uploadfile/'.$arr['file_path'];
				//	if(file_exists($file)){
				//		unlink($file);
				//	}
					//执行删除
				//}
				//执行删除
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
					Warning("非法操作！");
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
			echo "<script>alert('您没有此审核权限!');history.back();</script>";
			exit;
		}
		
		for($i=0;$i<count($ids);$i++){			
			$id=(int)(trim($ids[$i]));
			if($id>0){
				//检查当前准备删除的信息是否属于当前二级分类				
				if($db->getCount("info", "*", "id=$id and sec_id=$sec_id")!=1){
					$db->close();
					Warning("非法操作！");
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
		//检查是否选择了条目，并提示是否设置选中的条目的状态
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
				alert('请先选择准备设置状态的记录');
				document.form1.state.options[0].selected = true;
				return false;
			}
			else
			{
				if (document.form1.state.options[document.form1.state.selectedIndex].value == "-1")
				{
					alert('请选择状态');
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
				<td class="position">当前位置: 管理中心 -&gt; <?php echo $big_name?> -&gt; <?php echo $sec_name?> -&gt; 信息</td>
			</tr>
		</table>
		<form name="form1" action="<?php echo $listURL?>" method="post" style="margin:0px">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
				<input type="hidden" name="action" value="">

			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[刷新列表]</a>&nbsp;					
					<?php
					if($_SESSION['sql_adv']=='all' || @in_array('insert', $_SESSION['sql_adv']))
					{
					?>
					<a href="<?php echo $editURL?>">[增加]</a>&nbsp;
					<?php
					}
					?>
					<a href="javascript:reverseCheck(document.form1.ids);">[反向选择]</a>&nbsp;					
					<a href="javascript:if(delCheck(document.form1.ids)) {document.form1.action.value = 'del';document.form1.submit();}">[删除]</a>&nbsp;
					
					<?php
					if($hasState){				
					?>					
						<select name="state" onChange="if(stateCheck(document.form1.ids)) {document.form1.action.value = 'state';document.form1.submit();}">
							<option value="-1">设置状态为</option>
							<option value="0">不显示</option>
							<option value="1">正常</option>
							<option value="2">置顶</option>
							<option value="3">总置顶</option>
							<option value="4">头条</option>
						</select>
					<?php }?>

					<?php
					//三级分类
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
					//分页sql
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
				<td width="0" align="center"><strong>序号</strong></td>
				<td width="0" align="center"><strong>标题</strong></td>
				<td width="0" align="center"><strong>发表</strong></td>
				
				<?php
				if($hasViews){				
				?>				
					<td width="0" align="center"><strong>浏览</strong></td>
				<?php }?>				
				<?php
				if($hasState){				
				?>				
					<td width="0" align="center"><strong>状态</strong></td>
				<?php }?>
				
				<?php
				if($hasHot){				
				?>				
					<td width="0" align="center">证书</td>
				    
			        <?php }?>
				
				<?php
				if($hassmaPic){				
				?>				
					<td width="0" align="center"><strong>小图</strong></td>
				<?php }?>			
				
				<?php
				if($hasbigPic){				
				?>				
					<td width="0" align="center"><strong>大图</strong></td>
				<?php }?>
				
				<?php
				if($hasFile){				
				?>				
					<td width="0" align="center"><strong>附件</strong></td>
			    <?php }?>
		
				<?php
				if($comments){				
				?>				
				    <td width="0" align="center"><strong>评论</strong></td>
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
									case	0:	echo "<font color='#0066FF'>不显示</font>";	break;
									case	1:	echo "正常";	break;
									case	2:	echo "<font color='#FF9900'>置顶</font>";	break;
									case	3:	echo "<font color='#FF3300'>总置顶</font>";	break;
									case	4:	echo "<font color='#FF3300'>头条</font>";	break;
									default  :	echo "<font color='#FF0000'>错误</font>";	break;
								}
							?>						</td>
					<?php }?>
					<?php
					if($hasHot){				
					?>
						<td width="0" align="center">
							<?php echo $arr['hot']>0?"<font color='#FF6600'>是</font>":"否"?>						</td>				    
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
							有</a>
							<?php }else{?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=image&file_falg=sma">无</a>
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
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=image&file_falg=big">有</a>
							<?php }else{?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=image&file_falg=big">无</a>
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
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=flash&file_falg=flash">有</a>
							<?php }else{?>
							<a href="uploadfile.php?table_name=info&table_id=<?php echo $arr['id']?>&file=flash&file_falg=flash">无</a>
							<?php }?>							</td>
					   <?php }?>
					   
				<?php
				if($comments){				
				?>	
					   
				<td width="0" align="center"><a href="comment
				s.php?id=<?php echo $arr['id']?>&sec_id=<?php echo $sec_id?>">评论(<?php echo $db->getcount("commentary","id","infoid={$arr['id']}")?>)</a></td>
				
				
				<?php }?>					   
				</tr>
			<?php }?>
				
			

			<tr>
			  <td colspan="18" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="39%" align="left">
				<?php 
				if(@in_array('shenhe', $_SESSION['sql_adv']) || $_SESSION['sql_adv']=='all'){?>
				<input type="button" name="Submit" class="submit" value="批量审核" onClick="javascript:if(shCheck(document.form1.ids)) {document.form1.action.value = 'sh';document.form1.submit();}">
				<?php }?></td>
                    <td width="61%" align="right" valign="middle"><?php echo $pagestr;?></td>
                  </tr>
                </table></td>
		    </tr>
		</table>
</form>
	</body>
</html>