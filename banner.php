 <!-- 代码 开始 -->
    <div class="comiis_wrapad" id="slideContainer">
        <div id="frameHlicAe" class="frame cl">
            <div class="block">
                <div class="cl">
                    <ul class="slideshow" id="slidesImgs">
					<?php 
		$sql="select id,title,file_path,create_time,website from info,files where big_id=1 and info.id=files.table_id and files.table_name='info' and files.file_falg='sma' order by state desc,shownum desc limit 0,4 ";
		$query=$db->query($sql);
		while($arr=$db->fetch_array($query)){
	?>
                        <li><a href="display.php?id=<?=$arr['id']?>" target="_blank">
                            <img src="<?php echo "uploadfile/".$arr['file_path']?>" width="330" height="250" alt="<?=$arr['title']?>" /></a><span class="title"><?php echo cnsubstr($arr['title'],26);?></span></li>
			<?php }?>
                        
                    </ul>
                </div>
                <div class="slidebar" id="slideBar">
                    <ul>
                        <li class="on">1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        SlideShow(3000);
    </script>
    <!-- 代码 结束 -->