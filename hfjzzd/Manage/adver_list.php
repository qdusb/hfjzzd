<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$sec_id=(int)$_GET['sec_id'];
$third_id=(int)$_GET['third_id'];
$page=(int)$_GET['page']<1?1:$_GET['page'];
$pagesize=15;



$baseURL	="adver_list.php";
$listURL	="adver_list.php?page=$page";
$editURL	="adver_edit.php?sec_id=$sec_id&third_id=$third_id&page=$page";
$listsURL	="info_list_list.php?sec_id=$sec_id&third_id=$third_id&page=$page";



//���ݿ�
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

//ɾ��
if($_SERVER['REQUEST_METHOD']=='POST'){
	$action=$_POST['action'];
	$state=ToLimitLng($_POST['state'],0,3);
	$ids=$_POST['ids'];

	if($ids==""){
		$db->close();
		Warning("û��ѡ���¼��");
	}	
	if($action=="del"){
		for($i=0;$i<count($ids);$i++){			
			$id=(int)(trim($ids[$i]));
			
			if($id>0){
				//ɾ���ļ�
				$sql="select file_path from files where table_name='advert' and table_id=$id";
				$query=$db->query($sql);
				
				while($arr=mysql_fetch_array($query)){
					
					//ɾ���ļ�����
					$file='../uploadfile/'.$arr['file_path'];
					if(file_exists($file)){
						unlink($file);
					}
				}
				//ִ��ɾ��
				$sql="delete from files where table_name='advert' and table_id=$id";
				$db->query($sql);
				$sql="delete from advert where id=$id";
				$db->query($sql);
			}
				
		}
		
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
				<td class="position">��ǰλ��: �������� -&gt;  ������</td>
			</tr>
		</table>


		<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
			<form name="form1" action="<?php echo $listURL?>" method="post">
			<tr height="30">
		<?php
		//��ҳsql
		$pagesql="select * from advert order by file_order asc";
		
		
		
		$pagestr=$db->page_1($pagesql,$page,$pagesize);

		$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";
		$query=$db->query($pagesql);
		?>

		<input type="hidden" name="action" value="">
				<td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;<a href="<?php echo $editURL?>">[����]</a>&nbsp;<a href="javascript:reverseCheck(document.form1.ids);">[����ѡ��]</a>&nbsp;					
				<a href="javascript:if(delCheck(document.form1.ids)) {document.form1.action.value = 'del';document.form1.submit();}">[ɾ��]</a>&nbsp;</td>
				<td align="right"><?php echo $pagestr;?></td>
			</tr>
	</table>


        <table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
		<form name="form1" action="<?php echo $listURL?>" method="post">
          <tr id="title">
            <td width="0" align="center">ɾ!</td>
            <td width="0" align="center">���</td>

            <td width="0" align="center">����</td>
            <td width="0" align="center">״̬</td>
           <!--<td width="0" align="center">ͼƬ</td>-->
            <td width="-1" align="center">����</td>
            <td width="0" align="center">����</td>
            <td width="0" align="center">��</td>
            <td width="0" align="center">��</td>
          </tr>
		  <?php
		while($arr=$db->fetch_array($query)){
				$id         = $arr['id'];
				$file_name  = $arr['file_name'];
				$file_link 	= $arr['file_link'];
				$file_left 	= $arr['file_left'];
				$file_top 	= $arr['file_top'];
				$file_width = $arr['file_width'];
				$file_height= $arr['file_height'];
				$file_order = $arr['file_order'];
				$file_state = $arr['file_state'];
				
				$files=$db->fetch_array($db->query("select * from files where table_name='advert' and table_id=$id and file_falg='sma'"));
				$files['file_path']==''?$file_path="<a href='uploadfile.php?table_name=advert&table_id={$arr['id']}&file=image&file_falg=sma'>��</a>":$file_path="<a href='uploadfile.php?table_name=advert&table_id={$arr['id']}&file=image&file_falg=sma'>��</a>";

				
		  ?>
          <tr>
            <td width="0" align="center" bgcolor="#FFFFFF"><input type="checkbox" name="ids[]" id="ids" value="<?php echo $arr['id']?>"></td>
            <td width="0" align="center" bgcolor="#FFFFFF"><?php echo $file_order?></td>
            <td width="0" align="center" bgcolor="#FFFFFF"><a href='adver_edit.php?id=<?php echo $id?>'><?php echo $file_name?></a></td>
            
            <td width="0" align="center" bgcolor="#FFFFFF"><?php echo $file_state>0?'��ʾ':'<font color=blue>����ʾ</a>'?></td>
            <!--<td width="0" align="center" bgcolor="#FFFFFF"><?php echo $file_path?></td>-->
            <td width="-1" align="center" bgcolor="#FFFFFF"><?php echo $file_left?></td>
            <td width="0" align="center" bgcolor="#FFFFFF"><?php echo $file_top?></td>
            <td width="0" align="center" bgcolor="#FFFFFF"><?php echo $file_width?></td>
            <td width="0" align="center" bgcolor="#FFFFFF"><?php echo $file_height?></td>
          </tr>
		  
		  
		  <?php
		  }
		  ?>
          <tr class="listFooterTr">
            <td height="20" colspan="24" align="center"><?php echo $pagestr;?></td>
          </tr>
		  </form>
    </table>
	</body>
</html>