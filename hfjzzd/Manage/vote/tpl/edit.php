<?php
include './tpl/header.php';
?>

  <table width="98%" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr height="20">
      <td><a href="?action=<?php echo  $action?>&id=<?php echo $id?>">[ˢ���б�]</a>&nbsp;[<a href="?action=add">���</a>] [<a href="?">ͶƱ����</a>]</td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="editTable">
      <form name="form1" method="post" action="">
        <tr class="editHeaderTr"> 
          
          <td colSpan="2" align="left" >&nbsp;<strong>�޸ĵ�ǰͶƱ��Ŀ</strong></td>
        </tr>
        <tr class="editTr">
          <td width="0" class="editLeftTd">ͶƱ����</td>
          <td width="0" class="editRightTd"><input name="sorm" type="radio" value="0" <?php echo $checkfalse?>>
            ��ѡ
            <input type="radio" name="sorm" value="1" <?php echo $checktrue?>>
          ��ѡ</td>
        </tr>
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">ͶƱ����</td>
          <td width="0" class="editRightTd"><input name="voteco" type="text" id="voteco" value="<?php echo $vote[2]?>" size="35"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">ѡ�� 
            1 </td>
          <td width="0" class="editRightTd"><input name="cs1" type="text" value="<?php echo $vote[3]?>">
            Ʊ�� 
            <input name="cs1_num" type="text"  value="<?php echo $vote[8]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">ѡ�� 
            2 </td>
          <td width="0" class="editRightTd"><input name="cs2" type="text" value="<?php echo $vote[4]?>">
            Ʊ�� 
            <input name="cs2_num" type="text"  value="<?php echo $vote[9]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">ѡ�� 
            3 </td>
          <td width="0" class="editRightTd"><input name="cs3" type="text" value="<?php echo $vote[5]?>">
            Ʊ�� 
            <input name="cs3_num" type="text"  value="<?php echo $vote[10]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">ѡ�� 
            4 </td>
          <td width="0" class="editRightTd"><input name="cs4" type="text" value="<?php echo $vote[6]?>">
            Ʊ�� 
            <input name="cs4_num" type="text"  value="<?php echo $vote[11]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">ѡ�� 
            5 </td>
          <td width="0" class="editRightTd"><input name="cs5" type="text" value="<?php echo $vote[7]?>">
            Ʊ�� 
            <input name="cs5_num" type="text"  value="<?php echo $vote[12]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">������ɫ</td>
          <td width="0" class="editRightTd"><input name="bg_color" type="text" id="bg_color" value="<?php echo $vote[14]?>">
            ��EEEEEE ���ü�&quot;<font color="#FF3300">#</font>&quot;</td>
        </tr>
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">������ɫ</td>
          <td width="0" class="editRightTd"><input name="word_color" type="text" id="word_color" value="<?php echo $vote[15]?>">
            ��000000 ���ü�&quot;<font color="#FF3300">#</font>&quot;</td>
        </tr>
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">���ִ�С</td>
          <td width="0" class="editRightTd"><input name="word_size" type="text" id="word_size" value="<?php echo $vote[16]?>">
            ��λpx �磺����12px <span style="font-size:14px">����14px</span> </td>
        </tr>
        <tr class="editHeaderTr"> 
          <td width="0" align=center>&nbsp;</td>
          <td width="0" align=left><input type="submit" name="Submit" value="�޸ı���ͶƱ" /></td>
        </tr>
    </form>
</table>