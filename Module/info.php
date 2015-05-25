<?php
if(!defined('IN_EKMENG')) {
	exit('Access Denied');
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td>
	<?php 
	if($third_id>0){
		if($third_info=="content"){
			$sql="select id,title,content from info where big_id=$base_id and sec_id=$sec_id and third_id=$third_id and shenhe=1 and state>0 order by shownum asc limit 0,1";					
			$arr=$db->fetch_array($db->query($sql));
			echo "<span class='content1'>".$arr['content']."</span>";
		}elseif($third_info=="list"){
			$pagesize=20;
			$sql="select id,title,publishdate,color,create_time from info where big_id=$base_id and sec_id=$sec_id and third_id=$third_id and shenhe=1 and state>0 order by shownum desc";
			$pagestr=$db->page_1($sql,$page,$pagesize);
			$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";							
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){
		?>
        <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="2%" height="30">·</td>
            <td width="83%"><a href="display.php?id=<?php echo $arr['id']?>" target="_blank" style="color:<?php $arr['color']?>" title='<?php $arr['color']?>'/><?php echo $arr['title']?></a></td>
            <td width="15%" class="color1"><?php echo date('Y-m-d',$arr['create_time']);?></td>
          </tr>
          <tr>
            <td height="1" colspan="3" background="images/index-10.jpg"></td>
          </tr>
        </table>
		<?php }?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25" align="center"><?php echo $pagestr;?></td>
          </tr>
      </table>
      <?php 
		}elseif($third_info=="pic"){
		$pagesize=12;
		$sql="select id,title from info where big_id=$base_id and title like '%".$_GET['key']."%' and sec_id=$sec_id and third_id=$third_id and shenhe=1 and state>0 order by state desc,shownum desc";
			$pagestr=$db->page_1($sql,$page,$pagesize);
			$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";					
			$query=$db->query($sql);
			
		?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<?php
		for($r=0;$r<2;$r++){
		?>
          <tr>
			<?php
			for($c=0;$c<3;$c++){
			?>
				<td>
				<?php if($arr=$db->fetch_array($query)){?>
				<table width="160" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="140" align="center" valign="top">
					<?php
					$sql="select file_path from files where table_name='info' and table_id=".$arr['id'];
					if($imgs=$db->fetch_array($db->query($sql))){
					?>
					<a href="display.php?id=<?php echo $arr['id']?>"><img src="UpLoadFile/<?php echo $imgs['file_path']?>" width="160" height="140" border="0" /></a>					<?php
					}else{
						echo "暂无图片";
					}
					?>					</td>
                  </tr>
                  <tr>
                    <td height="45" align="center" valign="top" style="padding-top:3px"><a href="display.php?id=<?php echo $arr['id']?>"><?php echo $arr['title']?></a></td>
                  </tr>
                </table>
				<?php }?>
				</td>
			<?php }?>
          </tr>
		  <?php }?><h1></h1>
      </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25" align="center"><?php echo $pagestr;?></td>
          </tr>
      </table>
	  <?
		}   
	}else{
	//无三级分类
		if($sec_info=="content"){
			$sql="select id,title,content from info where big_id=$base_id and title like '%".$_GET['key']."%' and sec_id=$sec_id and shenhe=1 and state>0 order by state desc,shownum desc limit 0,1";					
			$arr=$db->fetch_array($db->query($sql));
			echo $arr['content'];
		}elseif($sec_info=="list"){
			$pagesize=15;
			$sql="select id,title,publishdate,color,create_time from info where big_id=$base_id and title like '%".$_GET['key']."%' and shenhe=1 and sec_id=$sec_id and state>0 order by state desc,shownum desc";
			$pagestr=$db->page_1($sql,$page,$pagesize);
			$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";							
			$query=$db->query($sql);
			while($arr=$db->fetch_array($query)){
		?>
			
			  <table width="95%" height="33" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px dotted #ccc; margin:0px auto;" align="center">
                <tr>
                  <td width="86%">
				  <?php if($base_id==2){?>
				  <a href="display_tz.php?id=<?=$arr['id'];?>" title="<?=$arr['title'];?>" class="a1" target="_blank">&nbsp;<img src="images/icon1.jpg" width="4" height="5" style="margin-top:10px; margin-right:10px;" /><?php echo $arr['title'];?></a>
				  <?php }else{?>
				  <a href="display.php?id=<?=$arr['id'];?>" title="<?=$arr['title'];?>" class="a1" target="_blank">&nbsp;<img src="images/icon1.jpg" width="4" height="5" style="margin-top:10px; margin-right:10px;" /><?php echo $arr['title'];?></a>
				  <?php }?>
				  </td>
                  <td width="14%"><span style="float:right;">
                    <?=date('Y-m-d',$arr['create_time']);?>
                  </span></td>
                </tr>
      </table>
			
		  <?php }?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="ah">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="35" align="center"><?php echo $pagestr;?></td>
          </tr>
      </table>
      <?php 
		}elseif($sec_info=="pic"){
		$pagesize=6;
		$sql="select id,title,intro from info where big_id=$base_id and title like '%".$_GET['key']."%' and sec_id=$sec_id and shenhe=1 and state>0 order by state desc,shownum desc";
			$pagestr=$db->page_1($sql,$page,$pagesize);
			$sql.=" limit ".(($page-1)*$pagesize).",$pagesize";			
			$query=$db->query($sql);
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
		for($r=0;$r<2;$r++){
		?>
          <tr>
			<?php
			for($c=0;$c<3;$c++){
			?>
				<td>
				<?php if($arr=$db->fetch_array($query)){?>
				<table width="160" border="0" align="center" cellpadding="0" cellspacing="0" >
                  <tr>
                    <td width="160" height="140" align="center" valign="top"><ul class="rigmain99">
					<?php
					$sql="select file_path from files where table_name='info' and table_id=".$arr['id'];
					if($imgs=$db->fetch_array($db->query($sql))){
					?>
					
        	<li><a href="display.php?id=<?=$arr['id'];?>" title="<?=$arr['title'];?>"><span class="li_pic"><img src="UpLoadFile/<?php echo $imgs['file_path']?>" width="170" height="170" border="0" /></span><h3 class="li_tit"><?=$arr['title'];?></h3><p class="li_js"><?=cnsubstr($arr['intro'],50);?></p></a></li>         
					<?php
					}else{
						echo "暂无图片";
					}
					?>
			<div class="clear"></div>            
        </ul>			</td>
                  </tr>
                </table>
				<?php }?>
				</td>
			<?php }?>
          </tr>
		  <?php }?><h1></h1>
        </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25" align="center" style="line-height:28px;"><?php echo $pagestr;?></td>
          </tr>
      </table>
	  <?
		}?>    
	<?php }?></td>
  </tr>
</table>
