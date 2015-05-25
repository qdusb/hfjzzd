<?php
define('IN_EKMENG',true);
require_once('isadmin.inc.php');
require_once('common.inc.php');

$user_id=(int)$_GET['user_id'];


$listURL	= "userinfo_list.php";
$editURL	= "userinfo_edit.php";

$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);


//删除
if($id>0){
	//检查当前准备删除的分类,是否属于当前一级分类
	if($db->getCount('userinfo',"*","user_id=$user_id")!=1){
		$db->close();
		Warning("非法操作！");
	}

	//删除相关联的文件与图片

	//
	$sql="delete from userinfo where user_id=$user_id";
	if($db->query($sql)){
		$db->close();
		Redirect($listURL);
	}else{
		Warning("删除记录失败！");
	}

}



list($width_orig, $height_orig) = getimagesize($uploadfile);
// if ($width_orig!=61||$height_orig!=61) {
// $image_p = imagecreatetruecolor(61, 61);
// if($piece[1]=="jpg"||$piece[1]=="jpeg"){
// $image = imagecreatefromjpeg($uploadfile);
// imagecopyresampled($image_p, $image, 0, 0, 0, 0, 61, 61, $width_orig, $height_orig);
// imagejpeg($image_p,$uploadfile);
// }else if($piece[1]=="gif"){
// $image = imagecreatefromgif($uploadfile);
// imagecopyresampled($image_p, $image, 0, 0, 0, 0, 61, 61, $width_orig, $height_orig);
// imagegif($image_p,$uploadfile);
// }
// }
return basename($uploadfile);
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

			
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" id="mainTable">
			<tr id="title">
				<td>序号</td>
				<td>分类名称</td>
				<td>三级分类</td>
				<td>记录状态</td>
				<?php
				if($big_sec_pic){
				?>
				<td>图片</td>
				<?php
				}
				?>
				
				<td>删除</td>
			</tr>

			<?php
			$sql = "select id, shownum, sec_name, third_state, info_state, pic from sec_class where big_id=$big_id order by shownum asc";
			$query=$db->query($sql);
			while($arr=mysql_fetch_array($query)){
				$i++;
				$css=$i%2==0?"listAlternatingTr":"listTr";
			?>
				<tr class="<?php echo $css;?>">
					<td><?php echo $arr['shownum'];?></td>
					<td><a href="<?php echo $editURL."&id=".$arr['id'];?>"><?php echo $arr['sec_name']?></a></td>
					<td>
						<?php
							if($arr['third_state']=="NO"){
								echo "无";
							}else{
								$third_sum=$db->getCount("third_class","*","sec_id=".$arr['id']." and big_id=$big_id");
								if($third_sum){
									echo '<a href="third_class_list.php?big_id='.$big_id.'&sec_id='.$arr['id'].'"><font color="#FF0000">有['.$third_sum.']</font></a>';
								}else{
									echo '<a href="third_class_list.php?big_id='.$big_id.'&sec_id='.$arr['id'].'"><font color="#FF0000">无</font></a>';
								}
								
							}						
													
						?>
					</td>
					<td>
						<?php				
							switch($arr['info_state']){
								case "list"		:	echo "列表";break;
								case "pic"		:	echo "图片列表";break;
								case "content"	:	echo "单一内容";break;
								Default			:	echo "<font color='#FF0000'>错误</font>";break;
							}								
						?>
					</td>
					<?php
					if($big_sec_pic){
					?>
					<td>
							有[3]
							无
							</a>
				  </td>
					<?php
					}
					?>
					<td><a href="<?php echo $listURL."&id=".$arr['id']?>" onClick="return del('<?php echo $arr['sec_name']?>');">删除</a></td>
				</tr>
			<?php
			}?>			

			<tr class="listFooterTr">
				<td colspan="10"></td>
			</tr>
		</table>

	</body>
</html>