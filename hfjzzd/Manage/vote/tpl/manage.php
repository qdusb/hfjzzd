<?
	include ('./tpl/header.php');

?>

<table width="95%" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr> 
    <td><table cellspacing="0" cellpadding="0" width="98%" align="center" border="0">
          <tr height="30">
            <td><a href="?">[ˢ���б�]</a>&nbsp;[<a href="?action=add">���</a>] [<a href="?">ͶƱ����</a>]</td>
          </tr>
    </table></td>
  </tr>
  <tr> 
    <td height="69"> <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" class="listTable">
        <tr class="listHeaderTr"> 
          <td width="0" align="center">&nbsp;</td>
          <td width="0" align="center"><font face="Verdana, Arial, Helvetica, sans-serif">ID</font></td>
          <td width="0" align="center">ͶƱ��Ŀ</td>
          <td width="0" align="center">ѡ����Ŀ</td>
          <td width="0" align="center">����ʱ��</td>
          <td width="0" align="center">ͶƱ����</td>
          <td width="0" align="center">��/��</td>
          <td width="0" align="center">�޸�</td>
          <td width="0" align="center">ɾ��</td>
        </tr>
<?
foreach ($mc->data as $vote) {
	$vote = explode($mc->sep, trim($vote));
	$votecount = $votenum = 0;
	for ($i=0;$i<5;$i++) {
		if ($vote[$i+3]) {
			$votecount++;
			$votenum += $vote[$i+8];
		}
	}

?>        
        <tr> 
          <td width="0" align="center" bgcolor="#FFFFFF"><a href="./demo.htm?thisvoteid=<?php echo $vote[1]?>"><img src="images/dot.gif" width="22" height="21" border="0"></a></td>
          <td width="0" align="center" bgcolor="#FFFFFF"  class="en" style="border-bottom:1px solid #E0F2FF;"><?php echo $vote[1]?></td>
          <td width="0" align="center" bgcolor="#FFFFFF" style="border-bottom:1px solid #E0F2FF;padding-left:8px;"><a href="?action=view&id=<?php echo $vote[1]?>"><?php echo $vote[2]?></a></td>
          <td width="0" align="center" bgcolor="#FFFFFF" class="en" style="border-bottom:1px solid #F3FBC8;"><?php echo $votecount?></td>
          <td width="0" align="center" bgcolor="#FFFFFF" class="en" style="border-bottom:1px solid #FAF8F2;"><?php echo date("Y/m/d",$vote[17])?></td>
          <td width="0" align="center" bgcolor="#FFFFFF" class="en" style="border-bottom:1px solid #DDFFED;"><?php echo $votenum?></td>
          <td width="0" align="center" bgcolor="#FFFFFF"><a href="?action=oorc&amp;id=<?php echo $vote[1]?>" target="return"><img id="oorc_<?php echo $vote[1]?>" src="images/<?php echo $vote[13] ? 'open' : 'close'?>.gif" alt="<?php echo $vote[13] ? '�رմ�ͶƱ' : '�򿪴�ͶƱ'?>" width="22" height="21" border="0" /></a></td>
          <td width="0" align="center" bgcolor="#FFFFFF"><a href="?action=edit&amp;id=<?php echo $vote[1]?>"><img src="images/edit.gif" alt="�޸�" width="22" height="21" border="0" /></a></td>
          <td width="0" align="center" bgcolor="#FFFFFF"><a href="?action=del&id=<?php echo $vote[1]?>" onClick="javascript:if(!confirm('ȷ��ɾ����ͶƱ��')){return false;}"><img src="images/del.gif" alt="ɾ��" width="22" height="21" border="0" /></a></td>
        </tr>
<?
}
?>  		
        <tr class="listHeaderTr">
          <td colspan="9" class="listFooterTr">&nbsp;</td>
        </tr>
    
        
      </table></td>
  </tr>
  <tr> 
    <td >&nbsp;</td>
  </tr>


<iframe name="return" frameborder="0" height="0" width="0" scrolling=no></iframe>
