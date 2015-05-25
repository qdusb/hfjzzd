<?php
define('IN_EKMENG',true);
define('UploadDir','../uploadfile/');
require_once('isadmin.inc.php');
require_once('common.inc.php');
$db=new dbconn();
$db->connect($dbname,$dbuser,$dbpwd,$dbhost);

$filetype=$_GET['file'];
$table_name=$_GET['table_name'];
$table_id=(int)$_GET['table_id'];
$file_falg=$_GET['file_falg'];
$id=$_GET['id'];
$act=$_GET['act'];
if($act=="del"){
	//删除文件
	$sql="select file_path from files where table_name='$table_name' and table_id=$table_id";
	$query=$db->query($sql);
	while($arr=mysql_fetch_array($query)){
	//删除文件程序
		$file='../uploadfile/'.$arr['file_path'];
	if(file_exists($file)){
		unlink($file);
	}
	//执行删除
	}
	//执行删除
	$sql="delete from files where table_id=".$table_id." and table_name='$table_name' and file_falg='$file_falg'";
	$db->query($sql);
	OutScriptNoBack("history.back();");
}


//检查
if($filetype!="remote" && $filetype!="file" && $filetype!="media" && $filetype!="flash" && $filetype!="image"){
	OutScript('提示：文件类型出错');
	exit();
}
if($table_name=="" || $table_id<1 || $file_falg==""){
	OutScript('提示：参数错误! ');
	exit();
}


$sql="select * from files where table_name='$table_name' and table_id=$table_id and file_falg='$file_falg'";
if($arr=$db->fetch_array($db->query($sql))){
	$realname=$arr['realname'];
	$ext=$arr['ext'];
	$length=((int)$arr['length']/1024)." KB";
	$p=$arr['file_path'];
	$f=true;
}else{
	$f=false;
}

$UploadSet = array( //上传文件限制
  'remote' => array('gif|jpg|jpeg|bmp',10000),
  'file'   => array('doc|xls',10000),
  'media'  => array('rm|mp3|wav|mid|midi|ra|avi|mpg|mpeg|asf|asx|wma|mov',10000),
  'flash'  => array('swf',10000),
  'image'  => array('gif|jpg|jpeg|bmp',10000)
);

$sAllowExt  = $UploadSet[$filetype][0];
$sAllowSize	= $UploadSet[$filetype][1];


//转为根路径格式
function RelativePath2RootPath($url) {
	if(substr($url,0,1)=="/") Return $url;
	$sWebEditorPath = $_SERVER["SCRIPT_NAME"];
  $sWebEditorPath = substr($sWebEditorPath,0,strrpos($sWebEditorPath,"/"));
  while(substr($url,0,3)=="../") {
  	$url = substr($url,3);
    $sWebEditorPath = substr($sWebEditorPath,0,strrpos($sWebEditorPath,"/"));
  }
	Return $sWebEditorPath ."/". $url;
}

//根路径转为带域名全路径格式
function RootPath2DomainPath($url) {
	$aProtocol = explode("/",$_SERVER["SERVER_PROTOCOL"]);
  $sHost = strtolower($aProtocol[0])."://".strtolower($_SERVER["HTTP_HOST"]);
  if($_SERVER["SERVER_PORT"]!="80") $sHost .= ":".$_SERVER["SERVER_PORT"];
  Return $sHost.$url;
}

//得到根目录的物理路径
function GetRoot() {
	$str = $_SERVER["PATH_TRANSLATED"];
  $str = substr($str, 0, strrpos($str, "/"));
  Return $str;
}

//取随机文件名
function GetRndFileName($sExt) {
	srand((double)microtime()*1000000);
  $randval = rand(100, 999);
  Return date("YmdHis").$randval.".".$sExt;
}

//检测扩展名的有效性
function CheckValidExt($sExt) {
	global $sAllowExt;
 		$aExt = explode("|",$sAllowExt);
  	if(in_array($sExt,$aExt)) {
	//echo $sExt."<==>".$aExt;
	//die();
		Return true;
  	}else{    
    	Return false;
 	}
}

//输出客户端脚本
function OutScript($str) {
	echo("<script language=javascript>alert('$str');history.back()</script>");
	exit();
}
function OutScriptNoBack($str) {
	echo("<script language=javascript>$str</script>");
	exit();
}


if($_SERVER['REQUEST_METHOD']=='POST'){


	 
	 
	
	 if(@is_file($_FILES['uploadfile']['tmp_name'])) {
		$sOriginalFileName	= $_FILES['uploadfile']['name'];
		$ExtName			= substr($sOriginalFileName,strrpos($sOriginalFileName,".")+1);
		
		if(!CheckValidExt($ExtName)) {			
			OutScript('提示：\n\n请选择一个有效的文件!\n支持的格式有('.$sAllowExt.'！)');
		}
		$FileSize=$_FILES['uploadfile']['size'];
		if($FileSize > intval($sAllowSize)*1024){
			OutScript('你上传的文件总大小超出了最大限制（'.$sAllowSize.' KB）');		
		}


		$sSaveFileName = GetRndFileName($ExtName);
        $SaveDir = GetRoot().RelativePath2RootPath(UploadDir);
		$SaveFile=$SaveDir.$sSaveFileName;

		
		
		//echo "文件名:$sOriginalFileName<br>文件大小:$FileSize<br>类型:$ExtName<br>";
		//echo $SaveFile;
		//die();
		
		$sSaveFileName = GetRndFileName($ExtName);
        $SaveDir = GetRoot().RelativePath2RootPath(UploadDir);
		$SaveFile=$SaveDir.$sSaveFileName;
		
		if(!@move_uploaded_file($_FILES["uploadfile"]['tmp_name'],UploadDir.$sSaveFileName)) {
  			OutScript("文件上传失败，原因未知! $SaveFile");
			exit;
  		}else{
		
		

		
				
			if(!$f){
				$order=$db->getMax("files","table_order","table_name='$table_name' and table_id=$table_id")+1;
				$sql="insert into files values('$table_name',$table_id,$order,'$sOriginalFileName','$file_falg','$ExtName',$FileSize,'$sSaveFileName')";
			}else{
				if($p!=""){					
					if(file_exists(UploadDir.$p)){
						unlink(UploadDir.$p);
					}
				}
				$sql="update files set realname='$sOriginalFileName',ext='$ExtName',length=$FileSize,file_path='$sSaveFileName' where table_name='$table_name' and table_id=$table_id and file_falg='$file_falg'";
			}			
			$db->query($sql);
			if($filetype=='image'){
		//	imagezoom(UploadDir.$sSaveFileName,UploadDir.$sSaveFileName, 440, 280, '#FFFFFF');
			}
			OutScriptNoBack("history.back();");
			exit;
		}

	 }else{
		OutScript('系统没有找到您要上传的文件!');
	 }
}

?>

<html>
	<head>
		<title>文件上传</title>
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
				<td class="position">当前位置: 管理中心  -&gt; 文件上传</td>
			</tr>
	</table>


		<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<a href="javascript:history.back();">[返回列表]</a>&nbsp;
				</td>
			</tr>
		</table>
		

		<table width="100%" border="0" cellSpacing="1" cellPadding="0" align="center" id="mainTable">
			<form name="form1" action="" method="post" enctype="multipart/form-data" onSubmit="return check(this);">
				
				<tr class="editHeaderTr">
					<td class="editHeaderTd" colSpan="2">文件上传</td>
				</tr>

				<tr class="editTr">
					<td width="13%" class="editLeftTd">选择文件</td>
					<td width="87%" class="editRightTd"><input type="file" name="uploadfile" size="40"></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">文件名称</td>
					<td class="editRightTd"><?php echo $realname?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">文件类型</td>
					<td class="editRightTd"><?php echo $ext?></td>
				</tr>
				<tr class="editTr">
					<td class="editLeftTd">文件大小</td>
					<td class="editRightTd"><?php echo $length?></td>
				</tr>


				<tr class="editTr">
					<td class="editLeftTd">说明</td>
					<td class="editRightTd">
						仅限 
						<?php
						$tmp=explode("|",$sAllowExt);
						for($i=0;$i<count($tmp);$i++){
							$tmpstr.=$tmp[$i]."、";
						}
						echo substr($tmpstr,0,strlen($tmpstr)-2);
						?>
						格式的图片。					</td>
				</tr>
				<tr class="editFooterTr">
					<td class="editFooterTd">&nbsp;</td>
			      <td class="editFooterTd"><input name="submit" type="submit" value=" 上 传 " class="submit">
                      <input name="button" type="button" onClick="history.back();" value="  返 回 " class="submit">
                      <input name="button2" type="button" onClick="location.href='uploadfile.php?table_name=<?php echo $table_name?>&table_id=<?php echo $table_id?>&file=<?php echo $filetype?>&file_falg=<?php echo $file_falg?>&act=del'" value="  删 除 " class="submit"></td>
				</tr>
			</form>
		</table>
		<table width="100%" border="0" cellspacing="5" cellpadding="0" align="center">
			<tr height="30">
				<td>
					<?php
					if((int)$length>0){
					echo $filetype=='flash'?"<embed  src='".UploadDir.$p."' type='application/x-shockwave-flash' width=100% height=600></embed>":"<img src='".UploadDir.$p."' />";
										
					}
					?>
				</td>
			</tr>
	</table>
		
		

				<script language="javascript">
			function check()
			{
				var obj = document.form1;

				if (obj.uploadfile.value == "")
				{
					alert("请选择上传文件！");
					return false;
				}

				return true;
			}
		</script>

	</body>
</html>