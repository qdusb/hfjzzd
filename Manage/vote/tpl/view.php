<html>
<head>
<title>显示<?php echo $id?></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../images/default.css" rel="stylesheet" type="text/css">

</head>

<body>
<table cellspacing="0" cellpadding="0" width="98%" align="center" border="0">
  <tr height="30">
    <td><a href="?">[刷新列表]</a>&nbsp;[<a href="?action=add">添加</a>] [<a href="?">投票管理</a>]</td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" class="editTable">
  <tr class="editHeaderTr"> 
    <td colspan="2"  class="editHeaderTr"><em><strong>投票议题：</strong></em><?php echo $vote[2]?></td>
  </tr>
<?
for ($i=1;$i<6;$i++) {
	if ($vote[$i+2]) {
?>
  <tr class="editTr" > 
    <td bgcolor="#FFFFFF" class="editRightTd"><b><?php echo $i?></b> <?php echo $vote[$i+2]?></td>
    <td class="editRightTd"> <?php echo $vote[$i+7]?></td>
  </tr>
<?
	}
}
?>
    
  <tr class="editHeaderTr"> 
    <td colspan="2" class="editHeaderTr">&nbsp;</td>
  </tr>
</table>
</body>
</html>