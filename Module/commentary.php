<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
?>
						<script language="javascript">
							function comment(){
								check=document.commform
								
								if((check.title.value).length<2 || (check.title.value).length>75){
									alert("请控制标题在 2-75 字之间!");
									return false;
								}
								
								if((check.content.value).length<10){
									alert("请控制内容在 10 个字以上!");
									return false;
								}	
								
							}
						</script>
									
						
						<?PHP
							if($_SERVER['REQUEST_METHOD']=="POST"){
								$title	=$_POST['title'];
								$content=$_POST['content'];
								$infoid	=$_POST['id'];
								$id		=$db->getMax("commentary","id")+1;
								$ip		=$_SERVER["REMOTE_ADDR"];
									
								if($title=="" || $content==""){
									echo "<script>alert('请填写好内容再发表!');history.back();</script>";
								}
								$sql="insert into commentary values('".$id."','".$infoid."','".$title."','".$content."',".time().",'".$ip."')";
								if($db->query($sql)){
									echo "<script>alert('感谢您的发表!');location='".$Reurl."';</script>";
									exit;
								}
									
							}
							$sql="select * from commentary where infoid=$id order by id asc";
							$qurey=$db->query($sql);
							while($arr=$db->fetch_array($qurey)){
						?>
						<table width="100%" border="0" cellspacing="0" cellpadding="2" style="border:#CCCCCC 1px solid; margin-top:5PX">
                          <tr>
                            <td height="20" align="left" bgcolor="#EEEEEE" style="padding-left:10px">网友评论：<?php  echo $arr['title']?></td>
                          </tr>
                          <tr>
                            <td width="82%" align="left" valign="top" style="padding-left:40px;padding-top:5px;">
							<?php echo nl2br($arr['content'])?>
							</td>
                          </tr>
                          <tr>
                            <td height="1" align="left" valign="top" background="images/dot.gif" style="padding:0px 10px;"></td>
                          </tr>
                          <tr>
                            <td height="22" align="left" style="padding-left:15px"><span style="color:#C0C0C0">时间：					
							<?php
							 echo date("Y-m-d h:i:s",$arr['createtime']+3600*8)
							 ?> 来自：<?php 
							 echo preg_replace("/(([\d]{1,3}\.){3})[\d]{1,3}/","\$1*",$arr['createip']);
							//echo preg_replace("/[\d]{1,3}$/",'*',$arr['createip']);
							 ?> <span style="cursor:hand" onclick="document.commform.title.value='Re:<?php echo $arr['title']?>'">回复</span></span></td>
                          </tr>
                        </table>
						
						<?php
						}
						?>
						
						
						<br>
						<table width="100%" border="0" cellspacing="0" cellpadding="2" style="border:#CCCCCC 1px solid">
                          <form name="commform" method="post" action="" onSubmit="return comment()">
						  <tr>
                            <td height="20" colspan="2" align="left" bgcolor="#EEEEEE"><strong>发表评论：</strong></td>
                            </tr>
						  <tr>
						    <td colspan="2" align="left">现在有<SPAN id="c_count"><strong><font color='red'><?php echo $db->getCount("commentary","id","infoid=$id")?></font></strong></SPAN>人对本文发表评论</td>
						    </tr>
						  <tr>
						    <td width="18%" align="right">评论标题：&nbsp;</td>
						    <td width="82%"><input name="title" type="text" id="title" size="40" maxlength="75"></td>
						  </tr>
                          <tr>
                            <td rowspan="2" align="right">评论内容：&nbsp;</td>
                            <td><textarea name="content" cols="55" rows="5" id="content"></textarea></td>
                          </tr>
                          <tr>
                            <td><input type="image" name="imageField" src="include/images/post.gif">
                            <input name="id" type="hidden" id="id" value="<?php echo $id?>"></td>
                          </tr>
						  </form>
                        </table>