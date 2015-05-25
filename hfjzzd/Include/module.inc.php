<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
//新闻内容显示
/*param:
big_id		最大类ID号
sec_id		二级分类ID号
state		显示状态,为True时显示为列表,为False时如只有一条显示内容,如多条显示列表;
length		显示字数,为True时显示简要说明,如False时显示全部
*/

//显示内容
function show_content($big_id,$sec_id,$third_id=0,$length=0){
	global $db;
	if($sec_id){
		if($third_id){
		$sql="select id,big_id,sec_id,third_id,content,intro from info where big_id=$big_id and sec_id=$sec_id and third_id=$third_id";
		}else{
		$sql="select id,big_id,sec_id,third_id,content,intro from info where big_id=$big_id and sec_id=$sec_id";
		}	
	}else{
		$sql="select id,big_id,sec_id,third_id,content,intro from info where big_id=$big_id";
	}
	
	echo $sql;
	$query=$db->query($sql);
	$arr=$db->fetch_array($query);
	if($length){
		return  $arr['intro'];
	}else{
		return $arr['content'];
	}

}

function show_list($big_id,$sec_id,$third_id=0,$rs_num=8,$substr=22,$date=1){
	global $db;
	if($sec_id){
		
		if($third_id){
		$sql="select id,big_id,sec_id,hot,third_id,title,create_time,content from info where big_id=$big_id and sec_id=$sec_id and third_id=$third_id and state>0 order by state desc,shownum desc limit 0,$rs_num";
		}else{
		$sql="select id,big_id,sec_id,third_id,hot,title,create_time,content from info where big_id=$big_id and sec_id=$sec_id and state>0 order by state desc,shownum desc limit 0,$rs_num";
		}
	
	}else{
		$sql="select id,big_id,sec_id,third_id,hot,title,create_time,content from info where big_id=$big_id and state>0 order by state desc,shownum desc limit 0,$rs_num";
	}
	
	$query=$db->query($sql);
	?>
	<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
	<?
	while($arr=$db->fetch_array($query)){
	?>	
	  <tr height=22>
		<td>
		·<a href="news_show.php?id=<?php echo $arr['id']?>" ><?php echo cnsubstr($arr['title'],$substr)?></a></td>
	    <td width="25%" align="center">
		<?php 
		if($arr['hot']==1){
			echo "<img src='Include/images/hot.gif' width='28' height='11' align='absmiddle'>";
		}else if($arr['hot']==0){
			
			if($date) echo "[".date('Y-m-d',$arr['create_time'])."]";
		
		}
		?>
		
		</td>
	  </tr>	  
	<?php }?>
	</table>
	<?		
}
//显示图片列表
function show_pic($big_id,$sec_id,$third_id=0,$rs_num=8,$cols=4,$width=100,$height=100,$url='#',$substr=14,$type=0){
	global $db;
	if($sec_id){
		if($third_id){
			$sql="select id,big_id,sec_id,third_id,title,file_path from info,files where big_id=$big_id and sec_id=$sec_id and third_id=$third_id and info.id=files.table_id and files.table_name='info' and state>0 order by state desc,shownum desc limit 0,$rs_num";
		}else{
			$sql="select id,big_id,sec_id,third_id,title,file_path from info,files where big_id=$big_id and sec_id=$sec_id and info.id=files.table_id and files.table_name='info' and state>0 order by state desc,shownum desc limit 0,$rs_num";
		}
	}else{
		$sql="select id,big_id,sec_id,third_id,title,file_path from info,files where big_id=$big_id and info.id=files.table_id and files.table_name='info' and state>0 order by state desc,shownum desc limit 0,$rs_num";
	}
	$query=$db->query($sql);
	$row=$rs_num%$cols==0?(int)($rs_num/$cols):(int)($rs_num/$cols)+1;
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">	
	<?php
	for($r=0;$r<$row;$r++){
	?>	
      <tr>
		 <?php
		for($c=0;$c<$cols;$c++){
		?>	  
        <td align="center">
		<?php if($arr=$db->fetch_array($query)){?>
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" style="padding:8px;"><a href="<?php echo $url?>?id=<?php echo $arr['id']?>"><img src="./UpLoadFile/<?php echo $arr['file_path'] ?>" width="<?php echo $width ?>" height="<?php echo $height ?>" border="0" /></a></td>
		  </tr>
		  
		  <?php if($type){?>
		  <tr>
			<td height="25" align="center"><a href="<?php echo $url?>?id=<?php echo $arr['id']?>"><?php echo cnsubstr($arr['title'],$substr) ?></a></td>
		  </tr>
		  <?php }?>
		  
		  
		</table>
		 <?php }?>
	    </td>	
		<?php }?>
      </tr>
	  <?php }?>
    </table>
<?
}
?>
<?php
//广告管理
//调用：advert(0)
//0,1,2,3,4,5,6
function advert($ay=0){
global $db;
$query=$db->query($sql="select * from advert where file_state>0 order by file_order asc");
while($arr=$db->fetch_array($query)){
$files=$db->fetch_array($db->query("select * from files where table_name='advert' and table_id={$arr['id']} and file_falg='sma'"));
$arr['file_type']=='flash'?$array[]="<embed src='UpLoadFile/".$files['file_path']."' width=".$arr['file_width']." height=".$arr['file_height']." quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'>":$array[]="<a href='".$arr['file_link']."' target='_blank'><img src='UpLoadFile/".$files['file_path']."' width=".$arr['file_width']." height=".$arr['file_height']." border=0 /></a>";
}
echo  str_replace("'","\"",$array[$ay]);
}
//类别
//调用：SmallClass(1,'product.php')
function SmallClass($big_id,$Reurl='Public.php'){
echo <<<EOT
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
EOT;
global $db;
$sql="select * from sec_class where big_id=".(int)$big_id." order by shownum asc";
$sec_class=$db->query($sql);
while($sec=$db->fetch_array($sec_class)){
echo <<<EOT
	<tr>
		<td width="34%" align="right" height="20"><font face="wingdings">1</font></td>
		<td width="66%" height="20" ><a href="{$Reurl}?sec_id={$sec['id']}"><strong>{$sec['sec_name']}</strong></a></td>
 	</tr>
EOT;
$sql="select * from third_class where big_id=$big_id and sec_id=".$sec['id']." order by shownum asc";
$third_class=$db->query($sql);
while($third=$db->fetch_array($third_class)){
echo <<<EOT
 	<tr>
 		<td height="24">&nbsp;&nbsp;&nbsp;</td>
 		<td  height="24"> <font face="wingdings">l</font>&nbsp;<a href="{$Reurl}?sec_id={$sec['id']}&third_id={$third['id']}">{$third['third_name']}</a></td>
	</tr>
EOT;
} }
echo "</table>";
}
//图片轮换
/*
$bigid==大类ID
$sec_id==小类ID相当于5001
$third_id(默认为0)
$width,$height(图高和宽)

调用：
image_cut(5,5002,0,545,250,0)
*/
function image_cut($big_id,$top=5,$sec_id=0,$third_id=0,$width=110,$height=110,$text_height=23){
		global $db;
		if($sec_id)
		{
			$sql="select id,big_id,sec_id,website,title,file_path from info,files where big_id=$big_id and info.id=files.table_id and files.table_name='info' and sec_id=$sec_id and state>0 order by state desc,shownum desc limit 0,$top";
		}
		else
		{
			$sql="select id,big_id,sec_id,website,title,file_path from info,files where big_id=$big_id and info.id=files.table_id and files.table_name='info' and state>0 order by state desc,shownum desc limit 0,$top";
		}
	$query=$db->query($sql);
	while($arr=$db->fetch_array($query)){
		$path.="uploadfile/".$arr['file_path']."|";
		$title.=$arr['title']."|";
		$like.="display.php?id="&$arr['id']."|"; 
		
	}
 ?>	
<SCRIPT type=text/javascript>
	var focus_width=<?php echo $width?>;
	var focus_height=<?php echo $height?>;
	var text_height=<?php echo $text_height?>;
	var swf_height = focus_height+text_height
	var pics='<?php echo substr($path,0,strlen($path)-1)?>';		//图片
	var links='<?php echo substr($like,0,strlen($like)-1)?>' ;		//链接
	var texts='<?php echo substr($title,0,strlen($title)-1)?>';	//标题
	document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'+ focus_width +'" height="'+ swf_height +'">');
	document.write('<param name="allowScriptAccess" value="sameDomain"><param name="movie" value="./Include/images/pixviewer.swf"><param name="quality" value="high"><param name="bgcolor" value="#DADADA">');
	document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
	document.write('<param name="FlashVars" value="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'">');
	document.write('<embed src="./Include/images/pixviewer.swf" wmode="opaque" FlashVars="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'" menu="false" bgcolor="#DADADA" quality="high" width="'+ focus_width +'" height="'+ focus_height +'" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
	document.write('</object>');
	//-->
</SCRIPT>
<?php
}
/*
友情链接
*/
function website($big_id,$sec_id,$third_id=0,$width=87,$height=31,$br=10,$type='image'){
	global $db;
	
	
if($type=='image'){
	$sql="select id,big_id,sec_id,website,title,file_path from info,files where big_id=$big_id and sec_id=$sec_id and info.id=files.table_id and state>0 order by state desc,shownum desc";
}else if($type=='text'){
		$sql="select id,title,website from info,files where info.big_id=$big_id and info.sec_id=$sec_id and info.id not in(select files.table_id from files) and state>0 group by title order by state desc,shownum desc";
}	
$query=$db->query($sql);
echo <<<EOT
<table width="{$width}" height="{$height}" border="0" cellpadding="0" cellspacing="0">
  <tr>
EOT;
	$ibr=0;
while($arr=$db->fetch_array($query)){
	$ibr++;
	$path="uploadfile/".$arr['file_path'];
	$filepath=$arr['file_path'];
	$title=$arr['title'];
	$like=$arr['website'];
	
if($type=='image' and $filepath!=''){
echo <<<EOT
   <td><table width="{$width}" height="{$height}" border="0" cellpadding="0" cellspacing="0" style="padding:2px 2px">
      <tr>
        <td>
		<a href="{$like}" target="_blank"><img src="{$path}" width="{$width}" height="{$height}" border="0" align="absmiddle"></a>
		</td>
      </tr>
    </table></td>
EOT;
}else if($type=='text' and $filepath==''){
echo <<<EOT
   <td><table width="{$width}" height="{$height}" border="0" cellpadding="0" cellspacing="0" style="padding:2px 2px">
      <tr>
        <td>
		<a href="{$like}" target="_blank">{$title}</a>
		</td>
      </tr>
    </table></td>
EOT;
}
echo ($ibr%$br)==0?'<TR>':'';

}
echo <<<EOT
</tr></table>
EOT;
}
//流量统计
//showcount(1)
function counter($show=0){
if($show==1){
global $db;
//$parse_url=parse_url($_SERVER["HTTP_REFERER"]);
//$form_url="http://".$parse_url["host"];
	if($_SESSION["count_true"]!="show"){
		$id=$db->getMax('counter','id',"")+1;
		$sql="insert into counter values('".$id."','".$_SERVER['HTTP_REFERER']."','".$_SERVER['REMOTE_ADDR']."','".date("Y/m/d H:i:s")."')";
		$db->query($sql);
		$_SESSION["count_true"]="show";
	}
}
}
?>