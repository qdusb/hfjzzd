<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$id=(int)$_GET['id'];
$page=(int)$_GET['page']<1?1:(int)$_GET['page'];

$listURL="zhiri.php?page=$page";
$editURL="zhiri_edit.php?page=$page";
$pagesize=20;

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

if($id>0){

	$sql="delete from zhiri where id=$id";
	$db->query($sql);
		
	$db->close();
	Redirect($listURL);
}
?>

<html>
	<head>
		<title></title>
		<link href="images/default.css" rel="stylesheet" type="text/css">
		<script language="javascript" src="images/common.js"></script></head>
	<body>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
			<tr class="position"> 
				<td class="position">当前位置: 管理中心 -&gt; 职工信息</td>
			</tr>
		</table>


		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="Main_menu">
			<tr height="30">
				<td>
					<a href="<?php echo $listURL?>">[刷新列表]</a>&nbsp;
					<a href="<?php echo $editURL?>">[增加]</a>&nbsp;
				</td>
				<td width="500" align="right">
				</td>
			</tr>
		</table>


		<table width="100%" border="0" align="center" id="mainTable">
          <tr id="title">
            <td><STRONG>带班领导</STRONG></td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
          <tr id="title">
            <td width="0">值日班次</td>
            <td width="0">值班局长</td>
            <td width="0">当前值日</td>
            <td width="-1">操作</td>
          </tr>
          <?php
		  		$sql="select * from zhiri where ztype=0 order by zid asc";
				$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
				$query=$db->query($sql);
				while($arr=$db->fetch_array($query)){
					$css=$i++%2==0?"listTr":"listAlternatingTr";			
			?>
          <tr class="listAlternatingTr">
            <td width="0"><?=$arr['zid']?></td>
            <td width="0"><?php
					$member = explode(',',$arr['gmember']);
					if($member)
					{
						$s = array();
						foreach($member as $key=>$val)
						{
							$s[] = $db->getField('workers','realname',"id=".intval($val));
						}
						$member = implode('，',$s);
						echo $member;
					}
					?>
            </td>
            <td width="0"><?php if($arr['state']){echo "是";}else{{echo "否";}}?></td>
            <td width="-1"><a href="<?=$editURL?>&id=<?=$arr['id']?>">编辑</a> | <a href="<?=$listURL?>&id=<?=$arr['id']?>" onClick="return del('<?=$arr['realname']?>');">删除</a></td>
          </tr>
          <?php }?>
          
        </table>
	    <br>
	    <table width="100%" border="0" align="center" id="mainTable">
          <tr id="title">
            <td><STRONG>值班大队</STRONG></td>
          </tr>
        </table>
	    <table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
          <tr id="title">
            <td width="0">值日班次</td>
            <td width="0">值班大队</td>
            <td width="-1">子成员值日</td>
            <td width="0">当前值日</td>
            <td width="-1">操作</td>
          </tr>
          <?php
		  		$sql="select * from zhiri where ztype=1 order by zid asc";
				$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
				$query=$db->query($sql);
				while($arr=$db->fetch_array($query)){
					$css=$i++%2==0?"listTr":"listAlternatingTr";			
			?>
          <tr class="listAlternatingTr">
            <td width="0"><?=$arr['zid']?></td>
            <td width="0"><?php
					$member = explode(',',$arr['gmember']);
					if($member)
					{
						$s = array();
						foreach($member as $key=>$val)
						{
							$s[] = $db->getField('workers','realname',"id=".intval($val));
						}
						$member = implode('，',$s);
						echo $member;
					}
					?>
            </td>
            <td width="-1"><?=$arr['intro']?></td>
            <td width="0"><?php if($arr['state']){echo "是";}else{{echo "否";}}?></td>
            <td width="-1"><a href="<?=$editURL?>&id=<?=$arr['id']?>">编辑</a> | <a href="<?=$listURL?>&id=<?=$arr['id']?>" onClick="return del('<?=$arr['realname']?>');">删除</a></td>
          </tr>
          <?php }?>
        </table>
	    <br>
	    <table width="100%" border="0" align="center" id="mainTable">
          <tr id="title">
            <td><STRONG>四大队</STRONG></td>
          </tr>
        </table>
	    <table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
          <tr id="title">
            <td width="0">值日班次</td>
            <td width="0">值班大队</td>
            <td width="0">当前值日</td>
            <td width="-1">操作</td>
          </tr>
          <?php
		  		$sql="select * from zhiri where ztype=3 order by zid asc";
				$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
				$query=$db->query($sql);
				while($arr=$db->fetch_array($query)){
					$css=$i++%2==0?"listTr":"listAlternatingTr";			
			?>
          <tr class="listAlternatingTr">
            <td width="0"><?=$arr['zid']?></td>
            <td width="0"><?php
					$member = explode(',',$arr['gmember']);
					if($member)
					{
						$s = array();
						foreach($member as $key=>$val)
						{
							$s[] = $db->getField('workers','realname',"id=".intval($val));
						}
						$member = implode('，',$s);
						echo $member;
					}
					?>            </td>
            <td width="0"><?php if($arr['state']){echo "是";}else{{echo "否";}}?></td>
            <td width="-1"><a href="<?=$editURL?>&id=<?=$arr['id']?>">编辑</a> | <a href="<?=$listURL?>&id=<?=$arr['id']?>" onClick="return del('<?=$arr['realname']?>');">删除</a></td>
          </tr>
          <?php }?>
        </table>
	    <br>
	    <table width="100%" border="0" align="center" id="mainTable">
          <tr id="title">
            <td><STRONG>六大队</STRONG></td>
          </tr>
        </table>
	    <table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
          <tr id="title">
            <td width="0">值日班次</td>
            <td width="0">值班大队</td>
            <td width="0">当前值日</td>
            <td width="-1">操作</td>
          </tr>
          <?php
		  		$sql="select * from zhiri where ztype=4 order by zid asc";
				$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
				$query=$db->query($sql);
				while($arr=$db->fetch_array($query)){
					$css=$i++%2==0?"listTr":"listAlternatingTr";			
			?>
          <tr class="listAlternatingTr">
            <td width="0"><?=$arr['zid']?></td>
            <td width="0"><?php
					$member = explode(',',$arr['gmember']);
					if($member)
					{
						$s = array();
						foreach($member as $key=>$val)
						{
							$s[] = $db->getField('workers','realname',"id=".intval($val));
						}
						$member = implode('，',$s);
						echo $member;
					}
					?>            </td>
            <td width="0"><?php if($arr['state']){echo "是";}else{{echo "否";}}?></td>
            <td width="-1"><a href="<?=$editURL?>&id=<?=$arr['id']?>">编辑</a> | <a href="<?=$listURL?>&id=<?=$arr['id']?>" onClick="return del('<?=$arr['realname']?>');">删除</a></td>
          </tr>
          <?php }?>
        </table>
	    <br>
	    <table width="100%" border="0" align="center" id="mainTable">
          <tr id="title">
            <td><STRONG>秘书科值班</STRONG></td>
          </tr>
    </table>
	    <table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
          <tr id="title">
            <td width="24%">值日班次</td>
            <td width="24%">姓名</td>
            <td width="24%">当前值日</td>
            <td width="28%">操作</td>
          </tr>
          <?php
		  		$sql="select * from zhiri where ztype=2 order by zid asc";
				$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";
				$query=$db->query($sql);
				while($arr=$db->fetch_array($query)){
					$css=$i++%2==0?"listTr":"listAlternatingTr";			
			?>
          <tr class="listAlternatingTr">
            <td width="24%"><?=$arr['zid']?></td>
            <td width="24%"><?php
					$member = explode(',',$arr['gmember']);
					if($member)
					{
						$s = array();
						foreach($member as $key=>$val)
						{
							$s[] = $db->getField('workers','realname',"id=".intval($val));
						}
						$member = implode('，',$s);
						echo $member;
					}
					?>            </td>
            <td width="24%"><?php if($arr['state']){echo "是";}else{{echo "否";}}?></td>
            <td width="28%"><a href="<?=$editURL?>&id=<?=$arr['id']?>">编辑</a> | <a href="<?=$listURL?>&id=<?=$arr['id']?>" onClick="return del('<?=$arr['realname']?>');">删除</a></td>
          </tr>
          <?php }?>
        </table>
		
		
		
</body>
</html>