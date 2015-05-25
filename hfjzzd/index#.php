<?php
define("IN_EKMENG",true);
//----------------------Header.inc.php包含文件开始-------------------
//包含文件
require_once("configs.inc.php");
require_once(ROOT_PATH.'./Include/dbconn.inc.php');
require_once(ROOT_PATH.'./Include/function.inc.php');
//数据库
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
if($arr=$db->fetch_array($db->query("select * from web_config"))){

	$web_title		= $arr['web_title'];
	$web_note		= $arr['web_note'];
	$web_keywords	= $arr['web_keywords'];
	$web_footer		= $arr['web_footer'];
}
$cname="default";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta name="keywords" content="<?php echo $web_keywords?>" />
<meta name="description" content="<?php echo $web_note?>" />
<title><?=$web_title?></title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>

<!--图片切换-->
<link href="css/slideshow.css" rel="stylesheet" />
<script src="js/slideshow.js" type="text/javascript"></script>

</head>
<body>
<div id="main">
  <div class="top">
    <div class="flash">
	
      
	  <?php require_once("flash.php")?>
  
	  
    </div>
	
	<!--menu-->
	 <?php require_once("menu.inc.php")?>
  </div>
  <!--head-->
  
  <?php require_once("header.inc.php")?>
  
  
  
  <div class="con">
    <div class="c_z">
      <div class="z_1">
        <div class="z_1_bt"> <img src="images/zbt_1.png" width="228px" height="30px" /> </div>
        <div class="z_1_lb">
		<div style="margin-left:10px; padding-top:10px;">
		<!--今日值班-->
		<?php 
				$sql="select content from info where sec_id=9001  and state=2  order by state desc,shownum desc ";
		$query=$db->query($sql);
		if($arr=$db->fetch_array($query)){
		
				?>
				<?php echo $arr['content']?>
		  
		  <?php }?>
		  
		  </div>
          <div class="clear"></div>
        </div>
		
		
      </div>
	  
	  <!--生日祝福-->
      <div class="z_2">
       <script type=text/javascript>
	function setTab03Syn ( i )
	{
		selectTab03Syn(i);
	}
	
	function selectTab03Syn ( i )
	{
		switch(i){
			case 1:
			document.getElementById("TabTab03Con1").style.display="block";
			document.getElementById("TabTab03Con2").style.display="none";
			document.getElementById("font1").style.color="#000000";
			document.getElementById("font2").style.color="#ffffff";
			break;
			case 2:
			document.getElementById("TabTab03Con1").style.display="none";
			document.getElementById("TabTab03Con2").style.display="block";
			document.getElementById("font1").style.color="#ffffff";
			document.getElementById("font2").style.color="#000000";
			break;
			case 3:
			document.getElementById("TabTab03Con1").style.display="none";
			document.getElementById("TabTab03Con2").style.display="none";
			document.getElementById("font1").style.color="#ffffff";
			document.getElementById("font2").style.color="#ffffff";
			break;
		}
	}

</script>

<div class="tab">
	<div id="bg" class="xixi1">
		<div id="font1" class="tab1" onMouseOver="setTab03Syn(1);document.getElementById('bg').className='xixi1'"></div>
		<div id="font2" class="tab2" onMouseOver="setTab03Syn(2);document.getElementById('bg').className='xixi2'"></div>
	</div>
	
	<!--生日-->
	<?php 
		$sql="select content from info where sec_id=9002  and state=2  order by state desc,shownum desc ";
		$query=$db->query($sql);
		if($arr=$db->fetch_array($query)){
		
	?>
    <div id=TabTab03Con1 style="text-align:center; color:#FF0000;"><?=$arr['content']?></div>
	<?php }?>
	
	<!--表彰-->
	<?php 
		$sql="select content from info where sec_id=9003  and state=2  order by state desc,shownum desc ";
		$query=$db->query($sql);
		if($arr=$db->fetch_array($query)){
		
	?>
	<div id=TabTab03Con2 style="display:none; text-align:center; color:#FF0000;"><?=$arr['content']?></div>
	<?php }?>
	
</div>
      </div>
	  
	  
      <div class="z_3">
        <div style="height:30px;"> <img src="images/zbt_3.png" width="228px" height="30px" /> </div>
        <div class="z_3_lb"> <a href="http://10.125.1.55:7001/defaultroot/login.jsp" target="_blank"><img src="images/xt_1.jpg" width="204px" height="51px" border="0" /></a> <a href="http://10.125.1.76:8001/qwjs.aspx" target="_blank"><img src="images/xt_2.jpg" width="204px" height="51px" border="0" /></a> <a href="http://10.125.1.125:8001/xtba/" target="_blank"><img src="images/xt_3.jpg" width="204px" height="51px" border="0" /></a> <a href="http://10.125.1.32:9080/zhcx/index1024.jsp" target="_blank"><img src="images/xt_4.jpg" width="204px" height="51px" border="0" /></a> <a href="http://10.125.1.27:8088/lgy/login.jsp" target="_blank"><img src="images/xt_5.jpg" width="204px" height="51px" border="0" /></a> <a href="http://jy-zyk.zx.ga/" target="_blank"><img src="images/xt_6.jpg" width="204px" height="51px" border="0" /></a> <a href="http://rk-zyk.zx.ga/" target="_blank"><img src="images/xt_7.jpg" width="204px" height="51px" border="0" /></a> <a href="http://ztry.xz.ga/" target="_blank"><img src="images/xt_8.jpg" width="204px" height="51px" border="0" /></a> </div>
      </div>
      <div class="z_4"> <a href="./Manage" target="_blank"><img src="images/ht.jpg" width="228px" height="55px"/></a> <a href="list.php?base_id=10"><img src="images/txl.jpg" width="228px" height="55px"/></a> </div>
    </div>
    <div class="c_y">
      <div class="y_1">
      <div class="y_1_bt"><span class="span1" style=" margin-right:15px; display:block; float:right;"><a href="list.php?base_id=1">更多>></a></span></div>
	  
	 <div style="border:1px #c9eaf5 solid; border-top:none; height:320px; width:769px;">
        <div style="float:left; margin-top:15px; margin-left:10px;"> 
		<!--焦点图-->
         <?php require_once("banner.php")?>
        </div>
		
		
        <div style="float:right; height:203px;">
          
          <div class="y_1_lb">
		  
		  <!--置顶-->
		 <?php								
			$sql="select id,big_id,create_time,color,title,intro from info where big_id=1 and sec_id=1002 and state=3 order by state desc,shownum desc";
			$query=$db->query($sql);
			if($arr=$db->fetch_array($query)){	
			
		?>
            <p style="font-size:15px; color:#ff0000; font-weight:bold; text-align:center; padding-top:15px;"><a href="display.php?id=<?=$arr['id']?>" target="_blank"  title="<?=$arr['title']?>" style=" color:#ff0000; font-weight:bold; font-size:17px;"><?=cnsubstr($arr['title'],38)?></a></p>
            <p style="color:#585858; width:382px; margin:10px auto; line-height:18px; border-bottom:#e4e4e4 1px dashed; height:46px;">&nbsp;&nbsp;&nbsp;&nbsp;<?=cnsubstr($arr['intro'],96)?><a href="display.php?id=<?=$arr['id']?>"  target="_blank" style="color:#585858;" class="a3">[详细]</a></p>
		<?php }?>
			  
            <ul>
			<!--要闻-->
			<?php								
			$sql="select id,big_id,create_time,color,title from info where big_id=1 and sec_id=1002 and state in(1,2) order by state desc,shownum desc limit 0,8";
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){	
			
		?>
              <li><a href="display.php?id=<?=$arr['id']?>" style="float:left;color:<?=$arr['color']?>"  class="a1" target="_blank" title="<?=$arr['title']?>">·<?=cnsubstr($arr['title'],50)?></a><span style="float:right;"><?=date("m-d",$arr['create_time'])?></span></li>
			<?php }?>
             
            </ul>
            <div class="clear"></div>
          </div>
        </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="y_2">
        <div class="y_2_z">
          <div class="y_2_z_bt"> <img src="images/ybt_2.jpg" width="144px" height="37px" style="float:left" /><span class="span1" ><a href="list.php?base_id=2">更多>></a></span> </div>
          <div class="y_2_z_lb">
            <ul>
			<!--通知通报-->
			<?php								
			$sql="select id,title,create_time,color from info where big_id=2 and sec_id=2001 and state>0 order by state desc,shownum desc limit 0,7";
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){		
		?>
              <li><a href="display.php?id=<?=$arr['id']?>" style="float:left;color:<?=$arr['color']?>" target="_blank"  title="<?=$arr['title']?>">·<?=cnsubstr($arr['title'],47)?></a><span style="float:right;"><?=date("m-d",$arr['create_time'])?></span></li>
			  <?php }?>
           
            </ul>
            <div class="clear"></div>
          </div>
        </div>
        <div class="y_2_y">
          <div class="y_2_y_bt"> <img src="images/ybt_3.jpg" width="144px" height="37px" style="float:left" /> <span class="span1" ><a href="list.php?base_id=3">更多>></a></span></div>
          <div class="y_2_y_lb">
            <ul>
			
			<!--领导批示-->
			
			<?php								
			$sql="select id,title,create_time,color from info where big_id=3 and sec_id=3006 and state>0 order by state desc,shownum desc limit 0,7";
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){		
		?>
              <li><a href="display.php?id=<?=$arr['id']?>" style="float:left;color:<?=$arr['color']?>" target="_blank">·<?=cnsubstr($arr['title'],47)?></a><span style="float:right;"><?=date("m-d",$arr['create_time'])?></span></li>
			  <?php }?>
            
            </ul>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      <div style="margin:11px 0; height:103px;"> 
	  
	  <!--hengfu -->
	  <?php 
		$sql="select id,title,file_path,create_time,website from info,files where  sec_id=4002 and info.id=files.table_id and files.table_name='info' and files.file_falg='sma' order by state desc,shownum desc";
		$query=$db->query($sql);
		if($arr=$db->fetch_array($query)){
	?>
	  <img src="<?php echo "uploadfile/".$arr['file_path']?>" width="772px" height="103px" />
	  <?php }?>
	  
	   </div>
      <div class="y_2">
        <div class="y_2_z">
          <div class="y_2_z_bt"> <img src="images/ybt_4.jpg" width="144px" height="37px"  style="float:left"/><span class="span1"><a href="list.php?base_id=5">更多>></a></span> </div>
          <div class="y_2_z_lb">
            <ul>
			
			<!--学习园地-->
			
			<?php								
			$sql="select id,title,create_time,color from info where big_id=5 and sec_id=5001 and state>0 order by state desc,shownum desc limit 0,7";
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){		
		?>
              <li><a href="display.php?id=<?=$arr['id']?>" style="float:left; color:<?=$arr['color']?>" target="_blank"  title="<?=$arr['title']?>">·<?=cnsubstr($arr['title'],47)?></a><span style="float:right;"><?=date("m-d",$arr['create_time'])?></span></li>
			  <?php }?>
            </ul>
            <div class="clear"></div>
          </div>
        </div>
        <div class="y_2_y">
          <div class="y_2_y_bt"> <img src="images/ybt_5.jpg" width="144px" height="37px" style="float:left" /> <span class="span1"><a href="list.php?base_id=6">更多>></a></span></div>
          <div class="y_2_y_lb">
            <ul>
			
              <!--时政要闻-->
			
			<?php								
			$sql="select id,title,create_time,color from info where big_id=6 and sec_id=6001 and state>0 order by state desc,shownum desc limit 0,7";
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){		
		?>
              <li><a href="display.php?id=<?=$arr['id']?>" style="float:left; color:<?=$arr['color']?>"  target="_blank"  title="<?=$arr['title']?>">·<?=cnsubstr($arr['title'],47)?></a><span style="float:right;"><?=date("m-d",$arr['create_time'])?></span></li>
			  <?php }?>
            </ul>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <div class="clear"></div>
  <!--footer_menu-->
  <?php require_once("footer_menu.php")?>
 
  
  
  
  <!--foot-->
 <?php require_once("footer.inc.php")?>
  
  
  
  <div class="clear"></div>
</div>
</body>
</html>