<?php
ini_set('date.timezone','America'); 

define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id']<0?0:(int)$_GET['id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];

$listURL="zhiri.php?page=$page";
$editURL="zhiri_edit.php?page=$page&id=$id";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SERVER['REQUEST_METHOD']=='POST'){
	$zid			=	intval($_POST['zid']);
	$ztype			=	intval($_POST['ztype']);
	$intro			=	$_POST['intro'];
	$gmember		=	@implode(',',$_POST['gmember']);
	$state			=	intval($_POST['state']);

	if($id>0){
		if($state)
		{
			$gdate = mktime(23,59,59,date('m',time()),date('d',time()),date('Y',time()));
			$sql = "update zhiri set state=0 where ztype=$ztype";
			$db->query($sql);
		}
		else
		{
			$gdate = 0;
		}
		
		$sql="update zhiri set zid=$zid,ztype=$ztype,gmember='$gmember',intro='$intro',state=$state,gdate=$gdate where id=$id";
	}else{
		if($state)
		{
			$gdate = mktime(23,59,59,date('m',time()),date('d',time()),date('Y',time()));
			$sql = "update zhiri set state=0 where ztype=$ztype";
			$db->query($sql);
		}
		else
		{
			$gdate = 0;
		}
		
		$sql="insert into zhiri(zid,ztype,gmember,state,gdate,intro) values($zid,$ztype,'$gmember',$state,$gdate,'$intro')";
	}
	$db->query($sql);
	$db->close();
	Redirect($listURL);
	
}else{
	if($id>0){
		$sql="select * from zhiri where id=$id";
		if($arr=$db->fetch_array($db->query($sql))){
			$zid=$arr['zid'];
			$ztype=$arr['ztype'];
			$gmember=@explode(',',$arr['gmember']);
			$state=$arr['state'];
			$intro=$arr['intro'];
		}else{
			$db->close();
			Warning("指定的记录号不存在！");
		}
	}else{
		$zid = 0;
		$ztype = 0;
		$state		= 0;
	}
}
?>

<html>
	<head>
		<title></title>
		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script>

		<script language="javascript">
			function check(form)
			{
				if (form.title.value == "")
				{
					alert("职位名称不能为空！");
					form.title.focus();
					return false;
				}

				return true;
			}
		</script>
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; 警员信息</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="zhiri.php?page=1">[返回列表]</a>&nbsp;				</td>
			</tr>
	</table>


		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="" method="post" onSubmit="return check(this);">
			
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">警员信息</td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">当前班次</td>
					<td class="editRightTd"><input name="zid" type="text" id="zid" size="8" maxlength="2" value="<?=$zid?>"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">值日类型</td>
				  <td class="editRightTd">
				  <select name="ztype" id="ztype">
					  <option value="0">带班领导</option>
					  <option value="3">四大队</option>
					  <option value="4">六大队</option>
					  <option value="1">值班大队</option>
					  <option value="2">秘书科值班</option>
				    </select>				  </td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">值日警员</td>
					<td class="editRightTd">
					<?php
					$sql = "select id,realname from workers";
					$query=$db->query($sql);
					while($arr=$db->fetch_array($query)){
					$zhiri_i++;
						if(@in_array($arr['id'],$gmember))
						{
							echo "<input name=gmember[] type=checkbox id=gmember[] value=$arr[id] checked> $arr[realname]";
						}
						else
						{
							echo "<input name=gmember[] type=checkbox id=gmember[] value=$arr[id]> $arr[realname]";
						}
					echo ($zhiri_i%9==0)?"<BR>":"";
					}
					
					?>					</td>
				</tr>
				<tr class="editTr">
				  <td class="editLeftTd">子成员值日</td>
				  <td class="editRightTd"><input name="intro" type="text" id="intro" size="40" value="<?=$intro?>"></td>
			  </tr>
				<tr class="editTr">
					<td class="editLeftTd">当前值日</td>
					<td class="editRightTd"><input type="radio" name="state" value="0" <?php echo $state==0?"checked":"";?>>
				    否
				      <input type="radio" name="state" value="1" <?php echo $state==1?"checked":"";?>>
				    是</td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd" colSpan="2">
						<input type="submit" value=" 确 定 ">
						<input type="reset" value=" 重 填 ">					</td>
				</tr>
			</form>
		</table>

		<script language="javascript">
			document.form1.zid.focus();
			document.form1.ztype.value = <?=$ztype?>
		</script>

	</body>
</html>