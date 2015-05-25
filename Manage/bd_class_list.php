<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];


$listURL	= "bd_class_list.php";
$editURL	= "bd_class_list.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$name = $_POST['out_name'];
	if($name)
	{
		foreach($name as $key => $val)
		{
			$sql = "update sec_class set out_name = ".intval($val)." where id=$key";
			$db->query($sql);
		}
		Redirect($editURL);
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
	</head>

	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; <?php echo $big_typename?> -&gt; 二级分类</td>
		    </tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[刷新列表]</a>&nbsp;
					<a href="<?php echo $editURL?>">[增加]</a>&nbsp;
				</td>
			</tr>
	</table>

			
        <form name="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
            <tr id="title">
              <td width="13%">序号</td>
              <td width="20%">分类名称</td>
              <td width="67%">绑定外网栏目</td>
            </tr>
            <?php
			
			$sql_b = "select id,shownum,typename from big_class where id in(1,2,3,4,5,6,7,12,13) order by shownum asc";
			$query_b=$db->query($sql_b);
			while($arr_b=mysql_fetch_array($query_b)){
			
			?>
            <tr>
              <td bgcolor="#BBDDE5"><strong><?php echo $arr_b['shownum'];?></strong></td>
              <td bgcolor="#BBDDE5"><strong><?php echo $arr_b['typename'];?></strong></td>
              <td bgcolor="#BBDDE5">&nbsp;</td>
            </tr>
            <?php
			$sql = "select id, shownum, sec_name,out_name, third_state, info_state, pic from sec_class where big_id=".$arr_b['id']." order by shownum asc";
			$query=$db->query($sql);
			while($arr=mysql_fetch_array($query)){
				$i++;
				$css=$i%2==0?"listAlternatingTr":"listTr";
			?>
            <tr>
              <td style="padding-left:30px"><?php echo $arr['shownum'];?></td>
              <td style="padding-left:30px"><?php echo $arr['sec_name']?></td>
              <td><input name="out_name[<?php echo $arr['id']?>]" type="text" id="out_name" value="<?php echo $arr['out_name']?>"></td>
            </tr>
            <?php
			}
			
			}
			?>
            <tr class="listFooterTr">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><input type="submit" name="Submit" value="提交" class="submit"></td>
            </tr>
          </table>
    </form>
</body>
</html>