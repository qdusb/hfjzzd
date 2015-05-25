<?
include './tpl/header.php';
?>

  <table width="95%" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr height="20">
      <td><a href="?action=add">[刷新列表]</a>&nbsp;[<a href="?action=add">添加</a>] [<a href="?">投票管理</a>]</td>
    </tr>
  </table>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1"  class="editTable">
      <form name="form1" method="post" action="">
        <tr class="editHeaderTr"> 
          
          <td colspan="2" ><span class="tl"><strong>添加新的投票项目</strong></span></td>
        </tr>
        <tr>
          <td width="0" class="editLeftTd">投票类型</td>
          <td width="0" class="editRightTd"><input name="sorm" type="radio" value="0" <?php echo $checkfalse?>>
            单选
            <input type="radio" name="sorm" value="1" <?php echo $checktrue?>>
          多选</td>
        </tr>
        <tr> 
          <td width="0" class="editLeftTd">投票议题</td>
          <td width="0" class="editRightTd"><input name="voteco" type="text" id="voteco" size="35">
          <?php echo $err['voteco']?"<font color=red>{$err['voteco']}</font>":''?>为了显示美观，请注意字数</td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">选项1</td>
          <td width="0" class="editRightTd"><input name="cs1" type="text" value="<?php echo $cs1?>"><?php echo $err['votecount']?"<font color=red>{$err['votecount']}</font>":''?></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">选项2</td>
          <td width="0" class="editRightTd"><input name="cs2" type="text" value="<?php echo $cs2?>"></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">选项3</td>
          <td width="0" class="editRightTd"><input name="cs3" type="text" value="<?php echo $cs3?>"></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">选项4</td>
          <td width="0" class="editRightTd"><input name="cs4" type="text" value="<?php echo $cs4?>"></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">选项5</td>
          <td width="0" class="editRightTd"><input name="cs5" type="text" value="<?php echo $cs5?>"></td>
        </tr>
        
        <tr> 
          <td width="0" class="editLeftTd">背景颜色</td>
          <td width="0" class="editRightTd"><input name="bg_color" type="text" id="bg_color" value="<?php echo $bg_color?>">
          如EEEEEE 不用加&quot;<font color="#FF3300">#</font>&quot; <font color="#FF3300">可以不填，默认是EEEEEE</font></td>
        </tr>
        <tr> 
          <td width="0" class="editLeftTd">文字颜色</td>
          <td width="0" class="editRightTd"><input name="word_color" type="text" id="word_color" value="<?php echo $word_color?>">
          如000000 不用加&quot;<font color="#FF3300">#</font>&quot; <font color="#FF3300">可以不填，默认是000000</font></td>
        </tr>
        <tr> 
          <td width="0" class="editLeftTd">文字大小</td>
          <td width="0" class="editRightTd"><input name="word_size" type="text" id="word_size" value="<?php echo $word_size?>">
          单位px 如：这是12px <span style="font-size:14px">这是14px</span> <font color="#FF3300">可以不填</font></td>
        </tr>
        <tr> 
          <td width="0" class="editLeftTd">&nbsp;</td>
          <td width="0" align="left" class="editRightTd"><input type="submit" name="Submit" value="发表本次投票"></td>
        </tr>
  </form>
</table>