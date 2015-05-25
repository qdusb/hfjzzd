<?php
session_start();
require './class.php';
require './adminclass.php';
require './config.php';
$mc = new admin;
//echo is_object($mc);
$magic_quotes_gpc = get_magic_quotes_gpc();
$register_globals = @ini_get('register_globals');
if(!$register_globals || !$magic_quotes_gpc) {
        extract($mc->daddslashes($_GET), EXTR_OVERWRITE);
        extract($mc->daddslashes($_POST), EXTR_OVERWRITE);
        if(!$magic_quotes_gpc) {		
              $_SERVER = $mc->daddslashes($_SERVER);
              $_COOKIE = $mc->daddslashes($_COOKIE);
        }
}
//登陆判断，可以换成你自己的
$IS_ADMIN = FALSE;

//if($_SESSION['isadmin']){
	$IS_ADMIN = TRUE;
//}

if ($_POST['Submit']){
	if ($username == $admin_name && $password == $admin_pw) {
		$_SESSION['isadmin'] = True;
		$IS_ADMIN = TRUE;
	}
}

if (!$IS_ADMIN) {
	//include './tpl/login.php';
	//exit;	
}
//::::::::::::::::::THE END:::::::::::::::::

if ($action == 'add') {

	if ($_POST['Submit']) {
		$err = array();
		$voteco = strip_tags($voteco);
		if (!$voteco) {
			$err['voteco'] = '投票议题为空。';
		}
		
		$votecount = 0;
		for ($i=1;$i<=5;$i++) {
			if (${"cs".$i}) {
				$votecount++;
				${"cs".$i} = strip_tags(${"cs".$i});
			}
		}
		if ($votecount == 0) {
			$err['votecount'] = '请至少填写一个选项。';
		}
		
		if (!count($err)) {
			$bg_color = strip_tags($bg_color);
			$word_color = strip_tags($word_color);
			$word_size = strip_tags($word_size);
		
			$newvote = array('', '', $voteco, $cs1, $cs2, $cs3, $cs4, $cs5, 0, 0, 0, 0, 0, 1, $bg_color, $word_color, $word_size, date('Y/m/d H:i:s'), 0, $sorm);
			$mc->newvote($newvote);
			$mc->msg('添加投票操作完成', '?');
		}
	}
	
	if ($sorm){
		$checktrue = "checked";
	} else {
		$checkfalse = "checked";
	}
	$title = '添加新投票';
	include './tpl/add.php';
} elseif ($action == 'edit') {

	if ($_POST['Submit']) {
		$err = array();
		$voteco = strip_tags($voteco);
		if (!$voteco) {
			$err['voteco'] = '投票议题为空。';
		}
		
		$votecount = 0;
		for ($i=1;$i<=5;$i++) {
			if (${'cs'.$i}) {
				$votecount++;
				${'cs'.$i} = strip_tags(${"cs".$i});
				${'cs'.$i.'_num'} = strip_tags(${'cs'.$i.'_num'});
			}
		}
		if ($votecount == 0) {
			$err['votecount'] = '请至少填写一个选项。';
		}
		
		if (!count($err)) {
			$bg_color = strip_tags($bg_color);
			$word_color = strip_tags($word_color);
			$word_size = strip_tags($word_size);
		
			$newvote = array('', $id, $voteco, $cs1, $cs2, $cs3, $cs4, $cs5, $cs1_num, $cs2_num, $cs3_num, $cs4_num, $cs5_num, 1, $bg_color, $word_color, $word_size, '', '', $sorm);
			$mc->editvote($newvote);
			$mc->msg('修改投票操作完成', '?');
		}
	} 
	
	$vote = $mc->get_vote($id);
	if ($vote[19]){
		$checktrue = "checked";
	} else {
		$checkfalse = "checked";
	}
	$title = '修改当前投票项目';
	include './tpl/edit.php';
} elseif ($action == 'oorc') {
	$q = $mc->oorc($id);
?>
<script type="text/javascript">
	e = parent.document.getElementById("oorc_<?php echo $id?>");
	e.src = "images/<?php echo $q ? 'open' : 'close'?>.gif";
	e.alt = "<?php echo $q ? '关闭此投票' : '打开此投票'?>";
</script>
<?php
} elseif ($action == 'del') {
	$mc->del($id);
	$mc->msg('删除投票操作完成', '?');
} elseif ($action == 'view') {

	$vote = $mc->get_vote($id);
	include './tpl/view.php';
} elseif ($action == 'help') {
	$title = '帮助';
	include './tpl/help.php';
} elseif ($action == 'logout') {
	unset($_SESSION['isadmin']);
	$mc->msg('你已成功退出管理系统');
} else {
	$title = '显示管理投票';
	include './tpl/manage.php';
}

?>