<?php

$msg=str_replace('\n','<br>',$_GET['msg']);
$url=str_replace('::','&',$_GET['url']);
if($url=='')
{
	$url='javascript:history.back();';
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv=refresh content=3;url=<?php echo $url?>>
<title>��Ϣ��ʾ</title>
<link href="./images/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<table width="500" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr>
    <td bgcolor="#E3EFFB"><strong>����˳���ɹ�</strong></td>
  </tr>
  <tr>
    <td height="80">
	<b><span id="yu">3</span><a href="javascript:countDown"></a>���Ӻ�ϵͳ���Զ�����...</b>
	<script>function countDown(secs){yu.innerText=secs;if(--secs>0)setTimeout("countDown("+secs+")",1000);}countDown(3);</script>
	<ul>
	<?php echo $msg;?>
	</ul>
	</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#E3EFFB"><a href="<?php echo $url;?>">������һҳ &gt;&gt; </a></td>
  </tr>
</table>
</body>
</html>
