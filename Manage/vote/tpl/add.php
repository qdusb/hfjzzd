<?
include './tpl/header.php';
?>

  <table width="95%" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr height="20">
      <td><a href="?action=add">[ˢ���б�]</a>&nbsp;[<a href="?action=add">���</a>] [<a href="?">ͶƱ����</a>]</td>
    </tr>
  </table>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1"  class="editTable">
      <form name="form1" method="post" action="">
        <tr class="editHeaderTr"> 
          
          <td colspan="2" ><span class="tl"><strong>����µ�ͶƱ��Ŀ</strong></span></td>
        </tr>
        <tr>
          <td width="0" class="editLeftTd">ͶƱ����</td>
          <td width="0" class="editRightTd"><input name="sorm" type="radio" value="0" <?php echo $checkfalse?>>
            ��ѡ
            <input type="radio" name="sorm" value="1" <?php echo $checktrue?>>
          ��ѡ</td>
        </tr>
        <tr> 
          <td width="0" class="editLeftTd">ͶƱ����</td>
          <td width="0" class="editRightTd"><input name="voteco" type="text" id="voteco" size="35">
          <?php echo $err['voteco']?"<font color=red>{$err['voteco']}</font>":''?>Ϊ����ʾ���ۣ���ע������</td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">ѡ��1</td>
          <td width="0" class="editRightTd"><input name="cs1" type="text" value="<?php echo $cs1?>"><?php echo $err['votecount']?"<font color=red>{$err['votecount']}</font>":''?></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">ѡ��2</td>
          <td width="0" class="editRightTd"><input name="cs2" type="text" value="<?php echo $cs2?>"></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">ѡ��3</td>
          <td width="0" class="editRightTd"><input name="cs3" type="text" value="<?php echo $cs3?>"></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">ѡ��4</td>
          <td width="0" class="editRightTd"><input name="cs4" type="text" value="<?php echo $cs4?>"></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">ѡ��5</td>
          <td width="0" class="editRightTd"><input name="cs5" type="text" value="<?php echo $cs5?>"></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">������ɫ</td>
          <td width="0" class="editRightTd"><input name="bg_color" type="text" id="bg_color" value="<?php echo $bg_color?>">
          ��EEEEEE ���ü�&quot;<font color="#FF3300">#</font>&quot; <font color="#FF3300">���Բ��Ĭ����EEEEEE</font></td>
        </tr>
        <tr> 
          <td width="0" class="editLeftTd">������ɫ</td>
          <td width="0" class="editRightTd"><input name="word_color" type="text" id="word_color" value="<?php echo $word_color?>">
          ��000000 ���ü�&quot;<font color="#FF3300">#</font>&quot; <font color="#FF3300">���Բ��Ĭ����000000</font></td>
        </tr>
        <tr> 
          <td width="0" class="editLeftTd">���ִ�С</td>
          <td width="0" class="editRightTd"><input name="word_size" type="text" id="word_size" value="<?php echo $word_size?>">
          ��λpx �磺����12px <span style="font-size:14px">����14px</span> <font color="#FF3300">���Բ���</font></td>
        </tr>
        <tr> 
          <td width="0" class="editLeftTd">&nbsp;</td>
          <td width="0" align="left" class="editRightTd"><input type="submit" name="Submit" value="������ͶƱ"></td>
        </tr>
  </form>
</table>