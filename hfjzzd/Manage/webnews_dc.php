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
$pagesize=100;
$baseURL	="webnews_dc.php";
$listURL	="webnews_dc.php?page=$page";

//���ݿ�
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);




if($_SERVER['REQUEST_METHOD']=='POST' and $_POST['action']=="data_dump")
{


	$ids=$_POST['ids'];
	
	if($_REQUEST['ids'])
	{			
			$filename = 'dumpsql/'.date('YmdHis').'.sql';
			foreach($_REQUEST['ids'] as $key => $val)
			{
				$sql = "select title,content,big_id,sec_id, website, adduser, state,publishdate, hot,shuser,dept_id from info where id=$val";
				$arr=$db->fetch_array($db->query($sql));
				$sec_id_info=$db->GetField("sec_class","out_name","id=".$arr['sec_id']);
				$big_id=substr($sec_id_info,-3);
				$sec_id=$sec_id_info;
				$dumpsql = "insert into info(title,content,big_id, sec_id, website, adduser, state,publishdate, hot,shuser,dept_id) values('".implode('\', \'', $arr)."');\r\n";
				//error_log($dumpsql, 3, $filename);
				echo $dumpsql."<br>";
				
			}
		}
		//header("location: $filename\n");
		exit;
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


		<form name="form1" action="<?php echo $listURL?>" method="post">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
				<input type="hidden" name="action" value="">

			<tr height="30">
			  <td width="85%">
			  <a href="<?php echo $listURL?>">[ˢ���б�]</a>&nbsp;<a href="javascript:reverseCheck(document.form1.ids);">[����ѡ��]</a>&nbsp;</td>

		      <td width="15%" align="center"><input type="button" name="Submit2" class="submit" value="��������" onClick="document.form1.action.value = 'data_dump';document.form1.submit();"></td>
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
			$pagesql="select id,shownum,title,state,adduser,publishdate,hot,shenhe from info where big_id in(1,2,3,4,5,6,7,12,13) and gx=1 order by state desc,shownum desc";
			
			$query=$db->query($pagesql);
			$pagestr=$db->page_1($pagesql,$page,$pagesize);
			$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";

			while($arr=mysql_fetch_array($query)){
			?>			
				<tr >
					<td width="5%" align="center">
				  <input type="checkbox" name="ids[]" id="ids" value="<?php echo $arr['id']?>"></td>
					<td width="6%" align="center"><?php echo $arr['shownum']?></td>
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
					?>					</td>
				</tr>
			<?php }?>
				
			

			<tr>
				<td colspan="22" align="center"><?php echo $pagestr;?></td>
		    </tr>
		</table>
</form>		
		</body>
</html>