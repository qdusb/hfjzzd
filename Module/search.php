<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <script language="javascript">
				  	function keysubmit(){
						if(document.sec_form.key.value==''){
							alert("请输入查询内容！");
							document.sec_form.key.focus();
							return false;
						}
						
						
					}
				  </script>
  <form id="sec_form" name="sec_form" method="get" action="news.php">
    <tr>
      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="34%" height="25" align="right">分&nbsp;&nbsp;类：</td>
              <td width="66%" height="25"><select name="sec_id" style="width:89px">
                  <?php
								$sql="select id,typename from big_class order by shownum asc";
								$big_class=$db->query($sql);
								while($big=$db->fetch_array($big_class)){
								?>
                  				<optgroup label="<?php echo $big['typename']?>">
                  <?php
								$sql="select id,sec_name from sec_class where big_id=".(int)$big['id']." order by shownum asc";
								$sec_class=$db->query($sql);
								while($sec=$db->fetch_array($sec_class)){
								?>
                  <option value=<?php echo $sec['id']?>><?php echo $sec['sec_name']?></option>
                  <?php
								}
								}
								?>
              </select>              </td>
            </tr>
            <tr>
              <td height="25" align="right">关键字：</td>
              <td height="25"><input name="key" type="text" class="style7" id="key" size="11" /></td>
            </tr>
            <tr>
              <td height="25" align="center">&nbsp;</td>
              <td height="25" align="left"><input type="submit" name="Submit" value="提交" onclick="return keysubmit()" />
                <input type="reset" name="Submit2" value="取消" /></td>
            </tr>
          </table>
      </td>
    </tr>
  </form>
</table>
