<?php
define("IN_EKMENG",true);
require_once("configs.inc.php");
require_once(ROOT_PATH.'./Include/dbconn.inc.php');
require_once(ROOT_PATH.'./Include/function.inc.php');
//Êý¾Ý¿â
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);
if($arr=$db->fetch_array($db->query("select * from web_config"))){

	$web_title		= $arr['web_title'];
	$web_note		= $arr['web_note'];
	$web_keywords	= $arr['web_keywords'];
	$web_footer		= $arr['web_footer'];
}


	$base_id			=	intval($_GET['base_id']);
	$sec_id				=	intval($_GET['sec_id']);
	$third_id			=	intval($_GET['third_id']);
	$page				=	intval($_GET['page'])==0?1:intval($_GET['page']);
	$sec_id>0?$base_id	=	intval(substr($sec_id,0,strlen($sec_id)-3)):$base_id=$base_id;
	if($sec_id>0){
		$sql="select id,sec_name,info_state,third_state from sec_class where big_id=$base_id and id=$sec_id order by shownum asc";
	}else{
		$sql="select id,sec_name,info_state,third_state from sec_class where big_id=$base_id order by shownum asc limit 0,1";
	}
	
	if($base_id>0){
		$arr=$db->fetch_array($db->query("select typename from big_class where id=$base_id"));
		$base_name=$arr['typename'];
	}
	if($arr=$db->fetch_array($db->query($sql))){
		$sec_id=$arr['id'];
		$sec_name=$arr['sec_name'];
		$third_state=$arr['third_state'];		
		$sec_info=$arr['info_state'];
		if($third_state=="YES"){
			if($third_id>0){
				$sql="select id,third_name,info_state from third_class where big_id=$base_id and sec_id=$sec_id and id=$third_id order by shownum asc";
			}else{
				$sql="select id,third_name,info_state from third_class where big_id=$base_id and sec_id=$sec_id order by shownum asc limit 0,1";
			}
			if($arr=$db->fetch_array($db->query($sql))){
				$third_id=$arr['id'];
				$third_name=$arr['third_name'];
				$third_info=$arr['info_state'];
			}else{
				$db->close();
				JSRedirect("index.php");
			}	
		}	
	}else{
		$db->close();
		JSRedirect("index.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?=$sec_name?>_<?=$web_title?></title>
<meta name="keywords" content="<?php echo $web_keywords?>" />
<meta name="description" content="<?php echo $web_note?>" />
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<div id="main">


	<div class="top">
    	<div class="flash"> <?php require_once("flash.php")?></div>
		
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
                    <td width="56%" align="right" style="color:#FFFFFF; font-size:14px;line-height:31px"><a href="index.php" style="margin-right:5px; color:#FFFFFF">ÍøÕ¾Ê×Ò³</a>&gt;&gt;<a href="list.php?sec_id=<?=$sec_id?>" style="margin-right:5px; color:#FFFFFF">
                      <?=$sec_name?>
                    </a></td>
                  </tr>
            </table>
       	  </div>	
            
            <div class="list_lb">
			<!--info-->
			
            	 <?php require_once("Module/info.php")?>
				 
				 
				 
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


