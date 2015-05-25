<?php
@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>合肥市公安局技术侦查支队网站管理系统</title>
<!--{literal}-->
<style type="text/css">
body,td{margin:0px; padding:0px;font-size:12px}
#header{background:#278296; border-bottom:1px solid #FFF; height:50px; width:100%;}
#nav{background:#80BDCB; height: 24px;}
#nav td{border-left:1px #BBDDE5 solid; border-right:1px #192E32 solid;}
#nav a{display:block; width:100px;line-height:24px;color:#335B64;font-size:13px;font-weight:bold;text-decoration:none;background:#9CCBD6;}
#nav a:hover{color:#000; background:#80BDCB;}

#ah a {color: #335B64;text-decoration:none ;}
#ah a:hover {color: #335B64;text-decoration: underline;}

</style>
<!--{/literal}-->
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="header">
  <tr>
    <td width="74%"><img src="images/LOGO.gif" /></td>
    <td width="26%" align="right" valign="top" style="padding:10px 10px; color:#F5F7F7"><a href="../" target="_blank" style="color:#F5F7F7">网站首页</a> | <a href="logout.php?action=logout" style="color:#F5F7F7">退出管理</a></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#80BDCB">
  <tr>
    <td width="778" align="left" style="padding-left:2px"><table border="0" cellpadding="0" cellspacing="0" id="nav">
      <tr>
        <td width="100" align="center"><a href="menu.php" target="menu-frame">信息管理</a> </td>
        <td width="102" align="center"><a href="user_menu.php" target="menu-frame">用户管理</a></td>
		<td width="102" align="center"><a href="config_menu.php" target="menu-frame">网站配置</a></td>
	  </tr>
    </table></td>
    <td width="559" align="center" style="padding:0px 5px">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="ah">
      <tr>
        <td align="right">
		<script language="JavaScript" type="text/javascript" author="luxiaoqing"><!--
		function initArray(){for(i=0;i<initArray.arguments.length;i++)
		this[i]=initArray.arguments[i];}var isnMonths=new initArray("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");var isnDays=new initArray("星期日","星期一","星期二","星期三","星期四","星期五","星期六","星期日");today=new Date();hrs=today.getHours();min=today.getMinutes();sec=today.getSeconds();clckh=""+((hrs>24)?hrs-24:hrs);
		clckm=((min<10)?"0":"")+min;clcks=((sec<10)?"0":"")+sec;clck=(hrs>=12)?"":"";var stnr="";var ns="0123456789";var a="";
		//-->
		</script>
		您好,<?php echo $_SESSION['realname']?>&nbsp;&nbsp;今天是:
		<script language="JavaScript" type="text/javascript">
		<!--
		function getFullYear(d){//d is a date object
		yr=d.getYear();if(yr<1000)
		yr+=1900;return yr;};//don't delete this line
		document.write(getFullYear(today)+"年 "+isnMonths[today.getMonth()]+""
		+today.getDate()+"日 "+isnDays[today.getDay()]);
		//-->
		</script>
	</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
