<?php
define('IN_EKMENG',true);
define('UploadDir','../uploadfile/');
require_once('isadmin.inc.php');
require_once('common.inc.php');
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$big_id=intval($_GET['big_id']);
$sec_id=intval($_GET['sec_id']);
$third_id=intval($_GET['third_id']);
$page=intval($_GET['page'])<1?1:intval($_GET['page']);
$pagesize=15;
$baseURL	="webnews_dr.php";
$listURL	="webnews_dr.php?big_id=$big_id&sec_id=$sec_id&third_id=$third_id&page=$page";

//���ݿ�
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


if($_SERVER['REQUEST_METHOD']=='POST' and $_POST['move']==1){
	$action=$_POST['action'];
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
				if($db->getCount("info", "*", "id=".$id)!=1){
					$db->close();
					Warning("�Ƿ�������");
				}
				
				
				//ִ��ɾ��
				$sql="delete from info where id=".$id;
				$db->query($sql);
				//$db->close();

			}
				
		}
				Redirect($listURL);		

	}else{
	$transfer_base_id	=	intval($_POST['transfer_base_id']);
	$transfer_second_id	=	intval($_POST['transfer_second_id']);
	$transfer_third_id	=	intval($_POST['transfer_third_id']);
	
	for($i=0;$i<count($ids);$i++){
		$id=(int)(trim($ids[$i]));
		if($id>0){
			$sql="update info set big_id=$transfer_base_id,sec_id=$transfer_second_id,third_id=$transfer_third_id where id=$id";				
			$db->query($sql);
		}
	}
	$db->close();
	Redirect($listURL);		
	
	}
	
		
}





if($_SERVER['REQUEST_METHOD']=='POST' and $_POST['upload']==1)
{
	$sql_file = 'dumpsql/upload.sql';
	/* ���ļ��ƶ�����ʱĿ¼������Ȩ������ */
        @unlink($sql_file);
        if (!move_uploaded_file($_FILES["uploadfile"]['tmp_name'] , $sql_file ))
        {
            echo "upload file error!";
        }
		$sql = explode(";\r\n", file_get_contents($sql_file));
		if($sql)
		{
			foreach($sql as $key => $val)
			{
				if(!empty($val))
				{
					$db->query($val);
				}
			}
		}

	Redirect($baseURL);


}
?>

<html>
	<head>
		<title>�ļ��ϴ�</title>
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
		
		<script language="javascript">
			function transfer()
			{
				var form = document.form1;
				var obj = form.ids;
				var hasChecked = false;

				if (form.transfer_base_id.options[form.transfer_base_id.selectedIndex].value == "0")
				{
					alert("��ѡ��һ����Ŀ��");
					form.transfer_base_id.focus();
					return false;
				}
				if (form.transfer_second_id.options[form.transfer_second_id.selectedIndex].value == "0")
				{
					alert("��ѡ�������Ŀ��");
					form.transfer_second_id.focus();
					return false;
				}
				if (form.transfer_third_id.options.length > 1 && form.transfer_third_id.options[form.transfer_third_id.selectedIndex].value == "0")
				{
					alert("��ѡ��������Ŀ��");
					form.transfer_third_id.focus();
					return false;
				}


				if (!obj)
				{
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
					alert('����ѡ��׼��ת�Ƶļ�¼');
					return false;
				}
				else
				{
					if (confirm('����ת������ѡ��ļ�¼, �Ƿ���� ?'))
					{
						form.submit();
					}
					else
					{
						return false;
					}
				}
			}


			function transferBaseIdChange()
			{
				var i;
				
				var transfer_base_id = document.form1.transfer_base_id;
				var transfer_second_id = document.form1.transfer_second_id;
				var transfer_third_id = document.form1.transfer_third_id;

				var base_id = transfer_base_id.options[transfer_base_id.selectedIndex].value;

				transfer_second_id.options.length = 0;
				transfer_second_id.options[0] = new Option("������Ŀ", "0");

				for (i = 0; i < secondClass.length; i++)
				{
					if (secondClass[i][3] == base_id)
					{
						transfer_second_id.options[transfer_second_id.options.length] = new Option(secondClass[i][1], secondClass[i][0]);
					}
				}

				transfer_third_id.style.display = "none";
			}

			function transferSecondIdChange()
			{
				var i, second_state;
				
				var transfer_second_id = document.form1.transfer_second_id;
				var transfer_third_id = document.form1.transfer_third_id;

				var second_id = transfer_second_id.options[transfer_second_id.selectedIndex].value;

				if (second_id > 0)
				{
					for (i = 0; i < secondClass.length; i++)
					{
						if (secondClass[i][0] == second_id)
						{
							second_state = secondClass[i][2];
							break;
						}
					}

					if (second_state == "YES")
					{
						transfer_third_id.style.display = "block";
						
						transfer_third_id.options.length = 0;
						transfer_third_id.options[0] = new Option("������Ŀ", "0");

						for (i = 0; i < thirdClass.length; i++)
						{
							if (thirdClass[i][2] == second_id)
							{
								transfer_third_id.options[transfer_third_id.options.length] = new Option(thirdClass[i][1], thirdClass[i][0]);
							}
						}
					}
					else
					{
						transfer_third_id.style.display = "none";
					}
				}
				else
				{
					transfer_third_id.style.display = "none";
				}
			}
		</script>	
	</head>

	<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">��ǰλ��: ��������  -&gt; ���ݵ���</td>
			</tr>
	</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="formup" action="" method="post" enctype="multipart/form-data" onSubmit="return check(this);">
				
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">�ļ��ϴ�</td>
				</tr>

				<tr class="editTr">
					<td width="13%" class="editLeftTd">ѡ���ļ�</td>
				  <td width="87%" class="editRightTd"><input type="file" name="uploadfile" size="40">
				    <input name="upload" type="hidden" id="upload" value="1"></td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
				    <td class="editFooterTd"><input name="submit" type="submit" value=" �� �� " class="submit">
                      <input name="button" type="button" onClick="history.back();" value="  �� �� " class="submit"></td>
				</tr>
			</form>
		</table>
		
		<form name="form1" action="<?php echo $listURL?>" method="post">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
				<input type="hidden" name="action" value="">

			<tr height="30">
			  <td>
					<a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;<a href="javascript:if(delCheck(document.form1.ids)) {document.form1.action.value = 'del';document.form1.submit();}">[ɾ��]</a>&nbsp;<a href="javascript:reverseCheck(document.form1.ids);">[����ѡ��]</a>&nbsp;
					<input type="button" value="ת�Ƶ�" onClick="transfer()">
					
					<select name="transfer_base_id" onChange="transferBaseIdChange()">
                        <option value="0" style="width:80px">һ����Ŀ</option>
                        <?php
						$sql = "select id, typename from big_class order by shownum asc";
						$query=$db->query($sql);
						while($arr=mysql_fetch_array($query)){
						?>
                        <option value="<?php echo $arr['id']?>"><?php echo $arr['typename']?></option>
                        <?php
						}
						?>
                    </select>
					<select name="transfer_second_id" onChange="transferSecondIdChange()">
                        <option value="0" style="width:80px">������Ŀ</option>
                    </select>
					<select name="transfer_third_id" style="display:none;width:80px">
                        <option value="0">������Ŀ</option>
            	  </select>
			  
              <script language="javascript">
						var secondClass = new Array();
						var thirdClass = new Array();
						<?php
						$i=-1;
						$sql = "select id, big_id, sec_name, third_state from sec_class order by big_id asc, shownum asc";
						$query=$db->query($sql);
						while($arr=mysql_fetch_array($query)){
						$i++;
						?>
							secondClass[<?php echo $i?>] = new Array(<?php echo $arr['id']?>, "<?php echo $arr['sec_name']?>", "<?php echo $arr['third_state']?>", <?php echo $arr['big_id']?>);
						<?php
						}
						?>

						<?php
						$i = -1;
						$sql = "select id, sec_id, third_name from third_class order by sec_id asc, shownum asc";
						$query=$db->query($sql);
						while($arr=mysql_fetch_array($query)){
						$i++;
						?>
							thirdClass[<?php echo $i?>] = new Array(<?php echo $arr['id']?>, "<?php echo $arr['third_name']?>", <?php echo $arr['sec_id']?>);
						<?php
						}
						?>
					    </script>
              <input name="move" type="hidden" id="move" value="1"></td>

		      <td>&nbsp;</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
			  <td width="5%" align="center"></td>
				<td width="6%" align="center"><strong>���</strong></td>
				<td width="52%" align="left"><strong>����</strong></td>
			    <td width="13%" align="left"><strong>����</strong></td>
			    <td width="12%" align="left">����</td>
			    <td width="6%" align="left">�ȵ�</td>
			    <td width="6%" align="center">״̬</td>
			</tr>
			<?php 			
			
			//��ҳsql
			$pagesql="select id,shownum,title,state,adduser,publishdate,hot,shenhe,gx from info where big_id in(1,2,3,4,5,6,7,12,13) and gx=1 order by state desc,shownum desc";
			
			$query=$db->query($pagesql);
			$pagestr=$db->page_1($pagesql,$page,$pagesize);
			$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";

			while($arr=mysql_fetch_array($query)){
			?>			
				<tr >
					<td width="5%" align="center">
				  <input type="checkbox" name="ids[]" id="ids" value="<?php echo $arr['id']?>"></td>
					<td width="6%" align="center"><?php echo $arr['id']?></td>
					<td width="52%" align="left"><?php echo $arr['title']?></td>
					<td width="13%" align="left"><?php echo $arr['adduser']?></td>
					<td width="12%" align="left"><?php echo $arr['publishdate']?></td>
					<td width="6%" align="left"><?php echo $arr['hot']>0?"<font color='#FF6600'>��</font>":"��"?></td>
					<td width="6%" align="center">
					<?php
					switch($arr['state']){
						case	0:	echo "<font color='#0066FF'>����ʾ</font>";	break;
						case	1:	echo "����";	break;
						case	2:	echo "<font color='#FF9900'>�ö�</font>";	break;
						case	3:	echo "<font color='#FF3300'>���ö�</font>";	break;
						case	4:	echo "<font color='#FF3300'>ͷ��</font>";	break;
						default  :	echo "<font color='#FF0000'>����</font>";	break;
					}
					?>
					</td>
				</tr>
			<?php }?>
				
			

			<tr>
				<td colspan="22" align="center"><?php echo $pagestr;?></td>
		    </tr>
		</table>
</form>		
		</body>
</html>