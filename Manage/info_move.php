<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$big_id=intval($_GET['big_id']);
$sec_id=intval($_GET['sec_id']);
$third_id=intval($_GET['third_id']);
$page=intval($_GET['page'])<1?1:intval($_GET['page']);
$pagesize=15;
$baseURL	="info_move.php";
$listURL	="info_move.php?big_id=$big_id&sec_id=$sec_id&third_id=$third_id&page=$page";

//数据库
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


if($sec_id>0){
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
}
if($_SERVER['REQUEST_METHOD']=='POST'){
	$ids=$_POST['ids'];
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
		
		<script language="javascript">
			function transfer()
			{
				var form = document.form1;
				var obj = form.ids;
				var hasChecked = false;

				if (form.transfer_base_id.options[form.transfer_base_id.selectedIndex].value == "0")
				{
					alert("请选择一级栏目！");
					form.transfer_base_id.focus();
					return false;
				}
				if (form.transfer_second_id.options[form.transfer_second_id.selectedIndex].value == "0")
				{
					alert("请选择二级栏目！");
					form.transfer_second_id.focus();
					return false;
				}
				if (form.transfer_third_id.options.length > 1 && form.transfer_third_id.options[form.transfer_third_id.selectedIndex].value == "0")
				{
					alert("请选择三级栏目！");
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
					alert('请先选择准备转移的记录');
					return false;
				}
				else
				{
					if (confirm('即将转移所有选择的记录, 是否继续 ?'))
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
				transfer_second_id.options[0] = new Option("二级栏目", "0");

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
						transfer_third_id.options[0] = new Option("三级栏目", "0");

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
				<td class="position">当前位置: 管理中心 -&gt; 信息转移</td>
			</tr>
		</table>

		<form name="form1" action="<?php echo $listURL?>" method="post">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
				<input type="hidden" name="action" value="">

			<tr height="30">
			  <td>
					<a href="<?php echo $listURL?>">[刷新列表]</a>&nbsp;<a href="javascript:reverseCheck(document.form1.ids);">[反向选择]</a>&nbsp;
					<select name="big_id" onChange="window.location='<?php echo $baseURL?>?big_id='+this.options[this.selectedIndex].value;" style="width:80px">
					<option value="0">一级栏目</option>
					<?php
					$sql="select id,typename from big_class order by shownum asc";
					$query=$db->query($sql);
					while($arr=mysql_fetch_array($query)){
					?>
					<option value="<?php echo $arr['id']?>" <?php echo $big_id==$arr['id']?"selected":""?>><?php echo $arr['typename']?></option>
					<?php }?>
					</select>
						
					<select name="sec_id" onChange="window.location='<?php echo $baseURL?>?big_id=<?php echo $big_id?>&sec_id='+this.options[this.selectedIndex].value;" style="width:80px">
						<option value="0">二级栏目</option>
						<?php
							$sql="select id,sec_name from sec_class where big_id=$big_id order by shownum asc";
							$query=$db->query($sql);
							while($arr=mysql_fetch_array($query)){
						?>
								<option value="<?php echo $arr['id']?>" <?php echo $sec_id==$arr['id']?"selected":""?>><?php echo $arr['sec_name']?></option>
							<?php }?>
					</select>
					
					
					
					<?php
					//三级分类
					if($sec_id>0 and $sec_third_state=="YES"){
						
					?>
						<select name="third_id" onChange="window.location='<?php echo $baseURL?>?big_id=<?php echo $big_id?>&sec_id=<?php echo $sec_id?>&third_id='+this.options[this.selectedIndex].value;" style="width:80px">
						<option value="0">三级栏目</option>
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
					

			  	    <input type="button" value="转移到" onClick="transfer()">
					
					<select name="transfer_base_id" onChange="transferBaseIdChange()">
                        <option value="0" style="width:80px">一级栏目</option>
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
                        <option value="0" style="width:80px">二级栏目</option>
                    </select>
					<select name="transfer_third_id" style="display:none;width:80px">
                        <option value="0">三级栏目</option>
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
					    </script></td>

		      <td>&nbsp;</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td width="8%" align="center"><input name="sh" type="hidden" id="sh"></td>
				<td width="7%" align="center"><strong>序号</strong></td>
				<td width="76%" align="left"><strong>标题</strong></td>
	
			    <td width="9%" align="center">状态</td>
			</tr>
			<?php 			
			
			//分页sql
			$pagesql="select id,shownum,title,state from info where state>0";
					
				
			if($big_id>0){
						$pagesql.=" and big_id=$big_id";		
			}
					
			if($sec_id>0){
				$pagesql.=" and sec_id=$sec_id";
			}
			
			if($third_id>0){
				$pagesql.=" and third_id=$third_id";
			}
			$pagesql.=" order by state desc,shownum desc";
			
			$pagesql.=" limit ".(($page-1)*$pagesize).",$pagesize";
			$query=$db->query($pagesql);
			$pagestr=$db->page_1($pagesql,$page,$pagesize);
			while($arr=mysql_fetch_array($query)){
			?>			
				<tr >
					<td width="8%" align="center">
					<input type="checkbox" name="ids[]" id="ids" value="<?php echo $arr['id']?>"></td>
					<td width="7%" align="center"><?php echo $arr['shownum']?></td>
					<td width="76%" align="left"><?php echo $arr['title']?></td>
					<td width="9%" align="center">
					<?php
					switch($arr['state']){
					case	0:	echo "<font color='#0066FF'>不显示</font>";	break;
					case	1:	echo "正常";	break;
					case	2:	echo "<font color='#FF9900'>置顶</font>";	break;
					case	3:	echo "<font color='#FF3300'>总置顶</font>";	break;
					default  :	echo "<font color='#FF0000'>错误</font>";	break;
					}
					?>					</td>

					   
				</tr>
			<?php }?>
				
			

			<tr>
				<td colspan="18" align="center"><?php echo $pagestr;?></td>
		    </tr>
		</table>
</form>
	</body>
</html>