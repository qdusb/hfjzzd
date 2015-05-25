<?php

$msg=$_GET['msg'];
$url=str_replace('::','&',$_GET['url']);
if($url=='')
{
	$url='javascript:history.back();';
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
	</head>

	<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="headerTable">
      <tr class="position">
        <td class="position">当前位置: 管理中心 -&gt; 错误提示</td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="mainTable1">
      <tr height="30" bgcolor="#EBF4FD">
        <td height="45" colspan="2" style="font-weight:bold;padding-left:10px;font-size:14px;"><img src="images/warning.gif" width="32" height="32" vspace="5" align="absmiddle"> <?php echo $msg?></td>
      </tr>
      <tr height="80">
        <td width="8%" height="30" align="left" style="padding-left:20px;line-height:140%">&nbsp;</td>
        <td width="92%" height="30" align="left" style="padding-left:20px;line-height:140%">如果您不做出选择，将在 <SPAN id="spanSeconds">3</SPAN> 秒后跳转到第一个链接地址。</td>
      </tr>
      <tr height="30" bgcolor="#EBF4FD" align="center">
        <td height="30" align="left" style="padding-left:20px;line-height:140%">&nbsp;</td>
        <td align="left" style="padding-left:20px;line-height:140%"><a href="<?php echo $url?>"><img src="images/arrow.gif" width="9" height="9"> 返回上一页</a></td>
      </tr>
    </table>
<script language="JavaScript">
<!--
var seconds = 3;
var defaultUrl = "javascript:history.back();";

onload = function()
{
  window.setInterval(redirection, 1000);
}
function redirection()
{
  if (seconds <= 0)
  {
    window.clearInterval();
    return;
  }

  seconds --;
  document.getElementById('spanSeconds').innerHTML = seconds;

  if (seconds == 0)
  {
    window.clearInterval();
    location.href = defaultUrl;
  }
}
//-->
</script>
	</body>
</html>