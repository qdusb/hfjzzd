<?php
define("IN_EKMENG",true);
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
	$id=intval($_GET['id']);
	$sql="select id,big_id,sec_id,views,title,content,intro,create_time,source,author from info where id=$id  and state>0 order by shownum asc limit 0,1";
	if($arr=$db->fetch_array($db->query($sql))){
		$id=$arr['id'];
		$base_id	=$arr['big_id'];
		$sec_id		=$arr['sec_id'];
		$third		=$arr['third'];
		$title		=$arr['title'];
		$content	=$arr['content'];
		//$author		=$arr['author'];
		$author=($arr['author']=="")?"管理员":$arr['author'];
		$create_time=$arr['create_time'];
		$intro		=$arr['intro'];
		$views		=$arr['views'];
		$source		=$arr['source'];
		$sql		="update info set views=views+1 where id=$id";
		$db->query($sql);
	}else{
		$db->close();
		JSRedirect("index.php");
	}
	
	if($base_id>0){
		$arr=$db->fetch_array($db->query("select typename from big_class where id=$base_id"));
		$base_name=$arr['typename'];
	}
		
	if($third>0){
		$sql="select third_name from third_class where id=$third_id";
		if($arr=$db->fetch_array($db->query($sql))){
			$third_name=$arr['third_name'];
		}else{
			$db->close();
			JSRedirect("index.php");		;		
		}
	}
	
	if($sec_id>0){
		$sql="select typename,sec_name from sec_class,big_class where big_class.id=$base_id and sec_class.id=$sec_id";
		if($arr=$db->fetch_array($db->query($sql))){
			$big_name=$arr['typename'];
			$sec_name=$arr['sec_name'];
		}else{
			$db->close();
			JSRedirect("index.php");	;			
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?=$title?>_<?=$web_title?></title>
<meta name="keywords" content="<?php echo $web_keywords?>" />
<meta name="description" content="<?php echo $web_note?>" />
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<div id="main">


	<div class="top">
    	<div class="flash">
		 <?php require_once("flash.php")?>
        </div>
		
		<!---nav-->
    	<?php require_once("menu.inc.php")?>
		
		
		
    </div>
    
	<!--header-->
    <?php require_once("header.inc.php")?>
	
     
	<div class="list">
	<!--left-->
     <?php require_once("left.inc.php")?>
		
		
        
        <div class="list_y">
        	<div class="list_bt">
        	  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="4%" style="color:#0074BA; font-size:14px; font-weight:bold; line-height:31px">&nbsp;</td>
                  <td width="40%" align="left" style="color:#000000; font-size:14px; font-weight:bold; line-height:24px; padding-top:7px"><?=$sec_name?></td>
                  <td width="56%" align="right" style="color:#FFFFFF; font-size:14px;line-height:31px"><a href="index.php" style="margin-right:5px; color:#FFFFFF">网站首页</a>&gt;&gt;<a href="list.php?sec_id=<?=$sec_id?>" style="margin-right:5px; color:#FFFFFF"><?=$sec_name?></a></td>
                </tr>
              </table>
        	</div>
            
            <div class="list_lb">
			<!--info-->
			
            	 <!--info-->
			<div style="margin:10px; padding:10px;">
			<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr valign="middle">
    <td align="center" style="height:40px;"><strong> <span style="font-size:16px;">
      <?=$title?>
    </span> </strong></td>
  </tr>
  <tr>
    <td height="40" align="center" style="border-bottom:1px #cccccc solid; font-size:12px;">日期：
      <?=date("Y-m-d",$create_time)?>
      &nbsp;浏览：[
      <?=$views?>
      ]  [<a href="javascript:window.close()">关闭</a>] [<a href="javascript:window.print()">打印</a>] </td>
  </tr>
  <tr>
    <td height="400" valign="top" style="padding-top:20px; padding-bottom:30px; height:400px auto;" id="content1"><?=$content?>
        <?php if($source!=""){?>
        <div style="text-align:right; height:25px; line-height:25px"></div>
      <?php }?></td>
  </tr>

</table></div>
				 
				 
				 
                <div class="clear"></div>
            </div>
            
            
        </div>
        
        
    </div>
	
	
	
    <div class="clear"></div>
    
	<!--footer_menu-->
     <?php require_once("footer_menu.php")?>
    
	<!--footer-->
    <?php require_once("footer.inc.php")?>
    
<div class="clear"></div>
</div>
 
</body>
</html>
