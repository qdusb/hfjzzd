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
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>

</head >

<body>
<div style="width:800px; height:260px; margin:0 auto;letter-spacing:1px;font-family:'宋体';"">
<div style=" width:700px;height:70px; margin:0 auto; margin-top:25px;">
<div><img src="pic1.jpg" /></div>
</div>
<div style=" width:400px;height:30px;color:#000;margin:0 auto; text-align:center;font-size:18px; margin-top:25px;">
<div style="margin-top:10px;"><?=$source?></div>
</div>
<hr style="width:95%;height:8px; border:none;border-top:8px solid #ff0506;" />
<div style=" width:720px;height:70px;color:#000;font-size:18px; font-weight:bolder; margin:0 auto; margin-top:20px; >
<div style="float:left; margin-top:10px;"><?=$content?></div>
</div>
</div>
</body>
</html>
