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
	
	
	<!--tab-->
	<style type="text/css">
<!--
body,td{font-size: 12px;}

#TabTab03Con1{width:226px;height:82px;border-left:#C9EAF5 1px solid;border-bottom:#C9EAF5 1px solid;border-right:#C9EAF5 1px solid; line-height:50px;}
#TabTab03Con2{width:226px;height:82px;border-left:#C9EAF5 1px solid;border-bottom:#C9EAF5 1px solid;border-right:#C9EAF5 1px solid;line-height:50px;}

.xixi1{width:228px;height:30px;line-height:40px;background-image:url(images/sr.jpg);cursor:pointer;}
.xixi2{width:228px;height:30px;line-height:40px;background-image:url(images/bz.jpg);cursor:pointer;}

.tab1{width:113px;height:30px;line-height:40px;float:left;text-align:center;cursor:pointer; float:left;}
.tab2{width:113px;height:30px;line-height:40px;float:left;text-align:center;cursor:pointer;color:#FFFFFF;}


-->
</style>

<!--添加收藏-->
<script language="javascript">
function AddFavorite(sURL, sTitle)
{
    try
    {
        window.external.addFavorite(sURL, sTitle);
    }
    catch (e)
    {
        try
        {
            window.sidebar.addPanel(sTitle, sURL, "");
        }
        catch (e)
        {
            alert("请使用Ctrl+D进行添加收藏");
        }
    }
}

</script>
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
		<div style="margin-left:10px; padding-top:10px; line-height:30px">
		<!--今日值班-->
		<strong>带班领导：</strong><?php
	
	$sql = "select id,gmember,gdate from zhiri where ztype=0 order by zid asc";
	$arr = $db->getAll($sql);
	if($gid = $db->getField('zhiri','id',"ztype=0 and state=1")){
		while($arr[0]['id'] != $gid)
		{
			$tmp = $arr[0];
			array_splice($arr,0,1);
			$arr[] = $tmp;
		}
		$time = time()-$db->getField('zhiri','gdate',"ztype=0 and state=1");
		$count = $db->getCount('zhiri','gdate',"ztype=0");
		if($time>0)
		{
			$gdate = $time%(3600*24)==0?intval($time/(3600*24)):intval($time/(3600*24))+1;
			$gid = $gdate%$count==0?0:$gdate%$count;
			$sql = "update zhiri set state=0 where ztype=0";
			$db->query($sql);
			$time = mktime(23,59,59,date('m',time()),date('d',time()),date('Y',time()));
			$sql = "update zhiri set state=1,gdate=$time where id=".$arr[$gid]['id'];
			$db->query($sql);
		}
		else
		{
			$gid = 0;
		}
		$member = explode(',',$arr[$gid]['gmember']);
		foreach($member as $key=>$val)
		{
			echo $db->getField('workers','realname',"id=".intval(trim($val))).'&nbsp;&nbsp;';
		}
		
	
	}
	?><br />
	
<strong>值班大队：</strong><?php
	$sql = "select id,gmember,gdate from zhiri where ztype=2 order by zid asc";
	$arr = $db->getAll($sql);
	
	if($gid = $db->getField('zhiri','id',"ztype=2 and state=1")){
	
		while($arr[0]['id'] != $gid)
		{
			$tmp = $arr[0];
			array_splice($arr,0,1);
			$arr[] = $tmp;
		}
		$time = time()-$db->getField('zhiri','gdate',"ztype=2 and state=1");
		$count = $db->getCount('zhiri','gdate',"ztype=2");
		if($time>0)
		{
			$gdate = $time%(3600*24)==0?intval($time/(3600*24)):intval($time/(3600*24))+1;
			$gid = $gdate%$count==0?0:$gdate%$count;
			$sql = "update zhiri set state=0 where ztype=2";
			$db->query($sql);
			$time = mktime(23,59,59,date('m',time()),date('d',time()),date('Y',time()));
			$sql = "update zhiri set state=1,gdate=$time where id=".$arr[$gid]['id'];
			$db->query($sql);
		}
		else
		{
			$gid = 0;
		}
		$member = explode(',',$arr[$gid]['gmember']);
		foreach($member as $key=>$val)
		{
			echo $db->getField('workers','realname',"id=".intval(trim($val))).'&nbsp;&nbsp;';
		}
	
	
	}
	?><br />
<strong>秘书科值班：</strong><?php
	$sql = "select id,gmember,gdate from zhiri where ztype=1 order by zid asc";
	$arr = $db->getAll($sql);
	if($gid = $db->getField('zhiri','id',"ztype=1 and state=1")){
		while($arr[0]['id'] != $gid)
		{
			$tmp = $arr[0];
			array_splice($arr,0,1);
			$arr[] = $tmp;
		}
		$time = time()-$db->getField('zhiri','gdate',"ztype=1 and state=1");
		$count = $db->getCount('zhiri','gdate',"ztype=1");
		if($time>0)
		{
			$gdate = $time%(3600*24)==0?intval($time/(3600*24)):intval($time/(3600*24))+1;
			$gid = $gdate%$count==0?0:$gdate%$count;
			$sql = "update zhiri set state=0 where ztype=1";
			$db->query($sql);
			$time = mktime(23,59,59,date('m',time()),date('d',time()),date('Y',time()));
			$sql = "update zhiri set state=1,gdate=$time where id=".$arr[$gid]['id'];
			$db->query($sql);
		}
		else
		{
			$gid = 0;
		}
		$member = explode(',',$arr[$gid]['gmember']);
		foreach($member as $key=>$val)
		{
			echo $db->getField('workers','realname',"id=".intval(trim($val))).'&nbsp;&nbsp;';
		}
	
	}
	
	?>
<br />
<strong>值班电话：</strong>0551-62695738<br />
<strong>传真电话：</strong>0551-62674766<br />
	
	
	
	
	
	
	
	
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
	<!--生日-->
		<?php
		$sql="select birthday,realname from workers order by id asc";
		$query=$db->query($sql);
		while($arr=$db->fetch_array($query)){
			
			if(date("m-d",$arr['birthday'])==date("m-d",time())){
				$birstr.=$arr['realname']."，";
			}
		}
		if($birstr!=""){
			$msg="<a href='Birthday.php' style='color:#FF0000'>祝：".substr($birstr,0,strlen($birstr)-2)." 同志生日快乐！</a>";
		}
	?>	
	

	
<div class="tab">
	<div id="bg" <?php echo ($birstr=="")?"class='xixi2'":"class='xixi1'"?>>
	<div id="font1" class="tab1" onMouseOver="setTab03Syn(1);document.getElementById('bg').className='xixi1'"></div>
	<div id="font2" class="tab2" onMouseOver="setTab03Syn(2);document.getElementById('bg').className='xixi2'"></div>
	</div>
    <div id=TabTab03Con1 style="text-align:center; color:#FF0000;<?php echo ($birstr=="")?"display:none":""?>"><?=$msg?></div>
	<!--表彰-->
	<?php 
		$sql="select content from info where sec_id=9003  and state=2  order by state desc,shownum desc ";
		$query=$db->query($sql);
		if($arr=$db->fetch_array($query)){
		
	?>
	<div id=TabTab03Con2  style="text-align:center; color:#FF0000;<?php echo ($birstr!="")?"display:none":""?>"><?=$arr['content']?></div>
	<?php }?>
	
</div>
      </div>
      
	  <div class="z_5">
      	<div style="height:30px;"> <img src="images/gwzx_jz.png" width="228px" height="30px" /> </div>
      
      </div>
      
	  
      <div class="z_3">
        <div style="height:30px;"> <img src="images/zbt_3.png" width="228px" height="30px" /> </div>
        <div class="z_3_lb"> <a href=""><img src="images/xt_1.jpg" width="204px" height="51px" /></a> <a href=""><img src="images/xt_2.jpg" width="204px" height="51px" /></a> <a href=""><img src="images/xt_3.jpg" width="204px" height="51px" /></a> <a href=""><img src="images/xt_4.jpg" width="204px" height="51px" /></a> <a href=""><img src="images/xt_5.jpg" width="204px" height="51px" /></a></div>
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
			$sql="select id,title,create_time,color from info where big_id=2 and sec_id=2001 and state>0 order by state desc,shownum desc limit 0,5";
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
			$sql="select id,title,create_time,color from info where big_id=3 and sec_id=3006 and state>0 order by state desc,shownum desc limit 0,5";
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
			$sql="select id,title,create_time,color from info where big_id=5 and sec_id=5001 and state>0 order by state desc,shownum desc limit 0,5";
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
			$sql="select id,title,create_time,color from info where big_id=6 and sec_id=6001 and state>0 order by state desc,shownum desc limit 0,5";
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