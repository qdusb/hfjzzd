<?php @session_start();?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Expires" content="-1000">
<title>header</title>
<link href="Inc/body.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="./images/common.js"></script>
<SCRIPT language=JavaScript type=text/JavaScript>
check_frame("default.php")
    var displayBar=true;
    function switchBar(obj)
    {
	if (displayBar)
	{
		parent.mainweb.cols="0,*";
		displayBar=false;
		//obj.src="open.gif";
		GaobeiSysTemSwitch.innerText="�򿪿������";
		obj.title="�򿪿������";
	}
	else{
		parent.mainweb.cols="180,*";
		displayBar=true;
		GaobeiSysTemSwitch.innerText="�رտ������";
		//obj.src="close.gif";
		obj.title="�رտ������";
	}
}
</SCRIPT>
</head>

<body  oncontextmenu=self.event.returnValue=false>
<table width="100%" height="56" border="0" cellpadding="0" cellspacing="0" background="images/header_bg.jpg">
  <tr>
    <td width="282"><img src="images/header_left.jpg" width="260" height="56"></td>
    <td width="117" align="center" id="GaobeiSysTemSwitch" onClick=switchBar(this) title="�ر���߹������˵�" class="STYLE1" style="cursor:hand">�رտ������</td>
    <td width="343" align="center"><span class="STYLE1">��ǰ�û���<span class="editRightTd">
      <?php echo $_SESSION['username']?>
    </span></span><a href="javascript:history.back()" style="color:#FFF;" ></a>&nbsp; <a href="edit_pass.php" target="right" style="color:#FFF;"><span class="STYLE1">�޸Ŀ���</span></a>&nbsp;<a href="javascript:history.go(1)" style="color:#FFF;" ></a>&nbsp; <a href="logout.php?action=logout" target="_top" style="color:#FFF;" onClick="if (confirm('ȷ��Ҫ�˳���')) return true; else return false;"><span class="STYLE1">�˳�ϵͳ</span></a></td>
    <td width="268" align="right"><img src="images/header_right.jpg" width="268" height="56"></td>
  </tr>
</table>
</body>
</html>
