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
//��½�жϣ����Ի������Լ���
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
			$err['voteco'] = 'ͶƱ����Ϊ�ա�';
		}
		
		$votecount = 0;
		for ($i=1;$i<=5;$i++) {
			if (${"cs".$i}) {
				$votecount++;
				${"cs".$i} = strip_tags(${"cs".$i});
			}
		}
		if ($votecount == 0) {
			$err['votecount'] = '��������дһ��ѡ�';
		}
		
		if (!count($err)) {
			$bg_color = strip_tags($bg_color);
			$word_color = strip_tags($word_color);
			$word_size = strip_tags($word_size);
		
			$newvote = array('', '', $voteco, $cs1, $cs2, $cs3, $cs4, $cs5, 0, 0, 0, 0, 0, 1, $bg_color, $word_color, $word_size, date('Y/m/d H:i:s'), 0, $sorm);
			$mc->newvote($newvote);
			$mc->msg('���ͶƱ�������', '?');
		}
	}
	
	if ($sorm){
		$checktrue = "checked";
	} else {
		$checkfalse = "checked";
	}
	$title = '�����ͶƱ';
	include './tpl/add.php';
} elseif ($action == 'edit') {

	if ($_POST['Submit']) {
		$err = array();
		$voteco = strip_tags($voteco);
		if (!$voteco) {
			$err['voteco'] = 'ͶƱ����Ϊ�ա�';
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
			$err['votecount'] = '��������дһ��ѡ�';
		}
		
		if (!count($err)) {
			$bg_color = strip_tags($bg_color);
			$word_color = strip_tags($word_color);
			$word_size = strip_tags($word_size);
		
			$newvote = array('', $id, $voteco, $cs1, $cs2, $cs3, $cs4, $cs5, $cs1_num, $cs2_num, $cs3_num, $cs4_num, $cs5_num, 1, $bg_color, $word_color, $word_size, '', '', $sorm);
			$mc->editvote($newvote);
			$mc->msg('�޸�ͶƱ�������', '?');
		}
	} 
	
	$vote = $mc->get_vote($id);
	if ($vote[19]){
		$checktrue = "checked";
	} else {
		$checkfalse = "checked";
	}
	$title = '�޸ĵ�ǰͶƱ��Ŀ';
	include './tpl/edit.php';
} elseif ($action == 'oorc') {
	$q = $mc->oorc($id);
?>
<script type="text/javascript">
	e = parent.document.getElementById("oorc_<?php echo $id?>");
	e.src = "images/<?php echo $q ? 'open' : 'close'?>.gif";
	e.alt = "<?php echo $q ? '�رմ�ͶƱ' : '�򿪴�ͶƱ'?>";
</script>
<?php
} elseif ($action == 'del') {
	$mc->del($id);
	$mc->msg('ɾ��ͶƱ�������', '?');
} elseif ($action == 'view') {

	$vote = $mc->get_vote($id);
	include './tpl/view.php';
} elseif ($action == 'help') {
	$title = '����';
	include './tpl/help.php';
} elseif ($action == 'logout') {
	unset($_SESSION['isadmin']);
	$mc->msg('���ѳɹ��˳�����ϵͳ');
} else {
	$title = '��ʾ����ͶƱ';
	include './tpl/manage.php';
}

?>