<?php
include './tpl/header.php';
?>

  <table width="98%" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr height="20">
      <td><a href="?action=<?php echo  $action?>&id=<?php echo $id?>">[刷新列表]</a>&nbsp;[<a href="?action=add">添加</a>] [<a href="?">投票管理</a>]</td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="editTable">
      <form name="form1" method="post" action="">
        <tr class="editHeaderTr"> 
          
          <td colSpan="2" align="left" >&nbsp;<strong>修改当前投票项目</strong></td>
        </tr>
        <tr class="editTr">
          <td width="0" class="editLeftTd">投票类型</td>
          <td width="0" class="editRightTd"><input name="sorm" type="radio" value="0" <?php echo $checkfalse?>>
            单选
            <input type="radio" name="sorm" value="1" <?php echo $checktrue?>>
          多选</td>
        </tr>
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">投票议题</td>
          <td width="0" class="editRightTd"><input name="voteco" type="text" id="voteco" value="<?php echo $vote[2]?>" size="35"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">选项 
            1 </td>
          <td width="0" class="editRightTd"><input name="cs1" type="text" value="<?php echo $vote[3]?>">
            票数 
            <input name="cs1_num" type="text"  value="<?php echo $vote[8]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">选项 
            2 </td>
          <td width="0" class="editRightTd"><input name="cs2" type="text" value="<?php echo $vote[4]?>">
            票数 
            <input name="cs2_num" type="text"  value="<?php echo $vote[9]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">选项 
            3 </td>
          <td width="0" class="editRightTd"><input name="cs3" type="text" value="<?php echo $vote[5]?>">
            票数 
            <input name="cs3_num" type="text"  value="<?php echo $vote[10]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">选项 
            4 </td>
          <td width="0" class="editRightTd"><input name="cs4" type="text" value="<?php echo $vote[6]?>">
            票数 
            <input name="cs4_num" type="text"  value="<?php echo $vote[11]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">选项 
            5 </td>
          <td width="0" class="editRightTd"><input name="cs5" type="text" value="<?php echo $vote[7]?>">
            票数 
            <input name="cs5_num" type="text"  value="<?php echo $vote[12]?>" size="5"></td>
        </tr>
        
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">背景颜色</td>
          <td width="0" class="editRightTd"><input name="bg_color" type="text" id="bg_color" value="<?php echo $vote[14]?>">
            如EEEEEE 不用加&quot;<font color="#FF3300">#</font>&quot;</td>
        </tr>
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">文字颜色</td>
          <td width="0" class="editRightTd"><input name="word_color" type="text" id="word_color" value="<?php echo $vote[15]?>">
            如000000 不用加&quot;<font color="#FF3300">#</font>&quot;</td>
        </tr>
        <tr class="editTr"> 
          <td width="0" class="editLeftTd">文字大小</td>
          <td width="0" class="editRightTd"><input name="word_size" type="text" id="word_size" value="<?php echo $vote[16]?>">
            单位px 如：这是12px <span style="font-size:14px">这是14px</span> </td>
        </tr>
        <tr class="editHeaderTr"> 
          <td width="0" align=center>&nbsp;</td>
          <td width="0" align=left><input type="submit" name="Submit" value="修改本次投票" /></td>
        </tr>
    </form>
</table>